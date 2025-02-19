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

class Ovau_Elementor_Audio_Grid_2 extends Widget_Base {

	public function get_name() {
		return 'ovau_elementor_audio_grid_2';
	}

	public function get_title() {
		return esc_html__( 'Audio Grid 2', 'ovau' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'ova-audio' ];
	}

	public function get_script_depends() {
		return [ 'ovau-elementor-ova-audio-grid-2' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'ovau' ),
			]
		);

			$this->add_control(
				'total_posts',
				[
					'label' 	=> esc_html__( 'Total Posts', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::NUMBER,
					'step' 		=> 1,
					'default' 	=> 3,
				]
			);	

			$this->add_control(
				'offset',
				[
					'label' 	=> esc_html__( 'Ofset', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::NUMBER,
					'step' 		=> 1,
					'min' 		=> 0,
					'max' 		=> 5,
					'default' 	=> 0,
					'condition' => [
						'show_pagination!' => 'yes'
					]
				]
			);	

			$this->add_control(
				'class_icon',
				[
					'label'   => esc_html__( 'Icon', 'ovau' ),
					'type'    => Controls_Manager::ICONS,
					'default' => [
						'value' => 'ovaicon ovaicon-folder',
						'library' => 'ovaicon'
					]
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
					$cate_arr[$cate->slug] = $cate->name;
				}
			} else {
				$cate_arr['not_found'] = esc_html__( "Category not found!", "ovau" );
			}

			$this->add_control(
				'categories',
				[
					'label' 	=> esc_html__( 'Categories', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::SELECT2,
					'multiple' 	=> true,
					'options' 	=> $cate_arr,
				]
			);

			$this->add_control(
				'column',
				[
					'label' 	=> esc_html__( 'Column', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::SELECT,
					'default' 	=> 'three_column',
					'options' 	=> [
						'two_column' => esc_html__( '2 Columns', 'ovau' ),
						'three_column'	=> esc_html__( '3 Columns', 'ovau' ),
						'four_column'	=> esc_html__( '4 Columns', 'ovau' ),
					],
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
				'time_type',
				[
					'label' 	=> esc_html__( 'Date Time Type', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::SELECT,
					'default' 	=> 'default',
					'options' 	=> [
						'default' => esc_html__( 'Default', 'ovau' ),
						'time_ago'	=> esc_html__( 'Time ago', 'ovau' ),
					],
				]
			);

			$this->add_control(
				'show_thumbnail',
				[
					'label' 		=> esc_html__( 'Show Thumbnail', 'ovau' ),
					'type' 			=> Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Show', 'ovau' ),
					'label_off' 	=> esc_html__( 'Hide', 'ovau' ),
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
					'label' => esc_html__( 'Show Date', 'ovau' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ovau' ),
					'label_off' => esc_html__( 'Hide', 'ovau' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);

			$this->add_control(
				'replace_date_by_cate',
				[
					'label' => esc_html__( 'Replace Date by Category', 'ovau' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'default' => 'no',
					'options' => [
						'yes' => esc_html__( 'Yes', 'ovau' ),
						'no'  => esc_html__( 'No', 'ovau' ),
					],
				]
			);

			$this->add_control(
				'show_comment',
				[
					'label' => esc_html__( 'Show Comment', 'ovau' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'ovau' ),
					'label_off' => esc_html__( 'Hide', 'ovau' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);

			$this->add_control(
				'show_duration',
				[
					'label' => esc_html__( 'Show Duration', 'ovau' ),
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

			$this->add_control(
				'show_pagination',
				[
					'label' 		=> esc_html__( 'Show Pagination', 'ovau' ),
					'type' 			=> Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Show', 'ovau' ),
					'label_off' 	=> esc_html__( 'Hide', 'ovau' ),
					'default' 		=> 'no',
				]
			);

			$this->add_responsive_control(
				'align_pagination',
				[
					'label' 	=> esc_html__( 'Pagination Alignment', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::CHOOSE,
					'options' 	=> [
						'left' => [
							'title' => esc_html__( 'Left', 'ovau' ),
							'icon' 	=> 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'ovau' ),
							'icon' 	=> 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'ovau' ),
							'icon' 	=> 'eicon-text-align-right',
						],
					],
					'toggle' 	=> true,
					'selectors' => [
						'{{WRAPPER}} .ovau_pagination_ajax' => 'text-align: {{VALUE}}',
					],
					'condition' => [
						'show_pagination' => 'yes'
					]
				]
			);

			$this->add_control(
				'more_options',
				[
					'label' 	=> esc_html__( 'Additional Options Play', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
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
					'label'   => __( 'Icon', 'ovau' ),
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
						'{{WRAPPER}} .ova-audio-grid-2 .item .ova-media .audio-img-wrapper .audio-img' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);

        $this->end_controls_section();

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
					'selector' 	=> '{{WRAPPER}} .ova-audio-grid-2 .item .ova-media .content .category',
				]
			);

			$this->add_control(
				'category_color',
				[
					'label' 	=> esc_html__( 'Color', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-grid-2 .item .ova-media .content .category, {{WRAPPER}} .ova-audio-grid-2 .item .ova-media .content .category a' => 'color: {{VALUE}};',
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
	                    '{{WRAPPER}} .ova-audio-grid-2 .item .ova-media .content .category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'selector' 	=> '{{WRAPPER}} .ova-audio-grid-2 .item .ova-media .content .episode',
				]
			);

			$this->add_control(
				'episode_color',
				[
					'label' 	=> esc_html__( 'Color', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-grid-2 .item .ova-media .content .episode' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'episode_dot_color',
				[
					'label' 	=> esc_html__( 'Dot Color', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-grid-2 .item .ova-media .content .episode:before' => 'background: {{VALUE}};',
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
	                    '{{WRAPPER}} .ova-audio-grid-2 .item .ova-media .content .episode' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'selector' 	=> '{{WRAPPER}} .ova-audio-grid-2 .item .ova-media .content .title',
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' 	=> esc_html__( 'Color', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-grid-2 .item .ova-media .content .title' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'title_color_hover',
				[
					'label' 	=> esc_html__( 'Color Hover', 'ovau' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-audio-grid-2 .item:hover .ova-media .content .title' => 'color: {{VALUE}};',
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
	                    '{{WRAPPER}} .ova-audio-grid-2 .item .ova-media .content .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

	    	$this->add_responsive_control(
				'font_size_icon',
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
						'{{WRAPPER}} .ova-audio-grid-2 .item .ova-media .content .audio-button i' => 'font-size: {{SIZE}}{{UNIT}};',
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
							'{{WRAPPER}} .ova-audio-grid-2 .item .ova-media .content .audio-button' => 'color : {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'color_button_background',
					[
						'label' 	=> esc_html__( 'Background ', 'ovau' ),
						'type' 		=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ova-audio-grid-2 .item .ova-media .content .audio-button' => 'background-color : {{VALUE}};',
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
							'{{WRAPPER}} .ova-audio-grid-2 .item:hover .ova-media .content .audio-button' => 'color : {{VALUE}} ;',
						],
					]
				);
				$this->add_control(
					'color_button_hover_background',
					[
						'label' 	=> esc_html__( 'Background', 'ovau' ),
						'type' 		=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ova-audio-grid-2 .item:hover .ova-media .content .audio-button' => 'background-color : {{VALUE}};',
						],
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}


	protected function render() {

		$settings = $this->get_settings();

		$template = apply_filters( 'el_ova_audio_grid_2_filter', 'elementor/ova_audio_grid_2.php' );

		ob_start();
		ovau_get_template( $template, $settings );
		echo ob_get_clean();
		
	}
}

$widgets_manager->register( new Ovau_Elementor_Audio_Grid_2() );