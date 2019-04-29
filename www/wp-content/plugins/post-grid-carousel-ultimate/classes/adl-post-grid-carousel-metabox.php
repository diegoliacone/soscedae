<?php

if( !defined('ABSPATH')) { die('Direct access does not allow');}



	class adl_post_grid_carousel_metabox
	{
		public function __construct() {
			//add metabox
			add_action('add_meta_boxes',array($this,'gc_adl_add_meta_box'));

            //save post
            add_action('save_post',array($this,'gc_adl_save_meta_box'));
			

		}

		//method for add meta box
		public function gc_adl_add_meta_box() {
			add_meta_box(
				'short_metabox',
				__( 'Settings & Shortcode Generator',POST_GRID_CAROUSEL_TEXTDOMAIN ),
				array($this,'outpost_shortcode_metabox_markup'),
				ADL_SHORT_CODE_POST_TYPE,
				'normal'
				);
		}

        //Function that will check if value is a valid HEX color.
        public function check_color( $value ) { 
             
            if ( preg_match( '/^#[a-f0-9]{6}$/i', $value ) ) { // if user insert a HEX color with #     
                return true;
            }
             
            return false;
        }

		//output of shortcode metabox
		public function outpost_shortcode_metabox_markup( $post ){
            
            // Add a nonce field so we can check for it later.
            wp_nonce_field( 'aps_meta_save', 'gc_meta_save_nonce' );

            $get_value = get_post_meta($post->ID,'gc',true);
            

            $gc_value = is_array($get_value) ? $get_value : array();

            extract($gc_value);

            $layout = !empty($layout) ? $layout : 'carousel';
			?>
			<div id="tabs-container">        
				<ul class="tabs-menu">
                    <li class="current"><a href="#tab-1"> <?php esc_html_e('Shortcodes', POST_GRID_CAROUSEL_TEXTDOMAIN); ?> </a></li>

	                <li><a href="#tab-2"> <?php esc_html_e('General Settings', POST_GRID_CAROUSEL_TEXTDOMAIN); ?> </a></li>

	                <li style="display: <?php if($layout == "grid" || $layout == "isotope"){ echo "none";}else{ echo "block";}?>;" id="tab1"><a href="#tab-3"> <?php esc_html_e('Carousel Settings', POST_GRID_CAROUSEL_TEXTDOMAIN); ?> </a></li>

	                <li style="display: <?php if($layout == "grid"){ echo "block";}else{ echo "none";}?>;" id="tab2"><a href="#tab-4"> <?php esc_html_e('Grid Settings', POST_GRID_CAROUSEL_TEXTDOMAIN); ?> </a></li>

	                <li style="display: <?php if($layout == "isotope"){ echo "block";}else{ echo "none";}?>;" id="tab3"><a href="#tab-5"> <?php esc_html_e('Sortable Grid Settings', POST_GRID_CAROUSEL_TEXTDOMAIN); ?> </a></li>

	                <li><a href="#tab-6"> <?php esc_html_e('Style Settings', POST_GRID_CAROUSEL_TEXTDOMAIN); ?> </a></li>
            	</ul>

                <div id="tab-1" class="tab-content">
                   
                    <p><?php esc_html_e('Shortcode',POST_GRID_CAROUSEL_TEXTDOMAIN); ?></p>
                    <p><?php esc_html_e('Copy this shortcode and paste on page or post where you want to display post grid,carousel and sortable grid.Use PHP code to your themes file to display post grid.',POST_GRID_CAROUSEL_TEXTDOMAIN); ?></p>
                    <textarea cols="50" rows="1" style="background:#0074A8; color:#fff" onClick="this.select();" >[post_grid_carousel <?php echo 'id="'.$post->ID.'"';?>]</textarea>
                <br /><br />

                <p><?php esc_html_e('PHP Code:',POST_GRID_CAROUSEL_TEXTDOMAIN); ?></p>
                <textarea cols="60" rows="1" style="background:#0074A8; color:#fff" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[post_grid_carousel id='; echo "'".$post->ID."']"; echo '"); ?>'; ?></textarea>  
 

                
                </div>    

                <!-- General settings -->
            	<div id="tab-2" class="tab-content">
                    



                     <table class='form-table'>
                        <tr>
                            <th><label for="gc[post_type]"><?php esc_html_e('Post type', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                            <td>
                                <select id="gc[post_type]" name="gc[post_type]">
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

                                            <option value="<?php echo $value;?>" <?php if(!empty($post_type) && $post_type ==$value){ echo "selected";}?> ><?php echo $value;?></option>
                                            <?php
                                        }
                                    }
                                    ?>

                                    
                                    
                                </select>
                                
                            </td>

                        </tr>

                        <tr>
                            <th><label for="sel5"><?php esc_html_e('Layout', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                            <td>
                                <select  name="gc[layout]" id="sel5">
                                    <option value="carousel">Carousel</option>
                                    <option value="grid" <?php if(!empty($layout) && $layout == "grid"){ echo "selected";}?>>Grid</option>
                                    <option value="isotope" <?php if(!empty($layout) && $layout == "isotope"){ echo "selected";}?>>Sortable Grid</option>
                                    <option disabled>Masonry (Pro)</option>
                                </select>
                                
                            </td>
                        </tr>


                        <tr>
                            <th><label for="gc[total_posts]"><?php esc_html_e('Total Posts', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                            <td>
                                <input type='number' id="gc[total_posts]" name="gc[total_posts]" value="<?php if(empty($total_posts)) {echo '';
                                }else{ echo $total_posts;}?>"/>
                                
                            </td>
                        </tr>

                        

                        <tr>            
                            <th><label for="gc[post_from]"><?php esc_html_e('Display Post From', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label>
                            </th>
                            <td>
                                <select id="gc[post_from]" name="gc[post_from]">
                                    <option value="latest" <?php if(!empty($post_from) && $post_from == "latest"){ echo "selected";}?>>Latest Posts</option>
                                    <option value="older" <?php if(!empty($post_from) && $post_from == "older"){ echo "selected";}?>>Older Posts</option>
                                    <option disabled>Feature Posts (Pro)</option>
                                    <option disabled>Populer Posts (Pro)</option>
                                    <option disabled>Random Posts (Pro)</option>
                                    <option disabled>Posts by Category (Pro)</option>
                                    <option disabled>Posts by Id (Pro)</option>
                                    <option disabled>Posts by Tag (Pro)</option>
                                    <option disabled>Posts by Year (Pro)</option>
                                    <option disabled>Posts by Month (Pro)</option>
                                </select>
                                
                            </td>
                        </tr>

                        <tr>
                            <th><label for="gc[image_resize_crop]"><?php esc_html_e('Enable Image Resizing & Cropping', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                            <td><input type="radio" name="gc[image_resize_crop]" id="gc[image_resize_crop1]" value="yes" <?php if(empty($image_resize_crop) || 'no' !== $image_resize_crop) { echo 'checked'; } ?>> <label for="gc[image_resize_crop1]"><?php esc_html_e('Yes', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label> <br/>
                                 <input type="radio" name="gc[image_resize_crop]" id="gc[image_resize_crop2]" value="no" <?php if (!empty($image_resize_crop)) { checked('no', $image_resize_crop); } ?>> <label for="gc[image_resize_crop2]"><?php esc_html_e('No', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label>
                                <p class="description">If the product images are not in the same size, this feature is helpful. It automatically resizes and crops. Note: your image must be higher than/equal to the cropping size set below. Otherwise, you may need to enable image upscaling feature from the settings below.</p>
                            </td>
                                    
                        </tr>

                        <tr>
                            <th><label for="gc[image_ups]"><?php esc_html_e('Enable Image Upscaling', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                            <td><input type="radio" name="gc[image_ups]" id="gc[image_ups]" value="yes" <?php if(empty($image_ups) || 'no' !== $image_ups) { echo 'checked'; } ?>> <label for="gc[image_ups]"><?php esc_html_e('Yes', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label> <br/>
                                 <input type="radio" name="gc[image_ups]" id="gc[image_ups]" value="no" <?php if (!empty($image_ups)) { checked('no', $image_ups); } ?>> <label for="gc[image_ups]"><?php esc_html_e('No', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label>
                                <p class="description"><?php esc_html_e('If the product image is less than the cropping size set above then by default, image will break. However, you can solve this problem by enabling upscaling.', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></p>
                            </td>
                                    
                        </tr>

                        <tr>
                            <th><label for="gc[image_width]"><?php esc_html_e('Image Width', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                            <td>
                                <input type='number' id="gc[image_width]" name="gc[image_width]" value="<?php if(empty($image_width)) {echo '300';
                                }else{ echo $image_width;}?>"/>
                                <p class="description"><?php esc_html_e('Image cropping width.', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th><label for="gc[image_hight]"><?php esc_html_e('Image Height', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                            <td>
                                <input type='number' id="gc[image_hight]" name="gc[image_hight]" value="<?php if(empty($image_hight)) {echo '200';
                                }else{ echo $image_hight;}?>"/>
                                <p class="description"><?php esc_html_e('Image cropping height.', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></p>
                            </td>
                        </tr>



                    </table>	

                            



                           

                           

                        </div>

                        <!-- all grid content -->
                        <div id="tab-4" class="tab-content">
                            <table class="form-table">
                                
                                <tr>
                                    <th><label for="gc[g_theme]"><?php esc_html_e('Select Theme', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td>
                                        <select id="gc[g_theme]" name="gc[g_theme]">
                                            <option value="theme_1">Theme-1</option>
                                            <option value="theme_2" <?php if(!empty($g_theme) && $g_theme == "theme_2"){ echo "selected";}?>>Theme-2</option>
                                            <option disabled>Theme-3(Pro)</option>
                                            <option disabled>Theme-4(Pro)</option>
                                            <option disabled>Theme-5(Pro)</option>
                                            <option disabled>Theme-6(Pro)</option>
                                            <option disabled>Theme-7(Pro)</option>
                                            <option disabled>Theme-8(Pro)</option>
                                            <option disabled>Theme-9(Pro)</option>
                                            <option disabled>Theme-10(Pro)</option>
                                            <option disabled>Theme-11(Pro)</option>
                                            <option disabled>Theme-12(Pro)</option>
                                            <option disabled>Theme-13(Pro)</option>
                                            <option disabled>Theme-14(Pro)</option>
                                            <option disabled>Theme-15(Pro)</option>
                                            <option disabled>Theme-16(Pro)</option>
                                            <option disabled>Theme-17(Pro)</option>
                                            <option disabled>Theme-18(Pro)</option>
                                            <option disabled>Theme-19(Pro)</option>
                                            <option disabled>Theme-20(Pro)</option>
                                            <option disabled>Theme-21(Pro)</option>
                                        </select>
                                        
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="gc[g_column]"><?php esc_html_e('Select Columns', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td>
                                        <select id="gc[g_column]" name="gc[g_column]">
                                            <option value="3">Column-3</option>
                                            <option value="1" <?php if(!empty($g_column) && $g_column == "1"){ echo "selected";}?>>Column-1</option>
                                            <option value="2" <?php if(!empty($g_column) && $g_column == "2"){ echo "selected";}?>>Column-2</option>
                                            <option value="4" <?php if(!empty($g_column) && $g_column == "4"){ echo "selected";}?>>Column-4</option>
                                        </select>
                                        
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="gc[g_tablet]"><?php esc_html_e('Select Columns for Tablet', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td>
                                        <select id="gc[g_tablet]" name="gc[g_tablet]">
                                            <option value="2">Column-2</option>
                                            <option value="1" <?php if(!empty($g_tablet) && $g_tablet == "1"){ echo "selected";}?>>Column-1</option>
                                            <option value="3" <?php if(!empty($g_tablet) && $g_tablet == "3"){ echo "selected";}?>>Column-3</option>
                                            <option value="4" <?php if(!empty($g_tablet) && $g_tablet == "4"){ echo "selected";}?>>Column-4</option>
                                        </select>
                                       
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="gc[g_mobile]"><?php esc_html_e('Select Columns for Mobile', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td>
                                        <select id="gc[g_mobile]" name="gc[g_mobile]">
                                            <option value="1">Column-1</option>
                                            <option value="2" <?php if(!empty($g_mobile) && $g_mobile == "2"){ echo "selected";}?>>Column-2</option>
                                            <option value="3" <?php if(!empty($g_mobile) && $g_mobile == "3"){ echo "selected";}?>>Column-3</option>
                                            <option value="4" <?php if(!empty($g_mobile) && $g_mobile == "4"){ echo "selected";}?>>Column-4</option>
                                        </select>
                                        
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        <label for="gc[pagi_hide]"><?php esc_html_e('Pagination Hide', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label>
                                    </th>
                                    <td>
                                        <label class="switch"> 
                                            <input type="checkbox" name="gc[pagi_hide]" id="gc[pagi_hide]" value="true" <?php if( !empty($pagi_hide)) { checked( 'true', $pagi_hide); } ?>>
                                            <span class="slider round"></span>
                                        </label>
                                            
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        <label for="gc[pagi_text_color]"><?php esc_html_e('Pagination Text Color', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label>
                                    </th>
                                    <td>
                                        <input type="text" name="gc[pagi_text_color]" class="cpa-color-picker" value="<?php if(empty($pagi_text_color)) { echo "#000000";}else{ echo $pagi_text_color;}?>" />
                                        
                                    </td>
                                    
                                </tr>   

                                <tr>
                                    <th>
                                        <label for="gc[pagi_text_hover_color]"><?php esc_html_e('Pagination Text Hover Color', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label>
                                    </th>
                                    <td>
                                        <input type="text" name="gc[pagi_text_hover_color]" class="cpa-color-picker" value="<?php if(empty($pagi_text_hover_color)) { echo "#FF0000";}else{ echo $pagi_text_hover_color;}?>" />
                                        
                                    </td>
                                    
                                </tr>  

                                <tr>
                                    <th>
                                        <label for="gc[pagi_text_active_color]"><?php esc_html_e('Pagination Active Text Color', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label>
                                    </th>
                                    <td>
                                        <input type="text" name="gc[pagi_text_active_color]" class="cpa-color-picker" value="<?php if(empty($pagi_text_active_color)) { echo "#ffffff";}else{ echo $pagi_text_active_color;}?>" />
                                        
                                    </td>
                                    
                                </tr> 

                                <tr>
                                    <th>
                                        <label for="gc[pagi_active_back_color]"><?php esc_html_e('Pagination Active Background Color', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label>
                                    </th>
                                    <td>
                                        <input type="text" name="gc[pagi_active_back_color]" class="cpa-color-picker" value="<?php if(empty($pagi_active_back_color)) { echo "#dda146";}else{ echo $pagi_active_back_color;}?>" />
                                        
                                    </td>
                                    
                                </tr> 
                            </table>
                         </div>   

                            

                        <!-- Carousel content -->

                        <div id="tab-3" class="tab-content">
                            <table class="form-table">

                                <div id="tab-1" class="tab-content">
                                    

                                   <tr>
                                        <th><label for="gc[c_theme]"><?php esc_html_e('Select Theme', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                        <td>
                                            <select id="gc[c_theme]" name="gc[c_theme]">
                                                    <option value="theme_1">Theme-1</option>
                                                    <option value="theme_2" <?php if(!empty($c_theme) && $c_theme == "theme_2"){ echo "selected";}?>>Theme-2</option>
                                                    <option value="theme_3" <?php if(!empty($c_theme) && $c_theme == "theme_3"){ echo "selected";}?>>Theme-3</option>
                                                    <option disabled>Theme-4 (Pro)</option>
                                                    
                                            </select>
                                        </td>
                                   </tr>  
                                </div> 
                                <tr>
                            <th><label for="gc[post_column]"><?php esc_html_e('Post Column', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                            <td>
                                <input type='number' name="gc[post_column]" value="<?php if(empty($post_column)) { echo intval(3);}else{ echo $post_column;}?>"/>
                                
                            </td>
                        </tr>

                        


                        <tr>
                            <th><label for="gc[post_column_tablet]"><?php esc_html_e('Post column on Tablet', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                            <td>
                                <input type='number' name="gc[post_column_tablet]" id="gc[post_column_tablet]" value="<?php if(empty($post_column_tablet)) { echo intval(2);}else{ echo $post_column_tablet;}?>" />
                                
                            </td>
                        </tr>

                        <tr>
                            <th><label for="gc[post_column_mobile]"><?php esc_html_e('Post column on Mobile', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                            <td>
                                <input type='number' name="gc[post_column_mobile]" id="gc[post_column_mobile]" value="<?php if(empty($post_column_mobile)) { echo intval(1);}else{ echo $post_column_mobile;}?>" />
                                
                            </td>
                        </tr>  
                                <tr>
                                    <th><label for="gc[c_autoplay]"><?php esc_html_e('Autoplay Pause', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="checkbox" id="gc[c_autoplay]" name="gc[c_autoplay]" value="off" <?php if( !empty($c_autoplay)) { checked( 'off', $c_autoplay); } ?>/>
                                        
                                        
                                    </td>
                                    
                                </tr>

                                <tr>
                                    <th><label for="gc[c_autoplay_speed]"><?php esc_html_e('Autoplay Speed', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="number" id="gc[c_autoplay_speed]" name="gc[c_autoplay_speed]" value="<?php if(empty($c_autoplay_speed)) { echo intval(3000);}else{ echo $c_autoplay_speed;}?>"/><span class="description">(Millisecond)</span>
                                        
                                    </td>
                                    
                                </tr>

                                <tr>
                                    <th><label for="gc[c_autoplay_time]"><?php esc_html_e('Autoplay Timeout', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="number" id="gc[c_autoplay_time]" name="gc[c_autoplay_time]" value="<?php if(empty($c_autoplay_time)) { echo intval(2000);}else{ echo $c_autoplay_time;}?>"/><span class="description">(Millisecond)</span>
                                        
                                    </td>
                                    
                                </tr>

                                <tr>
                                    <th><label for="gc[c_pause_hover]"><?php esc_html_e('Pause on Hover', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="checkbox" id="gc[c_pause_hover]" name="gc[c_pause_hover]" value="on" <?php if( !empty($c_pause_hover)) { checked( 'on', $c_pause_hover); } ?> />
                                        
                                    </td>
                                    
                                </tr>                              

                                
                                <tr>
                                    <th><label for="gc[mouse_draggable]"><?php esc_html_e('Mouse Draggable', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="checkbox" name="gc[mouse_draggable]" id="gc[mouse_draggable]" value="off" <?php if( !empty($mouse_draggable)) { checked( 'off', $mouse_draggable); } ?>/>
                                        
                                    </td>
                                    
                                </tr>
                            </table>
                        </div>   

                        <div id="tab-6" class="tab-content">
                            <table class="form-table">
                                <tr>
                                    <th><label for="gc[post_title]"><?php esc_html_e('Post Title Hide', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="checkbox" name="gc[post_title]" id="gc[post_title]" value="off" <?php if( !empty($post_title)) { checked( 'off', $post_title); } ?> />
                                        
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="gc[post_title_color]"><?php esc_html_e('Post Title Color', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="text" name="gc[post_title_color]" id="gc[post_title_color]" class="cpa-color-picker" value="<?php if(empty($post_title_color)) { echo "#33330E";}else{ echo $post_title_color;}?>" />
                                        
                                    </td>
                                    
                                </tr>

                                <tr>
                                    <th><label for="gc[post_title_hover_color]"><?php esc_html_e('Post Title Hover Color', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="text" name="gc[post_title_hover_color]" id="gc[post_title_hover_color]" class="cpa-color-picker" value="<?php if(empty($post_title_hover_color)) { echo "#1289A7";}else{ echo $post_title_hover_color;}?>" >
                                        
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="gc[post_title_alignment]"><?php esc_html_e('Post Title Alignment', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label>
                                    </th>

                                    <td>    
                                        
                                        <select id="gc[post_title_alignment]" name="gc[post_title_alignment]">
                                                    <option>Default</option>
                                                    <option disabled>Left (Pro)</option>
                                                    <option disabled>Right (Pro)</option>
                                                    <option disabled>Center (Pro)</option>
                                                    <option disabled>Justify (Pro)</option>   
                                        </select>
                                         
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="gc[post_content]"><?php esc_html_e('Post Content Hide', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="checkbox" name="gc[post_content]" id="gc[post_content]" value="off" <?php if( !empty($post_content)) { checked( 'off', $post_content); } ?> />
                                        
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="gc[post_content_color]"><?php esc_html_e('Post Content Color', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="text" name="gc[post_content_color]" id="gc[post_content_color]" class="cpa-color-picker" value="<?php if(empty($post_content_color)) { echo "#6e7387";}else{ echo $post_content_color;}?>" />
                                        
                                    </td> 
                                </tr>

                                <tr>
                                    <th><label for="gc[post_content_alignment]"><?php esc_html_e('Post Content Alignment', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label>
                                    </th>

                                    <td>    
                                        
                                        <select id="gc[post_content_alignment]" name="gc[post_content_alignment]">
                                                    <option value="">Default</option>
                                                    <option disabled>Left (Pro)</option>
                                                    <option disabled>Right (Pro)</option>
                                                    <option disabled>Center (Pro)</option>
                                                    <option disabled>Justify (Pro)</option>   </select>
                                        
                                    </td>

                                </tr>

                                <tr>
                                    <th><label for="gc[post_author_name]"><?php esc_html_e('Post Author Name Hide', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="checkbox" name="gc[post_author_name]" id="gc[post_author_name]" value="off" <?php if( !empty($post_author_name)) { checked( 'off', $post_author_name); } ?> />
                                        
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="gc[post_date]"><?php esc_html_e('Post Date Hide', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="checkbox" name="gc[post_date]" id="gc[post_date]" value="off" <?php if( !empty($post_date)) { checked( 'off', $post_date); } ?> />
                                        
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="gc[post_category]"><?php esc_html_e('Post Category Hide', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="checkbox" name="gc[post_category]" id="gc[post_category]" value="off" <?php if( !empty($post_category)) { checked( 'off', $post_category); } ?> />
                                        
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="gc[read_more]"><?php esc_html_e('Read More Hide', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="checkbox" name="gc[read_more]" id="gc[read_more]" value="off" <?php if( !empty($read_more)) { checked( 'off', $read_more); } ?> />

                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="gc[read_more_color]"><?php esc_html_e('Read More Color', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="text" name="gc[read_more_color]" id="gc[read_more_color]" class="cpa-color-picker" value="<?php if(empty($read_more_color)) { echo "#33330E";}else{ echo $read_more_color;}?>" />
                                        
                                    </td> 
                                </tr>

                                <tr>
                                    <th><label for="gc[read_more_back_color]"><?php esc_html_e('Read More Background Color', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="text" name="gc[read_more_back_color]" id="gc[read_more_back_color]" class="cpa-color-picker" value="<?php if(empty($read_more_back_color)) { echo "#fff";}else{ echo $read_more_back_color;}?>" />

                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="gc[read_more_border_color]"><?php esc_html_e('Read More Border Color', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="text" name="gc[read_more_border_color]" id="gc[read_more_border_color]" class="cpa-color-picker" value="<?php if(empty($read_more_border_color)) { echo "#e4e4ed";}else{ echo $read_more_border_color;}?>" />

                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="gc[read_more_hover_color]"><?php esc_html_e('Read More Hover  Color', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="text" name="gc[read_more_hover_color]" id="gc[read_more_hover_color]" class="cpa-color-picker" value="<?php if(empty($read_more_hover_color)) { echo "#dd3333";}else{ echo $read_more_hover_color;}?>" />
                                        
                                    </td> 
                                </tr>

                                <tr>
                                    <th><label for="gc[read_more_hover_back_color]"><?php esc_html_e('Read More Hover Background Color', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="text" name="gc[read_more_hover_back_color]" id="gc[read_more_hover_back_color]" class="cpa-color-picker" value="<?php if(empty($read_more_hover_back_color)) { echo "#1289A7";}else{ echo $read_more_hover_back_color;}?>" />
                                        
                                    </td> 
                                </tr>
                            </table>
                        </div>

                        <!-- all isotope content -->

                        <div id="tab-5" class="tab-content">
                            <table class="form-table">
                                 
                                <tr>
                                        <th><label for="gc[g_sort]"><?php esc_html_e('Select Sortable Grid Type', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                        <td>
                                            <select id="gc[g_sort]" name="gc[g_sort]">
                                                    <option value="cat">Category</option>
                                                    <option value="tag" <?php if(!empty($g_sort) && $g_sort == "tag"){ echo "selected";}?>>Tag</option>
                                                    
                                            </select>
                                        </td>
                                </tr> 

                                <tr>
                                        <th><label for=""><?php esc_html_e('Select Theme', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                        <td>
                                            <select id="gc[c_theme]" name="gc[c_theme]">
                                                    <option disabled>Theme-1 (Pro)</option>
                                                    <option disabled>Theme-2 (Pro)</option>
                                                    
                                                    
                                            </select>
                                        </td>
                                   </tr>  
                                <tr>
                                    <th><label for="gc[grid_menu_back]"><?php esc_html_e('Sortable Menu Background Hover Color', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="text" name="gc[grid_menu_back]" class="cpa-color-picker" value="<?php if(empty($grid_menu_back)) { echo "#ee5253";}else{ echo $grid_menu_back;}?>" />
                                        
                                    </td>
                                    
                                </tr>   

                                <tr>
                                    <th><label for="gc[grid_menu_text]"><?php esc_html_e('Sortable Menu Text Hover Color', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="text" name="gc[grid_menu_text]" class="cpa-color-picker" value="<?php if(empty($grid_menu_text)) { echo "#fff";}else{ echo $grid_menu_text;}?>" />
                                        
                                    </td>
                                    
                                </tr>  

                                <tr>
                                    <th><label for="gc[grid_active_back]"><?php esc_html_e('Sortable Menu Background Active Color', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="text" name="gc[grid_active_back]" class="cpa-color-picker" value="<?php if(empty($grid_active_back)) { echo "#ee5253";}else{ echo $grid_active_back;}?>" />
                                        
                                    </td>
                                    
                                </tr>   

                                <tr>
                                    <th><label for="gc[grid_active_text]"><?php esc_html_e('Sortable Menu Text Active Color', POST_GRID_CAROUSEL_TEXTDOMAIN); ?></label></th>
                                    <td><input type="text" name="gc[grid_active_text]" class="cpa-color-picker" value="<?php if(empty($grid_active_text)) { echo "#fff";}else{ echo $grid_active_text;}?>" />
                                        
                                    </td>
                                    
                                </tr> 
                            </table>
                        </div>

                    
                

			


			<?php
		}

        //save  all posts
        public function gc_adl_save_meta_box($post_id) {


           
            // Perform checking for before saving
            $is_autosave = wp_is_post_autosave($post_id);
            $is_revision = wp_is_post_revision($post_id);
            $is_valid_nonce = (isset($_POST['gc_meta_save_nonce']) && wp_verify_nonce( $_POST['gc_meta_save_nonce'], 'aps_meta_save' )? 'true': 'false');

            if ( $is_autosave || $is_revision || !$is_valid_nonce ) return;
            // Is the user allowed to edit the post or page?
            if ( !current_user_can( 'edit_post', $post_id )) return;



            $val    = isset($_POST['gc']) ? $_POST['gc'] : '';
            $value  = is_array($val) ? $val : array();

            update_post_meta($post_id,'gc',$value);

        }

		

	} // end class
