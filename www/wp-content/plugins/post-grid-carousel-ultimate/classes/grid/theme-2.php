<section class="section-padding">
        <div class="pgcu_container g_theme_2">
            <div class="aaz_pgcu_wrapper">
                <div class="pgcu_row theme2-posts-container">
                    <?php
                    if($post->have_posts()) :
                        while($post->have_posts()) : $post->the_post();
                            if('at_biz_dir' == $post_type) {
                                $image_id       = get_post_meta(get_the_ID(), '_listing_prv_img', true);
                            }elseif('advert' == $post_type) {
                                $gallery_img       = json_decode(get_post_meta(get_the_ID(), '_adverts_attachments_order', true));

                                $image_id = $gallery_img[0];
                            }else{
                                $image_id = get_post_thumbnail_id();
                            }

                            $im = wp_get_attachment_image_src($image_id,'full');
                            ?>
                    <div class="<?php if($g_column != 1 && $g_column != 2 && $g_column != 4){ echo "col-md-4";}elseif($g_column == 1){ echo "col-md-12";}elseif($g_column == 2) { echo "col-md-6";}elseif($g_column == 4) {echo "col-md-3";}?> <?php if($g_tablet != '1' && $g_tablet != '3' && $g_tablet != 4){ echo "col-sm-6";}elseif($g_tablet == 1){echo "col-sm-12";}elseif($g_tablet == 3){ echo "col-sm-4";}elseif($g_tablet == 4){ echo "col-sm-3";}?> <?php if($g_mobile != 2 && $g_mobile != 3 && $g_mobile != 4){ echo "col-xs-12";}elseif($g_mobile == 2){ echo "col-xs-6";}elseif($g_mobile == 3){ echo "col-xs-4";}elseif($g_mobile == 4){ echo "col-xs-3";}?>">
                        <article class="pgcu_post pgcu_post--style3">
                            <?php if(empty($post_image) || $post_image != "off") {?>
                            <figure class="pgcu_post__image">
                                <?php if($image_resize_crop !== "no") {
                                 $image_ups = ( $image_ups !== "no") ? true : false;
                                 $image_width      = !empty($image_width) ? $image_width : 300;
                                 $image_hight       = !empty($image_hight) ? $image_hight : 290;
                                 $img = aq_resize($im[0], $image_width, $image_hight,true,true, $image_ups);
                            ?>
                                <img src="<?php echo $img;?>" alt="">
                                <?php }else{?>
                                <img src="<?php echo $im[0];?>" alt="">
                                <?php } ?>
                            </figure>
                            <?php } ?>
                            <?php
                            if ( $post_title != 'off' || $post_content != 'off') {
                            ?>
                            <div class="pg_post__contents pgcu">
                                <?php if(empty($post_title) || $post_title != "off") {?>
                                <div class="post_title">
                                    <a href="<?php the_permalink();?>">
                                        <h4><?php the_title();?></h4>
                                    </a>
                                </div>
                                <?php } ?>
                                <?php 
                                $content = !empty($content_words) ? $content_words : 20;
                                if(empty($post_content) || $post_content != 'off'){?>
                                <p><?php echo wp_trim_words(get_the_content(),intval($content));?>
                                </p>
                                <?php if(empty($read_more) || $read_more != 'off'){?>
                                <a href="<?php the_permalink();?>" class="btn rmbtn btn--colored">Read More</a>
                                <?php } } ?>
                            </div>
                            <?php } ?>
                        </article>
                    </div>

                    <?php 
                    endwhile;
                    wp_reset_query();
                    endif;
                 ?>
             </div> <!-- end row -->

             <?php

            if(empty($pagi_hide)  || $pagi_hide  != 'true') {
                    $pages  = $post->max_num_pages;
                    $big    = 999999999; // need an unlikely integer
                if( empty($loading_type) || $loading_type == "number_pagi" ) {
                
                if ($pages > 1)
                {
                ?>
                <div class="row">
                    <div class="col-md-12">
                                <div class="pgcu_pagination">
                                    <ul class="list-unstyled">
                    <?php
                    echo paginate_links( array(
                        'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format'    => '?paged=%#%',
                        'current'   => max( 1, get_query_var('paged') ),
                        'total'     => $pages,
                        'prev_text' => __('Previous',POST_GRID_CAROUSEL_TEXTDOMAIN),
                        'next_text' => __('Next',POST_GRID_CAROUSEL_TEXTDOMAIN),
                        'mid_side'  => 1,
                    ) );

                    } // end of $pages
                    ?>
                                    </ul>
                                </div>
                                <!-- Ends: .pgcu_pagination -->
                    </div>
                </div>
                <?php 
                }else{ 
                    if ($pages > 1) {?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pgcu_load_more">
                                <a  class="btn load--btn theme2-load-more" data-page="1" data-posttype="<?php echo $post_type;?>" data-total="<?php echo $total_posts;?>" data-status="<?php echo $post_status;?>" data-from="<?php echo $post_from;?>" data-cat="<?php echo $post_by_cat;?>" data-id="<?php echo $posts_by_id;?>" data-tag="<?php echo $posts_by_tag;?>" data-year="<?php echo $posts_by_year;?>" data-month="<?php echo $posts_from_month;?>" data-monthyear="<?php echo $posts_from_month_year;?>" data-content="<?php echo $content_words;?>" data-column="<?php echo $g_column;?>" data-tablet="<?php echo $g_tablet;?>" data-mobile="<?php echo $g_mobile;?>" data-url="<?php echo admin_url('admin-ajax.php');?>">Load More
                                <span class="icon-refresh"></span>
                             </a>
                        </div>
                    </div>
               </div>


               <?php }// end of pages
                } // end of $loading_type
            } // end of $pagi_hide
            ?>







            </div>
        </div>
    </section>