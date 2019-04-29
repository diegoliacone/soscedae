<?php if( !defined('ABSPATH')) { die('direct browsing can not possible');} ?>
<section class="section-padding">
    <div id="pgcu_style1">
        <div class="pgcu_container c_theme_1">
            <div class="pgcu_row">
                <div class="col-md-12">
                    <div class="aaz_pgcu_wrapper">
                        <div class="pgcu_post_slider-<?php echo $rand;?>">
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
                            <div class="pgcu_post_slider__single">
                                <article class="pgcu_post pgcu_post--style1">
                                    
                                    <figure class="pgcu_post__image">
                                        <?php if($image_resize_crop !== "no") {
                                            $image_ups = ( $image_ups !== "no") ? true : false;
                                            $image_width       = !empty($image_width) ? $image_width : 300;
                                            $image_hight       = !empty($image_hight) ? $image_hight : 200;
                                            $img = aq_resize($im[0], $image_width, $image_hight,true,true, $image_ups);
                                        ?>
                                        <img src="<?php echo $img;?>" alt="">
                                        <?php }else{?>

                                        <img src="<?php echo $im[0];?>" alt="">


                                        <?php } ?>
                                    </figure>
                                    <?php
                                    if ( $post_title != 'off' || $post_category != 'off' || $post_date != 'off' || $post_content != 'off') {
                                    ?>
                                    <div class="pgcu_post__contents">
                                        <?php if(empty($post_title) || $post_title != 'off'){
                                        ?>
                                        <div class="post_title">
                                            <a target="_blank" href="<?php the_permalink();?>">
                                                <h4><?php the_title();?></h4>
                                            </a>
                                        </div>
                                        <?php } ?>
                                        <?php if('off' != $post_category || 'off' != $post_date) {?>
                                        <div class="post_info">
                                            <ul>
                                                <?php if(empty($post_date) || $post_date != 'off'){?>
                                                <li><?php echo get_the_date('F j, Y');?></li>
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
                                                        $output []= "{$space}<a href='{$link}'>{$cat->name}</a>";
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
                                        <a target="_blank" href="<?php the_permalink();?>" class="read_more"><?php esc_html_e('Read More', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></a>
                                        <?php } ?>
                                      <?php } ?>
                                    </div>
                                    <?php } ?>
                                </article>
                            </div>

                            <?php 

                            endwhile;
                            wp_reset_query();
                            endif;



                            ?>
                        </div>

                        <span class="icon-arrow-right nav_icon slide-<?php echo $rand;?>"></span>
                        <span class="icon-arrow-left nav_icon slide-<?php echo $rand;?>"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>