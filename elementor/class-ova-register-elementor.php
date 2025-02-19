<?php
/**
 * Elementor Integration for Ova Audio
 *
 * @package    OVA Audio
 * @author     Original: Ovatheme
 * @author     Modified: Arnel Go
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @copyright  Modifications Copyright (C) 2025 Arnel Go
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/wikiwyrhead/
 * 
 * Enhanced version with improved Elementor integration:
 * - Added singleton pattern
 * - Improved script loading
 * - Better error handling
 * - Enhanced resource management
 */

if (!defined('ABSPATH')) exit;

class Ova_Audio_Register_Elementor {

    private static $instance = null;
    private $scripts_loaded = false;

    public function __construct() {
        $this->init_hooks();
    }

    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function init_hooks() {
        // Register category
        add_action('elementor/elements/categories_registered', array($this, 'ovau_add_category'));
        
        // Register scripts
        add_action('elementor/frontend/before_enqueue_scripts', array($this, 'ovau_register_frontend_scripts'));
        
        // Register widgets
        add_action('elementor/widgets/register', array($this, 'ovau_include_widgets'));
    }

    public function ovau_add_category() {
        \Elementor\Plugin::instance()->elements_manager->add_category(
            'ova-audio',
            [
                'title' => esc_html__('Ova Audio', 'ovau'),
                'icon' => 'eicon-media-carousel',
            ]
        );
    }

    public function ovau_register_frontend_scripts() {
        if ($this->scripts_loaded) {
            return;
        }

        // Register main frontend script
        wp_register_script(
            'ovau-elementor-frontend',
            OVAU_PLUGIN_URL . 'assets/js/elementor/frontend.js',
            ['jquery', 'elementor-frontend'],
            OVAU_VERSION,
            true
        );
        wp_enqueue_script('ovau-elementor-frontend');

        // Register widget scripts
        $this->register_widget_scripts();

        // Add initialization data
        wp_localize_script('ovau-elementor-frontend', 'ovauElementorConfig', array(
            'isEditMode' => \Elementor\Plugin::$instance->editor->is_edit_mode(),
            'ajaxurl' => admin_url('admin-ajax.php')
        ));

        $this->scripts_loaded = true;
    }

    private function register_widget_scripts() {
        $files = glob(OVAU_PLUGIN_PATH . 'assets/js/elementor/*.js');
        
        if (!is_array($files)) {
            return;
        }

        foreach ($files as $file) {
            $file_name = wp_basename($file);
            if ($file_name === 'frontend.js') {
                continue;
            }

            $handle = 'ovau-elementor-' . str_replace('.js', '', $file_name);
            $src = OVAU_PLUGIN_URL . 'assets/js/elementor/' . $file_name;

            if (file_exists($file)) {
                wp_register_script(
                    $handle,
                    $src,
                    ['jquery', 'elementor-frontend', 'ovau-elementor-frontend'],
                    OVAU_VERSION,
                    true
                );
                wp_enqueue_script($handle);
            }
        }
    }

    public function ovau_include_widgets($widgets_manager) {
        $widget_files = glob(OVAU_PLUGIN_PATH . 'elementor/widgets/*.php');
        
        if (!is_array($widget_files)) {
            return;
        }

        foreach ($widget_files as $file) {
            $file_path = OVAU_PLUGIN_PATH . 'elementor/widgets/' . wp_basename($file);
            if (file_exists($file_path)) {
                require_once $file_path;
            }
        }
    }
}

// Initialize the Elementor integration
Ova_Audio_Register_Elementor::instance();