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
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Ovau_Elementor_Audio_Slider extends Widget_Base {

	public function get_name() {
		return 'ovau_elementor_audio_slider';
	}

	public function get_title() {
		return esc_html__( 'Audio Slider', 'ovau' );
	}

	public function get_icon() {
		return 'eicon-post-slider';
	}

	public function get_categories() {
		return [ 'ova-audio' ];
	}

	public function get_script_depends() {
		return [ 'ovau-elementor-ova-audio-slider' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'ovau' ),
			]
		);

		$args = array(
           'taxonomy' => 'category_audio',
           'orderby' => 'name',
           'order'   => 'ASC'
       	);
	
		$categories = get_categories($args);
		$catAll = array( 'all' => 'All categories');
		$cate_array = array();
		if ($categories) {
			foreach ( $categories as $cate ) {
				$cate_array[$cate->slug] = $cate->cat_name;
			}
		} else {
			$cate_array["No content Category found"] = esc_html('No category found','ovau');
		}

		$this->add_control(
			'show_featured',
			[
				'label' => esc_html__( 'Show Featured', 'ovau' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ovau' ),
				'label_off' => esc_html__( 'Hide', 'ovau' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'show_link_to_detail',
			[
				'label' => esc_html__( 'Show Link to Detail', 'ovau' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ovau' ),
				'label_off' => esc_html__( 'Hide', 'ovau' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'get_related_audio_by_id',
			[
				'label' => esc_html__( 'Get Related Audio by ID', 'ovau' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'ovau' ),
				'label_off' => esc_html__( 'No', 'ovau' ),
				'return_value' => 'yes',
				'default' => 'no',
				'description' => esc_html__( 'If this element located in a single audio page, get related audio by unique audio id and based category', 'ovau' ),
			]
		);

		$this->add_control(
			'category',
			[
				'label'   => esc_html__( 'Category', 'ovau' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'all',
				'options' => array_merge( $catAll, $cate_array ),
			]
		);

		$this->add_control(
			'total_count',
			[
				'label'   => esc_html__( 'Total', 'ovau' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5
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
				'label' => esc_html__( 'OrderBy', 'ovau' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'ID',
				'options' => [
					'ID'  => esc_html__( 'ID', 'ovau' ),
					'title'		=> esc_html__( 'Title', 'ovau' ),
					'date' 		=> esc_html__( 'Date', 'ovau' ),
					'modified' 	=> esc_html__( 'Modified', 'ovau' ),
					'rand' 		=> esc_html__( 'Random', 'ovau' ),
					'ovau_order' => esc_html__( 'Custom Order', 'ovau' ),
				],
			]
		);

		$this->add_control(
			'show_thumbnail',
			[
				'label' 		=> esc_html__( 'Show Thumbnail', 'ovau' ),
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
			'text_button',
			[
				'label'   => esc_html__( 'Text Button', 'ovau' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Episode page'
			]
		);


        $this->end_controls_section();

        /*****************************************************************
						START SECTION ADDITIONAL
		******************************************************************/

		$this->start_controls_section(
			'section_additional_options',
			[
				'label' => esc_html__( 'Additional Options', 'ovau' ),
			]
		);

			$this->add_control(
				'margin_items',
				[
					'label'   => esc_html__( 'Margin Right Items', 'ovau' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 30,
					'description' => esc_html__( 'Item space between', 'ovau' ),
				]	
			);

			$this->add_control(
				'stagePadding',
				[
					'label'   => esc_html__( 'Stage Padding', 'ovau' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 0,
				]
				
			);

			$this->add_control(
				'item_number',
				[
					'label'       => esc_html__( 'Item Number', 'ovau' ),
					'type'        => Controls_Manager::NUMBER,
					'description' => esc_html__( 'Number Item', 'ovau' ),
					'min' => 1,
					'max' => 3,
					'default' => 3,
				]
			);

			$this->add_control(
				'slides_to_scroll',
				[
					'label'       => esc_html__( 'Slides to Scroll', 'ovau' ),
					'type'        => Controls_Manager::NUMBER,
					'description' => esc_html__( 'Set how many slides are scrolled per swipe.', 'ovau' ),
					'default'     => 1,
				]
			);

			$this->add_control(
				'pause_on_hover',
				[
					'label'   => esc_html__( 'Pause on Hover', 'ovau' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'options' => [
						'yes' => esc_html__( 'Yes', 'ovau' ),
						'no'  => esc_html__( 'No', 'ovau' ),
					],
					'frontend_available' => true,
				]
			);


			$this->add_control(
				'infinite',
				[
					'label'   => esc_html__( 'Infinite Loop', 'ovau' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'options' => [
						'yes' => esc_html__( 'Yes', 'ovau' ),
						'no'  => esc_html__( 'No', 'ovau' ),
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'autoplay',
				[
					'label'   => esc_html__( 'Autoplay', 'ovau' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'options' => [
						'yes' => esc_html__( 'Yes', 'ovau' ),
						'no'  => esc_html__( 'No', 'ovau' ),
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'autoplay_speed',
				[
					'label'     => esc_html__( 'Autoplay Speed', 'ovau' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 3000,
					'step'      => 500,
					'condition' => [
						'autoplay' => 'yes',
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'smartspeed',
				[
					'label'   => esc_html__( 'Smart Speed', 'ovau' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 500,
				]
			);

			$this->add_control(
				'dot_control',
				[
					'label'   => esc_html__( 'Show Dots', 'ovau' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'options' => [
						'yes' => esc_html__( 'Yes', 'ovau' ),
						'no'  => esc_html__( 'No', 'ovau' ),
					],
					'frontend_available' => true,
				]
			);

		$this->end_controls_section();

		/****************************  END SECTION ADDITIONAL *********************/

		/* Begin content Style */
		$this->start_controls_section(
            'icon_style',
            [
                'label' => esc_html__( 'Content', 'ovau' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

	        $this->add_responsive_control(
	            'content_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'ovau' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ova-audio-slider .slide-audio .item .ova-media .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_control(
				'content_bgcolor',
				[
					'label' 	=> esc_html__( 'Background Color', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-slider .slide-audio .item .ova-media .content' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'content_box_shadow',
					'label' => esc_html__( 'Box Shadow', 'ovau' ),
					'selector' => '{{WRAPPER}} .ova-audio-slider .slide-audio .item .ova-media .content',
				]
			);

        $this->end_controls_section();
		/* End content style */

		/* Begin category Style */
		$this->start_controls_section(
            'category_style',
            [
                'label' => esc_html__( 'Category', 'ovau' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'category_typography',
					'selector' 	=> '{{WRAPPER}} .ova-audio-slider .slide-audio .item .ova-media .content .category',
				]
			);

			$this->add_control(
				'category_color',
				[
					'label' 	=> esc_html__( 'Color', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-slider .slide-audio .item .ova-media .content .category, {{WRAPPER}} .ova-audio-slider .slide-audio .item .ova-media .content .category a' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
	            'category_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'ovau' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ova-audio-slider .slide-audio .item .ova-media .content .category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

        $this->end_controls_section();
		/* End category style */

		/* Begin episode Style */
		$this->start_controls_section(
            'episode_style',
            [
                'label' => esc_html__( 'Episode', 'ovau' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'episode_typography',
					'selector' 	=> '{{WRAPPER}} .ova-audio-slider .slide-audio .item .ova-media .content .episode',
				]
			);

			$this->add_control(
				'episode_color',
				[
					'label' 	=> esc_html__( 'Color', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-slider .slide-audio .item .ova-media .content .episode' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'episode_dot_color',
				[
					'label' 	=> esc_html__( 'Dot Color', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-slider .slide-audio .item .ova-media .content .episode:before' => 'background: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
	            'episode_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'ovau' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ova-audio-slider .slide-audio .item .ova-media .content .episode' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

        $this->end_controls_section();
		/* End category style */

		/* Begin title Style */
		$this->start_controls_section(
            'title_style',
            [
                'label' => esc_html__( 'Title', 'ovau' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'title_typography',
					'selector' 	=> '{{WRAPPER}} .ova-audio-slider .slide-audio .item .ova-media .content .title',
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' 	=> esc_html__( 'Color', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-slider .slide-audio .item .ova-media .content .title' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'title_color_hover',
				[
					'label' 	=> esc_html__( 'Color Hover', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-slider .slide-audio .item:hover .ova-media .content .title' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
	            'title_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'ovau' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ova-audio-slider .slide-audio .item .ova-media .content .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

        $this->end_controls_section();
		/* End title style */

		//SECTION TAB STYLE TITLE
		$this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Button', 'ovau' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

	    	$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'text_button_typography',	
					'label' 	=> esc_html__( 'Typography', 'ovau' ),
					'selector' 	=> '{{WRAPPER}} .ova-audio-slider .slide-audio .item .ova-media .content .audio-button',
					
				]
			);

			$this->add_responsive_control(
	            'button_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'ovau' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ova-audio-slider .slide-audio .item .ova-media .content .audio-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_responsive_control(
	            'button_border_radius',
	            [
	                'label' 		=> esc_html__( 'Border Radius', 'ovau' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ova-audio-slider .slide-audio .item .ova-media .content .audio-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );


		$this->start_controls_tabs(
			'style_tabs_button'
		);

			$this->start_controls_tab(
				'style_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'ovau' ),
				]
			);

			    $this->add_control(
					'color_text_button',
					[
						'label' 	=> esc_html__( 'Text Color ', 'ovau' ),
						'type' 		=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ova-audio-slider .slide-audio .item .ova-media .content .audio-button' => 'color : {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'color_button_background',
					[
						'label' 	=> esc_html__( 'Background ', 'ovau' ),
						'type' 		=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ova-audio-slider .slide-audio .item .ova-media .content .audio-button' => 'background-color : {{VALUE}};',
						],
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'style_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'ovau' ),
				]
			);
				$this->add_control(
					'color_text_button_hover',
					[
						'label' 	=> esc_html__( 'Text Color', 'ovau' ),
						'type' 		=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ova-audio-slider .slide-audio .item:hover .ova-media .content .audio-button' => 'color : {{VALUE}} ;',
						],
					]
				);
				$this->add_control(
					'color_button_hover_background',
					[
						'label' 	=> esc_html__( 'Background', 'ovau' ),
						'type' 		=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ova-audio-slider .slide-audio .item:hover .ova-media .content .audio-button' => 'background-color : {{VALUE}};',
						],
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
		//END button style

		/* Begin Dots Style */
		$this->start_controls_section(
            'dots_style',
            [
                'label' => esc_html__( 'Dots', 'ovau' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
                'condition' => [
					'dot_control' => 'yes',
				]
            ]
        );

            $this->add_responsive_control(
				'dots_margin',
				[
					'label'      => esc_html__( 'Margin', 'ovau' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .ova-audio-slider .slide-audio .owl-dots' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->start_controls_tabs( 'tabs_dots_style' );
				
				$this->start_controls_tab(
		            'tab_dots_normal',
		            [
		                'label' => esc_html__( 'Normal', 'ovau' ),
		            ]
		        );

		            $this->add_control(
						'dot_color',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-slider .slide-audio .owl-dots .owl-dot span' => 'background-color: {{VALUE}}',
							],
						]
					);

					$this->add_responsive_control(
						'dots_width',
						[
							'label' 	=> esc_html__( 'Width', 'ovau' ),
							'type' 		=> Controls_Manager::SLIDER,
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 100,
								],
							],
							'size_units' 	=> [ 'px' ],
							'selectors' 	=> [
								'{{WRAPPER}} .ova-audio-slider .slide-audio .owl-dots .owl-dot span' => 'width: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$this->add_responsive_control(
						'dots_height',
						[
							'label' 	=> esc_html__( 'Height', 'ovau' ),
							'type' 		=> Controls_Manager::SLIDER,
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 100,
								],
							],
							'size_units' 	=> [ 'px' ],
							'selectors' 	=> [
								'{{WRAPPER}} .ova-audio-slider .slide-audio .owl-dots .owl-dot span' => 'height: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$this->add_control(
			            'dots_border_radius',
			            [
			                'label' 		=> esc_html__( 'Border Radius', 'ovau' ),
			                'type' 			=> Controls_Manager::DIMENSIONS,
			                'size_units' 	=> [ 'px', '%' ],
			                'selectors' 	=> [
			                    '{{WRAPPER}} .ova-audio-slider .slide-audio .owl-dots .owl-dot span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			                ],
			            ]
			        );

		        $this->end_controls_tab();

		        $this->start_controls_tab(
		            'tab_dots_active',
		            [
		                'label' => esc_html__( 'Active', 'ovau' ),
		            ]
		        );

		             $this->add_control(
						'dot_color_active',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-slider .slide-audio .owl-dots .owl-dot.active span' => 'background-color: {{VALUE}}',
							],
						]
					);

					$this->add_responsive_control(
						'dots_width_active',
						[
							'label' 	=> esc_html__( 'Width', 'ovau' ),
							'type' 		=> Controls_Manager::SLIDER,
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 50,
								],
							],
							'size_units' 	=> [ 'px' ],
							'selectors' 	=> [
								'{{WRAPPER}} .ova-audio-slider .slide-audio .owl-dots .owl-dot.active span' => 'width: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$this->add_responsive_control(
						'dots_height_active',
						[
							'label' 	=> esc_html__( 'Height', 'ovau' ),
							'type' 		=> Controls_Manager::SLIDER,
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 50,
								],
							],
							'size_units' 	=> [ 'px' ],
							'selectors' 	=> [
								'{{WRAPPER}} .ova-audio-slider .slide-audio .owl-dots .owl-dot.active span' => 'height: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$this->add_control(
			            'dots_border_radius_active',
			            [
			                'label' 		=> esc_html__( 'Border Radius', 'ovau' ),
			                'type' 			=> Controls_Manager::DIMENSIONS,
			                'size_units' 	=> [ 'px', '%' ],
			                'selectors' 	=> [
			                    '{{WRAPPER}} .ova-audio-slider .slide-audio .owl-dots .owl-dot.active span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			                ],
			            ]
			        );

		        $this->end_controls_tab();
			$this->end_controls_tabs();

        $this->end_controls_section();
        /* End Dots Style */

	}


	protected function render() {

		$settings = $this->get_settings();

		$template = apply_filters( 'el_ovau_audio_slider_filter', 'elementor/ova_audio_slider.php' );

		ob_start();
		ovau_get_template( $template, $settings );
		echo ob_get_clean();
		
	}
}

$widgets_manager->register( new Ovau_Elementor_Audio_Slider() );