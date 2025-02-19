<?php
/*
Plugin Name: Ova Audio
Plugin URI: https://ovatheme.com
Description: Ova Audio
Version: 1.0.7
Author: ovatheme
Author URI: https://ovatheme.com
Text Domain: ovau
License: GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( !defined( 'ABSPATH' ) ) exit();

if ( !class_exists('OVA_Audio') ) {
    
    class OVA_Audio {

        function __construct() {
            $this -> define_constants();
            $this -> includes();
            $this -> supports();
        }

        function define_constants() {

            if ( !defined( 'OVAU_PLUGIN_FILE' ) ) {
                define( 'OVAU_PLUGIN_FILE', __FILE__ );   
            }

            if ( !defined( 'OVAU_PLUGIN_URL' ) ) {
                define( 'OVAU_PLUGIN_URL', plugin_dir_url( __FILE__ ) );   
            }

            if ( !defined( 'OVAU_PLUGIN_PATH' ) ) {
                define( 'OVAU_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );   
            }
            
            load_plugin_textdomain( 'ovau', false, basename( dirname( __FILE__ ) ) .'/languages' );
        }

        function includes() {

            require_once( OVAU_PLUGIN_PATH.'inc/class-ova-custom-post-type.php' );

            require_once( OVAU_PLUGIN_PATH.'inc/class-ova-get-data.php' );

            require_once( OVAU_PLUGIN_PATH.'inc/ova-core-functions.php' );

            require_once( OVAU_PLUGIN_PATH.'inc/class-ova-templates-loaders.php' );

            require_once( OVAU_PLUGIN_PATH.'inc/class-ova-assets.php' );

            require_once( OVAU_PLUGIN_PATH.'shortcodes/shortcodes.php' );
            
            // ajax
            require_once( OVAU_PLUGIN_PATH.'inc/class-ajax.php' );

            // admin
            require_once( OVAU_PLUGIN_PATH.'admin/class-ova-metabox.php' );

            /* Customize */
            require_once OVAU_PLUGIN_PATH.'/inc/class-customize.php';
        }

        function supports() {

            /* Make Elementors */
            if ( did_action( 'elementor/loaded' ) ) {
                require_once OVAU_PLUGIN_PATH.'elementor/class-ova-register-elementor.php';
            }
        }

    }
}


return new OVA_Audio();
