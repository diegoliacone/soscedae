<?php 
            $post = new WP_Query(array(
                'post_type'         => 'post',
                'posts_per_page'    => (!empty($total_posts) ? $total_posts : -1),
                'status'            => 'publish',
                'orderby'           =>(!empty($order_by) ? $order_by : 'title'),
                'order'             => (!empty($order) ? $order : 'DESC')

                ));
	if( $g_sort != "tag" && $g_sort != "cat_c") {

       
?>




<section class="section-padding">
    <div id="pgcu_style3">
        <div class="pgcu_container s_theme_1">
            
            <div class="aaz_pgcu_wrapper">
                <div class="pgcu_row">
                    <div class="col-md-12">
                        <div class="pgcu_filter_area">
                            <ul>
                                <li data-filter="all" class="active">All</li>
                                <?php 
                                    $names = get_categories(get_the_id());
                                    $names = !empty($names) ? $names : array();
                                    foreach( $names as $name) {
                                ?>
                                <li data-filter="<?php echo $name->slug;?>"><?php echo $name->name;?> </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row pgcu_filterable_container">
                	<?php 
                    if($post->have_posts()) :
                        while($post->have_posts()) : $post->the_post() ;
                        $cat_names = get_the_category();
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
                    <div class="col-md-4 filtr-item" data-category="<?php 
                     $output = array();
                     $cat_names = !empty($cat_names) ? $cat_names : array();
                    foreach($cat_names as $cat_name){
                        $output [] =  $cat_name->slug;
                        echo join(',', $output);
                    }
                    ?>">
                        <article class="pgcu_post pgcu_post--style2">
                            
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
                            <?php
                            if ( $post_title != 'off' || $post_category != 'off' || $post_date != 'off' || $post_content != 'off' || $post_author_name != 'off') { ?>
                            <div class="pgcu_post__contents">
                                <?php
                                    if(empty($post_title) || $post_title != "off") {
                                ?>
                                <div class="post_title">
                                    <a target="_blank" href="<?php the_permalink();?>">
                                        <h4><?php the_title();?></h4>
                                    </a>
                                </div>
                                <?php } ?>
                                <?php if ( $post_category != 'off' || $post_date != 'off' || $post_author != 'off') { ?>
                                <div class="post_info">
                                    <ul>
                                        <?php if(empty($post_author_name) || $post_author_name != "off") {?>
                                        <li>
                                            <span class="icon-user"></span>
                                            <a target="_blank" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta( 'ID' )))?>"><?php the_author();?></a>
                                        </li>
                                        <?php } ?>
                                        <?php if(empty($post_date) || $post_date != 'off') {?>
                                        <li>
                                            <span class="icon-calendar"></span> <?php echo get_the_date();?>
                                        </li>
                                        <?php } ?>
                                        <?php if(empty($post_category) || $post_category != 'off') {?>
                                        <li class="category">
                                            <span class="icon-folder"></span>
                                            <?php
                                                $cats = get_the_category();
                                                $output = array();
                                                    foreach($cats as $cat) {
                                                        $link = get_category_link($cat->term_id);
                                                        $output []= "<a href='{$link}'>{$cat->name}</a>";
                                                    }
                                                    echo join(',', $output);
                                            ?>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <?php } ?>
                                <?php if(empty($post_content) || $post_content != 'off'){?>
                                <p><?php echo wp_trim_words(get_the_content(),25);?>
                                </p>
                                <?php if(empty($read_more) || $read_more != 'off'){?>
                                <a href="<?php the_permalink();?>" class="read_more"><?php esc_html_e('Read More', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></a>
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
                </div>
            </div>
        </div>
    </div>
</section>








<?php
	}elseif( $g_sort == "tag") {
        

?>



<section class="section-padding">
    <div id="pgcu_style3">
        <div class="pgcu_container s_theme_1">
            

            <div class="aaz_pgcu_wrapper">
                <div class="pgcu_row">
                    <div class="col-md-12">
                        <div class="pgcu_filter_area">
                            <ul>
                                <li data-filter="all" class="active">All</li>
                                <?php
                                    $names = get_tags(get_the_id());
                                    foreach( $names as $name) {
                               ?>
                                <li data-filter="<?php echo $name->slug;?>"><?php echo $name->name;?> </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row pgcu_filterable_container">
                    <?php
                        while($post->have_posts()) : $post->the_post() ;
                        $cat_names = get_the_tags();
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
                    <div class="col-md-4 filtr-item" data-category="<?php 
                     $output = array();
                     $cat_names = !empty($cat_names) ? $cat_names : array();
                    foreach($cat_names as $cat_name){
                        $output [] =  $cat_name->slug;
                        echo join(',', $output);
                    }
                    ?>">
                        <article class="pgcu_post pgcu_post--style2">

                            <figure class="pgcu_post__image">
                                <?php if($image_resize_crop !== "no") {
                                 $image_ups = ( $image_ups !== "no") ? true : false;
                                 $image_width      = !empty($image_width) ? $image_width : 300;
                                 $image_hight       = !empty($image_hight) ? $image_hight : 200;
                                 $img = aq_resize($im[0], $image_width, $image_hight,true,true, $image_ups);
                                ?>
                                <img src="<?php echo $img;?>" alt="">
                                <?php }else{?>
                                <img src="<?php echo $im[0];?>" alt="">
                                <?php } ?>
                            </figure>
                            <?php
                            if ( $post_title != 'off' || $post_category != 'off' || $post_date != 'off' || $post_content != 'off' || $post_author_name != 'off') {
                                ?>
                            <div class="pgcu_post__contents">
                                <?php
                                    if(empty($post_title) || $post_title != "off") {
                                ?>
                                <div class="post_title">
                                    <a target="_blank" href="<?php the_permalink();?>">
                                        <h4><?php the_title();?></h4>
                                    </a>
                                </div>
                                <?php } ?>
                                <?php
                                if ( $post_category != 'off' || $post_date != 'off' || $post_author_name != 'off') {
                                    ?>
                                <div class="post_info">
                                    <ul>
                                        <?php if(empty($post_author_name) || $post_author_name != "off") {?>
                                        <li>
                                            <span class="icon-user"></span>
                                            <a target="_blank" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta( 'ID' )))?>"><?php the_author();?></a>
                                        </li>
                                        <?php } ?>
                                        <?php if(empty($post_date) || $post_date != 'off') {?>
                                        <li>
                                            <span class="icon-calendar"></span> <?php echo get_the_date();?>
                                        </li>
                                        <?php } ?>
                                        <?php if(empty($post_category) || $post_category != 'off') {?>
                                        <li class="category">
                                            <span class="icon-folder"></span>
                                            <?php
                                                $cats = get_the_category();
                                                $output = array();
                                                foreach($cats as $cat) {
                                                    $link = get_category_link($cat->term_id);
                                                    $output []= "<a href='{$link}'>{$cat->name}</a>";
                                                }
                                                echo join(',', $output);
                                            ?>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <?php } if(empty($post_content) || $post_content != 'off'){?>
                                <p><?php echo wp_trim_words(get_the_content(),25);?>
                                </p>
                                <?php if(empty($read_more) || $read_more != 'off'){?>
                                <a href="<?php the_permalink();?>" class="read_more"><?php esc_html_e('Read More', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></a>
                                <?php } } ?>
                            </div>
                            <?php } ?>
                        </article>
                    </div>

                    <?php endwhile;?>
                </div>
            </div>
        </div>
    </div>
    </section>







<?php } ?>