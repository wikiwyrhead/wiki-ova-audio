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

class Ovau_Elementor_Audio_Host_Slider extends Widget_Base {

	public function get_name() {
		return 'ovau_elementor_audio_host_slider';
	}

	public function get_title() {
		return esc_html__( 'Audio Host Slider', 'ovau' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
		return [ 'ova-audio' ];
	}

	public function get_script_depends() {
		return [ 'ovau-elementor-ova-audio-host-slider' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'ovau' ),
			]
		);

			$this->add_control(
				'total_count',
				[
					'label'   => esc_html__( 'Total', 'ovau' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 4
				]
			);

			$this->add_control(
				'template',
				[
					'label' => esc_html__( 'Template', 'ovau' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'template_1',
					'options' => [
						'template_1'   => esc_html__( 'Template 1', 'ovau' ),
						'template_2'   => esc_html__( 'Template 2', 'ovau' ),
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
						'title'  => esc_html__( 'Title', 'ovau' ),
						'date' 			=> esc_html__( 'Date', 'ovau' ),
						'modified' 		=> esc_html__( 'Modified', 'ovau' ),
						'rand' 			=> esc_html__( 'Random', 'ovau' ),
						'ovau_host_order' 	=> esc_html__( 'Custom Order', 'ovau' ),
					],
				]
			);

			$this->add_control(
				'order',
				[
					'label' => esc_html__( 'Order', 'ovau' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'ASC',
					'options' => [
						'ASC'  => esc_html__( 'Ascending', 'ovau' ),
						'DESC'  => esc_html__( 'Descending', 'ovau' ),
					],
				]
			);

			$this->add_control(
				'show_social',
				[
					'label' => esc_html__( 'Show Social', 'ovau' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ovau' ),
					'label_off' => esc_html__( 'Hide', 'ovau' ),
					'return_value' => 'yes',
					'default' => 'yes',
					'condition' => [
						'template' => 'template_1'
					]
				]
			);

			$this->add_control(
				'show_name',
				[
					'label' => esc_html__( 'Show Name', 'ovau' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ovau' ),
					'label_off' => esc_html__( 'Hide', 'ovau' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);

			$this->add_control(
				'show_job',
				[
					'label' => esc_html__( 'Show Job', 'ovau' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ovau' ),
					'label_off' => esc_html__( 'Hide', 'ovau' ),
					'return_value' => 'yes',
					'default' => 'yes',
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
					'default' => 20,
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
					'max' => 4,
					'default' => 2,
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

		/* Begin image Style */
		$this->start_controls_section(
            'audio_host_image_style',
            [
                'label' => esc_html__( 'Image', 'ovau' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

        	$this->add_responsive_control(
				'audio_host_image_height',
				[
					'label' 		=> esc_html__( 'Height', 'ovau' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> ['px'],
					'range' => [
						'px' => [
							'min' => 160,
							'max' => 460,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-audio-host-slider .content .item-audio-host .img img' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
                'audio_host_image_border_radius',
                [
                    'label'         => esc_html__( 'Border Radius', 'ovau' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ova-audio-host-slider .content .item-audio-host .img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();


        // Info Tab Style
		$this->start_controls_section(
			'section_style_info',
			[
				'label' => esc_html__( 'Info', 'ovau' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		    $this->add_control(
				'heading_name',
				[
					'label' => esc_html__( 'Name', 'ovau' ),
					'type' => Controls_Manager::HEADING,
				]
			);

				$this->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
						'name' => 'name_typography',
						'selector' => '{{WRAPPER}} .ova-audio-host-slider .content .item-audio-host .info .name',
					]
				);


				$this->add_control(
					'color_name',
					[
						'label' => esc_html__( 'Color', 'ovau' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ova-audio-host-slider .content .item-audio-host .info .name' => 'color : {{VALUE}};'
						],
					]
				);

				$this->add_control(
					'color_name_hover',
					[
						'label' => esc_html__( 'Color Hover', 'ovau' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ova-audio-host-slider .content .item-audio-host:hover .info .name' => 'color : {{VALUE}};'
						],
					]
				);

			$this->add_control(
				'heading_job',
				[
					'label' => esc_html__( 'Job', 'ovau' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before'
				]
			);

			    $this->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
						'name' => 'job_typography',
						'selector' => '{{WRAPPER}} .ova-audio-host-slider .content .item-audio-host .info .job',
					]
				);

				$this->add_control(
					'color_job',
					[
						'label' => esc_html__( 'Color', 'ovau' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ova-audio-host-slider .content .item-audio-host .info .job' => 'color : {{VALUE}};',
						],
					]
				);
		    
		$this->end_controls_section();

		// ICON Tab
        $this->start_controls_section(
			'section_style_icon',
			[
				'label' => esc_html__( 'Icons', 'ovau' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_social' => 'yes'
				]
			]
		);
			$this->start_controls_tabs( 'Style Icons' );

				$this->start_controls_tab(
					'icon_normal',
					[
						'label' => esc_html__( 'Normal', 'ovau' ),
					]
				);
					$this->add_control(
						'color_icon',
						[
							'label' => esc_html__( 'Color', 'ovau' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-host-slider .content .item-audio-host .list-icon .item i' => 'color : {{VALUE}};',
							],
						]
					);
                    $this->add_control(
						'background_color_icon',
						[
							'label' => esc_html__( 'Background Color', 'ovau' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-host-slider .content .item-audio-host .list-icon' => 'background-color : {{VALUE}};',
							],
							
						]
					);
				$this->end_controls_tab();

				$this->start_controls_tab(
					'icon_hover',
					[
						'label' => esc_html__( 'Hover', 'ovau' ),
					]
				);
					$this->add_control(
						'color_social_icons_hover',
						[
							'label' => esc_html__( 'Color', 'ovau' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-host-slider .content .item-audio-host .list-icon .item:hover i' => 'color : {{VALUE}};',
							],
						]
					);
					$this->add_control(
						'bg_color_social_icons_hover',
						[
							'label' => esc_html__( 'Background Color', 'ovau' ),
							'type' => Controls_Manager::COLOR,
							
							'selectors' => [
								'{{WRAPPER}} .ova-audio-host-slider .content .item-audio-host .list-icon .item:hover ' => 'background-color : {{VALUE}};',
							],
						]
					);

                $this->end_controls_tab();

			$this->end_controls_tabs();

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
						'{{WRAPPER}} .ova-audio-host-slider .owl-dots' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
								'{{WRAPPER}} .ova-audio-host-slider .owl-dots .owl-dot span' => 'background-color: {{VALUE}}',
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
								'{{WRAPPER}} .ova-audio-host-slider .owl-dots .owl-dot span' => 'width: {{SIZE}}{{UNIT}};',
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
								'{{WRAPPER}} .ova-audio-host-slider .owl-dots .owl-dot span' => 'height: {{SIZE}}{{UNIT}};',
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
			                    '{{WRAPPER}} .ova-audio-host-slider .owl-dots .owl-dot span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
								'{{WRAPPER}} .ova-audio-host-slider .owl-dots .owl-dot.active span' => 'background-color: {{VALUE}}',
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
								'{{WRAPPER}} .ova-audio-host-slider .owl-dots .owl-dot.active span' => 'width: {{SIZE}}{{UNIT}};',
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
								'{{WRAPPER}} .ova-audio-host-slider .owl-dots .owl-dot.active span' => 'height: {{SIZE}}{{UNIT}};',
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
			                    '{{WRAPPER}} .ova-audio-host-slider .owl-dots .owl-dot.active span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		$template = apply_filters( 'el_ova_audio_host_slider_filter', 'elementor/ova_audio_host_slider.php' );

		ob_start();
		ovau_get_template( $template, $settings );
		echo ob_get_clean();
		
	}
}

$widgets_manager->register( new Ovau_Elementor_Audio_Host_Slider() );