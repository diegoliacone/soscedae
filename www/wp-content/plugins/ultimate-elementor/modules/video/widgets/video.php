<?php
/**
 * UAEL Video.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\Video\Widgets;


// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;

// UltimateElementor Classes.
use UltimateElementor\Base\Common_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class Video.
 */
class Video extends Common_Widget {

	/**
	 * Retrieve Video Widget name.
	 *
	 * @since 1.3.2
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_slug( 'Video' );
	}

	/**
	 * Retrieve Video Widget title.
	 *
	 * @since 1.3.2
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return parent::get_widget_title( 'Video' );
	}

	/**
	 * Retrieve Video Widget icon.
	 *
	 * @since 1.3.2
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'Video' );
	}

	/**
	 * Retrieve Widget Keywords.
	 *
	 * @since 1.5.1
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_keywords() {
		return parent::get_widget_keywords( 'Video' );
	}

	/**
	 * Retrieve the list of scripts the image carousel widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.3.2
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'uael-frontend-script' ];
	}


	/**
	 * Register Video controls.
	 *
	 * @since 1.3.2
	 * @access protected
	 */
	protected function _register_controls() {

		$this->register_video_content();
		$this->register_overlay_content();
		$this->register_video_icon_style();
		$this->register_helpful_information();
	}

	/**
	 * Video Tab.
	 *
	 * @since 1.3.2
	 * @access protected
	 */
	protected function register_video_content() {

		$this->start_controls_section(
			'section_video',
			[
				'label' => __( 'Video', 'uael' ),
			]
		);

			$this->add_control(
				'video_type',
				[
					'label'   => __( 'Video Type', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'youtube',
					'options' => [
						'youtube' => __( 'YouTube', 'uael' ),
						'vimeo'   => __( 'Vimeo', 'uael' ),
					],
				]
			);

			$this->add_control(
				'youtube_link',
				[
					'label'       => __( 'Link', 'uael' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active'     => true,
						'categories' => [
							TagsModule::POST_META_CATEGORY,
						],
					],
					'default'     => 'https://www.youtube.com/watch?v=HJRzUQMhJMQ',
					'label_block' => true,
					'condition'   => [
						'video_type' => 'youtube',
					],
				]
			);
			$this->add_control(
				'youtube_link_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '<b>Note:</b> Make sure you add the actual URL of the video and not the share URL.</br></br><b>Valid:</b>&nbsp;https://www.youtube.com/watch?v=HJRzUQMhJMQ</br><b>Invalid:</b>&nbsp;https://youtu.be/HJRzUQMhJMQ', 'uael' ) ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'video_type' => 'youtube',
					],
					'separator'       => 'none',
				]
			);

			$this->add_control(
				'vimeo_link',
				[
					'label'       => __( 'Link', 'uael' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active'     => true,
						'categories' => [
							TagsModule::POST_META_CATEGORY,
						],
					],
					'default'     => 'https://vimeo.com/274860274',
					'label_block' => true,
					'condition'   => [
						'video_type' => 'vimeo',
					],
				]
			);
			$this->add_control(
				'vimeo_link_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '<b>Note:</b> Make sure you add the actual URL of the video and not the categorized URL.</br></br><b>Valid:</b>&nbsp;https://vimeo.com/274860274</br><b>Invalid:</b>&nbsp;https://vimeo.com/channels/staffpicks/274860274', 'uael' ) ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'video_type' => 'vimeo',
					],
					'separator'       => 'none',
				]
			);

			$this->add_control(
				'start',
				[
					'label'       => __( 'Start Time', 'uael' ),
					'type'        => Controls_Manager::NUMBER,
					'description' => __( 'Specify a start time (in seconds)', 'uael' ),
					'condition'   => [
						'video_type' => [ 'youtube', 'vimeo' ],
					],
				]
			);

			$this->add_control(
				'end',
				[
					'label'       => __( 'End Time', 'uael' ),
					'type'        => Controls_Manager::NUMBER,
					'description' => __( 'Specify an end time (in seconds)', 'uael' ),
					'condition'   => [
						'video_type' => 'youtube',
					],
				]
			);

			$this->add_control(
				'aspect_ratio',
				[
					'label'        => __( 'Aspect Ratio', 'uael' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'16_9' => '16:9',
						'4_3'  => '4:3',
						'3_2'  => '3:2',
					],
					'default'      => '16_9',
					'prefix_class' => 'uael-aspect-ratio-',
				]
			);

			$this->add_control(
				'heading_youtube',
				[
					'label'     => __( 'Video Options', 'uael' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			// YouTube.
			$this->add_control(
				'yt_autoplay',
				[
					'label'     => __( 'Autoplay', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => [
						'video_type' => 'youtube',
					],
				]
			);

			$this->add_control(
				'yt_rel',
				[
					'label'     => __( 'Suggested Videos', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => __( 'Hide', 'uael' ),
					'label_on'  => __( 'Show', 'uael' ),
					'condition' => [
						'video_type' => 'youtube',
					],
				]
			);

			$this->add_control(
				'yt_controls',
				[
					'label'     => __( 'Player Control', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => __( 'Hide', 'uael' ),
					'label_on'  => __( 'Show', 'uael' ),
					'default'   => 'yes',
					'condition' => [
						'video_type' => 'youtube',
					],
				]
			);

			$this->add_control(
				'yt_showinfo',
				[
					'label'     => __( 'Player Title & Actions', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => __( 'Hide', 'uael' ),
					'label_on'  => __( 'Show', 'uael' ),
					'default'   => 'yes',
					'condition' => [
						'video_type' => 'youtube',
					],
				]
			);

			$this->add_control(
				'yt_mute',
				[
					'label'     => __( 'Mute', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => [
						'video_type' => 'youtube',
					],
				]
			);

			$this->add_control(
				'yt_modestbranding',
				[
					'label'       => __( 'Modest Branding', 'uael' ),
					'description' => __( 'This option lets you use a YouTube player that does not show a YouTube logo.', 'uael' ),
					'type'        => Controls_Manager::SWITCHER,
					'condition'   => [
						'video_type'  => 'youtube',
						'yt_controls' => 'yes',
					],
				]
			);

			$this->add_control(
				'yt_privacy',
				[
					'label'       => __( 'Privacy Mode', 'uael' ),
					'type'        => Controls_Manager::SWITCHER,
					'description' => __( 'When you turn on privacy mode, YouTube won\'t store information about visitors on your website unless they play the video.', 'uael' ),
					'condition'   => [
						'video_type' => 'youtube',
					],
				]
			);

			// Vimeo.
			$this->add_control(
				'vimeo_autoplay',
				[
					'label'     => __( 'Autoplay', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'vimeo_loop',
				[
					'label'     => __( 'Loop', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'vimeo_title',
				[
					'label'     => __( 'Intro Title', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => __( 'Hide', 'uael' ),
					'label_on'  => __( 'Show', 'uael' ),
					'default'   => 'yes',
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'vimeo_portrait',
				[
					'label'     => __( 'Intro Portrait', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => __( 'Hide', 'uael' ),
					'label_on'  => __( 'Show', 'uael' ),
					'default'   => 'yes',
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'vimeo_byline',
				[
					'label'     => __( 'Intro Byline', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => __( 'Hide', 'uael' ),
					'label_on'  => __( 'Show', 'uael' ),
					'default'   => 'yes',
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'vimeo_color',
				[
					'label'     => __( 'Controls Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .uael-vimeo-title a'  => 'color: {{VALUE}}',
						'{{WRAPPER}} .uael-vimeo-byline a' => 'color: {{VALUE}}',
						'{{WRAPPER}} .uael-vimeo-title a:hover' => 'color: {{VALUE}}',
						'{{WRAPPER}} .uael-vimeo-byline a:hover' => 'color: {{VALUE}}',
						'{{WRAPPER}} .uael-vimeo-title a:focus' => 'color: {{VALUE}}',
						'{{WRAPPER}} .uael-vimeo-byline a:focus' => 'color: {{VALUE}}',
					],
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Overlay Tab.
	 *
	 * @since 1.3.2
	 * @access protected
	 */
	protected function register_overlay_content() {

		$this->start_controls_section(
			'section_image_overlay',
			[
				'label' => __( 'Thumbnail & Overlay', 'uael' ),
			]
		);

			$this->add_control(
				'yt_thumbnail_size',
				[
					'label'     => __( 'Thumbnail Size', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'maxresdefault' => __( 'Maximum Resolution', 'uael' ),
						'hqdefault'     => __( 'High Quality', 'uael' ),
						'mqdefault'     => __( 'Medium Quality', 'uael' ),
						'sddefault'     => __( 'Standard Quality', 'uael' ),
					],
					'default'   => 'maxresdefault',
					'condition' => [
						'video_type' => 'youtube',
					],
				]
			);

			$this->add_control(
				'show_image_overlay',
				[
					'label'        => __( 'Custom Thumbnail', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_off'    => __( 'No', 'uael' ),
					'label_on'     => __( 'Yes', 'uael' ),
					'default'      => 'no',
					'return_value' => 'yes',
				]
			);

			$this->add_control(
				'image_overlay',
				[
					'label'     => __( 'Select Image', 'uael' ),
					'type'      => Controls_Manager::MEDIA,
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'dynamic'   => [
						'active' => true,
					],
					'condition' => [
						'show_image_overlay' => 'yes',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'image_overlay', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_overlay_size` and `image_overlay_custom_dimension`.
					'default'   => 'full',
					'separator' => 'none',
					'condition' => [
						'show_image_overlay' => 'yes',
					],
				]
			);

			$this->add_control(
				'image_overlay_color',
				[
					'label'     => __( 'Overlay Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-video__outer-wrap:before' => 'background: {{VALUE}}',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Style Tab.
	 *
	 * @since 1.3.2
	 * @access protected
	 */
	protected function register_video_icon_style() {

		$this->start_controls_section(
			'section_play_icon',
			[
				'label' => __( 'Play Button', 'uael' ),
			]
		);

			$this->add_control(
				'play_source',
				[
					'label'   => __( 'Image/Icon', 'uael' ),
					'type'    => Controls_Manager::CHOOSE,
					'options' => [
						'img'  => [
							'title' => __( 'Image', 'uael' ),
							'icon'  => 'fa fa-picture-o',
						],
						'icon' => [
							'title' => __( 'Icon', 'uael' ),
							'icon'  => 'fa fa-info-circle',
						],
					],
					'default' => 'icon',
				]
			);

			$this->add_control(
				'play_img',
				[
					'label'     => __( 'Select Image', 'uael' ),
					'type'      => Controls_Manager::MEDIA,
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'play_source' => 'img',
					],
				]
			);

			$this->add_control(
				'play_icon',
				[
					'label'     => __( 'Select Icon', 'uael' ),
					'type'      => Controls_Manager::ICON,
					'default'   => 'fa fa-play-circle',
					'condition' => [
						'play_source' => 'icon',
					],
				]
			);

			$this->add_responsive_control(
				'play_icon_size',
				[
					'label'     => __( 'Size', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 10,
							'max' => 700,
						],
					],
					'default'   => [
						'size' => 72,
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .uael-video__play-icon:before' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .uael-video__play-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .uael-video__play-icon > img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'hover_animation_img',
				[
					'label'     => __( 'Hover Animation', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => [
						''                => __( 'None', 'uael' ),
						'float'           => __( 'Float', 'uael' ),
						'sink'            => __( 'Sink', 'uael' ),
						'wobble-vertical' => __( 'Wobble Vertical', 'uael' ),
					],
					'condition' => [
						'play_source' => 'img',
					],
				]
			);

			$this->start_controls_tabs( 'tabs_style' );

				$this->start_controls_tab(
					'tab_normal',
					[
						'label'     => __( 'Normal', 'uael' ),
						'condition' => [
							'play_icon!'  => '',
							'play_source' => 'icon',
						],
					]
				);

					$this->add_control(
						'play_icon_color',
						[
							'label'     => __( 'Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .uael-video__play-icon' => 'color: {{VALUE}}',
							],
							'condition' => [
								'play_icon!'  => '',
								'play_source' => 'icon',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Text_Shadow::get_type(),
						[
							'name'      => 'play_icon_text_shadow',
							'selector'  => '{{WRAPPER}} .uael-video__play-icon',
							'condition' => [
								'play_icon!'  => '',
								'play_source' => 'icon',
							],
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_hover',
					[
						'label'     => __( 'Hover', 'uael' ),
						'condition' => [
							'play_icon!'  => '',
							'play_source' => 'icon',
						],
					]
				);

					$this->add_control(
						'play_icon_hover_color',
						[
							'label'     => __( 'Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .uael-video__outer-wrap:hover .uael-video__play-icon' => 'color: {{VALUE}}',
							],
							'condition' => [
								'play_icon!'  => '',
								'play_source' => 'icon',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Text_Shadow::get_type(),
						[
							'name'      => 'play_icon_hover_text_shadow',
							'selector'  => '{{WRAPPER}} .uael-video__outer-wrap:hover .uael-video__play-icon',
							'condition' => [
								'play_icon!'  => '',
								'play_source' => 'icon',
							],
						]
					);

					$this->add_control(
						'hover_animation',
						[
							'label'     => __( 'Hover Animation', 'uael' ),
							'type'      => Controls_Manager::SELECT,
							'default'   => '',
							'options'   => [
								''                => __( 'None', 'uael' ),
								'float'           => __( 'Float', 'uael' ),
								'sink'            => __( 'Sink', 'uael' ),
								'wobble-vertical' => __( 'Wobble Vertical', 'uael' ),
							],
							'condition' => [
								'play_icon!'  => '',
								'play_source' => 'icon',
							],
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Helpful Information.
	 *
	 * @since 1.3.2
	 * @access protected
	 */
	protected function register_helpful_information() {

		if ( parent::is_internal_links() ) {
			$this->start_controls_section(
				'section_helpful_info',
				[
					'label' => __( 'Helpful Information', 'uael' ),
				]
			);

			$this->add_control(
				'help_doc_1',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Getting started article » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/video-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_2',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Getting started video » %2$s', 'uael' ), '<a href="https://www.youtube.com/watch?v=2RlvBU_EFV4&index=18&list=PL1kzJGWGPrW_7HabOZHb6z88t_S8r-xAc" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_3',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Unable to edit Video widget » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/unable-to-edit-video-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->end_controls_section();
		}
	}

	/**
	 * Returns Video Thumbnail Image.
	 *
	 * @param string $id Video ID.
	 * @since 1.3.2
	 * @access protected
	 */
	protected function get_video_thumb( $id ) {

		if ( '' == $id ) {
			return '';
		}

		$settings = $this->get_settings_for_display();
		$thumb    = '';

		if ( 'yes' == $settings['show_image_overlay'] ) {

			$thumb = Group_Control_Image_Size::get_attachment_image_src( $settings['image_overlay']['id'], 'image_overlay', $settings );

		} else {

			if ( 'youtube' == $settings['video_type'] ) {

				$thumb = 'https://i.ytimg.com/vi/' . $id . '/' . apply_filters( 'uael_video_youtube_image_quality', $settings['yt_thumbnail_size'] ) . '.jpg';
			} else {

				$vimeo = unserialize( file_get_contents( "https://vimeo.com/api/v2/video/$id.php" ) );
				$thumb = str_replace( '_640', '_840', $vimeo[0]['thumbnail_large'] );
			}
		}

		return $thumb;
	}

	/**
	 * Returns Video ID.
	 *
	 * @since 1.3.2
	 * @access protected
	 */
	protected function get_video_id() {

		$settings = $this->get_settings_for_display();
		$id       = '';
		$url      = $settings[ $settings['video_type'] . '_link' ];

		if ( 'youtube' == $settings['video_type'] ) {

			if ( preg_match( '/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches ) ) {
				$id = $matches[1];
			}
		} elseif ( 'vimeo' == $settings['video_type'] ) {

			$id = preg_replace( '/[^\/]+[^0-9]|(\/)/', '', rtrim( $url, '/' ) );
		}

		return $id;
	}

	/**
	 * Returns Video URL.
	 *
	 * @param array  $params Video Param array.
	 * @param string $id Video ID.
	 * @since 1.3.2
	 * @access protected
	 */
	protected function get_url( $params, $id ) {

		$settings = $this->get_settings_for_display();
		$url      = '';

		if ( 'vimeo' == $settings['video_type'] ) {

			$url = 'https://player.vimeo.com/video/';
		} else {

			$cookie = '';

			if ( 'yes' == $settings['yt_privacy'] ) {
				$cookie = '-nocookie';
			}
			$url = 'https://www.youtube' . $cookie . '.com/embed/';
		}

		$url = add_query_arg( $params, $url . $id );

		$url .= ( empty( $params ) ) ? '?' : '&';

		$url .= 'autoplay=1';

		if ( 'vimeo' == $settings['video_type'] && '' != $settings['start'] ) {

			$time = date( 'H\hi\ms\s', $settings['start'] );
			$url .= '#t=' . $time;
		}

		return $url;
	}

	/**
	 * Returns Vimeo Headers.
	 *
	 * @param string $id Video ID.
	 * @since 1.3.2
	 * @access protected
	 */
	function get_header_wrap( $id ) {

		$settings = $this->get_settings_for_display();

		if ( 'vimeo' != $settings['video_type'] ) {
			return;
		}

		$vimeo = unserialize( file_get_contents( "https://vimeo.com/api/v2/video/$id.php" ) );

		if (
			'yes' == $settings['vimeo_portrait'] ||
			'yes' == $settings['vimeo_title'] ||
			'yes' == $settings['vimeo_byline']
		) { ?>
		<div class="uael-vimeo-wrap">
			<?php if ( 'yes' == $settings['vimeo_portrait'] ) { ?>
			<div class="uael-vimeo-portrait">
				<a href="<?php $vimeo[0]['user_url']; ?>"><img src="<?php echo $vimeo[0]['user_portrait_huge']; ?>"></a>
			</div>
			<?php } ?>
			<?php
			if (
				'yes' == $settings['vimeo_title'] ||
				'yes' == $settings['vimeo_byline']
			) {
				?>
			<div class="uael-vimeo-headers">
				<?php if ( 'yes' == $settings['vimeo_title'] ) { ?>
				<div class="uael-vimeo-title">
					<a href="<?php $settings['vimeo_link']; ?>"><?php echo $vimeo[0]['title']; ?></a>
				</div>
				<?php } ?>
				<?php if ( 'yes' == $settings['vimeo_byline'] ) { ?>
				<div class="uael-vimeo-byline">
					<?php _e( 'from ', 'uael' ); ?> <a href="<?php $settings['vimeo_link']; ?>"><?php echo $vimeo[0]['user_name']; ?></a>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
		<?php
	}

	/**
	 * Render Video.
	 *
	 * @since 1.3.2
	 * @access protected
	 */
	protected function get_video_embed() {

		$settings    = $this->get_settings_for_display();
		$id          = $this->get_video_id();
		$embed_param = $this->get_embed_params();
		$src         = $this->get_url( $embed_param, $id );
		$device      = ( false !== ( stripos( $_SERVER['HTTP_USER_AGENT'], 'iPhone' ) ) ? 'true' : 'false' );

		if ( 'youtube' == $settings['video_type'] ) {
			$autoplay = ( 'yes' == $settings['yt_autoplay'] ) ? '1' : '0';
		} else {
			$autoplay = ( 'yes' == $settings['vimeo_autoplay'] ) ? '1' : '0';
		}

		$this->add_render_attribute( 'video-outer', 'class', 'uael-video__outer-wrap' );
		$this->add_render_attribute( 'video-outer', 'data-autoplay', $autoplay );
		$this->add_render_attribute( 'video-outer', 'data-device', $device );

		$this->add_render_attribute( 'video-wrapper', 'class', 'uael-video__play' );
		$this->add_render_attribute( 'video-wrapper', 'data-src', $src );

		$this->add_render_attribute( 'video-thumb', 'class', 'uael-video__thumb' );
		$this->add_render_attribute( 'video-thumb', 'src', $this->get_video_thumb( $id ) );

		$this->add_render_attribute( 'video-play', 'class', 'uael-video__play-icon' );

		if ( 'icon' == $settings['play_source'] ) {
			$html = '';
			$this->add_render_attribute( 'video-play', 'class', $settings['play_icon'] );
		} else {
			$html = '<img src="' . $settings['play_img']['url'] . '" />';
		}

		if ( 'img' == $settings['play_source'] ) {
			$this->add_render_attribute( 'video-play', 'class', 'uael-animation-' . $settings['hover_animation_img'] );
		} else {
			$this->add_render_attribute( 'video-play', 'class', 'uael-animation-' . $settings['hover_animation'] );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'video-outer' ); ?>>
			<?php $this->get_header_wrap( $id ); ?>
			<div <?php echo $this->get_render_attribute_string( 'video-wrapper' ); ?>>
				<img <?php echo $this->get_render_attribute_string( 'video-thumb' ); ?> />
				<div <?php echo $this->get_render_attribute_string( 'video-play' ); ?>>
					<?php echo $html; ?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Video output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.3.2
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		if ( '' == $settings['youtube_link'] && 'youtube' == $settings['video_type'] ) {
			return '';
		}

		if ( '' == $settings['vimeo_link'] && 'vimeo' == $settings['video_type'] ) {
			return '';
		}

		$this->get_video_embed();
	}

	/**
	 * Render video widget as plain content.
	 *
	 * Override the default behavior, by printing the video URL insted of rendering it.
	 *
	 * @since 1.3.2
	 * @access public
	 */
	public function render_plain_content() {
		$settings = $this->get_settings_for_display();
		$url      = 'youtube' === $settings['video_type'] ? $settings['youtube_link'] : $settings['vimeo_link'];

		echo esc_url( $url );
	}

	/**
	 * Get embed params.
	 *
	 * Retrieve video widget embed parameters.
	 *
	 * @since 1.3.2
	 * @access public
	 *
	 * @return array Video embed parameters.
	 */
	public function get_embed_params() {

		$settings = $this->get_settings_for_display();

		$params = [];

		if ( 'youtube' === $settings['video_type'] ) {
			$youtube_options = [ 'autoplay', 'rel', 'controls', 'showinfo', 'mute', 'modestbranding' ];

			foreach ( $youtube_options as $option ) {

				if ( 'autoplay' == $option ) {
					if ( 'yes' === $settings['yt_autoplay'] ) {
						$params[ $option ] = '1';
					}
					continue;
				}

				$value             = ( 'yes' === $settings[ 'yt_' . $option ] ) ? '1' : '0';
				$params[ $option ] = $value;
				$params['start']   = $settings['start'];
				$params['end']     = $settings['end'];
			}
		}

		if ( 'vimeo' === $settings['video_type'] ) {
			$vimeo_options = [ 'autoplay', 'loop', 'title', 'portrait', 'byline' ];

			foreach ( $vimeo_options as $option ) {

				if ( 'autoplay' == $option ) {
					if ( 'yes' === $settings['vimeo_autoplay'] ) {
						$params[ $option ] = '1';
					}
					continue;
				}

				$value             = ( 'yes' === $settings[ 'vimeo_' . $option ] ) ? '1' : '0';
				$params[ $option ] = $value;
			}

			$params['color']     = str_replace( '#', '', $settings['vimeo_color'] );
			$params['autopause'] = '0';
		}

		return $params;
	}
}

