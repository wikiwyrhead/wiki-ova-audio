<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

// init shortcode [ova_audio]
add_shortcode( 'ova_audio', 'audio_button_shortcode' );
if ( !function_exists( 'audio_button_shortcode' ) ) {
	function audio_button_shortcode( $atts ) {
	    extract(shortcode_atts(array(
	        'title' 		=> esc_html__( 'Title Audio', 'ovau' ),
	        'button_title' 	=> esc_html__( 'Play', 'ovau' ),
	        'src' 			=> 'https://c1-ex-swe.nixcdn.com/NhacCuaTui1024/YeuKhongCanEp-BaoAnh-7122895.mp3',
	    ), $atts));

	    $args = array(
        	'title' 		=> $title,
        	'button_title' 	=> $button_title,
        	'src' 			=> $src
    	);

	    ob_start();

	    $template_file = ovau_locate_template( 'shortcode/ova_audio.php' );
	    if ( ! file_exists( $template_file ) ){
	        esc_html_e( 'Please check surely you made template file for search form in plugin or theme', 'ovau' );
	        
	    }else{
	        ovau_get_template( 'shortcode/ova_audio.php', $args );
	    }

	    return ob_get_clean();
	}
}