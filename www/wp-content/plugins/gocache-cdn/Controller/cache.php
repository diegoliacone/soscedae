<?php
namespace GoCache;

if ( ! function_exists( 'add_action' ) ) {
	exit(0);
}

class Cache_Controller
{
	public $actions = array(
		'save_post',
		'deleted_post',
		'future_to_publish',
		'trashed_post',
		'delete_attachment',
		'switch_theme',
	);

	public function __construct()
	{
		$this->setting = new Setting();

		if ( $this->setting->auto_clear_cache == 'yes' ) {
			add_action( 'init', array( $this, 'handle_actions' ) );
		}

		add_action( 'wp_ajax_VwtDUTW92c2B8Yjf', array( $this, 'delete_by_url' ) );
		add_action( 'wp_ajax_mbuceP3nRNUqXzR5', array( $this, 'delete_all' ) );
	}

	public function delete_all()
	{
		if ( ! Utils::is_request_ajax() ) {
			exit(0);
		}

		$request  = new Request();
		$response = $request->delete_all_cache();

		if ( isset( $response->msg ) && $response->msg == 'Success' ) {
			Utils::success_server_json( 'config_save_success', __( 'All cache was deleted.', App::TEXTDOMAIN ) );
			exit(1);
		}

		Utils::error_server_json( 'not_connected', __( 'Could not delete cache.', App::TEXTDOMAIN ) );
		http_response_code( 500 );

		exit(0);
	}

	public function delete_by_url()
	{
		if ( ! Utils::is_request_ajax() ) {
			exit(0);
		}

		$urls = Utils::post( 'urls', false, 'wp_strip_all_tags' );

		if ( ! $urls ) {
			Utils::error_server_json( 'empty_field', __( 'Empty field.', App::TEXTDOMAIN ) );
			http_response_code( 411 );
			exit(0);
		}

		$list    = preg_split( "/\\r\\n|\\r|\\n/", $urls );
		$request = new Request();
		$result  = $request->delete_cache( $list, true );

		if ( ! isset( $result->response->urls_accepted ) ) {
			Utils::error_server_json( 'invalid_urls', __( 'Invalid URL.', App::TEXTDOMAIN ) );
			http_response_code( 411 );
			exit(0);
		}

		$accepted = implode( ', ', $result->response->urls_accepted );

		Utils::success_server_json( 'success', __( 'Clear URL: ', App::TEXTDOMAIN ) . $accepted );

		exit(1);
	}

	public function handle_actions()
	{
		foreach ( $this->actions as $action ) {
			add_action( $action, array( $this, 'purge_post' ), 5, 1 );
		}

		//Comments
		add_action( 'wp_insert_comment', array( $this, 'purge_on_insert_comment' ), 99, 2 );
		add_action( 'transition_comment_status', array( $this, 'purge_on_change_comment_status' ), 99, 3 );
	}

	public function purge_post( $post )
	{
		$post_id           = ( is_object( $post ) ) ? $post->ID : intval( $post );
		$valid_post_status = array( 'publish', 'trash', 'future' );
		$post_status       = get_post_status( $post_id );
		$post_type         = get_post_type( $post_id );

		// If this is a revision, stop.
		if ( get_permalink( $post_id ) !== true && ! in_array( $post_status, $valid_post_status ) ) {
			return;
		}

		// array to collect all our URLs
		$urls_list = array();

		// Category purge based on Donnacha's work in WP Super Cache
		$categories = get_the_category( $post_id );
		if ( $categories ) {
			foreach ( $categories as $cat ) {
				array_push( $urls_list, get_category_link( $cat->term_id ) );
			}
		}

		// Tag purge based on Donnacha's work in WP Super Cache
		$tags = get_the_tags( $post_id );
		if ( $tags ) {
			foreach ( $tags as $tag ) {
				array_push( $urls_list, get_tag_link( $tag->term_id ) );
			}
		}

		// Author URL
		array_push( $urls_list,
			get_author_posts_url( get_post_field( 'post_author', $post_id ) ),
			get_author_feed_link( get_post_field( 'post_author', $post_id ) )
		);

		// Archives and their feeds
		$archive_urls = array();
		if ( get_post_type_archive_link( get_post_type( $post_id ) ) == true ) {
			array_push( $urls_list,
				$this->_trailingslashit( get_post_type_archive_link( get_post_type( $post_id ) ) ),
				get_post_type_archive_feed_link( get_post_type( $post_id ) )
			);
		}

		// Post URL
		array_push( $urls_list, get_permalink( $post_id ) );

		// Feeds
		array_push( $urls_list,
			get_bloginfo_rss( 'rdf_url' ),
			get_bloginfo_rss( 'rss_url' ),
			get_bloginfo_rss( 'rss2_url' ),
			get_bloginfo_rss( 'atom_url' ),
			get_bloginfo_rss( 'comments_rss2_url' ),
			get_post_comments_feed_link( $post_id )
		);

		if ( get_option( 'show_on_front' ) == 'page' ) {
			array_push( $urls_list, get_permalink( get_option( 'page_for_posts' ) ) );
		}

		//Main domain
		$domain = $this->_trailingslashit( esc_url( Utils::get_domain() ) );
		array_push( $urls_list, $domain );

		$request = new Request();
		$urls    = $this->_prepare_urls( $urls_list );
		$urls    = $request->append_custom_strings( $urls );
		$list    = array_chunk( $urls, 50, true );

		foreach( $list as $items ) {
			$request->delete_cache( $items );
		}
	}

	public function purge_on_insert_comment( $comment_id, $comment )
	{
		if ( $comment->comment_approved != 1 ) {
			return;
		}

		$this->purge_post( $comment->comment_post_ID );
	}

	public function purge_on_change_comment_status( $new_status, $old_status, $comment )
	{
		if ( $new_status == $old_status ) {
			return;
		}

		if ( $new_status == 'approved' ) {
			$this->purge_post( $comment->comment_post_ID );
		}
	}

	private function _prepare_urls( $urls )
	{
		if ( ! $urls ) {
			return array();
		}

		$prefix = isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ? 'http://' : 'https://';
		$data   = array_merge( $urls, $this->_get_without_slashes_items( $urls ) );
		$data   = array_merge( $data, $this->_get_https_items( $data, $prefix ) );
		$data   = array_unique( $data );

		return $data;
	}

	private function _get_without_slashes_items( $urls )
	{
		$without_slash = array();

		foreach ( $urls as $url ) {
			array_push( $without_slash, rtrim( $url, '/' ) );
		}

		return $without_slash;
	}

	private function _get_https_items( $urls, $prefix )
	{
		$maybe_ssl = array();

		foreach ( $urls as $url ) {
			array_push( $maybe_ssl, preg_replace( '(https?://)', $prefix, $url ) );
		}

		return $maybe_ssl;
	}

	private function _trailingslashit( $url )
	{
		if ( strpos( $url, '?' ) === false ) {
			return rtrim( $url, '/' ) . '/';
		}

		return $url;
	}
}
