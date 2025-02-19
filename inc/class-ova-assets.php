<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

if ( !class_exists( 'OVAU_assets' ) ) {

	class OVAU_assets{

		public function __construct(){
            add_action('admin_enqueue_scripts', array( $this, 'ovau_admin_enqueue_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'ovau_enqueue_scripts' ), 10, 0 );
			add_action('wp_footer', array( $this, 'display_player') );
		}

        public function ovau_admin_enqueue_scripts() {
            // Admin js
            wp_enqueue_script( 'ovau_admin_script', OVAU_PLUGIN_URL.'assets/js/admin/admin_script.js', array('jquery'), false, true );
        }

		public function ovau_enqueue_scripts() {
			wp_deregister_script( 'mediaelement-core' );
            wp_deregister_script( 'mediaelement' );
            wp_deregister_script( 'wp-mediaelement' );
            wp_deregister_script( 'mediaelement-migrate' );

            wp_deregister_style( 'wp-mediaelement' );
            wp_deregister_style( 'mediaelement' );


            wp_enqueue_script( 'ova-player', OVAU_PLUGIN_URL . 'assets/js/frontend/mediaelement-and-player.js', array( 'jquery' ), null, true );
            wp_enqueue_script( 'ova-player-skip-back', OVAU_PLUGIN_URL . 'assets/js/frontend/mediaelement-skip-back.js', array( 'jquery'), null, true );
            wp_enqueue_script( 'ova-player-jump-forward', OVAU_PLUGIN_URL . 'assets/js/frontend/mediaelement-jump-forward.js', array( 'jquery'), null, true );
            wp_enqueue_script( 'ova-player-speed', OVAU_PLUGIN_URL . 'assets/js/frontend/mediaelement-speed.js', array( 'jquery'), null, true );

            wp_enqueue_style('ova-audio', OVAU_PLUGIN_URL . 'assets/css/style.css', array('dashicons'), false, 'all');
            wp_enqueue_script('ova-audio', OVAU_PLUGIN_URL . 'assets/js/frontend/site.js', array('jquery'), null, true);

            /* Add JS */
            $params  = array(
                'ajax_url'      => admin_url('admin-ajax.php'), 
                'ajax_nonce'    => wp_create_nonce( apply_filters( 'ovau_ajax_security', 'ajax_ovau_plugin' ) )
            );
            wp_localize_script( 'ova-audio', 'ovau_ajax_object', $params );

            $inline_styles = $this->get_inline_styles();

            if ( !empty( $inline_styles ) ) {
                wp_add_inline_style( 'ova-audio', $inline_styles );
            }			
		}

		public function display_player() {
            include_once ovau_locate_template( 'shortcode/player.php' );
            include_once ovau_locate_template( 'shortcode/video.php' );
        }

		public function get_inline_styles() {
            $background = '#000';
            $controls   = '#FFF';

            $styles = '.ova-player-wrapper-bg, .ovamejs-volume-total {
                background-color: ' . $background . ';
            }';

            $styles .= '.meks-ova-player-wrapper, .ova-player-wrapper a, .ovamejs-button>button {
                color: ' . $controls . ';
            }';

            $styles .= '.ovamejs-volume-button>.ovamejs-volume-slider,.mejs__speed-selector, .ovamejs-speed-selector, .ovamejs-playpause-button {
                background-color: '. $controls .';
            }';

            $styles .= '.ovamejs-volume-button:hover > button:before,.mejs__speed-selector,.ovamejs-speed-selector, .ovamejs-speed-button:hover button, .ovamejs-playpause-button button{
                    color: '. $background .';
            }';

            $styles .= '.ovamejs-time-current, .ovamejs-time-handle-content{
                    background-color: '. $controls .';
            }';

            $styles .= '.ovamejs-time-handle-content{
                border-color: '. $controls .';
        	}';

            $styles .= ':root{
            	--player-original-bg-color: ' . $background . ';
        	}';

            return $styles;
        }

	}

	new OVAU_assets();
}
