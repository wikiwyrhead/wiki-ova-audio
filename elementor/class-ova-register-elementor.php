<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Ova_Audio_Register_Elementor {

	function __construct() {
            
		// Register Header Footer Category in Pane
	    add_action( 'elementor/elements/categories_registered', array( $this, 'ovau_add_category' ) );

	    add_action( 'elementor/frontend/after_register_scripts', array( $this, 'ovau_enqueue_scripts' ) );
		
		add_action( 'elementor/widgets/register', array( $this, 'ovau_include_widgets' ) );
	}

	function ovau_add_category( ) {
	   	\Elementor\Plugin::instance()->elements_manager->add_category(
	        'ova-audio',
	        [
	            'title' => esc_html__( 'Ova Audio', 'ovau' ),
	            'icon' => 'eicon-media-carousel',
	        ]
	    );
	}

	function ovau_enqueue_scripts() {
        $files = glob( OVAU_PLUGIN_PATH . 'assets/js/elementor/*.js' );
      
        foreach ($files as $file) {
            $file_name = wp_basename($file);
            $handle    = str_replace(".js", '', $file_name);
            $src       = OVAU_PLUGIN_URL . 'assets/js/elementor/' . $file_name;
            if (file_exists($file)) {
                wp_register_script( 'ovau-elementor-' . $handle, $src, [ 'elementor-frontend' ], '1.0.0', true );
            }
        }
	}

	function ovau_include_widgets( $widgets_manager ) {
        $files = glob( OVAU_PLUGIN_PATH . 'elementor/widgets/*.php' );

        foreach ($files as $file) {
            $file = OVAU_PLUGIN_PATH . 'elementor/widgets/' .wp_basename($file);
            if (file_exists($file)) {
                require_once $file;
            }
        }
    }
}

new Ova_Audio_Register_Elementor();