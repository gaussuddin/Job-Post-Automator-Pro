<?php
/**
 * Plugin Name: Job Automator Pro
 * Plugin URI: https://your-website.com/job-automator-pro
 * Description: Professional job post automation with company management, templates, and custom fields.
 * Version: 2.0.0
 * Author: Your Name
 * License: GPL v2 or later
 * Text Domain: job-automator-pro
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('JAP_PLUGIN_URL', plugin_dir_url(__FILE__));
define('JAP_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('JAP_VERSION', '2.0.0');

// Main plugin class
class JobAutomatorPro {
    
    public function __construct() {
        add_action('init', array($this, 'init'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }
    
    public function init() {
        // Load text domain
        load_plugin_textdomain('job-automator-pro', false, dirname(plugin_basename(__FILE__)) . '/languages');
        
        // Include required files
        $this->include_files();
        
        // Initialize admin
        if (is_admin()) {
            new JAP_Admin();
        }
        
        // Initialize AJAX handlers
        new JAP_Ajax();
    }
    
    private function include_files() {
        require_once JAP_PLUGIN_PATH . 'includes/class-database.php';
        require_once JAP_PLUGIN_PATH . 'includes/class-admin.php';
        require_once JAP_PLUGIN_PATH . 'includes/class-ajax.php';
        require_once JAP_PLUGIN_PATH . 'includes/class-companies.php';
        require_once JAP_PLUGIN_PATH . 'includes/class-templates.php';
        require_once JAP_PLUGIN_PATH . 'includes/class-fields.php';
        require_once JAP_PLUGIN_PATH . 'includes/class-categories.php';
        require_once JAP_PLUGIN_PATH . 'includes/class-job-generator.php';
    }
    
    public function activate() {
        JAP_Database::create_tables();
        JAP_Database::insert_default_data();
    }
    
    public function deactivate() {
        // Clean up if needed
    }
}

// Initialize the plugin
new JobAutomatorPro();