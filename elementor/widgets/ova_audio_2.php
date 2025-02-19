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

class Ovau_Elementor_Audio_2 extends Widget_Base {

	public function get_name() {
		return 'ovau_elementor_audio_2';
	}

	public function get_title() {
		return esc_html__( 'Audio 2', 'ovau' );
	}

	public function get_icon() {
		return 'eicon-headphones';
	}

	public function get_categories() {
		return [ 'ova-audio' ];
	}

	public function get_script_depends() {
		return [ 'ovau-elementor-ova-audio-2' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'ovau' ),
			]
		);

			$this->add_control(
				'custom_audio',
				[
					'label' 		=> esc_html__( 'Custom Audio', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Yes', 'ovau' ),
					'label_off' 	=> esc_html__( 'No', 'ovau' ),
					'default' 		=> '',
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
					'type' 		=> \Elementor\Controls_Manager::SELECT,
					'default' 	=> $default_audio,
					'condition' => [
						'custom_audio' => ''
					],
					'options' => $arr_audio,
				]
			);

			$this->add_control(
				'src',
				[
					'label' 		=> esc_html__( 'Choose Audio', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::MEDIA,
					'media_types' 	=> ['audio'],
					'condition' 	=> [
						'custom_audio' => 'yes'
					],
					'placeholder' 	=> esc_html__( 'https://your-link.com', 'ovau' ),
					'default' => [
						'url' => '',
					],
				]
			);

			$this->add_control(
				'show_avatar',
				[
					'label' 		=> esc_html__( 'Show Avatar', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Yes', 'ovau' ),
					'label_off' 	=> esc_html__( 'No', 'ovau' ),
					'default' 		=> 'yes',
				]
			);

			$this->add_control(
				'custom_avatar',
				[
					'label' 		=> esc_html__( 'Custom Avatar', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Yes', 'ovau' ),
					'label_off' 	=> esc_html__( 'No', 'ovau' ),
					'default' 		=> '',
					'condition' => [
						'show_avatar' => 'yes',
					],
				]
			);

			$this->add_control(
				'avatar',
				[
					'label' => esc_html__( 'Choose Avatar', 'ovau' ),
					'type' 	=> \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'custom_avatar' => 'yes',
						'show_avatar' => 'yes',
					],
				]
			);
			
			// when choose custom audio 
			$this->add_control(
				'title',
				[
					'label' 	=> esc_html__( 'Title', 'ovau' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__( 'Title Audio', 'ovau' ),
					'condition' => [
						'custom_audio' => 'yes'
					],
				]
			);

			$this->add_control(
				'episode',
				[
					'label' 	=> esc_html__( 'Episode', 'ovau' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__( 'Episode 1', 'ovau' ),
					'condition' => [
						'custom_audio' => 'yes'
					],
				]
			);

			$this->add_control(
				'seperate',
				[
					'label' 	=> esc_html__( 'Seperate', 'ovau' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__( '.', 'ovau' ),
					'condition' => [
						'custom_audio' => 'yes'
					],
				]
			);
			// end custom audio

			$this->add_control(
				'show_title',
				[
					'label' 		=> esc_html__( 'Show Title', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Yes', 'ovau' ),
					'label_off' 	=> esc_html__( 'No', 'ovau' ),
					'default' 		=> 'yes',
					'separator' 	=> 'before',
					'condition' => [
						'custom_audio!' => 'yes'
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
					'condition' 	=> [
						'show_title' 	=> 'yes',
						'custom_audio' => ''
					],
				]
			);

			$this->add_control(
				'target_title',
				[
					'label' 		=> esc_html__( 'Target', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Yes', 'ovau' ),
					'label_off' 	=> esc_html__( 'No', 'ovau' ),
					'default' 		=> '',
					'condition' 	=> [
						'link_title' 	=> 'yes',
						'show_title' 	=> 'yes',
						'custom_audio' 	=> ''
					],
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
					'condition' => [
						'custom_audio!' => 'yes'
					],
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
					'condition' => [
						'custom_audio!' => 'yes'
					],
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
					'condition' => [
						'custom_audio!' => 'yes'
					],
				]
			);
			// end show hide fields

			$this->add_control(
				'detail_label',
				[
					'label' 	=> esc_html__( 'Detail Label', 'ovau' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__( 'View Episode', 'ovau' ),
					'separator' => 'before',
				]
			);

			$this->add_control(
				'custom_link',
				[
					'label' 		=> esc_html__( 'Link', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::URL,
					'placeholder' 	=> esc_html__( 'https://your-link.com', 'ovau' ),
					'default' => [
						'url' => '',
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
				'redo_icon',
				[
					'label' 		=> esc_html__( 'Redo Icon', 'ovau' ),
					'type' 			=> Controls_Manager::ICONS,
					'default' 		=> [
						'value' 	=> 'fas fa-redo-alt',
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
            'section_avatar_style',
            [
                'label' => esc_html__( 'Avatar', 'ovau' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

			$this->add_responsive_control(
				'avatar_size',
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
						'size' => 160,
					],
					'selectors' => [
						'{{WRAPPER}} .ovau-audio-2 .avatar' => 'width: {{SIZE}}{{UNIT}};min-width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);

        	$this->add_responsive_control(
                'avatar_margin',
                [
                    'label'         => esc_html__( 'Margin', 'ovau' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ovau-audio-2 .avatar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' 		=> 'avatar_border',
					'label' 	=> esc_html__( 'Border', 'ovau' ),
					'selector' 	=> '{{WRAPPER}} .ovau-audio-2 .avatar',
				]
			);

			$this->add_responsive_control(
                'avatar_border_radius',
                [
                    'label'         => esc_html__( 'Border Radius', 'ovau' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ovau-audio-2 .avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .ovau-audio-2 .avatar img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' 		=> 'avatar_box_shadow',
					'label' 	=> esc_html__( 'Box Shadow', 'ovau' ),
					'selector' 	=> '{{WRAPPER}} .ovau-audio-2 .avatar',
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
						'selector' 	=> '{{WRAPPER}} .ovau-audio-2 .avatar.playing .loader .stroke',
						'exclude' 	=> ['image'],
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
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .play-pause' => 'background-color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'controls_color',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .play-pause' => 'color: {{VALUE}}',
							],
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
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .play-pause.playing' => 'background-color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'playing_color',
						[
							'label' 	=> esc_html__( 'Playing Color', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .play-pause.playing' => 'color: {{VALUE}}',
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
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .play-pause:hover' => 'background-color: {{VALUE}}',
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .play-pause.playing:hover' => 'background-color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'controls_color_hover',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .play-pause:hover' => 'color: {{VALUE}}',
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .play-pause.playing:hover' => 'color: {{VALUE}}',
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
							'max' => 200,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 65,
					],
					'selectors' => [
						'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .play-pause' => 'width: {{SIZE}}{{UNIT}};min-width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
					'separator' => 'before',
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
						'size' => 16,
					],
					'selectors' => [
						'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .play-pause i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' 		=> 'controls_border',
					'label' 	=> esc_html__( 'Border', 'ovau' ),
					'selector' 	=> '{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .play-pause',
				]
			);

			$this->add_control(
				'controls_border_color_hover',
				[
					'label' 	=> esc_html__( 'Border Color Hover', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .play-pause:hover' => 'border-color: {{VALUE}}',
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
                        '{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .play-pause' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                        '{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_sbjf_style',
            [
                'label' => esc_html__( 'Skip Back & Jump Forward', 'ovau' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

        	$this->start_controls_tabs(
				'style_sbjf_tabs'
			);

        		$this->start_controls_tab(
					'style_sbjf_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'ovau' ),
					]
				);

        			$this->add_control(
						'sbjf_background',
						[
							'label' 	=> esc_html__( 'Background', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .skip-back' => 'background-color: {{VALUE}}',
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .jump-forward' => 'background-color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'sbjf_color',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .skip-back' => 'color: {{VALUE}}',
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .jump-forward' => 'color: {{VALUE}}',
							],
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'style_sbjf_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'ovau' ),
					]
				);

        			$this->add_control(
						'sbjf_background_hover',
						[
							'label' 	=> esc_html__( 'Background', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .skip-back:hover' => 'background-color: {{VALUE}}',
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .jump-forward:hover' => 'background-color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'sbjf_color_hover',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .skip-back:hover' => 'color: {{VALUE}}',
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .jump-forward:hover' => 'color: {{VALUE}}',
							],
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_responsive_control(
				'sbjf_size',
				[
					'label'			=> esc_html__( 'Size', 'ovau' ),
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
						'size' => 30,
					],
					'selectors' => [
						'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .skip-back' => 'width: {{SIZE}}{{UNIT}};min-width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .jump-forward' => 'width: {{SIZE}}{{UNIT}};min-width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
					'separator' => 'before',
				]
			);

			$this->add_responsive_control(
				'sbjf_size_icon',
				[
					'label'			=> esc_html__( 'Size', 'ovau' ),
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
						'size' => 10,
					],
					'selectors' => [
						'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .skip-back' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .jump-forward' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' 		=> 'sbjf_border',
					'label' 	=> esc_html__( 'Border', 'ovau' ),
					'selector' 	=> '{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .skip-back, .ovau-audio-2 .content .ovau-player-top .ovau-controls .jump-forward',
				]
			);

			$this->add_control(
				'sbjf_border_color_hover',
				[
					'label' 	=> esc_html__( 'Border Color Hover', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .skip-back:hover' => 'border-color: {{VALUE}}',
						'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .jump-forward:hover' => 'border-color: {{VALUE}}',
					],
				]
			);

			$this->add_responsive_control(
                'sbjf_border_radius',
                [
                    'label'         => esc_html__( 'Border Radius', 'ovau' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .skip-back' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .jump-forward' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
				'skip_back_options',
				[
					'label' 	=> esc_html__( 'Skip Back Options', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

				$this->add_responsive_control(
	                'skip_back_margin',
	                [
	                    'label'         => esc_html__( 'Margin', 'ovau' ),
	                    'type'          => Controls_Manager::DIMENSIONS,
	                    'size_units'    => [ 'px', '%', 'em' ],
	                    'selectors'     => [
	                        '{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .skip-back' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                    ],
	                ]
	            );

	        $this->add_control(
				'jump_forward_options',
				[
					'label' 	=> esc_html__( 'Jump Forward Options', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

				$this->add_responsive_control(
	                'jump_forward_margin',
	                [
	                    'label'         => esc_html__( 'Margin', 'ovau' ),
	                    'type'          => Controls_Manager::DIMENSIONS,
	                    'size_units'    => [ 'px', '%', 'em' ],
	                    'selectors'     => [
	                        '{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .ovau-controls .jump-forward' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                    ],
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
					'selector' 	=> '{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .title-episode .title, {{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .title-episode .title a',
				]
			);

        	$this->add_control(
				'title_color',
				[
					'label' 	=> esc_html__( 'Color', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .title-episode .title' => 'color: {{VALUE}}',
						'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .title-episode .title a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'title_color_hover',
				[
					'label' 	=> esc_html__( 'Color Hover', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .title-episode .title a:hover' => 'color: {{VALUE}}',
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
                        '{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .title-episode .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        	$this->add_control(
				'label_options',
				[
					'label' 	=> esc_html__( 'Label Options', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::HEADING,
				]
			);

				$this->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
						'name' 		=> 'label_typography',
						'selector' 	=> '{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .title-episode .episode .label',
					]
				);

	        	$this->add_control(
					'label_color',
					[
						'label' 	=> esc_html__( 'Color', 'ovau' ),
						'type' 		=> \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .title-episode .episode .label' => 'color: {{VALUE}}',
						],
					]
				);

			$this->add_control(
				'seperate_options',
				[
					'label' 	=> esc_html__( 'Seperate Options', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

				$this->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
						'name' 		=> 'seperate_typography',
						'selector' 	=> '{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .title-episode .episode .seperate',
					]
				);

	        	$this->add_control(
					'seperate_color',
					[
						'label' 	=> esc_html__( 'Color', 'ovau' ),
						'type' 		=> \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .title-episode .episode .seperate' => 'color: {{VALUE}}',
						],
					]
				);

			$this->add_control(
				'duration_options',
				[
					'label' 	=> esc_html__( 'Duration Options', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

				$this->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
						'name' 		=> 'duration_typography',
						'selector' 	=> '{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .title-episode .episode .ovau-duration',
					]
				);

	        	$this->add_control(
					'duration_color',
					[
						'label' 	=> esc_html__( 'Color', 'ovau' ),
						'type' 		=> \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .title-episode .episode .ovau-duration' => 'color: {{VALUE}}',
						],
					]
				);

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
					'selector' 	=> '{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .detail-link a',
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
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .detail-link a' => 'color: {{VALUE}}',
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
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .detail-link a:hover' => 'color: {{VALUE}}',
							],
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_responsive_control(
                'view_detail_margin',
                [
                    'label'         => esc_html__( 'Margin', 'ovau' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ovau-audio-2 .content .ovau-player-top .detail-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_progress_style',
            [
                'label' => esc_html__( 'Progress', 'ovau' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

        	$this->add_control(
				'progress_color',
				[
					'label' 	=> esc_html__( 'Color', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-view .ovau-player .ovamejs-container .ovamejs-controls .ovamejs-time-rail .ovamejs-time-total' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'progress_color_current',
				[
					'label' 	=> esc_html__( 'Current Color', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-view .ovau-player .ovamejs-container .ovamejs-controls .ovamejs-time-rail .ovamejs-time-total .ovamejs-time-current' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'progress_color_handle',
				[
					'label' 	=> esc_html__( 'Handle Color', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-view .ovau-player .ovamejs-container .ovamejs-controls .ovamejs-time-rail .ovamejs-time-total .ovamejs-time-handle .ovamejs-time-handle-content' => 'border-color: {{VALUE}}',
					],
				]
			);

        $this->end_controls_section();

        $this->start_controls_section(
            'section_currenttime_style',
            [
                'label' => esc_html__( 'Current Time & Duration', 'ovau' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

        	$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' 		=> 'currenttime_typography',
					'selector' 	=> '{{WRAPPER}} .ovau-audio-2 .content .ovau-player-view .ovau-player .ovamejs-container .ovamejs-controls .ovamejs-time',
				]
			);

			$this->add_control(
				'currenttime_color_handle',
				[
					'label' 	=> esc_html__( 'Handle Color', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-view .ovau-player .ovamejs-container .ovamejs-controls .ovamejs-time' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_responsive_control(
                'currenttime_margin',
                [
                    'label'         => esc_html__( 'Margin', 'ovau' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ovau-audio-2 .content .ovau-player-view .ovau-player .ovamejs-container .ovamejs-controls .ovamejs-time' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_volume_style',
            [
                'label' => esc_html__( 'Volume', 'ovau' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

        	$this->start_controls_tabs(
				'style_volume_tabs'
			);

        		$this->start_controls_tab(
					'style_volume_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'ovau' ),
					]
				);

        			$this->add_control(
						'volume_background',
						[
							'label' 	=> esc_html__( 'Background', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-view .ovau-player .ovamejs-container .ovamejs-controls .ovamejs-volume-button > button' => 'background-color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'volume_color',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-view .ovau-player .ovamejs-container .ovamejs-controls .ovamejs-volume-button > button' => 'color: {{VALUE}}',
							],
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'style_volume_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'ovau' ),
					]
				);

        			$this->add_control(
						'volume_background_hover',
						[
							'label' 	=> esc_html__( 'Background', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-view .ovau-player .ovamejs-container .ovamejs-controls .ovamejs-volume-button > button:hover' => 'background-color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'volume_color_hover',
						[
							'label' 	=> esc_html__( 'Color', 'ovau' ),
							'type' 		=> \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-view .ovau-player .ovamejs-container .ovamejs-controls .ovamejs-volume-button > button:hover:before' => 'color: {{VALUE}}',
							],
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_responsive_control(
				'volume_size_icon',
				[
					'label'			=> esc_html__( 'Size icon', 'ovau' ),
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
						'size' => 24,
					],
					'selectors' => [
						'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-view .ovau-player .ovamejs-container .ovamejs-controls .ovamejs-volume-button > button:before' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' 		=> 'volume_border',
					'label' 	=> esc_html__( 'Border', 'ovau' ),
					'selector' 	=> '{{WRAPPER}} .ovau-audio-2 .content .ovau-player-view .ovau-player .ovamejs-container .ovamejs-controls .ovamejs-volume-button > button',
				]
			);

			$this->add_control(
				'volume_border_color_hover',
				[
					'label' 	=> esc_html__( 'Border Color Hover', 'ovau' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ovau-audio-2 .content .ovau-player-view .ovau-player .ovamejs-container .ovamejs-controls .ovamejs-volume-button > button:hover' => 'border-color: {{VALUE}}',
					],
				]
			);

			$this->add_responsive_control(
                'volume_margin',
                [
                    'label'         => esc_html__( 'Margin', 'ovau' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ovau-audio-2 .content .ovau-player-view .ovau-player .ovamejs-container .ovamejs-controls .ovamejs-volume-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();
	}


	protected function render() {

		$settings = $this->get_settings();

		$template = apply_filters( 'el_ova_audio_2_filter', 'elementor/ova_audio_2.php' );

		ob_start();
		ovau_get_template( $template, $settings );
		echo ob_get_clean();
		
	}
}

$widgets_manager->register( new Ovau_Elementor_Audio_2() );
