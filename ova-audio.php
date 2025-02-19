<?php
/*
Plugin Name: Wiki Ova Audio
Plugin URI: https://github.com/wikiwyrhead/wiki-ova-audio
Description: Enhanced version of Ova Audio with improved Elementor integration and robust error handling
Version: 1.0.9
Original Author: ovatheme
Original Plugin URI: https://ovatheme.com
Author: Arnel Go
Author URI: https://arnelgo.info/
Text Domain: ovau
License: GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
Elementor tested up to: 3.28.0
Elementor Pro tested up to: 3.28.0
*/

/**
 * Enhanced version of Ova Audio plugin with improved Elementor integration
 * 
 * Original Plugin by ovatheme (https://ovatheme.com)
 * Enhanced and Modified by Arnel Go (https://arnelgo.info/)
 * 
 * Modifications include:
 * - Improved Elementor integration
 * - Enhanced error handling
 * - Better resource management
 * - Improved code organization
 * - Added singleton patterns
 */

if ( !defined( 'ABSPATH' ) ) exit();

if ( !class_exists('OVA_Audio') ) {
    
    class OVA_Audio {
        
        private static $instance = null;

        public function __construct() {
            $this->define_constants();
            $this->includes();
            $this->supports();
        }

        public static function instance() {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        private function define_constants() {
            if (!defined('OVAU_VERSION')) {
                define('OVAU_VERSION', '1.0.9');
            }

            if (!defined('OVAU_PLUGIN_FILE')) {
                define('OVAU_PLUGIN_FILE', __FILE__);
            }

            if (!defined('OVAU_PLUGIN_URL')) {
                define('OVAU_PLUGIN_URL', plugin_dir_url(__FILE__));
            }

            if (!defined('OVAU_PLUGIN_PATH')) {
                define('OVAU_PLUGIN_PATH', plugin_dir_path(__FILE__));
            }
            
            load_plugin_textdomain('ovau', false, basename(dirname(__FILE__)) . '/languages');
        }

        private function includes() {
            $core_files = array(
                'inc/class-ova-custom-post-type.php',
                'inc/class-ova-get-data.php',
                'inc/ova-core-functions.php',
                'inc/class-ova-templates-loaders.php',
                'inc/class-ova-assets.php',
                'shortcodes/shortcodes.php',
                'inc/class-ajax.php',
                'admin/class-ova-metabox.php',
                'inc/class-customize.php'
            );

            foreach ($core_files as $file) {
                $file_path = OVAU_PLUGIN_PATH . $file;
                if (file_exists($file_path)) {
                    require_once $file_path;
                }
            }
        }

        private function supports() {
            if (did_action('elementor/loaded')) {
                $elementor_file = OVAU_PLUGIN_PATH . 'elementor/class-ova-register-elementor.php';
                if (file_exists($elementor_file)) {
                    require_once $elementor_file;
                }
            }
        }

        public function get_version() {
            return OVAU_VERSION;
        }
    }
}

// Initialize the plugin
function ovau_init() {
    return OVA_Audio::instance();
}

// Start the plugin
ovau_init();
