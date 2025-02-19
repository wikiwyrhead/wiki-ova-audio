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

class Ovau_Elementor_Audio_Categories_Slider extends Widget_Base {

	public function get_name() {
		return 'ovau_elementor_audio_categories_slider';
	}

	public function get_title() {
		return esc_html__( 'Audio Categories Slider', 'ovau' );
	}

	public function get_icon() {
		return 'eicon-slider-album';
	}

	public function get_categories() {
		return [ 'ova-audio' ];
	}

	public function get_script_depends() {
		return [ 'ovau-elementor-ova-audio-categories-slider' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'ovau' ),
			]
		);

			$args = array(
	           'taxonomy' 	=> 'category_audio',
	           'orderby' 	=> 'name',
	           'order'   	=> 'ASC'
	       	);
		
			$categories 	= get_categories( $args );
			$cate_arr 		= array();
			if ( $categories ) {
				foreach ( $categories as $cate ) {
					$cate_arr[$cate->term_id] = $cate->name;
				}
			}

			$this->add_control(
				'include_ids',
				[
					'label' 	=> esc_html__( 'Choose Categories', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::SELECT2,
					'label_block' 	=> true,
					'multiple' 	=> true,
					'options' 	=> $cate_arr,
					'description' 	=> esc_html__( 'Leave empty to select all', 'ovau' ),
				]
			);

			$this->add_control(
				'total_categories',
				[
					'label'       => esc_html__( 'Total Categories', 'ovau' ),
					'type'        => Controls_Manager::NUMBER,
					'default'     => 6,
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
				'show_thumbnail',
				[
					'label' 		=> esc_html__( 'Show Thumbnail', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Yes', 'ovau' ),
					'label_off' 	=> esc_html__( 'No', 'ovau' ),
					'default' 		=> 'yes',
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
					'default'     => 5,
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
				'nav_control',
				[
					'label'   => esc_html__( 'Show Nav', 'ovau' ),
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
				'class_icon_next_control',
				[
					'label'   => __( 'Icon Next', 'ovau' ),
					'type'    => Controls_Manager::ICONS,
					'default' => [
						'value' => 'flaticon flaticon-right-arrow-1',
						'library' => 'flaticon'
					],
					'condition' => [
						'nav_control' => 'yes'
					]
				]
			);

			$this->add_control(
				'class_icon_prev_control',
				[
					'label'   => __( 'Icon Prev', 'ovau' ),
					'type'    => Controls_Manager::ICONS,
					'default' => [
						'value' => 'flaticon flaticon-left-arrow-1',
						'library' => 'flaticon'
					],
					'condition' => [
						'nav_control' => 'yes'
					]
				]
			);

			$this->add_control(
				'dot_control',
				[
					'label'   => esc_html__( 'Show Dots', 'ovau' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'no',
					'options' => [
						'yes' => esc_html__( 'Yes', 'ovau' ),
						'no'  => esc_html__( 'No', 'ovau' ),
					],
					'frontend_available' => true,
				]
			);

		$this->end_controls_section();

		/****************************  END SECTION ADDITIONAL *********************/

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
					'selector' 	=> '{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .item .cat-title',
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' 	=> esc_html__( 'Color', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .item .cat-title' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'title_color_hover',
				[
					'label' 	=> esc_html__( 'Color Hover', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .item:hover .cat-title' => 'color: {{VALUE}};',
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
	                    '{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .cat-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

        $this->end_controls_section();
		/* End title style */

		/* Begin Image Style */
		$this->start_controls_section(
            'image_style',
            [
                'label' => esc_html__( 'Image', 'ovau' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

        	$this->add_responsive_control(
				'image_max_width',
				[
					'label' 	=> esc_html__( 'Max Width', 'ovau' ),
					'type' 		=> Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 300,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'size_units' 	=> [ 'px', '%' ],
					'selectors' 	=> [
						'{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .image-thumbnail img' => 'max-width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'image_height',
				[
					'label' 	=> esc_html__( 'Height', 'ovau' ),
					'type' 		=> Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 300,
						],
					],
					'size_units' 	=> [ 'px' ],
					'selectors' 	=> [
						'{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .image-thumbnail img' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);

        $this->end_controls_section();

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
						'{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-dots' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
								'{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-dots .owl-dot span' => 'background-color: {{VALUE}}',
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
								'{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-dots .owl-dot span' => 'width: {{SIZE}}{{UNIT}};',
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
								'{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-dots .owl-dot span' => 'height: {{SIZE}}{{UNIT}};',
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
			                    '{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-dots .owl-dot span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
								'{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-dots .owl-dot.active span' => 'background-color: {{VALUE}}',
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
								'{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-dots .owl-dot.active span' => 'width: {{SIZE}}{{UNIT}};',
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
								'{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-dots .owl-dot.active span' => 'height: {{SIZE}}{{UNIT}};',
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
			                    '{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-dots .owl-dot.active span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			                ],
			            ]
			        );

		        $this->end_controls_tab();
			$this->end_controls_tabs();

        $this->end_controls_section();
        /* End Dots Style */

        /* Begin Nav Arrow Style */
		$this->start_controls_section(
            'nav_style',
            [
                'label' => esc_html__( 'Arrows Control', 'ovau' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
                'condition' => [
					'nav_control' => 'yes'
				]
            ]
        );
            
            $this->add_responsive_control(
				'size_nav_icon',
				[
					'label' 		=> esc_html__( 'Icon Size', 'ovau' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px'],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 40,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-nav button.owl-prev i, {{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-nav button.owl-next i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'arrow_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'ovau' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-nav button.owl-prev, {{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-nav button.owl-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'nav_margin',
				[
					'label'      => esc_html__( 'Margin', 'ovau' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-nav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->start_controls_tabs( 'tabs_nav_style' );
				
				$this->start_controls_tab(
		            'tab_nav_normal',
		            [
		                'label' => esc_html__( 'Normal', 'ovau' ),
		            ]
		        );

		            $this->add_control(
						'color_nav_icon',
						[
							'label' => esc_html__( 'Color', 'ovau' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-nav button.owl-prev i, {{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-nav button.owl-next i' => 'color : {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'bgcolor_nav',
						[
							'label' => esc_html__( 'Background Color', 'ovau' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-nav button.owl-prev, {{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-nav button.owl-next' => 'background-color : {{VALUE}};',
							],
						]
					);

		        $this->end_controls_tab();

		        $this->start_controls_tab(
		            'tab_nav_hover',
		            [
		                'label' => esc_html__( 'Hover', 'ovau' ),
		            ]
		        );

		            $this->add_control(
						'color_nav_icon_hover',
						[
							'label' => esc_html__( 'Color Hover', 'ovau' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-nav button.owl-prev:hover i, {{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-nav button.owl-next:hover i' => 'color : {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'bgcolor_nav_hover',
						[
							'label' => esc_html__( 'Background Color', 'ovau' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-nav button.owl-prev:hover, {{WRAPPER}} .ova-audio-categories-slider .slide-audio-categories .owl-nav button.owl-next:hover' => 'background-color : {{VALUE}};',
							],
						]
					);

		        $this->end_controls_tab();

		    $this->end_controls_tabs();

        $this->end_controls_section();
        /* End Nav Arrow Style */

	}


	protected function render() {

		$settings = $this->get_settings();

		$template = apply_filters( 'el_ovau_audio_categories_slider_filter', 'elementor/ova_audio_categories_slider.php' );

		ob_start();
		ovau_get_template( $template, $settings );
		echo ob_get_clean();
		
	}
}

$widgets_manager->register( new Ovau_Elementor_Audio_Categories_Slider() );