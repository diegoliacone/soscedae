<?php
namespace ElementPack\Modules\PostGrid\Skins;
use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Carmie extends Elementor_Skin_Base {

	public function get_id() {
		return 'bdt-carmie';
	}

	public function get_title() {
		return __( 'Carmie', 'bdthemes-element-pack' );
	}

	public function render() {
		global $post;

		$settings = $this->parent->get_settings();
		
		$id       = $this->parent->get_id();
		$classes  = ['bdt-post-grid', 'bdt-post-grid-skin-carmie'];


		$this->parent->add_render_attribute('post-grid-item', 'class', 'bdt-width-1-'. $settings['columns_mobile']);
		$this->parent->add_render_attribute('post-grid-item', 'class', 'bdt-width-1-'. $settings['columns_tablet'] .'@s');
		$this->parent->add_render_attribute('post-grid-item', 'class', 'bdt-width-1-'. $settings['columns'] .'@m');

		$this->parent->query_posts($settings['carmie_item_limit']['size']);
		$wp_query = $this->parent->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		add_filter( 'excerpt_more', [ $this->parent, 'filter_excerpt_more' ], 20 );
		add_filter( 'excerpt_length', [ $this->parent, 'filter_excerpt_length' ], 20 );

		?> 
		<div id="bdt-post-grid-<?php echo esc_attr($id); ?>" class="<?php echo \element_pack_helper::acssc($classes); ?>">
	  		<div class="bdt-grid bdt-grid-<?php echo esc_attr($settings['column_gap']); ?>" bdt-grid>

				<?php

			
				while ($wp_query->have_posts()) :
					$wp_query->the_post();
		  			?>		

		            <div <?php echo $this->parent->get_render_attribute_string( 'post-grid-item' ); ?>>
		                <div class="bdt-post-grid-item bdt-transition-toggle bdt-position-relative">
								
							<?php $this->parent->render_image(get_post_thumbnail_id( $post->ID ), $image_size = 'full' ); ?>

							<div class="bdt-custom-overlay bdt-position-cover"></div>
					  		
					  		<div class="bdt-post-grid-desc bdt-position-bottom-left">
						  		<div class="bdt-position-medium ">
					            	<?php if (('yes' == $settings['show_author']) or ('yes' == $settings['show_date'])) : ?>
										<div class="bdt-post-grid-meta bdt-subnav">
											<?php $this->parent->render_author(); ?>
											<?php $this->parent->render_date(); ?>
										</div>
									<?php endif; ?>

									<?php $this->parent->render_title(); ?>

							  		<div class="bdt-transition-slide-bottom">
										<?php $this->parent->render_excerpt(); ?>
									</div>
								</div>
							</div>

							<?php $this->parent->render_category(); ?>

						</div>
		            </div>

				<?php endwhile; ?>
			</div>
		</div>
	
 		<?php 
		remove_filter( 'excerpt_length', [ $this->parent, 'filter_excerpt_length' ], 20 );
		remove_filter( 'excerpt_more', [ $this->parent, 'filter_excerpt_more' ], 20 );
		wp_reset_postdata();
	}
}

