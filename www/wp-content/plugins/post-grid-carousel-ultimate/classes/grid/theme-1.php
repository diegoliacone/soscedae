<section class="section-padding">
    <div id="pgcu_style2">
        <div class="pgcu_container g_theme_1">
            
            <div class="pgcu_row">
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
                    <article class="pgcu_post pgcu_post--style1">
                        <?php if(empty($post_image) || $post_image != "off") {?>
                        <figure class="pgcu_post__image">
                            <?php if($image_resize_crop !== "no") {
                                 $image_ups = ( $image_ups !== "no") ? true : false;
                                 $image_width      = !empty($image_width) ? $image_width : 300;
                                 $image_hight       = !empty($image_hight) ? $image_hight : 200;
                                 $img = aq_resize($im[0], $image_width, $image_hight,true,true, $image_ups);
                            ?>

                            <img src="<?php echo $img;?>" alt="">
                            <?php }else{ ?>

                            <img src="<?php echo $im[0];?>" alt="">

                            <?php } ?>
                        </figure>
                        <?php } ?>
                        <?php
                        if ( $post_title != 'off' || $post_category != 'off' || $post_date != 'off' || $post_content != 'off') {
                            ?>
                        <div class="pgcu_post__contents">
                        	<?php if(empty($post_title) || $post_title != "off") {?>
                            <div class="post_title">
                                <a target="_blank" href="<?php the_permalink();?>">
                                    <h4><?php the_title();?></h4>
                                </a>
                            </div>
                            <?php } ?>
                            <?php
                            if ($post_category != 'off' || $post_date != 'off' ) {
                            ?>
                            <div class="post_info">
                                <ul>
                                	<?php if(empty($post_date) || $post_date != "off") {?>
                                    <li><?php echo get_the_date();?></li>
                                    <?php } ?>
                                    <?php 
                                    if(empty($post_category) || $post_category != 'off'){
                                                    if(empty($post_type) || $post_type == 'post'){
                                                	$cats = get_the_category();
                                                	if(!empty($cats)){
                                    ?>
                                    <li class="category">in
                                        
                                        	<?php 
		                                                    	
		                                    $output = array();
		                                   	                                                    	
		                                    foreach($cats as $cat) {
		                                     $link = get_category_link($cat->term_id);
                                             $space = str_repeat('&nbsp;', 1);
		                                     $output []= "{$space}<a target='_blank' href='{$link}'>{$cat->name}</a>";
		                                    }
		                                    echo join(',', $output);
		                                                    
		                                    ?>
                                        
                                    </li>
                                    <?php } } }?>
                                </ul>
                            </div>
                            <?php } ?>
                            <?php if(empty($post_content) || $post_content != 'off'){?>
                            <p><?php echo wp_trim_words(get_the_content(),16);?></p>

                            <?php if(empty($read_more) || $read_more != 'off'){?>
                            <a href="<?php the_permalink();?>" target="_blank" class="read_more"><?php esc_html_e('Read More', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></a>
                            <?php }
                             } ?>
                        </div>
                        <?php } ?>
                    </article>
                </div>

                <?php 
                endwhile;
                wp_reset_postdata();
                endif;
                ?>

                
            </div>

            <?php

            if(empty($pagi_hide)  || $pagi_hide  != 'true') {
                    $pages  = $post->max_num_pages;
                    $big    = 999999999; // need an unlikely integer
                
                
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
            }
                
            ?>

        </div>
    </div>
</section>