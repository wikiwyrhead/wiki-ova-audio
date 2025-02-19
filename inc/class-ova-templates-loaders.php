<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

class OVAU_templates_loader {
	
	/**
	 * The Constructor
	 */
	public function __construct() {
		add_filter( 'template_include', array( $this, 'template_loader' ) );
	}

	public function template_loader( $template ) {

		$post_type = isset($_REQUEST['post_type'] ) ? esc_html( $_REQUEST['post_type'] ) : get_post_type();

		$single_audio_template = get_theme_mod( 'ovau_single_audio_template', 'template_1' );
		$single_template       = get_post_meta( get_the_ID(), 'ovau_single_template', true );

	    if ( $single_template != '' ) {
	        $single_audio_template = $single_template;
	    }
	    if (isset($_GET['single_audio_template'])) {
	        $single_audio_template = $_GET['single_audio_template'];
	    }

	    // get option show in Customize -> Audio -> Single
		$args_show = array(
			'show_audio_section' => get_theme_mod( 'ovau_single_show_audio_section', 'yes' ),
			'show_title' 	  	 => get_theme_mod( 'ovau_single_show_title', 'yes' ),
			'show_host' 	  	 => get_theme_mod( 'ovau_single_show_host', 'yes' ),
			'show_episode' 	  	 => get_theme_mod( 'ovau_single_show_episode', 'yes' ),
			'show_duration'  	 => get_theme_mod( 'ovau_single_show_duration', 'yes' ),
			'show_timeline'   	 => get_theme_mod( 'ovau_single_show_timeline', 'yes' ),
			'show_donation'   	 => get_theme_mod( 'ovau_single_show_donation', 'yes' ),
			'show_sharing'    	 => get_theme_mod( 'ovau_single_show_share', 'yes' ),
			'show_comment'    	 => get_theme_mod( 'ovau_single_show_comment', 'yes' ),
		);

		if ( $single_audio_template == 'template_2' ) { // template 2
			$args_show['show_image']    = get_theme_mod( 'ovau_single_show_image', 'yes' );
			$args_show['show_category'] = get_theme_mod( 'ovau_single_show_category', 'yes' );
			$args_show['show_date']     = get_theme_mod( 'ovau_single_show_date', 'yes' );
			$args_show['show_tag']      = get_theme_mod( 'ovau_single_show_tag', 'yes' );
		}

		if ( is_tax( 'category_audio' ) ||  get_query_var( 'category_audio' ) != '' ) {

			ovau_get_template( 'archive-audio.php' );

			return false;
		}

		if ( is_tax( 'season_audio' ) || get_query_var( 'season_audio' ) != '' ) {
			
			ovau_get_template( 'archive-audio.php' );

			return false;
		}

		if ( is_tax( 'tag_audio' ) || get_query_var( 'tag_audio' ) != '' ) {
			
			ovau_get_template( 'archive-audio.php' );

			return false;
		}

		// Is Audio Post Type
		if (  $post_type == 'ova_audio' ) {

			if ( is_post_type_archive( 'ova_audio' ) ) {
				ovau_get_template( 'archive-audio.php' );
				return false;
			} elseif ( is_single() ) {
				if ( $single_audio_template == 'template_2' ) {
					ovau_get_template( 'single-audio-2.php', $args_show );
				} else {
					ovau_get_template( 'single-audio.php', $args_show );
				}
				return false;
			}
		}

		// Is Audio Host Post Type
		if (  $post_type == 'ova_audio_host' ) {

			if ( is_post_type_archive( 'ova_audio_host' ) ) {
				ovau_get_template( 'archive-audio-host.php' );
				return false;
			} elseif ( is_single() ) {
				ovau_get_template( 'single-audio-host.php' );
				return false;
			}
		}

		if ( $post_type !== 'ova_audio' || $post_type !== 'ova_audio_host' ){
			return $template;
		}
	}
}

new OVAU_templates_loader();
