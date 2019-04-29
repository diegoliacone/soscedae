<?php
if( !defined('ABSPATH')) { die('direct browsing can not possible');}


	class gc_adl_custom_post
	{
		public function __construct() {
			//hook for custom post
			add_action('init',array($this,'gc_adl_custom_post_type'));

			// shortcode column list
			add_filter('manage_'.ADL_SHORT_CODE_POST_TYPE.'_posts_columns', array($this, 'gc_adl_new_post_shortcord_columns'));
			add_action('manage_'.ADL_SHORT_CODE_POST_TYPE.'_posts_custom_column', array($this, 'gc_adl_manage_shortcode_columns'), 10, 2);
		}

		//method for custom post type
		public function gc_adl_custom_post_type() {
			
				

				$shortcode_label = array(
					'name'               => _x( 'Shortcodes', 'post type general name', POST_GRID_CAROUSEL_TEXTDOMAIN ),
					'singular_name'      => _x( 'Shortcode', 'post type singular name', POST_GRID_CAROUSEL_TEXTDOMAIN ),
					'menu_name'          => _x( 'Post Grid & Carousel', 'admin menu', POST_GRID_CAROUSEL_TEXTDOMAIN ),
					'name_admin_bar'     => _x( 'Shortcode', 'add new on admin bar', POST_GRID_CAROUSEL_TEXTDOMAIN ),
					'add_new'            => _x( 'New Grid/Carousel', 'Shortcode', POST_GRID_CAROUSEL_TEXTDOMAIN ),
					'add_new_item'       => __( 'New Grid/Carousel', POST_GRID_CAROUSEL_TEXTDOMAIN ),
					'new_item'           => __( 'New Grid/Carousel', POST_GRID_CAROUSEL_TEXTDOMAIN ),
					'edit_item'          => __( 'Edit Post Grid/Carousel', POST_GRID_CAROUSEL_TEXTDOMAIN ),
					'view_item'          => __( 'View Post Grid/Carousel', POST_GRID_CAROUSEL_TEXTDOMAIN ),
					'all_items'          => __( 'All Grid/Carousel', POST_GRID_CAROUSEL_TEXTDOMAIN ),
					'search_items'       => __( 'Search Shortcodes', POST_GRID_CAROUSEL_TEXTDOMAIN ),
					'parent_item_colon'  => __( 'Parent Shortcodes:', POST_GRID_CAROUSEL_TEXTDOMAIN ),
					'not_found'          => __( 'No Shortcodes found.', POST_GRID_CAROUSEL_TEXTDOMAIN ),
					'not_found_in_trash' => __( 'No Shortcodes found in Trash.', POST_GRID_CAROUSEL_TEXTDOMAIN )
				);

				$short_args = array(
					'labels'             => $shortcode_label,
			        'description'        => __( 'Description.', POST_GRID_CAROUSEL_TEXTDOMAIN ),
					'public'             => true,
					'publicly_queryable' => true,
					'show_ui'            => true,
					'show_in_menu'       => true,
					'query_var'          => true,
					'rewrite'            => array( 'slug' => ADL_SHORT_CODE_POST_TYPE ),
					'capability_type'    => 'post',
					'has_archive'        => true,
					'hierarchical'       => false,
					'menu_position'      => 20,
					'supports'           => array( 'title'),
					'menu_icon'		     =>'dashicons-schedule'
				);

				

				
				register_post_type( ADL_SHORT_CODE_POST_TYPE, $short_args );

				$labels = array(
				'name'              => _x( 'Categories', 'taxonomy general name', 'textdomain' ),
				'singular_name'     => _x( 'category', 'taxonomy singular name', 'textdomain' ),
				'search_items'      => __( 'Search Categories', 'textdomain' ),
				'all_items'         => __( 'All Categories', 'textdomain' ),
				'parent_item'       => __( 'Parent category', 'textdomain' ),
				'parent_item_colon' => __( 'Parent category:', 'textdomain' ),
				'edit_item'         => __( 'Edit category', 'textdomain' ),
				'update_item'       => __( 'Update category', 'textdomain' ),
				'add_new_item'      => __( 'Add New category', 'textdomain' ),
				'new_item_name'     => __( 'New category Name', 'textdomain' ),
				'menu_name'         => __( 'category', 'textdomain' ),
			);

			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'category' ),
			);

			register_taxonomy( 'adl-category', array( ADL_POST_TYPE ), $args );
			
		}

		//method for shortcode columns
		public function gc_adl_new_post_shortcord_columns($columns) {
			$columns = array();
            $columns['cb']   = '<input type="checkbox" />';
            $columns['title']   = esc_html__('Post Name', POST_GRID_CAROUSEL_TEXTDOMAIN);
            $columns['post_grid_carousel_sc_1']   = esc_html__('Post Shortcode', POST_GRID_CAROUSEL_TEXTDOMAIN);
            $columns['post_grid_carousel_sc_2']   = esc_html__('Shortcode for Template File', POST_GRID_CAROUSEL_TEXTDOMAIN);
            $columns['date']   = esc_html__('Created at', POST_GRID_CAROUSEL_TEXTDOMAIN);
            return $columns;
		}

		/// method for shortcode column list
		public function gc_adl_manage_shortcode_columns($column_name, $post_id) {
			switch($column_name){
                case 'post_grid_carousel_sc_1': ?>
                    <textarea  style="background:#0074A8; color:#fff;" cols="50" rows="1" onClick="this.select();" >[post_grid_carousel id="<?php echo $post_id;?>"]</textarea>
                    <?php
                    break;
                case 'post_grid_carousel_sc_2': ?>
                    <textarea  style="background:#0074A8; color:#fff;" cols="50" rows="1" onClick="this.select();" ><?php echo "<?php post_grid_carousel('{$post_id}'); ?>"; ?></textarea>
                    <?php
                    break;

                default:
                    break;

            }
		}
	}
