<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use \Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Ovau_Elementor_Audio_Category_Filter extends Widget_Base {

	public function get_name() {
		return 'ovau_elementor_audio_category_filter';
	}

	public function get_title() {
		return esc_html__( 'Audio Category Filter', 'ovau' );
	}

	public function get_icon() {
		return 'eicon-filter';
	}

	public function get_categories() {
		return [ 'ova-audio' ];
	}

	public function get_script_depends() {
		return [ 'ovau-elementor-ova-audio-category-filter' ];
	}
	
	// Add Your Controll In This Function
	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Audio Category Filter', 'ovau' ),
			]
		);

			$this->add_control(
				'layout',
				[
					'label'   => esc_html__( 'Template', 'ovau' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '1',
					'options' => [
						'1' => esc_html__( 'Template 1', 'ovau' ),	
						'2' => esc_html__( 'Template 2', 'ovau' ),	
					],
				]
			);	

			$this->add_control(
				'posts_per_page',
				[
					'label'   => esc_html__( 'Post Per Page', 'ovau' ),
					'type'    => Controls_Manager::NUMBER,
					'min'     => -1,
					'default' => 4
				]
			);

			$this->add_control(
				'order_by',
				[
					'label'   => esc_html__( 'Order By', 'ovau' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'date',
					'options' => [
						'title' => esc_html__( 'Title', 'ovau' ),
						'date' 	=> esc_html__( 'Date', 'ovau' ),
						'ID' 	=> esc_html__( 'ID', 'ovau' ),			
					],
				]
			);

			$this->add_control(
				'order',
				[
					'label'   => esc_html__( 'Order', 'ovau' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'DESC',
					'options' => [
						'DESC' => esc_html__( 'Descending', 'ovau' ),
						'ASC'  => esc_html__( 'Ascending', 'ovau' ),
					],
				]
			);

			$this->add_control(
				'show_title',
				[
					'label' 		=> esc_html__( 'Show Title', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Yes', 'ovau' ),
					'label_off' 	=> esc_html__( 'No', 'ovau' ),
					'default' 		=> 'yes',
				]
			);

			$this->add_control(
				'show_host',
				[
					'label' 		=> esc_html__( 'Show Host', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Yes', 'ovau' ),
					'label_off' 	=> esc_html__( 'No', 'ovau' ),
					'default' 		=> 'yes',
				]
			);

			$this->add_control(
				'show_episode',
				[
					'label' 		=> esc_html__( 'Show Episode', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Yes', 'ovau' ),
					'label_off' 	=> esc_html__( 'No', 'ovau' ),
					'default' 		=> 'yes',
				]
			);

			$this->add_control(
				'show_category',
				[
					'label' 		=> esc_html__( 'Show Category', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Yes', 'ovau' ),
					'label_off' 	=> esc_html__( 'No', 'ovau' ),
					'default' 		=> 'yes',
				]
			);

			$this->add_control(
				'detail_label',
				[
					'label' 	=> esc_html__( 'Detail Label', 'ovau' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__( 'View Episode', 'ovau' ),
				]
			);

			$this->add_control(
				'target_link',
				[
					'label' 		=> esc_html__( 'Target', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Yes', 'ovau' ),
					'label_off' 	=> esc_html__( 'No', 'ovau' ),
					'default' 		=> 'no',
				]
			);

			$this->add_control(
				'pagination',
				[
					'label' 		=> esc_html__( 'Show Pagination', 'ovau' ),
					'type' 			=> Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Show', 'ovau' ),
					'label_off' 	=> esc_html__( 'Hide', 'ovau' ),
					'default' 		=> 'yes',
					'separator'     => 'before'
				]
			);

			$this->add_control(
				'category_not_in',
				[
					'label'   		=> esc_html__( 'Category Not In', 'ovau' ),
					'type'    		=> Controls_Manager::TEXT,
					'description' 	=> esc_html__( 'Enter the category ID of Case Study. IDs are separated by "|". Ex: 1|2|3.', 'ovau' ),
				]
			);

			$this->add_control(
				'category_order_by',
				[
					'label'   => esc_html__( 'Category Order By', 'ovau' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'name',
					'options' => [
						'name' 	=> esc_html__( 'Name', 'ovau' ),		
						'ID' => esc_html__( 'ID', 'ovau' ),
					],
				]
			);

			$this->add_control(
				'category_order',
				[
					'label'   => esc_html__( 'Category Order', 'ovau' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'ASC',
					'options' => [
						'DESC' => esc_html__( 'Descending', 'ovau' ),
						'ASC'  => esc_html__( 'Ascending', 'ovau' ),
					],
				]
			);

			$this->add_control(
				'more_options',
				[
					'label' 	=> esc_html__( 'Additional Options', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

				$this->add_control(
					'play_icon',
					[
						'label' 		=> esc_html__( 'Play Icon', 'ovau' ),
						'type' 			=> Controls_Manager::ICONS,
						'default' 		=> [
							'value' 	=> 'fas fa-play',
							'library' 	=> 'fa-solid',
						],
						'skin' 			=> 'inline',
						'label_block' 	=> false,
						'exclude_inline_options' => [ 'svg' ]
					]
				);

				$this->add_control(
					'pause_icon',
					[
						'label' 		=> esc_html__( 'Pause Icon', 'ovau' ),
						'type' 			=> Controls_Manager::ICONS,
						'default' 		=> [
							'value' 	=> 'fas fa-pause',
							'library' 	=> 'fa-solid',
						],
						'skin' 			=> 'inline',
						'label_block' 	=> false,
						'exclude_inline_options' => [ 'svg' ]
					]
				);

				$this->add_control(
					'loop',
					[
						'label' 		=> esc_html__( 'Loop', 'ovau' ),
						'type' 			=> \Elementor\Controls_Manager::SWITCHER,
						'label_on' 		=> esc_html__( 'Yes', 'ovau' ),
						'label_off' 	=> esc_html__( 'No', 'ovau' ),
						'default' 		=> 'yes',
					]
				);

				$this->add_control(
					'skip_back',
					[
						'label' 	=> esc_html__( 'Skip Back', 'ovau' ),
						'type' 		=> Controls_Manager::NUMBER,
						'default' 	=> 15,
					]
				);

				$this->add_control(
					'jump_forward',
					[
						'label' 	=> esc_html__( 'Jump Forward', 'ovau' ),
						'type' 		=> Controls_Manager::NUMBER,
						'default' 	=> 15,
					]
				);

				$this->add_control(
					'start_volume',
					[
						'label' 	=> esc_html__( 'Start Volume', 'ovau' ),
						'type' 		=> Controls_Manager::NUMBER,
						'default' 	=> 0.5,
						'min' 		=> 0,
						'max' 		=> 1,
						'step' 		=> 0.1
					]
				);

		$this->end_controls_section();

		/* Begin Categories Style */
		$this->start_controls_section(
			'section_list_categories_style',
			[
				'label' => esc_html__( 'List Categories', 'ovau' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_responsive_control(
				'case_study_categories_padding',
				[
					'label' 		=> esc_html__( 'Padding', 'ovau' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%', 'em' ],
					'selectors' 	=> [
						'{{WRAPPER}} .ova-audio-category-filter .audio-categories' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'category_items_style',
				[
					'label' 	=> esc_html__( 'Items Style', 'ovau' ),
					'type' 		=> Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'category_items_typography',
					'selector' 	=> '{{WRAPPER}} .ova-audio-category-filter .audio-categories li',
				]
			);

			$this->start_controls_tabs(
				'style_category_items_tabs'
			);

				$this->start_controls_tab(
					'style_category_items_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'ovau' ),
					]
				);

					$this->add_control(
						'category_items_color_normal',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-category-filter .audio-categories li' => 'color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'category_items_background_normal',
						[
							'label' 	=> esc_html__( 'Background', 'ovau' ),
							'type' 		=> Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-category-filter .audio-categories li' => 'background-color: {{VALUE}}',
							],
						]
					);


				$this->end_controls_tab();

				$this->start_controls_tab(
					'style_category_items_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'ovau' ),
					]
				);

					$this->add_control(
						'category_items_color_hover',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-category-filter .audio-categories li:hover' => 'color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'category_items_background_hover',
						[
							'label' 	=> esc_html__( 'Background', 'ovau' ),
							'type' 		=> Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-category-filter .audio-categories li:hover' => 'background-color: {{VALUE}}',
							],
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'style_category_items_active_tab',
					[
						'label' => esc_html__( 'Active', 'ovau' ),
					]
				);

					$this->add_control(
						'category_items_color_active',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-category-filter .audio-categories li.audio-active' => 'color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'category_items_background_acitve',
						[
							'label' 	=> esc_html__( 'Background', 'ovau' ),
							'type' 		=> Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-category-filter .audio-categories li.audio-active' => 'background-color: {{VALUE}}',
							],
						]
					);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' 		=> 'category_items_border',
					'label' 	=> esc_html__( 'Border', 'ovau' ),
					'selector' 	=> '{{WRAPPER}} .ova-audio-category-filter .audio-categories li',
					'separator' => 'before',
				]
			);

			$this->add_responsive_control(
				'category_items_border_radius',
				[
					'label' 		=> esc_html__( 'Border Radius', 'ovau' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%', 'em' ],
					'selectors' 	=> [
						'{{WRAPPER}} .ova-audio-category-filter .audio-categories li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'category_items_padding',
				[
					'label' 		=> esc_html__( 'Padding', 'ovau' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%', 'em' ],
					'selectors' 	=> [
						'{{WRAPPER}} .ova-audio-category-filter .audio-categories li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'category_items_margin',
				[
					'label' 		=> esc_html__( 'Margin', 'ovau' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%', 'em' ],
					'selectors' 	=> [
						'{{WRAPPER}} .ova-audio-category-filter .audio-categories li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();
		/* End Categories Style */

		$this->start_controls_section(
            'section_item_style',
            [
                'label' => esc_html__( 'Item', 'ovau' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

        	$this->add_responsive_control(
                'item_padding',
                [
                    'label'         => esc_html__( 'Padding', 'ovau' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ova-audio-category-filter .item-audio-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'item_margin',
                [
                    'label'         => esc_html__( 'Margin', 'ovau' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ova-audio-category-filter .item-audio-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
				'item_background',
				[
					'label' 	=> esc_html__( 'Background', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-category-filter .item-audio-list' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' 		=> 'item_border',
					'label' 	=> esc_html__( 'Border', 'ovau' ),
					'selector' 	=> '{{WRAPPER}} .ova-audio-category-filter .item-audio-list',
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' 		=> 'item_box_shadow',
					'label' 	=> esc_html__( 'Box Shadow', 'ovau' ),
					'selector' 	=> '{{WRAPPER}} .ova-audio-category-filter .item-audio-list',
				]
			);

        $this->end_controls_section();

        $this->start_controls_section(
            'section_controls_style',
            [
                'label' => esc_html__( 'Controls', 'ovau' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        	$this->start_controls_tabs(
				'style_controls_tabs'
			);

        		$this->start_controls_tab(
					'style_controls_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'ovau' ),
					]
				);

        			$this->add_control(
						'controls_background',
						[
							'label' 	=> esc_html__( 'Background', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ova-controls .ovau-btn-play' => 'background-color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'controls_color',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ova-controls .ovau-btn-play i' => 'color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'wave_options',
						[
							'label' 	=> esc_html__( 'Wave Options', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						]
					);

						$this->add_group_control(
							\Elementor\Group_Control_Background::get_type(),
							[
								'name' 		=> 'wave_background',
								'label' 	=> esc_html__( 'Wave Background', 'ovau' ),
								'types' 	=> [ 'classic', 'gradient' ],
								'selector' 	=> '{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ova-controls .ovau-btn-play.ovau-playing .loader .stroke',
								'exclude' 	=> ['image'],
							]
						);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'style_controls_playing_tab',
					[
						'label' => esc_html__( 'Playing', 'ovau' ),
					]
				);

					$this->add_control(
						'playing_background',
						[
							'label' 	=> esc_html__( 'Background', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ova-controls .ovau-btn-play.ovau-playing' => 'background-color: {{VALUE}}',
							],
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'style_controls_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'ovau' ),
					]
				);

        			$this->add_control(
						'controls_background_hover',
						[
							'label' 	=> esc_html__( 'Background', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ova-controls .ovau-btn-play:hover' => 'background-color: {{VALUE}}',
								'{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ova-controls .ovau-btn-play.ovau-playing:hover' => 'background-color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'controls_color_hover',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ova-controls .ovau-btn-play:hover i' => 'color: {{VALUE}}',
							],
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_responsive_control(
				'controls_size',
				[
					'label'			=> esc_html__( 'Size', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 5,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 60,
					],
					'separator' => 'before',
					'selectors' => [
						'{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ova-controls .ovau-btn-play' => 'width: {{SIZE}}{{UNIT}};min-width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'controls_size_icon',
				[
					'label'			=> esc_html__( 'Size Icon', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 14,
					],
					'selectors' => [
						'{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ova-controls .ovau-btn-play i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' 		=> 'controls_border',
					'label' 	=> esc_html__( 'Border', 'ovau' ),
					'selector' 	=> '{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ova-controls .ovau-btn-play',
				]
			);

			$this->add_control(
				'controls_border_color_hover',
				[
					'label' 	=> esc_html__( 'Border Color Hover', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ova-controls .ovau-btn-play:hover' => 'border-color: {{VALUE}}',
					],
				]
			);

			$this->add_responsive_control(
                'controls_border_radius',
                [
                    'label'         => esc_html__( 'Border Radius', 'ovau' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ova-controls .ovau-btn-play' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'controls_margin',
                [
                    'label'         => esc_html__( 'Margin', 'ovau' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ova-controls .ovau-btn-play' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' 		=> 'controls_box_shadow',
					'label' 	=> esc_html__( 'Box Shadow', 'ovau' ),
					'selector' 	=> '{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ova-controls .ovau-btn-play',
				]
			);

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Title', 'ovau' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

        	$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' 		=> 'title_typography',
					'selector' 	=> '{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ova-controls .title, {{WRAPPER}} .ova-audio-category-filter .item-audio-list .ova-controls .title a',
				]
			);

        	$this->add_control(
				'title_color',
				[
					'label' 	=> esc_html__( 'Color', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ova-controls .title' => 'color: {{VALUE}}',
						'{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ova-controls .title a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'title_color_hover',
				[
					'label' 	=> esc_html__( 'Color Hover', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ova-controls .title a:hover' => 'color: {{VALUE}}',
					],
					'condition' => [
						'link_title' => 'yes',
					],
				]
			);

			$this->add_responsive_control(
                'title_margin',
                [
                    'label'         => esc_html__( 'Margin', 'ovau' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ova-controls .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_episode_style',
            [
                'label' => esc_html__( 'Episode', 'ovau' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' 		=> 'episode_typography',
					'selector' 	=> '{{WRAPPER}} .ova-audio-category-filter .item-audio-list .episode .label',
				]
			);

        	$this->add_control(
				'episode_color',
				[
					'label' 	=> esc_html__( 'Color', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-category-filter .item-audio-list .episode .label' => 'color: {{VALUE}}',
					],
				]
			);

        $this->end_controls_section();

        $this->start_controls_section(
            'section_host_style',
            [
                'label' => esc_html__( 'Host', 'ovau' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' 		=> 'host_typography',
					'selector' 	=> '{{WRAPPER}} .ova-audio-category-filter .item-audio-list .host',
				]
			);

			$this->start_controls_tabs(
				'style_host_tabs'
			);

				$this->start_controls_tab(
					'style_host_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'ovau' ),
					]
				);

					$this->add_control(
						'host_color',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-category-filter .item-audio-list .host' => 'color: {{VALUE}}',
							],
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'style_host_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'ovau' ),
					]
				);

					$this->add_control(
						'host_color_hover',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-category-filter .item-audio-list .host:hover' => 'color: {{VALUE}}',
							],
						]
					);

				$this->end_controls_tab();
			$this->end_controls_tabs();
		$this->end_controls_section();

        $this->start_controls_section(
            'section_category_style',
            [
                'label' => esc_html__( 'Category', 'ovau' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' 		=> 'category_typography',
					'selector' 	=> '{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ovau-category a',
				]
			);

			$this->start_controls_tabs(
				'style_category_tabs'
			);

				$this->start_controls_tab(
					'style_category_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'ovau' ),
					]
				);

					$this->add_control(
						'category_color',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ovau-category a' => 'color: {{VALUE}}',
							],
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'style_category_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'ovau' ),
					]
				);

					$this->add_control(
						'category_color_hover',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-category-filter .item-audio-list .ovau-category a:hover' => 'color: {{VALUE}}',
							],
						]
					);

				$this->end_controls_tab();
			$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
            'section_view_detail_style',
            [
                'label' => esc_html__( 'View Detail', 'ovau' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

        	$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' 		=> 'view_detail_typography',
					'selector' 	=> '{{WRAPPER}} .ova-audio-category-filter .item-audio-list .detail-link a',
				]
			);

        	$this->start_controls_tabs(
				'style_view_detail_tabs'
			);

        		$this->start_controls_tab(
					'style_view_detail_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'ovau' ),
					]
				);

					$this->add_control(
						'view_detail_color',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-category-filter .item-audio-list .detail-link a' => 'color: {{VALUE}}',
							],
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'style_view_detail_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'ovau' ),
					]
				);

					$this->add_control(
						'view_detail_color_hover',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-category-filter .item-audio-list .detail-link a:hover' => 'color: {{VALUE}}',
							],
						]
					);

				$this->end_controls_tab();
			$this->end_controls_tabs();
        $this->end_controls_section();

		/* Begin Loader Style */
		$this->start_controls_section(
			'section_loader_style',
			[
				'label' => esc_html__( 'Loader', 'ovau' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'loader_color',
				[
					'label' 	=> esc_html__( 'Color', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-category-filter .wrap_loader .loader circle' => 'stroke: {{VALUE}}',
					],
				]
			);

		$this->end_controls_section();
		/* End Loader Style */
		
	}

	// Render Template Here
	protected function render() {

		$settings 	= $this->get_settings();

		$template = apply_filters( 'el_ova_audio_category_ajax_filter', 'elementor/ova_audio_category_filter.php' );
		ob_start();
		ovau_get_template( $template, $settings );
		echo ob_get_clean();
	}

	
}
$widgets_manager->register( new Ovau_Elementor_Audio_Category_Filter() );