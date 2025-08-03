<?php
if (!defined('ABSPATH')) {
    exit;
}

class JAP_Database {
    
    public static function create_tables() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        // Companies table
        $companies_table = $wpdb->prefix . 'jap_companies';
        $companies_sql = "CREATE TABLE $companies_table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            email varchar(255),
            phone varchar(50),
            category_id mediumint(9),
            status varchar(20) DEFAULT 'active',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        // Templates table
        $templates_table = $wpdb->prefix . 'jap_templates';
        $templates_sql = "CREATE TABLE $templates_table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            content longtext,
            category_id mediumint(9),
            status varchar(20) DEFAULT 'active',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        // Custom Fields table
        $fields_table = $wpdb->prefix . 'jap_custom_fields';
        $fields_sql = "CREATE TABLE $fields_table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            field_label varchar(255) NOT NULL,
            field_name varchar(255) NOT NULL UNIQUE,
            field_type varchar(50) NOT NULL,
            is_required tinyint(1) DEFAULT 0,
            status varchar(20) DEFAULT 'active',
            field_options text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        // Company Categories table
        $company_categories_table = $wpdb->prefix . 'jap_company_categories';
        $company_categories_sql = "CREATE TABLE $company_categories_table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            color varchar(7) DEFAULT '#2c3e50',
            status varchar(20) DEFAULT 'active',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        // Template Categories table
        $template_categories_table = $wpdb->prefix . 'jap_template_categories';
        $template_categories_sql = "CREATE TABLE $template_categories_table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            color varchar(7) DEFAULT '#2c3e50',
            status varchar(20) DEFAULT 'active',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        // Company Field Values table
        $company_field_values_table = $wpdb->prefix . 'jap_company_field_values';
        $company_field_values_sql = "CREATE TABLE $company_field_values_table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            company_id mediumint(9) NOT NULL,
            field_id mediumint(9) NOT NULL,
            field_value text,
            PRIMARY KEY (id),
            UNIQUE KEY company_field (company_id, field_id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        
        dbDelta($companies_sql);
        dbDelta($templates_sql);
        dbDelta($fields_sql);
        dbDelta($company_categories_sql);
        dbDelta($template_categories_sql);
        dbDelta($company_field_values_sql);
    }
    
    public static function insert_default_data() {
        global $wpdb;
        
        // Insert default company category
        $company_categories_table = $wpdb->prefix . 'jap_company_categories';
        $wpdb->insert(
            $company_categories_table,
            array(
                'name' => 'Government',
                'color' => '#2c3e50',
                'status' => 'active'
            )
        );
        
        // Insert default template category
        $template_categories_table = $wpdb->prefix . 'jap_template_categories';
        $wpdb->insert(
            $template_categories_table,
            array(
                'name' => 'Government',
                'color' => '#2c3e50',
                'status' => 'active'
            )
        );
        
        // Insert default custom field
        $fields_table = $wpdb->prefix . 'jap_custom_fields';
        $wpdb->insert(
            $fields_table,
            array(
                'field_label' => 'Company Name',
                'field_name' => 'company_name',
                'field_type' => 'text',
                'is_required' => 1,
                'status' => 'active'
            )
        );
        
        // Insert sample company
        $companies_table = $wpdb->prefix . 'jap_companies';
        $company_id = $wpdb->insert(
            $companies_table,
            array(
                'name' => 'L P Gas Limited LPGL',
                'category_id' => 1,
                'status' => 'active'
            )
        );
        
        // Insert sample templates
        $templates_table = $wpdb->prefix . 'jap_templates';
        $wpdb->insert(
            $templates_table,
            array(
                'name' => 'Govt Online 1',
                'content' => 'BPATC job circular 2025 has been published. Bangladesh Public Administration Training Centre has released the job circular PDF and notice on its official website www.bpatc.gov.bd and in daily newspapers. Interested eligible male and female candidates can submit job application online through the bpatc.teletalk.com.bd website.',
                'category_id' => 1,
                'status' => 'active'
            )
        );
        
        $wpdb->insert(
            $templates_table,
            array(
                'name' => 'Govt Online 2',
                'content' => 'BPATC job circular 2025 has been published on 19 June 2025 in the daily Jugantor newspaper and www.bpatc.gov.bd. A total of 5 people of 5 categories of posts through this BPATC circular 2025. The job application will start on 26 June 2025 at 10:00 AM and will end on 20 July 2025 at 5:00 PM. The BPATC job application official website is bpatc.teletalk.com.bd.',
                'category_id' => 1,
                'status' => 'active'
            )
        );
    }
    
    public static function get_companies($search = '', $category = '', $limit = 20, $offset = 0) {
        global $wpdb;
        
        $companies_table = $wpdb->prefix . 'jap_companies';
        $categories_table = $wpdb->prefix . 'jap_company_categories';
        
        $where = "WHERE c.status = 'active'";
        
        if (!empty($search)) {
            $where .= $wpdb->prepare(" AND c.name LIKE %s", '%' . $search . '%');
        }
        
        if (!empty($category) && $category !== 'all') {
            $where .= $wpdb->prepare(" AND c.category_id = %d", $category);
        }
        
        $sql = "SELECT c.*, cat.name as category_name, cat.color as category_color 
                FROM $companies_table c 
                LEFT JOIN $categories_table cat ON c.category_id = cat.id 
                $where 
                ORDER BY c.created_at DESC 
                LIMIT %d OFFSET %d";
        
        return $wpdb->get_results($wpdb->prepare($sql, $limit, $offset));
    }
    
    public static function get_templates($search = '', $category = '', $limit = 20, $offset = 0) {
        global $wpdb;
        
        $templates_table = $wpdb->prefix . 'jap_templates';
        $categories_table = $wpdb->prefix . 'jap_template_categories';
        
        $where = "WHERE t.status = 'active'";
        
        if (!empty($search)) {
            $where .= $wpdb->prepare(" AND t.name LIKE %s", '%' . $search . '%');
        }
        
        if (!empty($category) && $category !== 'all') {
            $where .= $wpdb->prepare(" AND t.category_id = %d", $category);
        }
        
        $sql = "SELECT t.*, cat.name as category_name, cat.color as category_color 
                FROM $templates_table t 
                LEFT JOIN $categories_table cat ON t.category_id = cat.id 
                $where 
                ORDER BY t.created_at DESC 
                LIMIT %d OFFSET %d";
        
        return $wpdb->get_results($wpdb->prepare($sql, $limit, $offset));
    }
    
    public static function get_custom_fields() {
        global $wpdb;
        
        $fields_table = $wpdb->prefix . 'jap_custom_fields';
        
        return $wpdb->get_results("SELECT * FROM $fields_table WHERE status = 'active' ORDER BY created_at ASC");
    }
    
    public static function get_company_categories() {
        global $wpdb;
        
        $categories_table = $wpdb->prefix . 'jap_company_categories';
        
        return $wpdb->get_results("SELECT * FROM $categories_table WHERE status = 'active' ORDER BY name ASC");
    }
    
    public static function get_template_categories() {
        global $wpdb;
        
        $categories_table = $wpdb->prefix . 'jap_template_categories';
        
        return $wpdb->get_results("SELECT * FROM $categories_table WHERE status = 'active' ORDER BY name ASC");
    }
    
    public static function get_stats() {
        global $wpdb;
        
        $companies_table = $wpdb->prefix . 'jap_companies';
        $templates_table = $wpdb->prefix . 'jap_templates';
        $fields_table = $wpdb->prefix . 'jap_custom_fields';
        $company_categories_table = $wpdb->prefix . 'jap_company_categories';
        
        $stats = array();
        $stats['companies'] = $wpdb->get_var("SELECT COUNT(*) FROM $companies_table WHERE status = 'active'");
        $stats['templates'] = $wpdb->get_var("SELECT COUNT(*) FROM $templates_table WHERE status = 'active'");
        $stats['fields'] = $wpdb->get_var("SELECT COUNT(*) FROM $fields_table WHERE status = 'active'");
        $stats['categories'] = $wpdb->get_var("SELECT COUNT(*) FROM $company_categories_table WHERE status = 'active'");
        
        return $stats;
    }
}