<?php
namespace ElementPack\Modules\Marker\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Image Widget
 */
class Marker extends Widget_Base {

	public function get_name() {
		return 'bdt-marker';
	}

	public function get_title() {
		return __( 'Marker', 'bdthemes-element-pack' );
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-post';
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_image',
			[
				'label' => __( 'Image', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label'   => __( 'Choose Image', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'image', // Actually its `image_size`.
				'label'   => __( 'Image Size', 'bdthemes-element-pack' ),
				'default' => 'large',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => __( 'Alignment', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'bdthemes-element-pack' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'bdthemes-element-pack' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'bdthemes-element-pack' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'caption',
			[
				'label'       => __( 'Caption', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => '',
				'placeholder' => __( 'Enter your caption about the image', 'bdthemes-element-pack' ),
				'title'       => __( 'Input image caption here', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => __( 'Link to', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => __( 'http://your-link.com', 'bdthemes-element-pack' ),
				'condition'   => [
					'link_to' => 'custom',
				],
				'show_label' => false,
			]
		);

		$this->add_control(
			'marker_animation',
			[
				'label'        => __( 'Animation', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_sliders',
			[
				'label' => esc_html__( 'Markers', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'markers',
			[
				'label' => esc_html__( 'Marker Items', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'marker_title'   => esc_html__( 'Marker #1', 'bdthemes-element-pack' ),
						'marker_x_position' => [
							'size' => 50,
							'unit' => '%',
						],
						'marker_y_position' => [
							'size' => 50,
							'unit' => '%',
						]
					],
					[
						'marker_title'   => esc_html__( 'Marker #2', 'bdthemes-element-pack' ),
						'marker_x_position' => [
							'size' => 30,
							'unit' => '%',
						],
						'marker_y_position' => [
							'size' => 30,
							'unit' => '%',
						]
					],
					[
						'marker_title'   => esc_html__( 'Marker #3', 'bdthemes-element-pack' ),
						'marker_x_position' => [
							'size' => 80,
							'unit' => '%',
						],
						'marker_y_position' => [
							'size' => 20,
							'unit' => '%',
						]
					],
				],
				'fields' => [
					[
						'name'        => 'marker_title',
						'label'       => esc_html__( 'Title', 'bdthemes-element-pack' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => esc_html__( 'Marker Title' , 'bdthemes-element-pack' ),
						'label_block' => true,
					],
					[
						'name'  => 'marker_x_position',
						'label' => esc_html__( 'X Postion', 'bdthemes-element-pack' ),
						'type' => Controls_Manager::SLIDER,
						'default' => [
							'size' => 20,
							'unit' => '%',
						],
						'range' => [
							'%' => [
								'min' => 0,
								'max' => 100,
							],
						],
					],
					[
						'name'  => 'marker_y_position',
						'label' => esc_html__( 'Y Postion', 'bdthemes-element-pack' ),
						'type' => Controls_Manager::SLIDER,
						'default' => [
							'size' => 20,
							'unit' => '%',
						],
						'range' => [
							'%' => [
								'min' => 0,
								'max' => 100,
							],
						],
					],
					[
						'name'    => 'link_to',
						'label'   => esc_html__( 'Link to', 'bdthemes-element-pack' ),
						'type'    => Controls_Manager::SELECT,
						'default' => 'custom',
						'options' => [
							'custom'   => __( 'Custom URL', 'bdthemes-element-pack' ),
							'lightbox' => __( 'Lightbox', 'bdthemes-element-pack' ),
							''         => __( 'None', 'bdthemes-element-pack' ),
						],
					],
					[
						'name'        => 'marker_link',
						'label'       => esc_html__( 'Link', 'bdthemes-element-pack' ),
						'type'        => Controls_Manager::URL,
						'dynamic'     => [ 'active' => true ],
						'placeholder' => 'http://your-link.com',
						'default'     => [
							'url' => '#',
						],
						'condition' => [
							'link_to' => 'custom',
						],
					],
					[
						'name'    => 'image_link',
						'label'   => esc_html__( 'Choose Image', 'bdthemes-element-pack' ),
						'type'    => Controls_Manager::MEDIA,
						'default' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'condition' => [
							'link_to' => 'lightbox',
						],
					],
				],
				'title_field' => '{{{ marker_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => __( 'Image', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'space',
			[
				'label'   => __( 'Size (%)', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-marker-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'opacity',
			[
				'label'   => __( 'Opacity', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-marker-wrapper img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'image_border',
				'label'     => __( 'Image Border', 'bdthemes-element-pack' ),
				'selector'  => '{{WRAPPER}} .bdt-marker-wrapper img',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_radius',
			[
				'label'      => __( 'Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-marker-wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'    => 'image_shadow',
				'exclude' => [
					'shadow_position',
				],
				'selector' => '{{WRAPPER}} .bdt-marker-wrapper img',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_caption',
			[
				'label' => __( 'Caption', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'caption_align',
			[
				'label'   => __( 'Alignment', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => '',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .widget-image-caption' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .widget-image-caption' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'caption_typography',
				'selector' => '{{WRAPPER}} .widget-image-caption',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_marker',
			[
				'label' => __( 'Marker', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'marker_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-marker-wrapper .bdt-marker' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'marker_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-marker-wrapper .bdt-marker' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'marker_size',
			[
				'label'   => __( 'Size', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-marker-wrapper .bdt-marker > svg' => 'width: calc({{SIZE}}{{UNIT}} - 12px); height: auto;',
					'{{WRAPPER}} .bdt-marker-animated .bdt-marker:before, 
					{{WRAPPER}} .bdt-marker-animated .bdt-marker:after' => 'width: calc({{SIZE}}{{UNIT}} + 12px); height: calc({{SIZE}}{{UNIT}} + 12px);',
				],
			]
		);

		$this->add_control(
			'marker_opacity',
			[
				'label'   => __( 'Opacity (%)', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-marker-wrapper .bdt-marker' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'marker_border',
				'label'     => __( 'Image Border', 'bdthemes-element-pack' ),
				'selector'  => '{{WRAPPER}} .bdt-marker-wrapper .bdt-marker',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'marker_radius',
			[
				'label'      => __( 'Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-marker-wrapper .bdt-marker' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .bdt-marker-animated .bdt-marker:before, {{WRAPPER}} .bdt-marker-animated .bdt-marker:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'    => 'marker_shadow',
				'exclude' => [
					'shadow_position',
				],
				'selector' => '{{WRAPPER}} .bdt-marker-wrapper .bdt-marker',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['image']['url'] ) ) {
			return;
		}

		$has_caption = ! empty( $settings['caption'] );

		$this->add_render_attribute( 'wrapper', 'class', 'bdt-marker-wrapper bdt-inline bdt-dark' );

		if ('yes' === $settings['marker_animation']) {
			$this->add_render_attribute( 'wrapper', 'class', 'bdt-marker-animated' );
			$this->add_render_attribute( 'wrapper', 'bdt-scrollspy', 'target: > .bdt-marker; cls:bdt-animation-scale-up; delay: 350' );
		}

		$this->add_render_attribute('wrapper', 'bdt-lightbox', 'toggle: .bdt-marker-lightbox-item; animation: slide;');

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>			
	        
			<?php if ( $has_caption ) : ?>
				<figure class="wp-caption">
			<?php
			endif;

			echo Group_Control_Image_Size::get_attachment_image_html( $settings );
		    
		    foreach ($settings['markers'] as $marker) {

				$this->add_render_attribute('marker', 'class',  ['bdt-position-absolute bdt-transform-center'], true);
				$this->add_render_attribute('marker', 'style', 'left:' . $marker['marker_x_position']['size'] . '%;', true);
				$this->add_render_attribute('marker', 'style', 'top:' . $marker['marker_y_position']['size'] . '%;');

				if ($marker['link_to'] and $marker['marker_link']) {
					
					if ( 'lightbox' === $marker['link_to'] ) {
						$this->add_render_attribute( 'marker', 'data-elementor-open-lightbox', 'no');
						$this->add_render_attribute( 'marker', 'data-caption', $marker['marker_title']);
						$this->add_render_attribute( 'marker', 'class', 'bdt-marker-lightbox-item');
						$this->add_render_attribute('marker', 'href', $marker['image_link']['url'], true);
					} else {
						$this->add_render_attribute('marker', 'href', $marker['marker_link']['url'], true);
						if ( ! empty( $marker['marker_link']['is_external'] ) ) {
							$this->add_render_attribute('marker', 'target', ['_blank'], true);
						}					
						if ( ! empty( $marker['marker_link']['nofollow'] ) ) {
							$this->add_render_attribute('marker', 'rel', ['nofollow'], true);
						}
					}
					
				}

				if ($marker['marker_title']) {
					$this->add_render_attribute('marker', 'title', [$marker['marker_title']], true);
					$this->add_render_attribute('marker', 'bdt-tooltip', ['pos: top'], true);
				} 
		    	?>
		    	
				<a <?php echo $this->get_render_attribute_string('marker'); ?> bdt-marker></a>

				<?php
		    	
		    }

			if ( $has_caption ) : ?>
				<figcaption class="widget-image-caption wp-caption-text"><?php echo $settings['caption']; ?></figcaption>
			<?php
			endif;

			if ( $has_caption ) : ?>
				</figure>
			<?php endif; ?>
		</div>
		<?php
	}

	protected function _content_template() {
		?>
		<# if ( '' !== settings.image.url ) {
			var image = {
				id: settings.image.id,
				url: settings.image.url,
				size: settings.image_size,
				dimension: settings.image_custom_dimension,
				model: view.getEditModel()
			};

			var image_url = elementor.imagesManager.getImageUrl( image );

			if ( ! image_url ) {
				return;
			}


			var has_caption = ! settings.caption;

			view.addRenderAttribute( 'wrapper', 'class', [ 'bdt-marker-wrapper', 'bdt-inline', 'bdt-dark' ] );

			if ('yes' === settings.marker_animation) {
				view.addRenderAttribute( 'wrapper', 'class', [ 'bdt-marker-animated' ] );
			}

			var marker_wrapper = view.getRenderAttributeString( 'wrapper' ); #>
			
			<div <# print(marker_wrapper); #>><#
				var imgClass = '',
					hasCaption = '' !== settings.caption;

				if ( hasCaption ) { #>
					<figure class="wp-caption">
				<# } #>

				

				<img src="{{ image_url }}" class="{{ imgClass }}" />


			
				<# _.each( settings.markers, function( item ) { 
								
					view.addRenderAttribute( 'marker', 'class', [ 'bdt-position-absolute', 'bdt-transform-center' ], true );
					view.addRenderAttribute( 'marker', 'style', 'left:' + item.marker_x_position.size + '%;', true );
					view.addRenderAttribute( 'marker', 'style', 'top:' + item.marker_y_position.size + '%;' );

					if (item.link_to && item.marker_link) {					
						if ( 'lightbox' === item.link_to ) {
							view.addRenderAttribute( 'marker', 'data-elementor-open-lightbox', 'no');
							view.addRenderAttribute( 'marker', 'data-caption', item.marker_title);
							view.addRenderAttribute( 'marker', 'class', 'bdt-marker-lightbox-item');
							view.addRenderAttribute('marker', 'href', item.image_link.url, true);
						} else {
							view.addRenderAttribute('marker', 'href', item.marker_link.url, true);
							if ( item.marker_link.is_external) {
								view.addRenderAttribute('marker', 'target', '_blank', true);
							}					
							if (item.marker_link.nofollow) {
								view.addRenderAttribute('marker', 'rel', 'nofollow', true);
							}
						}					
					}

					if (item.marker_title) {
						view.addRenderAttribute( 'marker', 'title', [item.marker_title], true );
						view.addRenderAttribute( 'marker', 'bdt-tooltip', ['pos: top'], true );
					} 


					#>		 
					
					<a <# print( view.getRenderAttributeString( 'marker' ) ); #> bdt-marker></a>

				<# }); #>
			
				 

				<# if ( hasCaption ) { #>
					<figcaption class="widget-image-caption wp-caption-text">{{{ settings.caption }}}</figcaption><#
				}

				if ( hasCaption ) { #>
					</figure>
				<# } #>
			</div>
			<# } #>
		<?php
	}
}
