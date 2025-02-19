<?php

if ( !defined( 'ABSPATH' ) ) exit();

if ( !class_exists( 'Ovau_Customize' ) ) {

	class Ovau_Customize {

		public function __construct() {
			add_action( 'customize_register', array( $this, 'ovau_customize_register' ) );
		}

		public function ovau_customize_register( $wp_customize ) {

			$this->ovau_init( $wp_customize );

			do_action( 'ovau_customize_register', $wp_customize );
		}


		/* Audio */
		public function ovau_init( $wp_customize ){

            // Section Audio
			$wp_customize->add_panel( 'ovau_section' , array(
				'title'      => esc_html__( 'Audio', 'ovau' ),
				'priority'   => 5
			) );

				// Archive
				$wp_customize->add_section( 'ovau_archive_section' , array(
				    'title'     => esc_html__( 'Archive', 'ovau' ),
				    'priority'  => 1,
				    'panel' 	=> 'ovau_section'
				) );
					
					// Post per page
					$wp_customize->add_setting( 'ovau_total_record', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports'    => '', // Rarely needed.
						'default' 			=> '6',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name  
					) );
					
					$wp_customize->add_control('ovau_archive_section', array(
						'label' 	=> esc_html__('Number of posts per page','ovau'),
						'section' 	=> 'ovau_archive_section',
						'settings' 	=> 'ovau_total_record',
						'type' 		=> 'number'
					));

					$wp_customize->add_setting( 'ovau_archive_order', array(
					  'type' => 'theme_mod', // or 'option'
					  'capability' => 'edit_theme_options',
					  'theme_supports' => '', // Rarely needed.
					  'default' => 'DESC',
					  'transport' => 'refresh', // or postMessage
					  'sanitize_callback' => 'sanitize_text_field' // Get function name 
					) );

					$wp_customize->add_control('ovau_archive_order', array(
						'label' => esc_html__('Order','ovau'),
						'section' => 'ovau_archive_section',
						'settings' => 'ovau_archive_order',
						'type' =>'select',
						'choices' => array(
							'ASC'  => esc_html__( 'Ascending', 'ovau' ),
							'DESC' => esc_html__( 'Descending', 'ovau' ),
						)
					));

					$wp_customize->add_setting( 'ovau_archive_orderby', array(
					  	'type' => 'theme_mod', // or 'option'
					  	'capability' => 'edit_theme_options',
					  	'theme_supports' => '', // Rarely needed.
					  	'default' => 'ovau_order',
					  	'transport' => 'refresh', // or postMessage
					  	'sanitize_callback' => 'sanitize_text_field' // Get function name 
					) );

					$wp_customize->add_control('ovau_archive_orderby', array(
						'label' => esc_html__('Order By','ovau'),
						'section' => 'ovau_archive_section',
						'settings' => 'ovau_archive_orderby',
						'type' =>'select',
						'choices' => array(
							'id'  			=> esc_html__( 'ID', 'ovau' ),
							'title'			=> esc_html__( 'Title', 'ovau' ),
							'date' 			=> esc_html__( 'Date', 'ovau' ),
							'modified' 		=> esc_html__( 'Modified', 'ovau' ),
							'rand' 			=> esc_html__( 'Random', 'ovau' ),
							'ovau_order' 	=> esc_html__( 'Sort Order', 'ovau' ),
						)
					));

					// Column Layout
					$wp_customize->add_setting( 'ovau_column_layout', array(
					  	'type' => 'theme_mod', // or 'option'
					  	'capability' => 'edit_theme_options',
					  	'theme_supports' => '', // Rarely needed.
					  	'default' => 'three_column',
					  	'transport' => 'refresh', // or postMessage
					  	'sanitize_callback' => 'sanitize_text_field' // Get function name 
					) );

					$wp_customize->add_control('ovau_column_layout', array(
						'label' => esc_html__('Column','ovau'),
						'section' => 'ovau_archive_section',
						'settings' => 'ovau_column_layout',
						'type' =>'select',
						'choices' => array(
							'two_column'   => esc_html__( '2 column', 'ovau' ),
							'three_column' => esc_html__( '3 column', 'ovau' ),
							'four_column'  => esc_html__( '4 column', 'ovau' ),
						)
					));

					// Header Archive Audio
					$wp_customize->add_setting( 'header_archive_audio', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'default',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name 
					) );

					$wp_customize->add_control('header_archive_audio', array(
						'label' 	=> esc_html__('Header Archive','ovau'),
						'section' 	=> 'ovau_archive_section',
						'settings' 	=> 'header_archive_audio',
						'type' 		=>'select',
						'choices' 	=> apply_filters( 'podover_list_header', '' )
					));

					// Footer Archive Audio
					$wp_customize->add_setting( 'footer_archive_audio', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'default',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name 
					) );

					$wp_customize->add_control('footer_archive_audio', array(
						'label' 	=> esc_html__('Footer Archive','ovau'),
						'section' 	=> 'ovau_archive_section',
						'settings' 	=> 'footer_archive_audio',
						'type' 		=>'select',
						'choices' 	=> apply_filters('podover_list_footer', '')
					));

					$wp_customize->add_setting( 'ovau_archive_show_thumbnail', array(
					  	'type' => 'theme_mod', // or 'option'
					  	'capability' => 'edit_theme_options',
					  	'theme_supports' => '', // Rarely needed.
					  	'default' => 'yes',
					  	'transport' => 'refresh', // or postMessage
					  	'sanitize_callback' => 'sanitize_text_field' // Get function name 	  
					) );
					
					$wp_customize->add_control('ovau_archive_show_thumbnail', array(
						'label' => esc_html__('Show Thumbnail','ovau'),
						'section' => 'ovau_archive_section',
						'settings' => 'ovau_archive_show_thumbnail',
						'type' =>'select',
						'choices' => array(
							'yes' => esc_html__('Yes', 'ovau'),
							'no'  => esc_html__('No', 'ovau'),
						)
					));

					$wp_customize->add_setting( 'ovau_archive_show_host', array(
					  	'type' => 'theme_mod', // or 'option'
					  	'capability' => 'edit_theme_options',
					  	'theme_supports' => '', // Rarely needed.
					  	'default' => 'yes',
					  	'transport' => 'refresh', // or postMessage
					  	'sanitize_callback' => 'sanitize_text_field' // Get function name 	  
					) );
					
					$wp_customize->add_control('ovau_archive_show_host', array(
						'label' => esc_html__('Show Host','ovau'),
						'section' => 'ovau_archive_section',
						'settings' => 'ovau_archive_show_host',
						'type' =>'select',
						'choices' => array(
							'yes' => esc_html__('Yes', 'ovau'),
							'no'  => esc_html__('No', 'ovau'),
						)
					));

					$wp_customize->add_setting( 'ovau_archive_show_category', array(
					  	'type' => 'theme_mod', // or 'option'
					  	'capability' => 'edit_theme_options',
					  	'theme_supports' => '', // Rarely needed.
					  	'default' => 'yes',
					  	'transport' => 'refresh', // or postMessage
					  	'sanitize_callback' => 'sanitize_text_field' // Get function name 	  
					) );
					
					$wp_customize->add_control('ovau_archive_show_category', array(
						'label' => esc_html__('Show Category','ovau'),
						'section' => 'ovau_archive_section',
						'settings' => 'ovau_archive_show_category',
						'type' =>'select',
						'choices' => array(
							'yes' => esc_html__('Yes', 'ovau'),
							'no'  => esc_html__('No', 'ovau'),
						)
					));

					$wp_customize->add_setting( 'ovau_archive_show_episode', array(
					  	'type' => 'theme_mod', // or 'option'
					  	'capability' => 'edit_theme_options',
					  	'theme_supports' => '', // Rarely needed.
					  	'default' => 'yes',
					  	'transport' => 'refresh', // or postMessage
					  	'sanitize_callback' => 'sanitize_text_field' // Get function name 	  
					) );
					
					$wp_customize->add_control('ovau_archive_show_episode', array(
						'label' => esc_html__('Show Episode','ovau'),
						'section' => 'ovau_archive_section',
						'settings' => 'ovau_archive_show_episode',
						'type' =>'select',
						'choices' => array(
							'yes' => esc_html__('Yes', 'ovau'),
							'no'  => esc_html__('No', 'ovau'),
						)
					));

					$wp_customize->add_setting( 'ovau_archive_show_title', array(
					  	'type' => 'theme_mod', // or 'option'
					  	'capability' => 'edit_theme_options',
					  	'theme_supports' => '', // Rarely needed.
					  	'default' => 'yes',
					  	'transport' => 'refresh', // or postMessage
					  	'sanitize_callback' => 'sanitize_text_field' // Get function name 	  
					) );
					
					$wp_customize->add_control('ovau_archive_show_title', array(
						'label' => esc_html__('Show Title','ovau'),
						'section' => 'ovau_archive_section',
						'settings' => 'ovau_archive_show_title',
						'type' =>'select',
						'choices' => array(
							'yes' => esc_html__('Yes', 'ovau'),
							'no'  => esc_html__('No', 'ovau'),
						)
					));

					$wp_customize->add_setting( 'ovau_archive_show_text_button', array(
					  	'type' => 'theme_mod', // or 'option'
					  	'capability' => 'edit_theme_options',
					  	'theme_supports' => '', // Rarely needed.
					  	'default' => 'yes',
					  	'transport' => 'refresh', // or postMessage
					  	'sanitize_callback' => 'sanitize_text_field' // Get function name 	  
					) );
					
					$wp_customize->add_control('ovau_archive_show_text_button', array(
						'label' => esc_html__('Show Text Button','ovau'),
						'section' => 'ovau_archive_section',
						'settings' => 'ovau_archive_show_text_button',
						'type' =>'select',
						'choices' => array(
							'yes' => esc_html__('Yes', 'ovau'),
							'no'  => esc_html__('No', 'ovau'),
						)
					));

				// Single
				$wp_customize->add_section( 'ovau_single_section' , array(
				    'title'     => esc_html__( 'Single', 'ovau' ),
				    'priority'  => 2,
				    'panel' 	=> 'ovau_section',
				) );

					// Template
					$wp_customize->add_setting( 'ovau_single_audio_template', array(
					  'type' => 'theme_mod', // or 'option'
					  'capability' => 'edit_theme_options',
					  'theme_supports' => '', // Rarely needed.
					  'default' => 'template_1',
					  'transport' => 'refresh', // or postMessage
					  'sanitize_callback' => 'sanitize_text_field' // Get function name 
					) );

					$wp_customize->add_control('ovau_single_audio_template', array(
						'label' => esc_html__('Template','ovau'),
						'section' => 'ovau_single_section',
						'settings' => 'ovau_single_audio_template',
						'type' =>'select',
						'choices' => array(
							'template_1' => esc_html__( 'Template 1', 'ovau' ),
							'template_2' => esc_html__( 'Template 2', 'ovau' ),
						)
					));

					// Header Single Audio
					$wp_customize->add_setting( 'header_single_audio', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'default',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name 
					) );

					$wp_customize->add_control('header_single_audio', array(
						'label' 	=> esc_html__('Header Single','ovau'),
						'section' 	=> 'ovau_single_section',
						'settings' 	=> 'header_single_audio',
						'type' 		=>'select',
						'choices' 	=> apply_filters( 'podover_list_header', '' )
					));

					// Header Single Audio 2
					$wp_customize->add_setting( 'header_single_audio_2', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'default',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name 
					) );

					$wp_customize->add_control('header_single_audio_2', array(
						'label' 	=> esc_html__('Header Single 2','ovau'),
						'section' 	=> 'ovau_single_section',
						'settings' 	=> 'header_single_audio_2',
						'type' 		=>'select',
						'choices' 	=> apply_filters( 'podover_list_header', '' )
					));

					// Footer Single Audio
					$wp_customize->add_setting( 'footer_single_audio', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'default',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name 
					) );

					$wp_customize->add_control('footer_single_audio', array(
						'label' 	=> esc_html__('Footer Single','ovau'),
						'section' 	=> 'ovau_single_section',
						'settings' 	=> 'footer_single_audio',
						'type' 		=>'select',
						'choices' 	=> apply_filters('podover_list_footer', '')
					));

					// Footer Single Audio 2
					$wp_customize->add_setting( 'footer_single_audio_2', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'default',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name 
					) );

					$wp_customize->add_control('footer_single_audio_2', array(
						'label' 	=> esc_html__('Footer Single 2','ovau'),
						'section' 	=> 'ovau_single_section',
						'settings' 	=> 'footer_single_audio_2',
						'type' 		=>'select',
						'choices' 	=> apply_filters('podover_list_footer', '')
					));

					$wp_customize->add_setting( 'ovau_single_show_audio_section', array(
					  	'type' => 'theme_mod', // or 'option'
					  	'capability' => 'edit_theme_options',
					  	'theme_supports' => '', // Rarely needed.
					  	'default' => 'yes',
					  	'transport' => 'refresh', // or postMessage
					  	'sanitize_callback' => 'sanitize_text_field' // Get function name 	  
					) );

					$wp_customize->add_control('ovau_single_show_audio_section', array(
						'label' => esc_html__('Show Audio/Video Section','ovau'),
						'section' => 'ovau_single_section',
						'settings' => 'ovau_single_show_audio_section',
						'type' =>'select',
						'choices' => array(
							'yes' => esc_html__('Yes', 'ovau'),
							'no'  => esc_html__('No', 'ovau'),
						)
					));

					$wp_customize->add_setting( 'ovau_single_show_image', array(
					  	'type' => 'theme_mod', // or 'option'
					  	'capability' => 'edit_theme_options',
					  	'theme_supports' => '', // Rarely needed.
					  	'default' => 'yes',
					  	'transport' => 'refresh', // or postMessage
					  	'sanitize_callback' => 'sanitize_text_field' // Get function name 	  
					) );

					$wp_customize->add_control('ovau_single_show_image', array(
						'label' => esc_html__('Show Image','ovau'),
						'section' => 'ovau_single_section',
						'settings' => 'ovau_single_show_image',
						'type' =>'select',
						'choices' => array(
							'yes' => esc_html__('Yes', 'ovau'),
							'no'  => esc_html__('No', 'ovau'),
						),
						'active_callback' => array( $this, 'is_single_control_visible' ),
					));

					$wp_customize->add_setting( 'ovau_single_show_title', array(
					  	'type' => 'theme_mod', // or 'option'
					  	'capability' => 'edit_theme_options',
					  	'theme_supports' => '', // Rarely needed.
					  	'default' => 'yes',
					  	'transport' => 'refresh', // or postMessage
					  	'sanitize_callback' => 'sanitize_text_field' // Get function name 	  
					) );

					$wp_customize->add_control('ovau_single_show_title', array(
						'label' => esc_html__('Show Title','ovau'),
						'section' => 'ovau_single_section',
						'settings' => 'ovau_single_show_title',
						'type' =>'select',
						'choices' => array(
							'yes' => esc_html__('Yes', 'ovau'),
							'no'  => esc_html__('No', 'ovau'),
						)
					));

					$wp_customize->add_setting( 'ovau_single_show_host', array(
					  	'type' => 'theme_mod', // or 'option'
					  	'capability' => 'edit_theme_options',
					  	'theme_supports' => '', // Rarely needed.
					  	'default' => 'yes',
					  	'transport' => 'refresh', // or postMessage
					  	'sanitize_callback' => 'sanitize_text_field' // Get function name 	  
					) );

					$wp_customize->add_control('ovau_single_show_host', array(
						'label' => esc_html__('Show Host','ovau'),
						'section' => 'ovau_single_section',
						'settings' => 'ovau_single_show_host',
						'type' =>'select',
						'choices' => array(
							'yes' => esc_html__('Yes', 'ovau'),
							'no'  => esc_html__('No', 'ovau'),
						)
					));

					$wp_customize->add_setting( 'ovau_single_show_episode', array(
					  	'type' => 'theme_mod', // or 'option'
					  	'capability' => 'edit_theme_options',
					  	'theme_supports' => '', // Rarely needed.
					  	'default' => 'yes',
					  	'transport' => 'refresh', // or postMessage
					  	'sanitize_callback' => 'sanitize_text_field' // Get function name 	  
					) );

					$wp_customize->add_control('ovau_single_show_episode', array(
						'label' => esc_html__('Show Episode','ovau'),
						'section' => 'ovau_single_section',
						'settings' => 'ovau_single_show_episode',
						'type' =>'select',
						'choices' => array(
							'yes' => esc_html__('Yes', 'ovau'),
							'no'  => esc_html__('No', 'ovau'),
						)
					));

					$wp_customize->add_setting( 'ovau_single_show_duration', array(
					  	'type' => 'theme_mod', // or 'option'
					  	'capability' => 'edit_theme_options',
					  	'theme_supports' => '', // Rarely needed.
					  	'default' => 'yes',
					  	'transport' => 'refresh', // or postMessage
					  	'sanitize_callback' => 'sanitize_text_field' // Get function name 	  
					) );

					$wp_customize->add_control('ovau_single_show_duration', array(
						'label' => esc_html__('Show Duration','ovau'),
						'section' => 'ovau_single_section',
						'settings' => 'ovau_single_show_duration',
						'type' =>'select',
						'choices' => array(
							'yes' => esc_html__('Yes', 'ovau'),
							'no'  => esc_html__('No', 'ovau'),
						)
					));

					$wp_customize->add_setting( 'ovau_single_show_category', array(
					  	'type' => 'theme_mod', // or 'option'
					  	'capability' => 'edit_theme_options',
					  	'theme_supports' => '', // Rarely needed.
					  	'default' => 'yes',
					  	'transport' => 'refresh', // or postMessage
					  	'sanitize_callback' => 'sanitize_text_field' // Get function name 	  
					) );
					
					$wp_customize->add_control('ovau_single_show_category', array(
						'label' => esc_html__('Show Category','ovau'),
						'section' => 'ovau_single_section',
						'settings' => 'ovau_single_show_category',
						'type' =>'select',
						'choices' => array(
							'yes' => esc_html__('Yes', 'ovau'),
							'no'  => esc_html__('No', 'ovau'),
						),
						'active_callback' => array( $this, 'is_single_control_visible' ),
					));

					$wp_customize->add_setting( 'ovau_single_show_date', array(
					  	'type' => 'theme_mod', // or 'option'
					  	'capability' => 'edit_theme_options',
					  	'theme_supports' => '', // Rarely needed.
					  	'default' => 'yes',
					  	'transport' => 'refresh', // or postMessage
					  	'sanitize_callback' => 'sanitize_text_field' // Get function name 	  
					) );
					
					$wp_customize->add_control('ovau_single_show_date', array(
						'label' => esc_html__('Show Date','ovau'),
						'section' => 'ovau_single_section',
						'settings' => 'ovau_single_show_date',
						'type' =>'select',
						'choices' => array(
							'yes' => esc_html__('Yes', 'ovau'),
							'no'  => esc_html__('No', 'ovau'),
						),
						'active_callback' => array( $this, 'is_single_control_visible' ),
					));

					$wp_customize->add_setting( 'ovau_single_show_timeline', array(
					  	'type' => 'theme_mod', // or 'option'
					  	'capability' => 'edit_theme_options',
					  	'theme_supports' => '', // Rarely needed.
					  	'default' => 'yes',
					  	'transport' => 'refresh', // or postMessage
					  	'sanitize_callback' => 'sanitize_text_field' // Get function name 	  
					) );
					
					$wp_customize->add_control('ovau_single_show_timeline', array(
						'label' => esc_html__('Show Timeline','ovau'),
						'section' => 'ovau_single_section',
						'settings' => 'ovau_single_show_timeline',
						'type' =>'select',
						'choices' => array(
							'yes' => esc_html__('Yes', 'ovau'),
							'no'  => esc_html__('No', 'ovau'),
						)
					));

					$wp_customize->add_setting( 'ovau_single_show_donation', array(
					  	'type' => 'theme_mod', // or 'option'
					  	'capability' => 'edit_theme_options',
					  	'theme_supports' => '', // Rarely needed.
					  	'default' => 'yes',
					  	'transport' => 'refresh', // or postMessage
					  	'sanitize_callback' => 'sanitize_text_field' // Get function name 	  
					) );
					
					$wp_customize->add_control('ovau_single_show_donation', array(
						'label' => esc_html__('Show Donation','ovau'),
						'section' => 'ovau_single_section',
						'settings' => 'ovau_single_show_donation',
						'type' =>'select',
						'choices' => array(
							'yes' => esc_html__('Yes', 'ovau'),
							'no'  => esc_html__('No', 'ovau'),
						)
					));

					$wp_customize->add_setting( 'ovau_single_show_tag', array(
					  	'type' => 'theme_mod', // or 'option'
					  	'capability' => 'edit_theme_options',
					  	'theme_supports' => '', // Rarely needed.
					  	'default' => 'yes',
					  	'transport' => 'refresh', // or postMessage
					  	'sanitize_callback' => 'sanitize_text_field' // Get function name 	  
					) );
					
					$wp_customize->add_control('ovau_single_show_tag', array(
						'label' => esc_html__('Show Tag','ovau'),
						'section' => 'ovau_single_section',
						'settings' => 'ovau_single_show_tag',
						'type' =>'select',
						'choices' => array(
							'yes' => esc_html__('Yes', 'ovau'),
							'no'  => esc_html__('No', 'ovau'),
						),
						'active_callback' => array( $this, 'is_single_control_visible' ),
					));

					$wp_customize->add_setting( 'ovau_single_show_share', array(
					  	'type' => 'theme_mod', // or 'option'
					  	'capability' => 'edit_theme_options',
					  	'theme_supports' => '', // Rarely needed.
					  	'default' => 'yes',
					  	'transport' => 'refresh', // or postMessage
					  	'sanitize_callback' => 'sanitize_text_field' // Get function name 	  
					) );
					
					$wp_customize->add_control('ovau_single_show_share', array(
						'label' => esc_html__('Show Sharing','ovau'),
						'section' => 'ovau_single_section',
						'settings' => 'ovau_single_show_share',
						'type' =>'select',
						'choices' => array(
							'yes' => esc_html__('Yes', 'ovau'),
							'no'  => esc_html__('No', 'ovau'),
						)
					));

					$wp_customize->add_setting( 'ovau_single_show_comment', array(
					  	'type' => 'theme_mod', // or 'option'
					  	'capability' => 'edit_theme_options',
					  	'theme_supports' => '', // Rarely needed.
					  	'default' => 'yes',
					  	'transport' => 'refresh', // or postMessage
					  	'sanitize_callback' => 'sanitize_text_field' // Get function name 	  
					) );
					
					$wp_customize->add_control('ovau_single_show_comment', array(
						'label' => esc_html__('Show Comment','ovau'),
						'section' => 'ovau_single_section',
						'settings' => 'ovau_single_show_comment',
						'type' =>'select',
						'choices' => array(
							'yes' => esc_html__('Yes', 'ovau'),
							'no'  => esc_html__('No', 'ovau'),
						)
					));

			// Section Audio Host
		    $wp_customize->add_panel( 'ovau_host_section' , array(
				'title'      => esc_html__( 'Audio Host', 'ovau' ),
				'priority'   => 5
			) );

				// Archive
				$wp_customize->add_section( 'ovau_host_archive_section' , array(
				    'title'     => esc_html__( 'Archive', 'ovau' ),
				    'priority'  => 1,
				    'panel' 	=> 'ovau_host_section'
				) );
					
					// Post per page
					$wp_customize->add_setting( 'ovau_host_total_record', array(
						  'type' 				=> 'theme_mod', // or 'option'
						  'capability' 			=> 'edit_theme_options',
						  'theme_supports' 		=> '', // Rarely needed.
						  'default' 			=> '6',
						  'transport' 			=> 'refresh', // or postMessage
						  'sanitize_callback' 	=> 'sanitize_text_field' // Get function name 
						  
					) );
					
					$wp_customize->add_control('ovau_host_archive_section', array(
						'label' 	=> esc_html__('Number of posts per page','ovau'),
						'section' 	=> 'ovau_host_archive_section',
						'settings' 	=> 'ovau_host_total_record',
						'type' 		=> 'number'
					));

					$wp_customize->add_setting( 'ovau_host_archive_order', array(
					  'type' => 'theme_mod', // or 'option'
					  'capability' => 'edit_theme_options',
					  'theme_supports' => '', // Rarely needed.
					  'default' => 'DESC',
					  'transport' => 'refresh', // or postMessage
					  'sanitize_callback' => 'sanitize_text_field' // Get function name 
					  
					) );

					$wp_customize->add_control('ovau_host_archive_order', array(
						'label' => esc_html__('Order','ovau'),
						'section' => 'ovau_host_archive_section',
						'settings' => 'ovau_host_archive_order',
						'type' =>'select',
						'choices' => array(
							'ASC'  => esc_html__( 'Ascending', 'ovau' ),
							'DESC' => esc_html__( 'Descending', 'ovau' ),
						)
					));

					$wp_customize->add_setting( 'ovau_host_archive_orderby', array(
					  'type' => 'theme_mod', // or 'option'
					  'capability' => 'edit_theme_options',
					  'theme_supports' => '', // Rarely needed.
					  'default' => 'ovau_host_order',
					  'transport' => 'refresh', // or postMessage
					  'sanitize_callback' => 'sanitize_text_field' // Get function name 
					  
					) );

					$wp_customize->add_control('ovau_host_archive_orderby', array(
						'label' => esc_html__('Order By','ovau'),
						'section' => 'ovau_host_archive_section',
						'settings' => 'ovau_host_archive_orderby',
						'type' =>'select',
						'choices' => array(
							'id'  			=> esc_html__( 'ID', 'ovau' ),
							'title'			=> esc_html__( 'Title', 'ovau' ),
							'date' 			=> esc_html__( 'Date', 'ovau' ),
							'modified' 		=> esc_html__( 'Modified', 'ovau' ),
							'rand' 			=> esc_html__( 'Random', 'ovau' ),
							'ovau_host_order' => esc_html__( 'Sort Order', 'ovau' ),
						)
					));

					// Column Layout
					$wp_customize->add_setting( 'ovau_host_column_layout', array(
					  'type' => 'theme_mod', // or 'option'
					  'capability' => 'edit_theme_options',
					  'theme_supports' => '', // Rarely needed.
					  'default' => 'three_column',
					  'transport' => 'refresh', // or postMessage
					  'sanitize_callback' => 'sanitize_text_field' // Get function name 
					  
					) );

					$wp_customize->add_control('ovau_host_column_layout', array(
						'label' => esc_html__('Column','ovau'),
						'section' => 'ovau_host_archive_section',
						'settings' => 'ovau_host_column_layout',
						'type' =>'select',
						'choices' => array(
							'two_column'      => __( '2 column', 'ovau' ),
							'three_column' => __( '3 column', 'ovau' ),
							'four_column'      => __( '4 column', 'ovau' ),
						)
					));


					// Header Archive Audio Host
					$wp_customize->add_setting( 'header_archive_audio_host', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'default',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name 
					) );

					$wp_customize->add_control('header_archive_audio_host', array(
						'label' 	=> esc_html__('Header Archive','ovau'),
						'section' 	=> 'ovau_host_archive_section',
						'settings' 	=> 'header_archive_audio_host',
						'type' 		=>'select',
						'choices' 	=> apply_filters( 'podover_list_header', '' )
					));

					// Footer Archive Audio Host
					$wp_customize->add_setting( 'footer_archive_audio_host', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'default',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name 
					) );

					$wp_customize->add_control('footer_archive_audio_host', array(
						'label' 	=> esc_html__('Footer Archive','ovau'),
						'section' 	=> 'ovau_host_archive_section',
						'settings' 	=> 'footer_archive_audio_host',
						'type' 		=>'select',
						'choices' 	=> apply_filters('podover_list_footer', '')
					));

				// Single
				$wp_customize->add_section( 'ovau_host_single_section' , array(
				    'title'     => esc_html__( 'Single', 'ovau' ),
				    'priority'  => 2,
				    'panel' 	=> 'ovau_host_section',
				) );

				    // Number my audio per page
					$wp_customize->add_setting( 'ovau_host_audio_total_record', array(
						  'type' 				=> 'theme_mod', // or 'option'
						  'capability' 			=> 'edit_theme_options',
						  'theme_supports' 		=> '', // Rarely needed.
						  'default' 			=> '3',
						  'transport' 			=> 'refresh', // or postMessage
						  'sanitize_callback' 	=> 'sanitize_text_field' // Get function name 
						  
					) );
					
					$wp_customize->add_control('ovau_host_single_section', array(
						'label' 	=> esc_html__('Number of my podcasts','ovau'),
						'section' 	=> 'ovau_host_single_section',
						'settings' 	=> 'ovau_host_audio_total_record',
						'type' 		=> 'number'
					));


					// Sub title 
					$wp_customize->add_setting( 'ovau_host_audio_sub_title', array(
						  'type' 				=> 'theme_mod', // or 'option'
						  'capability' 			=> 'edit_theme_options',
						  'theme_supports' 		=> '', // Rarely needed.
						  'default' 			=> 'Enjoy New Shows',
						  'transport' 			=> 'refresh', // or postMessage
						  'sanitize_callback' 	=> 'sanitize_text_field' // Get function name 
						  
					) );
					
					$wp_customize->add_control('ovau_host_audio_sub_title', array(
						'label' 	=> esc_html__('Sub Title','ovau'),
						'section' 	=> 'ovau_host_single_section',
						'settings' 	=> 'ovau_host_audio_sub_title',
						'type' 		=> 'text'
					));

					// Title 
					$wp_customize->add_setting( 'ovau_host_audio_title', array(
						  'type' 				=> 'theme_mod', // or 'option'
						  'capability' 			=> 'edit_theme_options',
						  'theme_supports' 		=> '', // Rarely needed.
						  'default' 			=> 'My podcasts',
						  'transport' 			=> 'refresh', // or postMessage
						  'sanitize_callback' 	=> 'sanitize_text_field' // Get function name 
						  
					) );
					
					$wp_customize->add_control('ovau_host_audio_title', array(
						'label' 	=> esc_html__('Title','ovau'),
						'section' 	=> 'ovau_host_single_section',
						'settings' 	=> 'ovau_host_audio_title',
						'type' 		=> 'text'
					));

					// Text Button 
					$wp_customize->add_setting( 'ovau_host_audio_text_button', array(
						  'type' 				=> 'theme_mod', // or 'option'
						  'capability' 			=> 'edit_theme_options',
						  'theme_supports' 		=> '', // Rarely needed.
						  'default' 			=> 'View all My Podcasts',
						  'transport' 			=> 'refresh', // or postMessage
						  'sanitize_callback' 	=> 'sanitize_text_field' // Get function name 
						  
					) );
					
					$wp_customize->add_control('ovau_host_audio_text_button', array(
						'label' 	=> esc_html__('Text Button','ovau'),
						'section' 	=> 'ovau_host_single_section',
						'settings' 	=> 'ovau_host_audio_text_button',
						'type' 		=> 'text'
					));


					// Column Layout My Podcasts
					$wp_customize->add_setting( 'ovau_host_audio_column_layout', array(
					  'type' => 'theme_mod', // or 'option'
					  'capability' => 'edit_theme_options',
					  'theme_supports' => '', // Rarely needed.
					  'default' => 'three_column',
					  'transport' => 'refresh', // or postMessage
					  'sanitize_callback' => 'sanitize_text_field' // Get function name 
					  
					) );

					$wp_customize->add_control('ovau_host_audio_column_layout', array(
						'label' => esc_html__('Layout of my podcasts','ovau'),
						'section' => 'ovau_host_single_section',
						'settings' => 'ovau_host_audio_column_layout',
						'type' =>'select',
						'choices' => array(
							'two_column'      => __( '2 column', 'ovau' ),
							'three_column' => __( '3 column', 'ovau' ),
						)
					));
                    
                    // Show button view all My Podcasts
					$wp_customize->add_setting( 'ovau_host_audio_single_show_button', array(
					  'type' => 'theme_mod', // or 'option'
					  'capability' => 'edit_theme_options',
					  'theme_supports' => '', // Rarely needed.
					  'default' => 'yes',
					  'transport' => 'refresh', // or postMessage
					  'sanitize_callback' => 'sanitize_text_field' // Get function name 
					  
					) );
					
					$wp_customize->add_control('ovau_host_audio_single_show_button', array(
						'label' => esc_html__('Show Button','ovau'),
						'section' => 'ovau_host_single_section',
						'settings' => 'ovau_host_audio_single_show_button',
						'type' =>'select',
						'choices' => array(
							'yes' => esc_html__('Yes', 'ovau'),
							'no'  => esc_html__('No', 'ovau'),
						)
					));

					// Header Single Audio Host
					$wp_customize->add_setting( 'header_single_audio_host', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'default',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name 
					) );

					$wp_customize->add_control('header_single_audio_host', array(
						'label' 	=> esc_html__('Header Single','ovau'),
						'section' 	=> 'ovau_host_single_section',
						'settings' 	=> 'header_single_audio_host',
						'type' 		=>'select',
						'choices' 	=> apply_filters( 'podover_list_header', '' )
					));

					// Footer Single Audio Host
					$wp_customize->add_setting( 'footer_single_audio_host', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'default',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name 
					) );

					$wp_customize->add_control('footer_single_audio_host', array(
						'label' 	=> esc_html__('Footer Single','ovau'),
						'section' 	=> 'ovau_host_single_section',
						'settings' 	=> 'footer_single_audio_host',
						'type' 		=>'select',
						'choices' 	=> apply_filters('podover_list_footer', '')
					));

					// Add more customize
		}

		// Define the callback function
		public function is_single_control_visible() {
		    return get_theme_mod( 'ovau_single_audio_template', 'template_1' ) === 'template_2';
		}

	}

	new Ovau_Customize();
}