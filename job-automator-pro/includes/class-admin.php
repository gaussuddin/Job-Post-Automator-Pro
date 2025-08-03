<?php
if (!defined('ABSPATH')) {
    exit;
}

class JAP_Admin {
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('admin_init', array($this, 'admin_init'));
    }
    
    public function admin_init() {
        // Register settings
        register_setting('jap_settings', 'jap_items_per_page', array('default' => 20));
        register_setting('jap_settings', 'jap_ui_theme', array('default' => 'modern'));
        register_setting('jap_settings', 'jap_auto_save', array('default' => 1));
        register_setting('jap_settings', 'jap_notifications', array('default' => 1));
        register_setting('jap_settings', 'jap_debug_mode', array('default' => 0));
        register_setting('jap_settings', 'jap_export_data', array('default' => 1));
        register_setting('jap_settings', 'jap_import_data', array('default' => 1));
        register_setting('jap_settings', 'jap_max_file_size', array('default' => 5));
        register_setting('jap_settings', 'jap_allowed_file_types', array('default' => 'json,csv'));
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
            'Fields',
            'Fields',
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
        
        wp_enqueue_style('jap-admin-css', JAP_PLUGIN_URL . 'assets/css/admin.css', array(), JAP_VERSION);
        wp_enqueue_script('jap-admin-js', JAP_PLUGIN_URL . 'assets/js/admin.js', array('jquery'), JAP_VERSION, true);
        
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
    
    public function dashboard_page() {
        $stats = JAP_Database::get_stats();
        include JAP_PLUGIN_PATH . 'templates/dashboard.php';
    }
    
    public function companies_page() {
        $action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : 'list';
        $company_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        switch ($action) {
            case 'add':
                include JAP_PLUGIN_PATH . 'templates/companies-add.php';
                break;
            case 'edit':
                include JAP_PLUGIN_PATH . 'templates/companies-edit.php';
                break;
            default:
                include JAP_PLUGIN_PATH . 'templates/companies-list.php';
                break;
        }
    }
    
    public function templates_page() {
        $action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : 'list';
        $template_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        switch ($action) {
            case 'add':
                include JAP_PLUGIN_PATH . 'templates/templates-add.php';
                break;
            case 'edit':
                include JAP_PLUGIN_PATH . 'templates/templates-edit.php';
                break;
            default:
                include JAP_PLUGIN_PATH . 'templates/templates-list.php';
                break;
        }
    }
    
    public function fields_page() {
        $action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : 'list';
        $field_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        switch ($action) {
            case 'add':
                include JAP_PLUGIN_PATH . 'templates/fields-add.php';
                break;
            case 'edit':
                include JAP_PLUGIN_PATH . 'templates/fields-edit.php';
                break;
            default:
                include JAP_PLUGIN_PATH . 'templates/fields-list.php';
                break;
        }
    }
    
    public function categories_page() {
        include JAP_PLUGIN_PATH . 'templates/categories.php';
    }
    
    public function settings_page() {
        if (isset($_POST['submit'])) {
            // Handle settings save
            $this->save_settings();
        }
        include JAP_PLUGIN_PATH . 'templates/settings.php';
    }
    
    private function save_settings() {
        if (!wp_verify_nonce($_POST['jap_settings_nonce'], 'jap_save_settings')) {
            wp_die('Security check failed');
        }
        
        $settings = array(
            'jap_items_per_page',
            'jap_ui_theme',
            'jap_auto_save',
            'jap_notifications',
            'jap_debug_mode',
            'jap_export_data',
            'jap_import_data',
            'jap_max_file_size',
            'jap_allowed_file_types'
        );
        
        foreach ($settings as $setting) {
            if (isset($_POST[$setting])) {
                update_option($setting, sanitize_text_field($_POST[$setting]));
            }
        }
        
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success"><p>' . __('Settings saved successfully.', 'job-automator-pro') . '</p></div>';
        });
    }
}