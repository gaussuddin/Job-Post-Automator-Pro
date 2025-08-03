<?php
if (!defined('ABSPATH')) {
    exit;
}

class JAP_Templates {
    
    public static function create($data) {
        global $wpdb;
        
        $templates_table = $wpdb->prefix . 'jap_templates';
        
        $result = $wpdb->insert(
            $templates_table,
            array(
                'name' => sanitize_text_field($data['name']),
                'content' => wp_kses_post($data['content']),
                'category_id' => intval($data['category_id']),
                'status' => sanitize_text_field($data['status'])
            ),
            array('%s', '%s', '%d', '%s')
        );
        
        return $result !== false ? $wpdb->insert_id : false;
    }
    
    public static function update($id, $data) {
        global $wpdb;
        
        $templates_table = $wpdb->prefix . 'jap_templates';
        
        $result = $wpdb->update(
            $templates_table,
            array(
                'name' => sanitize_text_field($data['name']),
                'content' => wp_kses_post($data['content']),
                'category_id' => intval($data['category_id']),
                'status' => sanitize_text_field($data['status'])
            ),
            array('id' => $id),
            array('%s', '%s', '%d', '%s'),
            array('%d')
        );
        
        return $result !== false;
    }
    
    public static function delete($id) {
        global $wpdb;
        
        $templates_table = $wpdb->prefix . 'jap_templates';
        
        $result = $wpdb->update(
            $templates_table,
            array('status' => 'inactive'),
            array('id' => $id),
            array('%s'),
            array('%d')
        );
        
        return $result !== false;
    }
    
    public static function get($id) {
        global $wpdb;
        
        $templates_table = $wpdb->prefix . 'jap_templates';
        $categories_table = $wpdb->prefix . 'jap_template_categories';
        
        return $wpdb->get_row($wpdb->prepare(
            "SELECT t.*, cat.name as category_name, cat.color as category_color 
             FROM $templates_table t 
             LEFT JOIN $categories_table cat ON t.category_id = cat.id 
             WHERE t.id = %d",
            $id
        ));
    }
    
    public static function process_content($content, $company, $field_values = array()) {
        // Replace company placeholders
        $content = str_replace('{{company_name}}', $company->name, $content);
        $content = str_replace('{{company_email}}', $company->email, $content);
        $content = str_replace('{{company_phone}}', $company->phone, $content);
        
        // Replace custom field placeholders
        foreach ($field_values as $field_name => $field_value) {
            $content = str_replace('{{' . $field_name . '}}', $field_value, $content);
        }
        
        // Replace date placeholders
        $content = str_replace('{{current_date}}', date('F j, Y'), $content);
        $content = str_replace('{{current_year}}', date('Y'), $content);
        
        return $content;
    }
    
    public static function duplicate($id) {
        global $wpdb;
        
        $original = self::get($id);
        if (!$original) {
            return false;
        }
        
        $templates_table = $wpdb->prefix . 'jap_templates';
        
        $result = $wpdb->insert(
            $templates_table,
            array(
                'name' => $original->name . ' (Copy)',
                'content' => $original->content,
                'category_id' => $original->category_id,
                'status' => 'active'
            ),
            array('%s', '%s', '%d', '%s')
        );
        
        return $result !== false ? $wpdb->insert_id : false;
    }
}