<?php
/**
 * Plugin Name: Job Automator Pro Debug
 * Plugin URI: https://your-website.com/job-automator-pro
 * Description: Debug version - Professional job post automation with company management, templates, and custom fields.
 * Version: 2.0.0-debug
 * Author: Your Name
 * License: GPL v2 or later
 * Text Domain: job-automator-pro-debug
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('JAP_DEBUG_PLUGIN_URL', plugin_dir_url(__FILE__));
define('JAP_DEBUG_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('JAP_DEBUG_VERSION', '2.0.0-debug');

// Simple test class
class JobAutomatorProDebug {
    
    public function __construct() {
        add_action('plugins_loaded', array($this, 'init'));
        register_activation_hook(__FILE__, array($this, 'activate'));
    }
    
    public function init() {
        add_action('admin_menu', array($this, 'add_menu'));
        add_action('admin_notices', array($this, 'debug_notice'));
    }
    
    public function add_menu() {
        add_menu_page(
            'JAP Debug',
            'JAP Debug',
            'manage_options',
            'jap-debug',
            array($this, 'debug_page'),
            'dashicons-admin-tools'
        );
    }
    
    public function debug_page() {
        echo '<div class="wrap">';
        echo '<h1>Job Automator Pro Debug</h1>';
        echo '<p>Plugin activated successfully!</p>';
        echo '<h2>System Info:</h2>';
        echo '<ul>';
        echo '<li>WordPress Version: ' . get_bloginfo('version') . '</li>';
        echo '<li>PHP Version: ' . PHP_VERSION . '</li>';
        echo '<li>Plugin Path: ' . JAP_DEBUG_PLUGIN_PATH . '</li>';
        echo '<li>Plugin URL: ' . JAP_DEBUG_PLUGIN_URL . '</li>';
        echo '</ul>';
        
        echo '<h2>File Check:</h2>';
        $files = array(
            'job-automator-pro/job-automator-pro.php',
            'job-automator-pro/includes/class-database.php',
            'job-automator-pro/includes/class-admin.php',
            'job-automator-pro/templates/dashboard.php'
        );
        
        echo '<ul>';
        foreach ($files as $file) {
            $full_path = WP_PLUGIN_DIR . '/' . $file;
            $exists = file_exists($full_path) ? 'EXISTS' : 'MISSING';
            echo "<li>{$file}: {$exists}</li>";
        }
        echo '</ul>';
        echo '</div>';
    }
    
    public function debug_notice() {
        echo '<div class="notice notice-success"><p>Job Automator Pro Debug: Plugin loaded successfully!</p></div>';
    }
    
    public function activate() {
        // Simple activation
        update_option('jap_debug_activated', current_time('mysql'));
    }
}

// Initialize debug plugin
new JobAutomatorProDebug();