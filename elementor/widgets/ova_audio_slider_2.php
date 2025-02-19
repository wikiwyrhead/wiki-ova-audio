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

class Ovau_Elementor_Audio_Slider_2 extends Widget_Base {

	public function get_name() {
		return 'ovau_elementor_audio_slider_2';
	}

	public function get_title() {
		return esc_html__( 'Audio Slider 2', 'ovau' );
	}

	public function get_icon() {
		return 'eicon-post-slider';
	}

	public function get_categories() {
		return [ 'ova-audio' ];
	}

	public function get_script_depends() {
		return [ 'ovau-elementor-ova-audio-slider-2' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'ovau' ),
			]
		);

			$this->add_control(
				'template',
				[
					'label' 	=> esc_html__( 'Template', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::SELECT,
					'default' 	=> 'template_1',
					'options' 	=> [
						'template_1'  	=> esc_html__( 'Template 1', 'ovau' ),
						'template_2'  	=> esc_html__( 'Template 2', 'ovau' ),
					],
				]
			);

			$this->add_control(
				'data_filter',
				[
					'label' 	=> esc_html__( 'Data Filter', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::SELECT,
					'default' 	=> 'by_category',
					'options' 	=> [
						'by_category'  	=> esc_html__( 'By Category', 'ovau' ),
						'any_audio'  	=> esc_html__( 'Manual Audios', 'ovau' ),
					],
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
				'class_icon',
				[
					'label'   => esc_html__( 'Icon', 'ovau' ),
					'type'    => Controls_Manager::ICONS,
					'default' => [
						'value' => 'flaticon flaticon-headphones',
						'library' => 'flaticon'
					]
				]
			);

			$this->add_control(
				'category',
				[
					'label'   => esc_html__( 'Category', 'ovau' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'all',
					'options' => array_merge( $catAll, $cate_array ),
					'condition' => [
						'data_filter' => 'by_category'
					]
				]
			);

			$arr_audio = array();

			$base_query = array(
	           'post_type' 		=> 'ova_audio',
	           'posts_per_page' => -1,
	           'post_status'    => 'publish',
	           'orderby'		=> 'meta_value_num',
	           'order'   		=> 'ASC',
	           'meta_type'   	=> 'NUMERIC',
	           'meta_key'		=> 'ovau_order',
	           'fields'         => 'ids'
	       	);

	       	$audios = new \WP_Query( $base_query );

	       	$default_audio = '';
	       	$i = 0;

	       	if ( $audios->have_posts() ) : 
			    while ( $audios->have_posts() ) : $audios->the_post(); 
			        $id 	= get_the_id();
                	$title 	= get_the_title();
                	$arr_audio[$id] = $title;
                	if ( $i === 0 ) {
                		$default_audio = $id;
                		$i++;
                	}
			    endwhile; wp_reset_postdata();
			endif;

			$this->add_control(
				'audio_id',
				[
					'label' 	=> esc_html__( 'Choose Audio', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::SELECT2,
					'multiple' 	=> true,
					'default' 	=> $default_audio,
					'options'   => $arr_audio,
					'condition' => [
						'data_filter' => 'any_audio'
					]
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
						'title'	=> esc_html__( 'Title', 'ovau' ),
						'date' 		=> esc_html__( 'Date', 'ovau' ),
						'modified' 	=> esc_html__( 'Modified', 'ovau' ),
						'rand' 		=> esc_html__( 'Random', 'ovau' ),
						'ovau_order' => esc_html__( 'Custom Order', 'ovau' ),
					],
				]
			);

			$this->add_control(
				'time_type',
				[
					'label' 	=> esc_html__( 'Date Time Type', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::SELECT,
					'default' 	=> 'default',
					'options' 	=> [
						'default' => esc_html__( 'Default', 'ovau' ),
						'time_ago'	=> esc_html__( 'Time ago', 'ovau' ),
					],
					'condition' => [
						'template' => 'template_2'
					]
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
				'show_excerpt',
				[
					'label' 		=> esc_html__( 'Show Excerpt', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Yes', 'ovau' ),
					'label_off' 	=> esc_html__( 'No', 'ovau' ),
					'default' 		=> '',
				]
			);

			$this->add_control(
				'show_date',
				[
					'label' 		=> esc_html__( 'Show Date', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Yes', 'ovau' ),
					'label_off' 	=> esc_html__( 'No', 'ovau' ),
					'default' 		=> 'yes',
				]
			);

			$this->add_control(
				'show_comment',
				[
					'label' 		=> esc_html__( 'Show Comment', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Yes', 'ovau' ),
					'label_off' 	=> esc_html__( 'No', 'ovau' ),
					'default' 		=> 'yes',
				]
			);

			$this->add_control(
				'show_duration',
				[
					'label' 		=> esc_html__( 'Show Duration', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Yes', 'ovau' ),
					'label_off' 	=> esc_html__( 'No', 'ovau' ),
					'default' 		=> 'yes',
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
				'class_icon_button',
				[
					'label'   => esc_html__( 'Icon Button', 'ovau' ),
					'type'    => Controls_Manager::ICONS,
					'default' => [
						'value' => 'flaticon flaticon-right-arrow-1',
						'library' => 'flaticon'
					],
					'condition' => [
						'template' => 'template_1'
					]
				]
			);

			$this->add_control(
				'text_button',
				[
					'label'   => esc_html__( 'Text Button', 'ovau' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'View Episode', 'ovau' ),
					'condition' => [
						'template' => 'template_1'
					]
				]
			);

        $this->end_controls_section();

        $this->start_controls_section(
			'section_more_options',
			[
				'label' => esc_html__( 'Additional Options Play', 'ovau' ),
				'condition' => [
					'template' => 'template_2'
				]
			]
		);

			$this->add_control(
				'seperate',
				[
					'label' 	=> esc_html__( 'Seperate', 'ovau' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__( '.', 'ovau' ),
					'condition' => [
						'episode_label!' => '',
					],
				]
			);

			$this->add_control(
				'play_icon',
				[
					'label'   => esc_html__( 'Icon', 'ovau' ),
					'type'    => Controls_Manager::ICONS,
					'default' => [
						'value' => 'fas fa-play',
						'library' => 'flaticon'
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

        /*****************************************************************
						START SECTION ADDITIONAL
		******************************************************************/

		$this->start_controls_section(
			'section_additional_options',
			[
				'label' => esc_html__( 'Additional Options Slider', 'ovau' ),
			]
		);

			$this->add_control(
				'margin_items',
				[
					'label'   => esc_html__( 'Margin Right Items', 'ovau' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 0,
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
					'default'     => 3,
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

		/* Begin image Style */
		$this->start_controls_section(
            'audio_image_style',
            [
                'label' => esc_html__( 'Image', 'ovau' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

        	$this->add_responsive_control(
				'audio_image_height',
				[
					'label' 		=> esc_html__( 'Height', 'ovau' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> ['px'],
					'range' => [
						'px' => [
							'min' => 130,
							'max' => 400,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item .ova-media .audio-img-wrapper .audio-img' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);

        $this->end_controls_section();

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
						'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item .ova-media .icon i' => 'font-size: {{SIZE}}{{UNIT}};',
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
								'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item .ova-media .icon i' => 'color: {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'icon_bgcolor',
						[
							'label' 	=> esc_html__( 'Background Color', 'ovau' ),
							'type' 		=> Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item .ova-media .icon' => 'background-color: {{VALUE}};',
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
								'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item:hover .ova-media .icon i' => 'color: {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'icon_bgcolor_hover',
						[
							'label' 	=> esc_html__( 'Background Color Hover', 'ovau' ),
							'type' 		=> Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item:hover .ova-media .icon' => 'background-color: {{VALUE}};',
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
	                    '{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item .ova-media .icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'selector' 	=> '{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item .ova-media .content .category',
				]
			);

			$this->add_control(
				'category_color',
				[
					'label' 	=> esc_html__( 'Color', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item .ova-media .content .category, {{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item .ova-media .content .category a' => 'color: {{VALUE}};',
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
	                    '{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item .ova-media .content .category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'selector' 	=> '{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item .ova-media .content .episode',
				]
			);

			$this->add_control(
				'episode_color',
				[
					'label' 	=> esc_html__( 'Color', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item .ova-media .content .episode' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'episode_dot_color',
				[
					'label' 	=> esc_html__( 'Dot Color', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item .ova-media .content .episode:before' => 'background: {{VALUE}};',
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
	                    '{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item .ova-media .content .episode' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'selector' 	=> '{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item .ova-media .content .title',
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' 	=> esc_html__( 'Color', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item .ova-media .content .title' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'title_color_hover',
				[
					'label' 	=> esc_html__( 'Color Hover', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item:hover .ova-media .content .title' => 'color: {{VALUE}};',
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
	                    '{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item .ova-media .content .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'selector' 	=> '{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item .ova-media .content .audio-button',
					
				]
			);

			$this->add_responsive_control(
	            'button_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'ovau' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item .ova-media .content .audio-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
	                    '{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item .ova-media .content .audio-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'label' 	=> esc_html__( 'Color ', 'ovau' ),
						'type' 		=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item .ova-media .content .audio-button' => 'color : {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'color_button_background',
					[
						'label' 	=> esc_html__( 'Background ', 'ovau' ),
						'type' 		=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item .ova-media .content .audio-button' => 'background-color : {{VALUE}};',
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
						'label' 	=> esc_html__( 'Color', 'ovau' ),
						'type' 		=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item:hover .ova-media .content .audio-button' => 'color : {{VALUE}} ;',
						],
					]
				);
				$this->add_control(
					'color_button_hover_background',
					[
						'label' 	=> esc_html__( 'Background', 'ovau' ),
						'type' 		=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .item:hover .ova-media .content .audio-button' => 'background-color : {{VALUE}};',
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
						'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-dots' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
								'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-dots .owl-dot span' => 'background-color: {{VALUE}}',
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
									'max' => 50,
								],
							],
							'size_units' 	=> [ 'px' ],
							'selectors' 	=> [
								'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-dots .owl-dot span' => 'width: {{SIZE}}{{UNIT}};',
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
									'max' => 50,
								],
							],
							'size_units' 	=> [ 'px' ],
							'selectors' 	=> [
								'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-dots .owl-dot span' => 'height: {{SIZE}}{{UNIT}};',
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
			                    '{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-dots .owl-dot span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
								'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-dots .owl-dot.active span' => 'background-color: {{VALUE}}',
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
									'max' => 100,
								],
							],
							'size_units' 	=> [ 'px' ],
							'selectors' 	=> [
								'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-dots .owl-dot.active span' => 'width: {{SIZE}}{{UNIT}};',
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
									'max' => 100,
								],
							],
							'size_units' 	=> [ 'px' ],
							'selectors' 	=> [
								'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-dots .owl-dot.active span' => 'height: {{SIZE}}{{UNIT}};',
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
			                    '{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-dots .owl-dot.active span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-nav button.owl-prev i, {{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-nav button.owl-next i' => 'font-size: {{SIZE}}{{UNIT}};',
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
						'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-nav button.owl-prev, {{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-nav button.owl-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-nav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
								'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-nav button.owl-prev i, {{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-nav button.owl-next i' => 'color : {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'bgcolor_nav',
						[
							'label' => esc_html__( 'Background Color', 'ovau' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-nav button.owl-prev, {{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-nav button.owl-next' => 'background-color : {{VALUE}};',
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
								'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-nav button.owl-prev:hover i, {{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-nav button.owl-next:hover i' => 'color : {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'bgcolor_nav_hover',
						[
							'label' => esc_html__( 'Background Color', 'ovau' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-nav button.owl-prev:hover, {{WRAPPER}} .ova-audio-slider-2 .slide-audio-2 .owl-nav button.owl-next:hover' => 'background-color : {{VALUE}};',
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

		$template = apply_filters( 'el_ovau_audio_slider_filter_2', 'elementor/ova_audio_slider_2.php' );

		ob_start();
		ovau_get_template( $template, $settings );
		echo ob_get_clean();
		
	}
}

$widgets_manager->register( new Ovau_Elementor_Audio_Slider_2() );