<?php
if( !defined('ABSPATH')) { die('direct browsing can not possible');}

	add_action('widgets_init','adl_widget_function');

	function adl_widget_function() {
		register_widget('Adl_widget_post');
	}

	class Adl_widget_post extends WP_Widget{

		public function __construct() {
			parent::__construct('adl_widget','Post Grid & Carousel Ultimate',array(
				'description'=> 'Post Grid & Carousel Ultimate Widget'
				));
		} 

		public function widget($arg,$instance) {
			extract($arg);
            $title          = $instance['title'];
			$post_from      = !empty($instance['post_from']) ? $instance['post_from'] : 'latest';
            $posts_per_page = !empty($instance['posts_per_page']) ? $instance['posts_per_page'] : 2;
            $post_type      = !empty($instance['post_type']) ? $instance['post_type'] : 'post';

			echo $before_widget . $before_title . $title . $after_title;
            
			$args = array();
            $common_args = [
                'post_type' => $post_type ,
                'posts_per_page'=> $posts_per_page,
                'status' => 'published',
                'no_found_rows'=> true, // remove if pagination needed

            ];
            if ( 'latest' == $post_from ) { $args = $common_args; }
            elseif ('older' == $post_from) {
                $older_args = [
                    'orderby'   => 'date',
                    'order'     => 'ASC',
                ];
                $args = array_merge($common_args, $older_args);
            }else{
                $args = $common_args;
            }    
            $post = new WP_Query( $args );
			?>
			
			<section class="section-padding widget1">
                
                    

                    <div class="aaz_pgcu_wrapper">
                        <div class="row">
                            
                            <div class="col-md">
                                <div id="pgcu_sw2">
                                    <div class="pgcu_sidebar_widget pgcu_sidebar_widget2">
                                        
                                        <!-- Ends: .pgcu_widget_head -->

                                        <div class="pgcu_widget_contents">
                                            <?php 
                                                if($post->have_posts()) :
                                                while($post->have_posts()) : $post->the_post();
                                                $image_id = get_post_thumbnail_id();
                                                $im = wp_get_attachment_image_src($image_id,'full');
                                                $image_resize_crop = !empty($image_resize_crop) ? $image_resize_crop : "yes";
                                                $image_ups         = !empty($image_ups) ? $image_ups : "yes";
                                                
                                            ?>
                                            <div class="pgcu_post_single">
                                                <figure class="pgcu_post__image">
                                                <?php 
                                                     $image_ups = true;
                                                     $image_width      = 100;
                                                     $image_hight       = 90;
                                                     $img = aq_resize($im[0], $image_width, $image_hight,true,true, $image_ups);
                                                ?>

                                                    <img src="<?php echo $img;?>" alt="">
                                                <?php ?>
                                                </figure>
                                                <div class="pgcu_post__details">
                                                    <div class="post_title">
                                                        <a href="<?php the_permalink();?>">
                                                            <h4><?php the_title();?></h4>
                                                        </a>
                                                    </div>
                                                    <ul class="author-date">
                                                        <li>
                                                            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta( 'ID' )))?>"><?php the_author();?></a><?php echo get_the_date();?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- Ends: .pgcu_post_single -->

                                            <?php 
                                            endwhile;
                                            wp_reset_postdata();
                                            endif;
                                            ?>
                                        </div>
                                        <!-- Ends: .pgcu_widget_contents -->
                                    </div>
                                    <!-- Ends: .pgcu_sidebar_widget -->
                                </div>
                            </div>
                            <!-- Ends: .col-md-4 -->
                        </div>
                    </div>
                    <!-- Ends: .aaz_pgcu_wrapper -->
               
            </section>
            <!-- Ends: section -->
			

			<?php
			echo $after_widget;
		}

        public function update( $new_instance, $old_instance ) {
            return $new_instance;
        }

		public function form($instance) {
			$title = __('Latest Posts',POST_GRID_CAROUSEL_TEXTDOMAIN);
                if(isset($instance['title']))
                {
            $title = $instance['title'];
                }
            $post_from = __('latest',POST_GRID_CAROUSEL_TEXTDOMAIN);
                if(isset($instance['post_from']))
                {
            $post_from = $instance['post_from'];
                }    

            $post_type = __('post',POST_GRID_CAROUSEL_TEXTDOMAIN);
                if(isset($instance['post_type']))
                {
            $post_type = $instance['post_type'];
                }

                $posts_per_page = 3;
                if( !empty( $instance['posts_per_page'] ) ) {
            $posts_per_page = $instance['posts_per_page'];
                }
             ?>
		     
		<p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php echo esc_html__( 'Title',POST_GRID_CAROUSEL_TEXTDOMAIN ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_name( 'post_from' ); ?>"><?php echo esc_html__( 'Display Post From',POST_GRID_CAROUSEL_TEXTDOMAIN ); ?></label> <br>
            <select name="<?php echo $this->get_field_name( 'post_from' ); ?>">
            	<option value="latest">Latest</option>
            	<option value="older" <?php if(!empty($post_from) && $post_from == "older"){ echo "selected";}?>>Older</option>
                <option disabled>Feature Post (Pro)</option>
                <option disabled>Populer Post (Pro)</option>
                <option disabled>Posts by category (Pro)</option>
                <option disabled>Posts by Id (Pro)</option>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_name( 'theme' ); ?>"><?php echo esc_html__( 'Select Theme',POST_GRID_CAROUSEL_TEXTDOMAIN ); ?></label> <br>
            <select name="<?php echo $this->get_field_name( 'theme' ); ?>">
                <option>Theme-1</option>
                <option disabled>Theme-2 (Pro)</option>
                <option disabled>Theme-3 (Pro)</option>
                <option disabled>Theme-3 (Pro)</option>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_name( 'posts_per_page' ); ?>"><?php echo esc_html__( 'Posts Per Page',POST_GRID_CAROUSEL_TEXTDOMAIN ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" type="number" value="<?php echo esc_attr( $posts_per_page ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_name( 'post_type' ); ?>"><?php echo esc_html__( 'Post Type',POST_GRID_CAROUSEL_TEXTDOMAIN ); ?></label> <br>
            <select name="<?php echo $this->get_field_name( 'post_type' ); ?>">
            	<?php 
                                    $custom_posts = get_post_types(array(
                                        'public'=>true, 
                                        ));

                                    $exclude    = array( 'adl-shortcode','attachment', 'revision', 'nav_menu_item' );

                                        foreach ( $exclude as $ex ) {
                                            unset( $custom_posts[ $ex ] );
                                        }


                                    if(!empty($custom_posts)) {
                                        foreach($custom_posts as $value){
                                            ?>
            	<option value="<?php echo $value;?>" <?php if(!empty($post_from) && $post_from == $value){ echo "selected";}?>><?php echo $value;?></option>
            	<?php }} ?>
            </select>
        </p>
        <p><a class="button button-primary" href="https://aazztech.com/product/post-grid-carousel-ultimate-pro/" target="_blank">Click here to unlock more features!</a></p>
		     <?php



		}	

	}	