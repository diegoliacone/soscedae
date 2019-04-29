<?php
/*
Plugin Name: Post Grid & Carousel Ultimate
Plugin URI: https://wordpress.org/product/post-grid-carousel-ultimate-pro
Description: Use Post Grid & Carousel Ultimate Plugin to display your posts in different beautiful Grids and Sliders/Carousels very easily.
Version: 1.2.0
Author: AazzTech
Author URI: https://aazztech.com
License: GPLv2 or later
*/

if( !defined('ABSPATH')) { die('Direct browsing is not possible');}


	class post_grid_and_carousel_ultimate
	{
		public function __construct() {
			//after load the plugin
			add_action('plugins_load',array($this,'gc_load_textdomain'));

			//require all file
			$this->gc_requires();

			add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array($this, 'pro_version_plugin_link') );

			add_action('admin_menu', array($this, 'upgrade_support_submenu_pages_for_gc'));

		}

		

		//method for language
		public function gc_load_textdomain() {
			load_plugin_textdomain(POST_GRID_CAROUSEL_TEXTDOMAIN,false,plugin_basename( dirname( __FILE__ ) ) . '/languages/');
		}

		

		

		//method for require files
		public function gc_requires() {
			require_once(plugin_dir_path( __FILE__ ).'classes/config.php');
			require_once(plugin_dir_path( __FILE__ ).'classes/adl-custom-post.php');
			require_once(plugin_dir_path( __FILE__ ).'classes/adl-post-grid-carousel-metabox.php');
			require_once(plugin_dir_path( __FILE__ ).'adl-post-carousel-enqueue.php');
			require_once(plugin_dir_path( __FILE__ ).'classes/adl-gc-shortcode.php');
			require_once(plugin_dir_path( __FILE__ ).'gc-mce-shortcode-button.php');
			require_once(plugin_dir_path( __FILE__ ).'classes/gc-resize.php');
			require_once(plugin_dir_path( __FILE__ ).'classes/adl-gc-widget.php');

		}	

		
		//method for pro version link
		public function pro_version_plugin_link($links) {

		$links[] = '<a href="https://aazztech.com/demos/plugins/post-carousel-theme-4/" target="_blank">Pro Version</a>';
         return $links;
     
		}

		//method for support plugin
		public function upgrade_support_submenu_pages_for_gc() {
			add_submenu_page( 'edit.php?post_type=adl-shortcode', esc_html__('Support', POST_GRID_CAROUSEL_TEXTDOMAIN), esc_html__('Usage & Support', POST_GRID_CAROUSEL_TEXTDOMAIN), 'manage_options', 'support', array( $this, 'support_view' ) );
		}

		//method for submenu page
		public function support_view() {
			require_once('classes/support.php');
		}
		

	} // endclass


	if(class_exists('post_grid_and_carousel_ultimate')) { 

		new post_grid_and_carousel_ultimate;

		new gc_adl_custom_post;

		new adl_post_grid_carousel_metabox;

		new adl_post_carousel_enqueue;

		new adl_gc_shortcode;

		new Adl_widget_post;
		
		
		
	}