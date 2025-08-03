<?php
if (!defined('ABSPATH')) {
    exit;
}

class JAP_Companies {
    
    public static function create($data) {
        global $wpdb;
        
        $companies_table = $wpdb->prefix . 'jap_companies';
        
        $result = $wpdb->insert(
            $companies_table,
            array(
                'name' => sanitize_text_field($data['name']),
                'email' => sanitize_email($data['email']),
                'phone' => sanitize_text_field($data['phone']),
                'category_id' => intval($data['category_id']),
                'status' => sanitize_text_field($data['status'])
            ),
            array('%s', '%s', '%s', '%d', '%s')
        );
        
        return $result !== false ? $wpdb->insert_id : false;
    }
    
    public static function update($id, $data) {
        global $wpdb;
        
        $companies_table = $wpdb->prefix . 'jap_companies';
        
        $result = $wpdb->update(
            $companies_table,
            array(
                'name' => sanitize_text_field($data['name']),
                'email' => sanitize_email($data['email']),
                'phone' => sanitize_text_field($data['phone']),
                'category_id' => intval($data['category_id']),
                'status' => sanitize_text_field($data['status'])
            ),
            array('id' => $id),
            array('%s', '%s', '%s', '%d', '%s'),
            array('%d')
        );
        
        return $result !== false;
    }
    
    public static function delete($id) {
        global $wpdb;
        
        $companies_table = $wpdb->prefix . 'jap_companies';
        
        $result = $wpdb->update(
            $companies_table,
            array('status' => 'inactive'),
            array('id' => $id),
            array('%s'),
            array('%d')
        );
        
        return $result !== false;
    }
    
    public static function get($id) {
        global $wpdb;
        
        $companies_table = $wpdb->prefix . 'jap_companies';
        $categories_table = $wpdb->prefix . 'jap_company_categories';
        
        return $wpdb->get_row($wpdb->prepare(
            "SELECT c.*, cat.name as category_name, cat.color as category_color 
             FROM $companies_table c 
             LEFT JOIN $categories_table cat ON c.category_id = cat.id 
             WHERE c.id = %d",
            $id
        ));
    }
    
    public static function get_field_values($company_id) {
        global $wpdb;
        
        $field_values_table = $wpdb->prefix . 'jap_company_field_values';
        $custom_fields_table = $wpdb->prefix . 'jap_custom_fields';
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT cf.*, cfv.field_value 
             FROM $custom_fields_table cf 
             LEFT JOIN $field_values_table cfv ON cf.id = cfv.field_id AND cfv.company_id = %d 
             WHERE cf.status = 'active' 
             ORDER BY cf.created_at ASC",
            $company_id
        ));
    }
    
    public static function save_field_values($company_id, $field_values) {
        global $wpdb;
        
        $field_values_table = $wpdb->prefix . 'jap_company_field_values';
        
        foreach ($field_values as $field_id => $value) {
            $existing = $wpdb->get_var($wpdb->prepare(
                "SELECT id FROM $field_values_table WHERE company_id = %d AND field_id = %d",
                $company_id, $field_id
            ));
            
            if ($existing) {
                $wpdb->update(
                    $field_values_table,
                    array('field_value' => sanitize_text_field($value)),
                    array('company_id' => $company_id, 'field_id' => $field_id),
                    array('%s'),
                    array('%d', '%d')
                );
            } else {
                $wpdb->insert(
                    $field_values_table,
                    array(
                        'company_id' => $company_id,
                        'field_id' => $field_id,
                        'field_value' => sanitize_text_field($value)
                    ),
                    array('%d', '%d', '%s')
                );
            }
        }
    }
}