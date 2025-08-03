<?php
/**
 * Plugin Name: Job Automator Pro
 * Plugin URI: https://your-website.com/job-automator-pro
 * Description: Professional job post automation with company management, templates, and custom fields.
 * Version: 2.0.0
 * Author: Your Name
 * License: GPL v2 or later
 * Text Domain: job-automator-pro
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
if (!defined('JAP_PLUGIN_URL')) {
    define('JAP_PLUGIN_URL', plugin_dir_url(__FILE__));
}
if (!defined('JAP_PLUGIN_PATH')) {
    define('JAP_PLUGIN_PATH', plugin_dir_path(__FILE__));
}
if (!defined('JAP_VERSION')) {
    define('JAP_VERSION', '2.0.0');
}

// Main plugin class
class JobAutomatorPro {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        add_action('plugins_loaded', array($this, 'init'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }
    
    public function init() {
        try {
            // Load text domain
            load_plugin_textdomain('job-automator-pro', false, dirname(plugin_basename(__FILE__)) . '/languages');
            
            // Initialize admin interface
            if (is_admin()) {
                add_action('admin_menu', array($this, 'add_admin_menu'));
                add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
            }
            
        } catch (Exception $e) {
            add_action('admin_notices', function() use ($e) {
                echo '<div class="notice notice-error"><p>Job Automator Pro Error: ' . esc_html($e->getMessage()) . '</p></div>';
            });
        }
    }
    
    public function add_admin_menu() {
        add_menu_page(
            'Job Automator Pro',
            'Job Automator Pro',
            'manage_options',
            'job-automator-pro',
            array($this, 'dashboard_page'),
            'dashicons-businessman',
            30
        );
        
        add_submenu_page(
            'job-automator-pro',
            'Dashboard',
            'Dashboard',
            'manage_options',
            'job-automator-pro',
            array($this, 'dashboard_page')
        );
        
        add_submenu_page(
            'job-automator-pro',
            'Companies',
            'Companies',
            'manage_options',
            'jap-companies',
            array($this, 'companies_page')
        );
        
        add_submenu_page(
            'job-automator-pro',
            'Templates',
            'Templates',
            'manage_options',
            'jap-templates',
            array($this, 'templates_page')
        );
        
        add_submenu_page(
            'job-automator-pro',
            'Custom Fields',
            'Custom Fields',
            'manage_options',
            'jap-fields',
            array($this, 'fields_page')
        );
        
        add_submenu_page(
            'job-automator-pro',
            'Categories',
            'Categories',
            'manage_options',
            'jap-categories',
            array($this, 'categories_page')
        );
        
        add_submenu_page(
            'job-automator-pro',
            'Settings',
            'Settings',
            'manage_options',
            'jap-settings',
            array($this, 'settings_page')
        );
    }
    
    public function enqueue_scripts($hook) {
        if (strpos($hook, 'job-automator-pro') === false && strpos($hook, 'jap-') === false) {
            return;
        }
        
        $css_file = JAP_PLUGIN_URL . 'assets/css/admin.css';
        $js_file = JAP_PLUGIN_URL . 'assets/js/admin.js';
        
        if (file_exists(JAP_PLUGIN_PATH . 'assets/css/admin.css')) {
            wp_enqueue_style('jap-admin-css', $css_file, array(), JAP_VERSION);
        }
        
        if (file_exists(JAP_PLUGIN_PATH . 'assets/js/admin.js')) {
            wp_enqueue_script('jap-admin-js', $js_file, array('jquery'), JAP_VERSION, true);
            
            wp_localize_script('jap-admin-js', 'jap_ajax', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('jap_nonce'),
                'strings' => array(
                    'confirm_delete' => __('Are you sure you want to delete this item?', 'job-automator-pro'),
                    'loading' => __('Loading...', 'job-automator-pro'),
                    'error' => __('An error occurred. Please try again.', 'job-automator-pro'),
                    'success' => __('Operation completed successfully.', 'job-automator-pro')
                )
            ));
        }
    }
    
    public function dashboard_page() {
        $template_file = JAP_PLUGIN_PATH . 'templates/dashboard.php';
        
        if (file_exists($template_file)) {
            // Include necessary classes for stats if available
            $this->safe_include('includes/class-database.php');
            
            if (class_exists('JAP_Database')) {
                $stats = JAP_Database::get_stats();
            } else {
                $stats = array(
                    'companies' => 0,
                    'templates' => 0,
                    'fields' => 0,
                    'categories' => 0
                );
            }
            
            include $template_file;
        } else {
            $this->fallback_dashboard();
        }
    }
    
    public function companies_page() {
        $template_file = JAP_PLUGIN_PATH . 'templates/companies-list.php';
        
        if (file_exists($template_file)) {
            include $template_file;
        } else {
            echo '<div class="wrap"><h1>Companies Management</h1><p>Coming Soon</p></div>';
        }
    }
    
    public function templates_page() {
        $template_file = JAP_PLUGIN_PATH . 'templates/templates-list.php';
        
        if (file_exists($template_file)) {
            include $template_file;
        } else {
            echo '<div class="wrap"><h1>Templates Management</h1><p>Coming Soon</p></div>';
        }
    }
    
    public function fields_page() {
        $template_file = JAP_PLUGIN_PATH . 'templates/fields-list.php';
        
        if (file_exists($template_file)) {
            include $template_file;
        } else {
            echo '<div class="wrap"><h1>Custom Fields Management</h1><p>Coming Soon</p></div>';
        }
    }
    
    public function categories_page() {
        $template_file = JAP_PLUGIN_PATH . 'templates/categories.php';
        
        if (file_exists($template_file)) {
            include $template_file;
        } else {
            echo '<div class="wrap"><h1>Categories Management</h1><p>Coming Soon</p></div>';
        }
    }
    
    public function settings_page() {
        $template_file = JAP_PLUGIN_PATH . 'templates/settings.php';
        
        if (file_exists($template_file)) {
            include $template_file;
        } else {
            echo '<div class="wrap"><h1>Plugin Settings</h1><p>Coming Soon</p></div>';
        }
    }
    
    private function safe_include($file) {
        $filepath = JAP_PLUGIN_PATH . $file;
        if (file_exists($filepath)) {
            include_once $filepath;
        }
    }
    
    private function fallback_dashboard() {
        ?>
        <div class="wrap">
            <h1>Job Automator Pro Dashboard</h1>
            <div class="notice notice-info">
                <p>Welcome to Job Automator Pro! The plugin has been activated successfully.</p>
            </div>
            <div class="card">
                <h2>Quick Start</h2>
                <p>Use the menu items on the left to manage:</p>
                <ul>
                    <li>Companies</li>
                    <li>Templates</li>
                    <li>Custom Fields</li>
                    <li>Categories</li>
                    <li>Settings</li>
                </ul>
            </div>
        </div>
        <?php
    }
    
    public function activate() {
        try {
            // Simple activation - create database tables if class exists
            $this->safe_include('includes/class-database.php');
            
            if (class_exists('JAP_Database')) {
                JAP_Database::create_tables();
                JAP_Database::insert_default_data();
            }
            
            // Set activation flags
            update_option('jap_plugin_activated', true);
            update_option('jap_plugin_version', JAP_VERSION);
            
        } catch (Exception $e) {
            // Log error but don't die
            error_log('Job Automator Pro activation error: ' . $e->getMessage());
            
            // Set minimal activation
            update_option('jap_plugin_activated', true);
            update_option('jap_plugin_version', JAP_VERSION);
        }
    }
    
    public function deactivate() {
        delete_option('jap_plugin_activated');
    }
}

// Initialize the plugin safely
if (!function_exists('jap_init')) {
    function jap_init() {
        return JobAutomatorPro::get_instance();
    }
}

// Start the plugin
jap_init();