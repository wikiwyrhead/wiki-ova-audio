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
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Ovau_Elementor_Audio_List_2 extends Widget_Base {

	public function get_name() {
		return 'ovau_elementor_audio_list_2';
	}

	public function get_title() {
		return esc_html__( 'Audio List 2', 'ovau' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_categories() {
		return [ 'ova-audio' ];
	}

	public function get_script_depends() {
		return [ 'ovau-elementor-ova-audio-list-2' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'ovau' ),
			]
		);

		    $this->add_control(
				'show_featured',
				[
					'label' => __( 'Show Featured', 'ovau' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'ovau' ),
					'label_off' => __( 'Hide', 'ovau' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);

			$this->add_control(
				'total_posts',
				[
					'label' 	=> esc_html__( 'Total Posts', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::NUMBER,
					'step' 		=> 1,
					'default' 	=> 4,
				]
			);	
			
			$args = array(
	           'taxonomy' 	=> 'category_audio',
	           'orderby' 	=> 'name',
	           'order'   	=> 'ASC'
	       	);
		
			$categories 	= get_categories( $args );
			$cate_arr 		= array( 'all' => esc_html__( "All", "ovau" ) );
			if ( $categories ) {
				foreach ( $categories as $cate ) {
					$cate_arr[$cate->slug] = $cate->name;
				}
			}

			$this->add_control(
				'category',
				[
					'label' 	=> esc_html__( 'Category', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::SELECT,
					'default' 	=> 'all',
					'options' 	=> $cate_arr,
				]
			);

			$this->add_control(
				'order',
				[
					'label' 	=> esc_html__( 'Order', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::SELECT,
					'default' 	=> 'ASC',
					'options' 	=> [
						'ASC'  	=> esc_html__( 'Ascending', 'ovau' ),
						'DESC'	=> esc_html__( 'Descending', 'ovau' ),
					],
				]
			);

			$this->add_control(
				'orderby',
				[
					'label' 	=> esc_html__( 'Order By', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::SELECT,
					'default' 	=> 'ovau_order',
					'options' 	=> [
						'id'  			=> esc_html__( 'ID', 'ovau' ),
						'title'			=> esc_html__( 'Title', 'ovau' ),
						'date' 			=> esc_html__( 'Date', 'ovau' ),
						'modified' 		=> esc_html__( 'Modified', 'ovau' ),
						'rand' 			=> esc_html__( 'Random', 'ovau' ),
						'ovau_order' 	=> esc_html__( 'Order', 'ovau' ),
					],
				]
			);

			$this->add_control(
				'link_title',
				[
					'label' 		=> esc_html__( 'Link Title', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Yes', 'ovau' ),
					'label_off' 	=> esc_html__( 'No', 'ovau' ),
					'default' 		=> 'yes',
					'separator' 	=> 'before',
				]
			);

			$this->add_control(
				'target_link',
				[
					'label' 		=> esc_html__( 'Target', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Yes', 'ovau' ),
					'label_off' 	=> esc_html__( 'No', 'ovau' ),
					'default' 		=> '',
					'condition' 	=> [
						'link_title' => 'yes',
					],
				]
			);

			$this->add_control(
				'show_title',
				[
					'label' => esc_html__( 'Show Title', 'ovau' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'ovau' ),
					'label_off' => esc_html__( 'No', 'ovau' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);

			$this->add_control(
				'show_host',
				[
					'label' => esc_html__( 'Show Host', 'ovau' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'ovau' ),
					'label_off' => esc_html__( 'No', 'ovau' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);

			$this->add_control(
				'show_episode',
				[
					'label' => esc_html__( 'Show Episode', 'ovau' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'ovau' ),
					'label_off' => esc_html__( 'No', 'ovau' ),
					'return_value' => 'yes',
					'default' => 'yes',
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
                        '{{WRAPPER}} .ova-audio-list-2 .item-audio-2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                        '{{WRAPPER}} .ova-audio-list-2 .item-audio-2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' 		=> 'item_border',
					'label' 	=> esc_html__( 'Border', 'ovau' ),
					'selector' 	=> '{{WRAPPER}} .ova-audio-list-2 .item-audio-2',
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' 		=> 'item_box_shadow',
					'label' 	=> esc_html__( 'Box Shadow', 'ovau' ),
					'selector' 	=> '{{WRAPPER}} .ova-audio-list-2 .item-audio-2',
				]
			);

			$this->add_control(
				'item_first_child_options',
				[
					'label' 	=> esc_html__( 'Item First Child', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

				$this->add_responsive_control(
	                'item_first_child_padding',
	                [
	                    'label'         => esc_html__( 'Padding', 'ovau' ),
	                    'type'          => Controls_Manager::DIMENSIONS,
	                    'size_units'    => [ 'px', '%', 'em' ],
	                    'selectors'     => [
	                        '{{WRAPPER}} .ova-audio-list-2 .item-audio-2:first-child' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                    ],
	                ]
	            );

	            $this->add_responsive_control(
	                'item_first_child_margin',
	                [
	                    'label'         => esc_html__( 'Margin', 'ovau' ),
	                    'type'          => Controls_Manager::DIMENSIONS,
	                    'size_units'    => [ 'px', '%', 'em' ],
	                    'selectors'     => [
	                        '{{WRAPPER}} .ova-audio-list-2 .item-audio-2:first-child' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                    ],
	                ]
	            );

	            $this->add_group_control(
					\Elementor\Group_Control_Border::get_type(),
					[
						'name' 		=> 'item_first_child_border',
						'label' 	=> esc_html__( 'Border', 'ovau' ),
						'selector' 	=> '{{WRAPPER}} .ova-audio-list-2 .item-audio-2:first-child',
					]
				);

			$this->add_control(
				'item_last_child_options',
				[
					'label' 	=> esc_html__( 'Item Last Child', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

				$this->add_responsive_control(
	                'item_last_child_padding',
	                [
	                    'label'         => esc_html__( 'Padding', 'ovau' ),
	                    'type'          => Controls_Manager::DIMENSIONS,
	                    'size_units'    => [ 'px', '%', 'em' ],
	                    'selectors'     => [
	                        '{{WRAPPER}} .ova-audio-list-2 .item-audio-2:last-child' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                    ],
	                ]
	            );

	            $this->add_responsive_control(
	                'item_last_child_margin',
	                [
	                    'label'         => esc_html__( 'Margin', 'ovau' ),
	                    'type'          => Controls_Manager::DIMENSIONS,
	                    'size_units'    => [ 'px', '%', 'em' ],
	                    'selectors'     => [
	                        '{{WRAPPER}} .ova-audio-list-2 .item-audio-2:last-child' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                    ],
	                ]
	            );

	            $this->add_group_control(
					\Elementor\Group_Control_Border::get_type(),
					[
						'name' 		=> 'item_last_child_border',
						'label' 	=> esc_html__( 'Border', 'ovau' ),
						'selector' 	=> '{{WRAPPER}} .ova-audio-list-2 .item-audio-2:last-child',
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
								'{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ova-controls .ovau-btn-play' => 'background-color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'controls_color',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ova-controls .ovau-btn-play i' => 'color: {{VALUE}}',
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
								'selector' 	=> '{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ova-controls .ovau-btn-play.ovau-playing .loader .stroke',
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
								'{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ova-controls .ovau-btn-play.ovau-playing' => 'background-color: {{VALUE}}',
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
								'{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ova-controls .ovau-btn-play:hover' => 'background-color: {{VALUE}}',
								'{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ova-controls .ovau-btn-play.ovau-playing:hover' => 'background-color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'controls_color_hover',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ova-controls .ovau-btn-play:hover i' => 'color: {{VALUE}}',
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
						'{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ova-controls .ovau-btn-play' => 'width: {{SIZE}}{{UNIT}};min-width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
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
						'{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ova-controls .ovau-btn-play i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' 		=> 'controls_border',
					'label' 	=> esc_html__( 'Border', 'ovau' ),
					'selector' 	=> '{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ova-controls .ovau-btn-play',
				]
			);

			$this->add_control(
				'controls_border_color_hover',
				[
					'label' 	=> esc_html__( 'Border Color Hover', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ova-controls .ovau-btn-play:hover' => 'border-color: {{VALUE}}',
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
                        '{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ova-controls .ovau-btn-play' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                        '{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ova-controls .ovau-btn-play' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' 		=> 'controls_box_shadow',
					'label' 	=> esc_html__( 'Box Shadow', 'ovau' ),
					'selector' 	=> '{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ova-controls .ovau-btn-play',
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
					'selector' 	=> '{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ova-controls .title, {{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ova-controls .title a',
				]
			);

        	$this->add_control(
				'title_color',
				[
					'label' 	=> esc_html__( 'Color', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ova-controls .title' => 'color: {{VALUE}}',
						'{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ova-controls .title a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'title_color_hover',
				[
					'label' 	=> esc_html__( 'Color Hover', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ova-controls .title a:hover' => 'color: {{VALUE}}',
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
                        '{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ova-controls .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'selector' 	=> '{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .episode .label',
				]
			);

        	$this->add_control(
				'episode_color',
				[
					'label' 	=> esc_html__( 'Color', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .episode .label' => 'color: {{VALUE}}',
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
					'selector' 	=> '{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .host',
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
								'{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .host' => 'color: {{VALUE}}',
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
								'{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .host:hover' => 'color: {{VALUE}}',
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
					'selector' 	=> '{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ovau-category a',
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
								'{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ovau-category a' => 'color: {{VALUE}}',
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
								'{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .ovau-category a:hover' => 'color: {{VALUE}}',
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
					'selector' 	=> '{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .detail-link a',
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
								'{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .detail-link a' => 'color: {{VALUE}}',
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
								'{{WRAPPER}} .ova-audio-list-2 .item-audio-2 .detail-link a:hover' => 'color: {{VALUE}}',
							],
						]
					);

				$this->end_controls_tab();
			$this->end_controls_tabs();
        $this->end_controls_section();
	}


	protected function render() {

		$settings = $this->get_settings();

		$template = apply_filters( 'el_ova_audio_list_2_filter', 'elementor/ova_audio_list_2.php' );

		ob_start();
		ovau_get_template( $template, $settings );
		echo ob_get_clean();
		
	}
}

$widgets_manager->register( new Ovau_Elementor_Audio_List_2() );
