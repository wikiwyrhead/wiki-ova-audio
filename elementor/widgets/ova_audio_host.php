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

class Ovau_Elementor_Audio_Host extends Widget_Base {

	public function get_name() {
		return 'ovau_elementor_audio_host';
	}

	public function get_title() {
		return esc_html__( 'Audio Host', 'ovau' );
	}

	public function get_icon() {
		return 'eicon-user-circle-o';
	}

	public function get_categories() {
		return [ 'ova-audio' ];
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
					'default' => 3
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
				'number_column',
				[
					'label' => esc_html__( 'Number Of Column', 'ovau' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'three_column',
					'options' => [
						'one_column'   => esc_html__( '1 Columns', 'ovau' ),
						'two_column'   => esc_html__( '2 Columns', 'ovau' ),
						'three_column' => esc_html__( '3 Columns', 'ovau' ),
						'four_column'  => esc_html__( '4 Columns', 'ovau' ),
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
						'{{WRAPPER}} .ova-audio-host .content .item-audio-host .img img' => 'height: {{SIZE}}{{UNIT}};',
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
                        '{{WRAPPER}} .ova-audio-host .content .item-audio-host .img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'selector' => '{{WRAPPER}} .ova-audio-host .content .item-audio-host .info .name',
					]
				);


				$this->add_control(
					'color_name',
					[
						'label' => esc_html__( 'Color', 'ovau' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ova-audio-host .content .item-audio-host .info .name' => 'color : {{VALUE}};'
						],
					]
				);

				$this->add_control(
					'color_name_hover',
					[
						'label' => esc_html__( 'Color Hover', 'ovau' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ova-audio-host .content .item-audio-host:hover .info .name' => 'color : {{VALUE}};'
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
						'selector' => '{{WRAPPER}} .ova-audio-host .content .item-audio-host .info .job',
					]
				);

				$this->add_control(
					'color_job',
					[
						'label' => esc_html__( 'Color', 'ovau' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ova-audio-host .content .item-audio-host .info .job' => 'color : {{VALUE}};',
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
								'{{WRAPPER}} .ova-audio-host .content .item-audio-host .list-icon .item i' => 'color : {{VALUE}};',
							],
						]
					);
                    $this->add_control(
						'background_color_icon',
						[
							'label' => esc_html__( 'Background Color', 'ovau' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-audio-host .content .item-audio-host .list-icon' => 'background-color : {{VALUE}};',
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
								'{{WRAPPER}} .ova-audio-host .content .item-audio-host .list-icon .item:hover i' => 'color : {{VALUE}};',
							],
						]
					);
					$this->add_control(
						'bg_color_social_icons_hover',
						[
							'label' => esc_html__( 'Background Color', 'ovau' ),
							'type' => Controls_Manager::COLOR,
							
							'selectors' => [
								'{{WRAPPER}} .ova-audio-host .content .item-audio-host .list-icon .item:hover ' => 'background-color : {{VALUE}};',
							],
						]
					);

                $this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

	}


	protected function render() {

		$settings = $this->get_settings();

		$template = apply_filters( 'el_ova_audio_host_filter', 'elementor/ova_audio_host.php' );

		ob_start();
		ovau_get_template( $template, $settings );
		echo ob_get_clean();
		
	}
}

$widgets_manager->register( new Ovau_Elementor_Audio_Host() );