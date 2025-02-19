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

class Ovau_Elementor_Audio_Category_Filter_2 extends Widget_Base {

	public function get_name() {
		return 'ovau_elementor_audio_category_filter_2';
	}

	public function get_title() {
		return esc_html__( 'Audio Category Filter 2', 'ovau' );
	}

	public function get_icon() {
		return 'eicon-filter';
	}

	public function get_categories() {
		return [ 'ova-audio' ];
	}

	public function get_script_depends() {
		return [ 'ovau-elementor-ova-audio-category-filter-2' ];
	}
	
	// Add Your Controll In This Function
	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Audio Category Filter 2', 'ovau' ),
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
				'show_thumbnail',
				[
					'label' 		=> esc_html__( 'Show Thumbnail', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Yes', 'ovau' ),
					'label_off' 	=> esc_html__( 'No', 'ovau' ),
					'default' 		=> 'yes',
					'separator'     => 'before'
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
					'default' 	=> esc_html__( 'Episode page', 'ovau' ),
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
        
        /* Begin icon Style */
		$this->start_controls_section(
            'icon_style',
            [
                'label' => esc_html__( 'Icon', 'ovau' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );
            
			$this->add_responsive_control(
				'size_icon',
				[
					'label' 		=> esc_html__( 'Size', 'ovau' ),
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
						'{{WRAPPER}} .ova-audio-category-filter-2  .item .ova-media .icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->start_controls_tabs( 'tabs_icon_style' );
				
				$this->start_controls_tab(
		            'tab_icon_normal',
		            [
		                'label' => esc_html__( 'Normal', 'ovau' ),
		            ]
		        );
                     
                     $this->add_control(
						'icon_color',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-category-filter-2  .item .ova-media .icon i' => 'color: {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'icon_bgcolor',
						[
							'label' 	=> esc_html__( 'Background Color', 'ovau' ),
							'type' 		=> Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-category-filter-2  .item .ova-media .icon' => 'background-color: {{VALUE}};',
							],
						]
					);

		        $this->end_controls_tab();

		        $this->start_controls_tab(
		            'tab_icon_hover',
		            [
		                'label' => esc_html__( 'Hover', 'ovau' ),
		            ]
		        );

		             $this->add_control(
						'icon_color_hover',
						[
							'label' 	=> esc_html__( 'Color Hover', 'ovau' ),
							'type' 		=> Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-category-filter-2  .item:hover .ova-media .icon i' => 'color: {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'icon_bgcolor_hover',
						[
							'label' 	=> esc_html__( 'Background Color Hover', 'ovau' ),
							'type' 		=> Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-category-filter-2  .item:hover .ova-media .icon' => 'background-color: {{VALUE}};',
							],
						]
					);

		        $this->end_controls_tab();

		    $this->end_controls_tabs();

	        $this->add_responsive_control(
	            'icon_border_radius',
	            [
	                'label' 		=> esc_html__( 'Border Radius', 'ovau' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ova-audio-category-filter-2  .item .ova-media .icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

        $this->end_controls_section();
		/* End icon style */

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
					'selector' 	=> '{{WRAPPER}} .ova-audio-category-filter-2  .item .ova-media .content .category',
				]
			);

			$this->add_control(
				'category_color',
				[
					'label' 	=> esc_html__( 'Color', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-category-filter-2  .item .ova-media .content .category, {{WRAPPER}} .ova-audio-category-filter-2  .item .ova-media .content .category a' => 'color: {{VALUE}};',
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
	                    '{{WRAPPER}} .ova-audio-category-filter-2  .item .ova-media .content .category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'selector' 	=> '{{WRAPPER}} .ova-audio-category-filter-2  .item .ova-media .content .episode',
				]
			);

			$this->add_control(
				'episode_color',
				[
					'label' 	=> esc_html__( 'Color', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-category-filter-2  .item .ova-media .content .episode' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'episode_dot_color',
				[
					'label' 	=> esc_html__( 'Dot Color', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-category-filter-2  .item .ova-media .content .episode:before' => 'background: {{VALUE}};',
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
	                    '{{WRAPPER}} .ova-audio-category-filter-2  .item .ova-media .content .episode' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'selector' 	=> '{{WRAPPER}} .ova-audio-category-filter-2  .item .ova-media .content .title',
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' 	=> esc_html__( 'Color', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-category-filter-2  .item .ova-media .content .title' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'title_color_hover',
				[
					'label' 	=> esc_html__( 'Color Hover', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-category-filter-2  .item:hover .ova-media .content .title' => 'color: {{VALUE}};',
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
	                    '{{WRAPPER}} .ova-audio-category-filter-2  .item .ova-media .content .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'selector' 	=> '{{WRAPPER}} .ova-audio-category-filter-2  .item .ova-media .content .audio-button',
					
				]
			);

			$this->add_responsive_control(
	            'button_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'ovau' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ova-audio-category-filter-2  .item .ova-media .content .audio-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
	                    '{{WRAPPER}} .ova-audio-category-filter-2  .item .ova-media .content .audio-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
							'{{WRAPPER}} .ova-audio-category-filter-2  .item .ova-media .content .audio-button' => 'color : {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'color_button_background',
					[
						'label' 	=> esc_html__( 'Background ', 'ovau' ),
						'type' 		=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ova-audio-category-filter-2  .item .ova-media .content .audio-button' => 'background-color : {{VALUE}};',
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
							'{{WRAPPER}} .ova-audio-category-filter-2  .item:hover .ova-media .content .audio-button' => 'color : {{VALUE}} ;',
						],
					]
				);
				$this->add_control(
					'color_button_hover_background',
					[
						'label' 	=> esc_html__( 'Background', 'ovau' ),
						'type' 		=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ova-audio-category-filter-2  .item:hover .ova-media .content .audio-button' => 'background-color : {{VALUE}};',
						],
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
		//END button style

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

		$template = apply_filters( 'el_ova_audio_category_ajax_2_filter', 'elementor/ova_audio_category_filter_2.php' );
		ob_start();
		ovau_get_template( $template, $settings );
		echo ob_get_clean();
	}

	
}
$widgets_manager->register( new Ovau_Elementor_Audio_Category_Filter_2() );