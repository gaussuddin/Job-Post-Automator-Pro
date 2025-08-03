<?php
if (!defined('ABSPATH')) {
    exit;
}

class JAP_Categories {
    
    public static function create($data, $type = 'company') {
        global $wpdb;
        
        $table = $type === 'company' ? 'jap_company_categories' : 'jap_template_categories';
        $categories_table = $wpdb->prefix . $table;
        
        $result = $wpdb->insert(
            $categories_table,
            array(
                'name' => sanitize_text_field($data['name']),
                'color' => sanitize_hex_color($data['color']),
                'status' => sanitize_text_field($data['status'])
            ),
            array('%s', '%s', '%s')
        );
        
        return $result !== false ? $wpdb->insert_id : false;
    }
    
    public static function update($id, $data, $type = 'company') {
        global $wpdb;
        
        $table = $type === 'company' ? 'jap_company_categories' : 'jap_template_categories';
        $categories_table = $wpdb->prefix . $table;
        
        $result = $wpdb->update(
            $categories_table,
            array(
                'name' => sanitize_text_field($data['name']),
                'color' => sanitize_hex_color($data['color']),
                'status' => sanitize_text_field($data['status'])
            ),
            array('id' => $id),
            array('%s', '%s', '%s'),
            array('%d')
        );
        
        return $result !== false;
    }
    
    public static function delete($id, $type = 'company') {
        global $wpdb;
        
        $table = $type === 'company' ? 'jap_company_categories' : 'jap_template_categories';
        $categories_table = $wpdb->prefix . $table;
        
        $result = $wpdb->update(
            $categories_table,
            array('status' => 'inactive'),
            array('id' => $id),
            array('%s'),
            array('%d')
        );
        
        return $result !== false;
    }
    
    public static function get($id, $type = 'company') {
        global $wpdb;
        
        $table = $type === 'company' ? 'jap_company_categories' : 'jap_template_categories';
        $categories_table = $wpdb->prefix . $table;
        
        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $categories_table WHERE id = %d",
            $id
        ));
    }
    
    public static function get_default_colors() {
        return array(
            '#2c3e50', '#3498db', '#9b59b6', '#e74c3c', '#f39c12',
            '#1abc9c', '#34495e', '#27ae60', '#e67e22', '#95a5a6'
        );
    }
}