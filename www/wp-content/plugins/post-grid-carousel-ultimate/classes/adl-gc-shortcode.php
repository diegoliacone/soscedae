<?php

if( !defined('ABSPATH')) { die('Direct access not allow');}


	class adl_gc_shortcode
	{

		public function __construct() {
			//add shortcode hoke
			add_shortcode("post_grid_carousel",array($this,"shortcode_for_post_grid_carousel"));

		}

		//method for shortcode
		public function shortcode_for_post_grid_carousel($atts, $content) {

			ob_start();
			extract(shortcode_atts(
				array(
					'id'=>'',
					),$atts));

			$this->gc_adl_all_css_files();

			$post_id = $id;
			$data 	 = get_post_meta($post_id,'gc',true);

			$value = is_array($data) ? $data : array();
			extract($value);

			$rand = rand();


			$image_resize_crop = !empty($image_resize_crop) ? $image_resize_crop : "yes";
			$image_ups		   = !empty($image_ups) ? $image_ups : "yes";
			$image_width	   = !empty($image_width) ? $image_width : 300;
			$image_hight	   = !empty($image_hight) ? $image_hight : 290;
			$post_title	       = !empty($post_title) ? $post_title : '';
			$post_category	   = !empty($post_category) ? $post_category : '';
			$post_date	       = !empty($post_date) ? $post_date : '';
			$post_content	   = !empty($post_content) ? $post_content : '';
			$post_author_name	   = !empty($post_author_name) ? $post_author_name : '';



			if( $layout != 'isotope') { 
			$post_from = !empty($post_from) ? $post_from : 'latest';
			$paged 			    = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
			$args = array();
		    $common_args = [
		        'post_type' => (!empty($post_type) ?  $post_type :  "post"),
		        'posts_per_page'=> (!empty($total_posts) ? $total_posts : -1),
		        'status' => 'published',
		        'paged'=>$paged

		    ];
		    if ( 'latest' == $post_from ) { $args = $common_args; }
		    elseif ('older' == $post_from) {
		        $older_args = [
		            'orderby'   => 'date',
		            'order'     => 'ASC',
		        ];
		        $args = array_merge($common_args, $older_args);
		    }else {
		        $args = $common_args;
		    }

		    $post = new WP_Query( $args );


			if($layout != 'grid' &  $layout != 'isotope') {
                wp_enqueue_script('owl-carousel');
                wp_enqueue_style('owl-css');
				?>

					<script type="text/javascript">
						 jQuery(document).ready(function() {

						    'use strict';
						    (function($){
						        // custom nav trigger function for owl casousel
						    function customTrigger(slideNext, slidePrev, targetSlider) {
						        $(slideNext).on('click', function () {
						            targetSlider.trigger('next.owl.carousel');
						        });
						        $(slidePrev).on('click', function () {
						            targetSlider.trigger('prev.owl.carousel');
						        });
						    }

						    // post grid slider1
						    var pgSlider = $('.pgcu_post_slider-<?php echo $rand;?>');
						    pgSlider.owlCarousel({
						        margin: 30,
						        mouseDrag:<?php echo !empty($mouse_draggable) && $mouse_draggable == 'off' ? 'false' : 'true';?>,
						        dots: <?php echo !empty($c_pagination_dots) && $c_pagination_dots == 'off' ? 'false' : 'true';?>,
						        autoplayHoverPause:<?php echo !empty($c_pause_hover) && $c_pause_hover == 'off' ? 'false' : 'true';?>,
						        autoplay:<?php echo !empty($c_autoplay) && $c_autoplay == 'off' ? 'false' : 'true';?>, 
						        autoplaySpeed:<?php if(!empty($c_autoplay_speed)) { echo $c_autoplay_speed;}else{ echo 3000;}?>,
						        autoplayTimeout:<?php if(empty($c_autoplay_time)) { echo 2000;}else{ echo $c_autoplay_time;}?>,
						        smartSpeed:250,
						        responsive: {
                                    0 : {
                                        items:1
                                    },
                                    350: {
                                        items:<?php echo (!empty( $post_column_mobile)) ? absint( $post_column_mobile):2; ?>
                                    },
                                    480: {
                                        items:<?php echo (!empty( $post_column_mobile)) ? (absint( $post_column_mobile)+1):3; ?>
                                    },
                                    600 : {
                                        items:<?php echo (!empty( $post_column_tablet)) ? (absint( $post_column_tablet) - 1):3; ?>
                                    },
                                    768:{
                                        items:<?php echo (!empty( $post_column_tablet)) ? absint( $post_column_tablet):4; ?>
                                    },
                                    978:{
                                        items:<?php echo (!empty( $post_column)) ? absint( $post_column) : 3 ; ?>                          },
                                    1198:{
                                        items:<?php echo (!empty( $post_column)) ? absint( $post_column) : 3 ; ?>
                                    }
                                }
						        
						    });
						    customTrigger('.slide-<?php echo $rand;?>.icon-arrow-left', '.slide-<?php echo $rand;?>.icon-arrow-right', pgSlider);
						    })(jQuery)

						 });

					</script>


				<?php
			if($c_theme != "theme_2" && $c_theme != "theme_3" && $c_theme == "theme_1"){
				include(plugin_dir_path( __FILE__ ).'styles/carousel/c_theme1.php');
				include(plugin_dir_path( __FILE__ ).'carousel/theme-1.php');
			}elseif($c_theme == "theme_2") {
				include(plugin_dir_path( __FILE__ ).'styles/carousel/c_theme2.php');
				include(plugin_dir_path( __FILE__ ).'carousel/theme-2.php');
			}elseif($c_theme == "theme_3") {
				include(plugin_dir_path( __FILE__ ).'styles/carousel/c_theme3.php');
				include(plugin_dir_path( __FILE__ ).'carousel/theme-3.php');
			}

			}elseif($layout == 'grid') {
				include(plugin_dir_path( __FILE__ ).'styles/pagination.php');

				if($g_theme == "theme_1" && $g_theme != "theme_2") {
					include(plugin_dir_path( __FILE__ ).'styles/grid/g_theme1.php');
					include(plugin_dir_path( __FILE__ ).'grid/theme-1.php');
				}elseif($g_theme == "theme_2") {
					include(plugin_dir_path( __FILE__ ).'styles/grid/g_theme2.php');
					include(plugin_dir_path( __FILE__ ).'grid/theme-2.php');
				}

			}

			}elseif($layout == "isotope") {
				add_action('wp_footer',array($this,'all_footer'));
				include(plugin_dir_path( __FILE__ ).'styles/sortable/s_theme.php');
				include(plugin_dir_path( __FILE__ ).'sortable/s-theme.php');
			}
		
			$true = ob_get_clean();
			return $true;
		}

		//method for css & js files
		public function gc_adl_all_css_files() {
			

			wp_enqueue_script('filterizr');


			wp_enqueue_style('simple');
			wp_enqueue_style('style');
			wp_enqueue_style('reset');
			


		}


		public function all_footer() {
			?>





			<script type="text/javascript">
			(function($){
	            jQuery(document).ready(function() {

	            	'use strict';
				    // custom nav trigger function for owl casousel
				    function customTrigger(slideNext, slidePrev, targetSlider) {
				        $(slideNext).on('click', function () {
				            targetSlider.trigger('next.owl.carousel');
				        });
				        $(slidePrev).on('click', function () {
				            targetSlider.trigger('prev.owl.carousel');
				        });
				    }

				    


				    $('.pgcu_filterable_container').filterizr({
				        layout: 'sameWidth',
				        animationDuration: 0.3
				    });

				    $('.pgcu_filter_area ul li').on('click', function () {
				        var $this = $(this);
				        $this.siblings('li').removeClass('active');
				        $this.addClass('active');
				    });
	            });	
	           })(jQuery) 
	            </script>	

	            

			<?php
		}
		


	}//end class

