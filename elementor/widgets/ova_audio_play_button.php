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

class Ovau_Elementor_Audio_Play_Button extends Widget_Base {

	public function get_name() {
		return 'ovau_elementor_audio_play_button';
	}

	public function get_title() {
		return esc_html__( 'Audio Play Button', 'ovau' );
	}

	public function get_icon() {
		return ' eicon-play';
	}

	public function get_categories() {
		return [ 'ova-audio' ];
	}

	public function get_script_depends() {
		return [ 'ovau-elementor-ova-audio-play-button' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'ovau' ),
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
					'options' => $arr_audio,
				]
			);

			$this->add_control(
				'text_button',
				[
					'label' 	=> esc_html__( 'Text Button', 'ovau' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__( 'Start Listening', 'ovau' ),
					'separator' => 'before',
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

		// Text Button Tab Style
		$this->start_controls_section(
			'section_style_text_button',
			[
				'label' => esc_html__( 'Text Button', 'ovau' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'text_button_typography',
					'selector' => '{{WRAPPER}} .ovau-play-button .ova-media .icon .text_button',
				]
			);


			$this->add_control(
				'color_text_button',
				[
					'label' => esc_html__( 'Color', 'ovau' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ovau-play-button .ova-media .icon .text_button' => 'color : {{VALUE}};'
					],
				]
			);

			$this->add_control(
				'color_text_button_hover',
				[
					'label' => esc_html__( 'Color Hover', 'ovau' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ovau-play-button .ova-media .icon:hover .text_button' => 'color : {{VALUE}};'
					],
				]
			);

			$this->add_responsive_control(
				'text_button_width',
				[
					'label'			=> esc_html__( 'Width', 'ovau' ),
					'type' 			=> \Elementor\Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px' ],
					'range' => [
						'px' => [
							'min' => 100,
							'max' => 600,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ovau-play-button .ova-media .icon .text_button' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();

	}


	protected function render() {

		$settings = $this->get_settings();

		$template = apply_filters( 'el_ova_audio_play_button_filter', 'elementor/ova_audio_play_button.php' );

		ob_start();
		ovau_get_template( $template, $settings );
		echo ob_get_clean();
		
	}
}

$widgets_manager->register( new Ovau_Elementor_Audio_Play_Button() );
