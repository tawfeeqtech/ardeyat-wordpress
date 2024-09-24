<?php

namespace PixelGallery\Modules\Fixer\Widgets;

use PixelGallery\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Repeater;
use PixelGallery\Utils;
use PixelGallery\Traits\Global_Widget_Controls;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Fixer extends Module_Base {

	use Global_Widget_Controls;

	public function get_name() {
		return 'pg-fixer';
	}

	public function get_title() {
		return BDTPG . esc_html__('Fixer', 'pixel-gallery');
	}

	public function get_icon() {
		return 'pg-icon-fixer pg-new';
	}

	public function get_categories() {
		return ['pixel-gallery'];
	}

	public function get_keywords() {
		return ['fixer', 'grid', 'gallery'];
	}

	public function get_style_depends() {
		return ['pg-fixer'];
	}

	protected function is_dynamic_content(): bool {
		return false;
	}

	protected function register_controls() {

		$this->start_controls_section(
            'section_layout',
            [
                'label' => __('Layout', 'pixel-gallery'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

		//Global
		$this->register_grid_controls('fixer');
		$this->register_global_height_controls('fixer');
		$this->register_title_tag_controls();
		$this->register_show_meta_controls();
		$this->register_alignment_controls('fixer');
		$this->register_thumbnail_size_controls();

		//Global Lightbox Controls
		$this->register_lightbox_controls();
        $this->end_controls_section();

		$this->start_controls_section(
			'section_item_content',
			[
				'label' => __('Items', 'pixel-gallery'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();
		$repeater->start_controls_tabs('tabs_item_content');
		$repeater->start_controls_tab(
			'tab_item_content',
			[
				'label' => esc_html__('Content', 'pixel-gallery'),
			]
		);
		$this->register_repeater_media_controls($repeater);
		$this->register_repeater_title_controls($repeater);
		$this->register_repeater_meta_controls($repeater);
		$this->register_repeater_custom_url_controls($repeater);
		$this->register_repeater_hidden_item_controls($repeater);

		$repeater->end_controls_tab();
		$repeater->start_controls_tab(
			'tab_item_grid',
			[
				'label' => esc_html__('Grid', 'pixel-gallery'),
			]
		);
		$this->register_repeater_grid_controls($repeater, 'fixer');
		$this->register_repeater_item_height_controls($repeater, 'fixer');
		$repeater->end_controls_tab();
		$repeater->end_controls_tabs();
		$this->register_repeater_items_controls($repeater);
		$this->end_controls_section();

        //Style
		$this->start_controls_section(
			'pg_section_style',
			[
				'label'     => esc_html__( 'Items', 'pixel-gallery' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_item_style' );

		$this->start_controls_tab(
			'tab_item_normal',
			[
				'label' => esc_html__( 'Normal', 'pixel-gallery' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'item_background',
				'label' => esc_html__( 'Background', 'pixel-gallery' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .pg-fixer-item',
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [ 
                'name'      => 'item_border',
                'selector'  => '{{WRAPPER}} .pg-fixer-item',
                'separator' => 'before',
            ]
        );

		$this->add_responsive_control(
			'item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'pixel-gallery' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pg-fixer-item, {{WRAPPER}} .pg-fixer-image-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => esc_html__( 'Padding', 'pixel-gallery' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pg-fixer-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'item_margin',
			[
				'label'      => esc_html__( 'Margin', 'pixel-gallery' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pg-fixer-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_box_shadow',
				'selector' => '{{WRAPPER}} .pg-fixer-item',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_item_hover',
			[
				'label' => esc_html__( 'Hover', 'pixel-gallery' ),
			]
		);

		$this->add_control(
			'item_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'pixel-gallery' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'item_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .pg-fixer-item:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_hover_box_shadow',
				'selector' => '{{WRAPPER}} .pg-fixer-item:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

        $this->start_controls_section(
			'section_style_content',
			[
				'label'     => esc_html__( 'Content', 'pixel-gallery' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'glassmorphism_effect',
			[
				'label' => esc_html__('Glassmorphism', 'pixel-gallery') . BDTPG_NC,
				'type'  => Controls_Manager::SWITCHER,
				'description' => sprintf(esc_html__('This feature will not work in the Firefox browser untill you enable browser compatibility so please %1s look here %2s', 'pixel-gallery'), '<a href="https://developer.mozilla.org/en-US/docs/Web/CSS/backdrop-filter#Browser_compatibility" target="_blank">', '</a>'),

			]
		);

		$this->add_control(
			'glassmorphism_blur_level',
			[
				'label'       => esc_html__('Blur Level', 'pixel-gallery'),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'  => 0,
						'step' => 1,
						'max'  => 50,
					]
				],
				'default'     => [
					'size' => 5
				],
				'selectors'   => [
					'{{WRAPPER}} .pg-fixer-content' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);'
				],
				'condition' => [
					'glassmorphism_effect' => 'yes',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'content_background',
				'label' => esc_html__( 'Background', 'pixel-gallery' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .pg-fixer-content',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
					'color' => [
						'default' => '#fff',
					],
				],
				'separator' => 'before',
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'content_border',
                'selector'  => '{{WRAPPER}} .pg-fixer-content',
                'separator' => 'before',
            ]
        );

		$this->add_responsive_control(
			'content_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'pixel-gallery' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pg-fixer-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding', 'pixel-gallery' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pg-fixer-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'content_margin',
			[
				'label'      => esc_html__( 'Margin', 'pixel-gallery' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pg-fixer-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'content_box_shadow',
				'selector' => '{{WRAPPER}} .pg-fixer-content',
			]
		);
		//content position left right choose option 
		$this->add_control(
			'content_position',
			[
				'label' => esc_html__('Content Position', 'pixel-gallery') . BDTPG_NC,
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'options'   => [
					'left'    => [
						'title' => __('Left', 'pixel-gallery'),
						'icon'  => 'eicon-h-align-left',
					],
					'right'   => [
						'title' => __('Right', 'pixel-gallery'),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors_dictionary' => [
					'left' => 'left: 0;',
					'right' => 'right: 0;',
				],
				'selectors' => [
					'{{WRAPPER}} .pg-fixer-content' => '{{VALUE}};',
				],
				'render_type' => 'template',
				'separator' => 'before',
				'toggle' => false,
			]
		);


		$this->end_controls_section();

		//Global Title Controls
		$this->register_title_controls('fixer');
        
		//Global Meta Controls
		$this->register_meta_controls('fixer');

		//Clip Path Controls
		$this->register_clip_path_controls('fixer');

	}

	public function render_items() {
        $settings = $this->get_settings_for_display();
		$id = 'pg-fixer-' . $this->get_id();
		$slide_index = 1;
		foreach ($settings['items'] as $index => $item) :

			$attr_name = 'grid-item' . $index;
			$this->add_render_attribute($attr_name, 'class', 'pg-fixer-item pg-item elementor-repeater-item-' . esc_attr($item['_id']), true);

			/**
			 * Render Video Inject Here
			 * Video Would be work on Media File & Lightbox
			 * @since 1.0.0
			 */
			if ($item['media_type'] == 'video') {
				$this->render_video_frame($item, $attr_name, $id);
			}

		?>

		<div <?php $this->print_render_attribute_string($attr_name); ?>>
			<?php if ($item['item_hidden'] !== 'yes' ) : ?>
			<?php $this->render_image_wrap($item, 'fixer'); ?>
			<div class="pg-fixer-content">
				<?php $this->render_title($item, 'fixer'); ?>
				<?php $this->render_meta($item, 'fixer'); ?>
			</div>
			<?php $this->render_lightbox_link_url($item, $index, $id); ?>
			<?php endif; ?>
		</div>

		<?php 
		$slide_index++;
		endforeach;
    }

	public function render() {
		$settings   = $this->get_settings_for_display();
		$this->add_render_attribute( 'grid', 'class', 'pg-fixer-grid pg-grid' );

		if (isset($settings['pg_in_animation_show']) && ($settings['pg_in_animation_show'] == 'yes')) {
			$this->add_render_attribute( 'grid', 'class', 'pg-in-animation' );
			if (isset($settings['pg_in_animation_delay']['size'])) {
				$this->add_render_attribute( 'grid', 'data-in-animation-delay', $settings['pg_in_animation_delay']['size'] );
			}
		}

		?>
		<div <?php $this->print_render_attribute_string('grid'); ?>>
			<?php $this->render_items(); ?>
		</div>
		<?php
	}
}