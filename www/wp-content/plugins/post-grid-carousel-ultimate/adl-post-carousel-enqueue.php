<?php
if(!defined('ABSPATH')) { die( 'direnct access is not allow');}



	class adl_post_carousel_enqueue
	{
		public function __construct() {
			//css & js files for admin
			add_action('admin_enqueue_scripts',array($this,'admin_enqueue_script'));

			//css & js files
			add_action("wp_enqueue_scripts",array($this,"wp_enqueue_function"));
		}

		public function admin_enqueue_script() {
			wp_enqueue_script('admin',PLUGINS_URL('admin/admin.js',__FILE__),array('jquery'));
			wp_enqueue_script( 'adl_color_js', PLUGINS_URL( 'admin/admin.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ));
			wp_enqueue_style('admin-css',PLUGINS_URL('admin/admin.css',__FILE__));
			wp_enqueue_style('wp-color-picker');
		}

		public function wp_enqueue_function() {
			//js files
			
			wp_register_script('owl-carousel',PLUGINS_URL('assets/js/owl.carousel.min.js', __FILE__ ),array('jquery'));
			wp_register_script('filterizr',PLUGINS_URL('assets/js/jquery.filterizr.min.js',__FILE__),array('jquery'));
			


			//css files
			wp_register_style('owl-css',PLUGINS_URL('assets/css/owl.carousel.css', __FILE__ ));
			wp_register_style('theme',PLUGINS_URL('assets/css/themes.css', __FILE__ ));
			wp_register_style('simple',PLUGINS_URL('assets/css/simple-line-icons.css',__FILE__));
			wp_register_style('style',PLUGINS_URL('assets/css/style.css', __FILE__ ));
			wp_register_style('reset',PLUGINS_URL('assets/css/reset.css', __FILE__ ));

			wp_enqueue_style('sidebar',PLUGINS_URL('assets/css/sidebar.css', __FILE__ ));
			wp_enqueue_style('reset');

		}


	}

