<?php
namespace ElementPack\Modules\TestimonialSlider\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Testimonial_Slider extends Widget_Base {

	protected $_has_template_content = false;

	public function get_name() {
		return 'bdt-testimonial-slider';
	}

	public function get_title() {
		return esc_html__( 'Testimonial Slider', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-testimonial-carousel';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_script_depends() {
		return [ 'bdt-uikit-icons' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'source',
			[
				'label'   => _x( 'Source', 'Posts Query Control', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''        => esc_html__( 'Show All', 'bdthemes-element-pack' ),
					'by_name' => esc_html__( 'Manual Selection', 'bdthemes-element-pack' ),
				],
				'label_block' => true,
			]
		);


		$post_categories = get_terms( 'testimonial_categories' );

		$post_options = [];
		foreach ( $post_categories as $category ) {
			$post_options[ $category->slug ] = $category->name;
		}

		$this->add_control(
			'post_categories',
			[
				'label'       => esc_html__( 'Categories', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $post_options,
				'default'     => [],
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [
					'source'    => 'by_name',
				],
			]
		);

		$this->add_control(
			'posts',
			[
				'label'   => esc_html__( 'Posts Limit', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order by', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'     => esc_html__( 'Date', 'bdthemes-element-pack' ),
					'title'    => esc_html__( 'Title', 'bdthemes-element-pack' ),
					'category' => esc_html__( 'Category', 'bdthemes-element-pack' ),
					'rand'     => esc_html__( 'Random', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => esc_html__( 'Descending', 'bdthemes-element-pack' ),
					'ASC'  => esc_html__( 'Ascending', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'thumb',
			[
				'label'   => esc_html__( 'Testimonial Image', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'company_name',
			[
				'label'   => esc_html__( 'Company Name/Address', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'rating',
			[
				'label'   => esc_html__( 'Rating', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_slider_settins',
			[
				'label' => esc_html__( 'Slider Settings', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => esc_html__( 'Auto Play', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'loop',
			[
				'label'   => esc_html__( 'Loop', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_navigation',
			[
				'label' => __( 'Navigation', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'navigation',
			[
				'label'   => __( 'Navigation', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'arrows',
				'options' => [
					'both'   => __( 'Arrows and Dots', 'bdthemes-element-pack' ),
					'arrows' => __( 'Arrows', 'bdthemes-element-pack' ),
					'dots'   => __( 'Dots', 'bdthemes-element-pack' ),
					'none'   => __( 'None', 'bdthemes-element-pack' ),
				],
				'prefix_class' => 'bdt-navigation-type-',
				'render_type' => 'template',				
			]
		);
		
		$this->add_control(
			'both_position',
			[
				'label'     => __( 'Arrows and Dots Position', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => element_pack_navigation_position(),
				'condition' => [
					'navigation' => 'both',
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label'     => __( 'Arrows Position', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => element_pack_navigation_position(),
				'condition' => [
					'navigation' => 'arrows',
				],				
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label'     => __( 'Dots Position', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'bottom-center',
				'options'   => element_pack_pagination_position(),
				'condition' => [
					'navigation' => 'dots',
				],				
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_style',
			[
				'label' => esc_html__( 'Style', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-meta .bdt-testimonial-title' => 'color: {{VALUE}};',
				],
				'condition' => ['title' => 'yes'],
			]
		);

		$this->add_control(
			'address_color',
			[
				'label'     => esc_html__( 'Company Name/Address Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-meta .bdt-testimonial-address' => 'color: {{VALUE}};',
				],
				'condition' => [
					'company_name' => 'yes',
				],
			]
		);

		$this->add_control(
			'rating_color',
			[
				'label'     => esc_html__( 'Rating Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e7e7e7',
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-rating .bdt-rating-item' => 'color: {{VALUE}};',
				],
				'condition' => [
					'rating' => 'yes',
				],
			]
		);

		$this->add_control(
			'active_rating_color',
			[
				'label'     => esc_html__( 'Active Rating Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFCC00',
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-rating.bdt-rating-1 .bdt-rating-item:nth-child(1)'            => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-rating.bdt-rating-2 .bdt-rating-item:nth-child(-n+2)'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-rating.bdt-rating-3 .bdt-rating-item:nth-child(-n+3)'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-rating.bdt-rating-4 .bdt-rating-item:nth-child(-n+4)'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-rating.bdt-rating-5 .bdt-rating-item:nth-child(-n+5)'         => 'color: {{VALUE}};',
				],
				'condition' => [
					'rating' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'     => __( 'Navigation', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation' => [ 'arrows', 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label' => __( 'Arrows Size', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-prev svg, {{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-next svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_background',
			[
				'label'     => __( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-prev, {{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-next' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_background',
			[
				'label'     => __( 'Hover Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-prev:hover, {{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-next:hover' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => __( 'Arrows Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-prev svg, {{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-next svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => __( 'Arrows Hover Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-prev:hover svg, {{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-next:hover svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_space',
			[
				'label' => __( 'Space', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-prev' => 'margin-right: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-next' => 'margin-left: {{SIZE}}px;',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_padding',
			[
				'label' => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-prev, {{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'separator'  => 'after',
				'selectors'  => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-prev, {{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label' => __( 'Dots Size', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'     => __( 'Dots Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .swiper-pagination-bullet' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'active_dot_color',
			[
				'label'     => __( 'Active Dots Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .swiper-pagination-bullet-active' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_ncx_position',
			[
				'label'   => __( 'Horizontal Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[
							'name'     => 'arrows_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_ncy_position',
			[
				'label'   => __( 'Vertical Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 40,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-arrows-container' => 'transform: translate({{arrows_ncx_position.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[
							'name'     => 'arrows_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_acx_position',
			[
				'label'   => __( 'Horizontal Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => -60,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[
							'name'  => 'arrows_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'dots_nnx_position',
			[
				'label'   => __( 'Horizontal Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'dots',
						],
						[
							'name'     => 'dots_position',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'dots_nny_position',
			[
				'label'   => __( 'Vertical Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-dots-container' => 'transform: translate({{dots_nnx_position.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'dots',
						],
						[
							'name'     => 'dots_position',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_ncx_position',
			[
				'label'   => __( 'Horizontal Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_ncy_position',
			[
				'label'   => __( 'Vertical Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 40,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-arrows-dots-container' => 'transform: translate({{both_ncx_position.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_cx_position',
			[
				'label'   => __( 'Arrows Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => -60,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'  => 'both_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_cy_position',
			[
				'label'   => __( 'Dots Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-dots-container' => 'transform: translateY({{SIZE}}px);',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'  => 'both_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render_header() {
		$id       = $this->get_id();
		$settings = $this->get_settings();
		
		$this->add_render_attribute( 'testimonial-slider', 'id', 'bdt-testimonial-slider-' . $id );
		$this->add_render_attribute( 'testimonial-slider', 'class', 'bdt-testimonial-slider bdt-testimonial-slider-skin-default' );

		if ('arrows' == $settings['navigation']) {
			$this->add_render_attribute( 'testimonial-slider', 'class', 'bdt-arrows-align-'. $settings['arrows_position'] );
		}
		if ('dots' == $settings['navigation']) {
			$this->add_render_attribute( 'testimonial-slider', 'class', 'bdt-dots-align-'. $settings['dots_position'] );
		}
		if ('both' == $settings['navigation']) {
			$this->add_render_attribute( 'testimonial-slider', 'class', 'bdt-arrows-dots-align-'. $settings['both_position'] );
		}

		?>

		<div <?php echo $this->get_render_attribute_string( 'testimonial-slider' ); ?>>
			<div class="swiper-container">
				<div class="swiper-wrapper">
		<?php
	}

	protected function render_footer() {
		$id       = 'bdt-testimonial-slider-' . $this->get_id();
		$settings = $this->get_settings();
		
		?>
				</div>
			</div>
			
			<?php if ('both' == $settings['navigation']) : ?>
				<?php $this->render_both_navigation(); ?>
				<?php if ('center' === $settings['both_position']) : ?>
					<div class="bdt-dots-container">
						<div class="swiper-pagination"></div>
					</div>
				<?php endif; ?>
			<?php else : ?>			
				<?php $this->render_pagination(); ?>
				<?php $this->render_navigation(); ?>
			<?php endif; ?>
			
		</div>

		<?php $this->render_script($id);
	}

	public function render_both_navigation() {
		$settings = $this->get_settings();

		?>
		<div class="bdt-position-z-index bdt-position-<?php echo esc_attr($settings['both_position']); ?>">
			<div class="bdt-arrows-dots-container bdt-slidenav-container ">
				
				<div class="bdt-flex bdt-flex-middle">
					<div class="bdt-visible@m">
						<a href="javascript:void(0);" class="bdt-navigation-prev bdt-slidenav-previous bdt-icon bdt-slidenav" bdt-icon="icon: chevron-left; ratio: 1.9"></a>
					</div>

					<?php if ('center' !== $settings['both_position']) : ?>
						<div class="swiper-pagination"></div>
					<?php endif; ?>
					
					<div class="bdt-visible@m">
						<a href="javascript:void(0);" class="bdt-navigation-next bdt-slidenav-next bdt-icon bdt-slidenav" bdt-icon="icon: chevron-right; ratio: 1.9"></a>
					</div>
					
				</div>
			</div>
		</div>
		<?php
	}

	public function render_navigation() {
		$settings = $this->get_settings();

		if ( 'arrows' == $settings['navigation'] ) : ?>
			<div class="bdt-position-z-index bdt-visible@m bdt-position-<?php echo esc_attr($settings['arrows_position']); ?>">
				<div class="bdt-arrows-container bdt-slidenav-container">
					<a href="javascript:void(0);" class="bdt-navigation-prev bdt-slidenav-previous bdt-icon bdt-slidenav" bdt-icon="icon: chevron-left; ratio: 1.9"></a>
					<a href="javascript:void(0);" class="bdt-navigation-next bdt-slidenav-next bdt-icon bdt-slidenav" bdt-icon="icon: chevron-right; ratio: 1.9"></a>
				</div>
			</div>
		<?php endif;
	}

	public function render_pagination() {
		$settings = $this->get_settings();

		if ( 'dots' == $settings['navigation'] ) : ?>
			<?php if ( 'arrows' !== $settings['navigation'] ) : ?>
				<div class="bdt-position-z-index bdt-position-<?php echo esc_attr($settings['dots_position']); ?>">
					<div class="bdt-dots-container">
						<div class="swiper-pagination"></div>
					</div>
				</div>
			<?php endif; ?>
		<?php endif;
	}

	public function render_script($id) {
		$settings = $this->get_settings();

		?>
		<script>
			jQuery(document).ready(function($) {
			    "use strict";				    
			    var swiper = new Swiper("#<?php echo esc_attr($id); ?> .swiper-container", {
					navigation: {
						nextEl: "#<?php echo esc_attr($id); ?> .bdt-navigation-next",
						prevEl: "#<?php echo esc_attr($id); ?> .bdt-navigation-prev",
					},
					pagination: {
					  el: "#<?php echo esc_attr($id); ?> .swiper-pagination",
					  type: 'bullets',
					  clickable: true,
					},
			        "centeredSlides" : true,
			        "autoplay"       : <?php echo ($settings['autoplay'] == 'yes') ? '{ "delay": ' . $settings['autoplay_speed'] . ' }' : 'false'; ?>,
			        "loop"           : <?php echo ($this->get_settings('loop') == 'yes') ? 'true' : 'false'; ?>,
			        "slidesPerView"  : 'auto',
			    });
			});
		</script>
		<?php
	}

	public function query_posts() {

		$settings = $this->get_settings();

		$args = array(
			'post_type'      => 'bdthemes-testimonial',
			'posts_per_page' => $settings['posts'],
			'orderby'        => $settings['orderby'],
			'order'          => $settings['order'],
			'post_status'    => 'publish'
		);

		if ( 'by_name' === $settings['source'] and !empty($settings['post_categories']) ) {			  
			$args['tax_query'][] = array(
				'taxonomy' => 'testimonial_categories',
				'field'    => 'slug',
				'terms'    => $settings['post_categories'],
			);
		}

		$this->_query = new \WP_Query( $args );
	}

	public function get_query() {
		return $this->_query;
	}

	public function render() {
		$settings  = $this->get_settings();

		$rating_align = ($settings['thumb']) ? '' : ' bdt-flex-center';

		$this->query_posts();

		$wp_query = $this->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}
			$this->render_header();
		?>
			<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

		  		<div class="swiper-slide">

                	<div class="bdt-testimonial-text"><?php the_excerpt(); ?></div>
                	
                		<div class="bdt-flex bdt-flex-center bdt-flex-middle">

	                    <?php if('yes' == $settings['thumb']) : ?>
                        	<div><div class="bdt-testimonial-thumb"><?php echo  the_post_thumbnail('medium', array('class' => ''));  ?></div></div>
	                    <?php endif ?>

	                    <?php if (('yes' == $settings['title']) or ('yes' == $settings['company_name']) or ('yes' == $settings['rating'])) : ?>
						    <div class="bdt-testimonial-meta">
		                        <?php if ('yes' == $settings['title']) : ?>
		                            <div class="bdt-testimonial-title"><?php echo esc_attr(get_the_title()); ?></div>
		                        <?php endif ?>

		                        <?php if ( 'yes' == $settings['company_name']) : ?>
		                        	<?php $separator = (( 'yes' == $settings['title'] ) and ( 'yes' == $settings['company_name'] )) ? ', ' : ''?>
		                            <span class="bdt-testimonial-address"><?php echo esc_attr( $separator ).get_post_meta(get_the_ID(), 'bdthemes_tm_company_name', true); ?></span>
		                        <?php endif ?>
		                        
		                        <?php if ('yes' == $settings['rating']) : ?>
		                            <ul class="bdt-rating bdt-rating-<?php echo get_post_meta(get_the_ID(), 'bdthemes_tm_rating', true); ?> bdt-grid bdt-grid-collapse<?php echo esc_attr($rating_align); ?>">
					                    <li class="bdt-rating-item"><i class="fa fa-star" aria-hidden="true"></i></span></li>
										<li class="bdt-rating-item"><i class="fa fa-star" aria-hidden="true"></i></span></li>
										<li class="bdt-rating-item"><i class="fa fa-star" aria-hidden="true"></i></span></li>
										<li class="bdt-rating-item"><i class="fa fa-star" aria-hidden="true"></i></span></li>
										<li class="bdt-rating-item"><i class="fa fa-star" aria-hidden="true"></i></span></li>
					                </ul>
		                        <?php endif ?>

		                    </div>
		                <?php endif ?>

	                </div>
                </div>
		  
			<?php endwhile;
			wp_reset_postdata();
			
		$this->render_footer();
	}
}
