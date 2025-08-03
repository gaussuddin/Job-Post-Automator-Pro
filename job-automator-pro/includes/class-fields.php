<?php
if (!defined('ABSPATH')) {
    exit;
}

class JAP_Fields {
    
    public static function create($data) {
        global $wpdb;
        
        $fields_table = $wpdb->prefix . 'jap_custom_fields';
        
        $result = $wpdb->insert(
            $fields_table,
            array(
                'field_label' => sanitize_text_field($data['field_label']),
                'field_name' => sanitize_text_field($data['field_name']),
                'field_type' => sanitize_text_field($data['field_type']),
                'is_required' => intval($data['is_required']),
                'status' => sanitize_text_field($data['status']),
                'field_options' => isset($data['field_options']) ? sanitize_text_field($data['field_options']) : ''
            ),
            array('%s', '%s', '%s', '%d', '%s', '%s')
        );
        
        return $result !== false ? $wpdb->insert_id : false;
    }
    
    public static function update($id, $data) {
        global $wpdb;
        
        $fields_table = $wpdb->prefix . 'jap_custom_fields';
        
        $result = $wpdb->update(
            $fields_table,
            array(
                'field_label' => sanitize_text_field($data['field_label']),
                'field_name' => sanitize_text_field($data['field_name']),
                'field_type' => sanitize_text_field($data['field_type']),
                'is_required' => intval($data['is_required']),
                'status' => sanitize_text_field($data['status']),
                'field_options' => isset($data['field_options']) ? sanitize_text_field($data['field_options']) : ''
            ),
            array('id' => $id),
            array('%s', '%s', '%s', '%d', '%s', '%s'),
            array('%d')
        );
        
        return $result !== false;
    }
    
    public static function delete($id) {
        global $wpdb;
        
        $fields_table = $wpdb->prefix . 'jap_custom_fields';
        
        $result = $wpdb->update(
            $fields_table,
            array('status' => 'inactive'),
            array('id' => $id),
            array('%s'),
            array('%d')
        );
        
        return $result !== false;
    }
    
    public static function get($id) {
        global $wpdb;
        
        $fields_table = $wpdb->prefix . 'jap_custom_fields';
        
        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $fields_table WHERE id = %d",
            $id
        ));
    }
    
    public static function get_field_types() {
        return array(
            'text' => __('Text', 'job-automator-pro'),
            'textarea' => __('Textarea', 'job-automator-pro'),
            'email' => __('Email', 'job-automator-pro'),
            'url' => __('URL', 'job-automator-pro'),
            'number' => __('Number', 'job-automator-pro'),
            'date' => __('Date', 'job-automator-pro'),
            'select' => __('Select', 'job-automator-pro'),
            'checkbox' => __('Checkbox', 'job-automator-pro')
        );
    }
    
    public static function render_field($field, $value = '') {
        $output = '';
        $required = $field->is_required ? 'required' : '';
        $field_id = 'field_' . $field->id;
        
        switch ($field->field_type) {
            case 'text':
                $output = sprintf(
                    '<input type="text" id="%s" name="field_values[%d]" value="%s" %s class="regular-text">',
                    $field_id, $field->id, esc_attr($value), $required
                );
                break;
                
            case 'textarea':
                $output = sprintf(
                    '<textarea id="%s" name="field_values[%d]" %s class="large-text" rows="4">%s</textarea>',
                    $field_id, $field->id, $required, esc_textarea($value)
                );
                break;
                
            case 'email':
                $output = sprintf(
                    '<input type="email" id="%s" name="field_values[%d]" value="%s" %s class="regular-text">',
                    $field_id, $field->id, esc_attr($value), $required
                );
                break;
                
            case 'url':
                $output = sprintf(
                    '<input type="url" id="%s" name="field_values[%d]" value="%s" %s class="regular-text">',
                    $field_id, $field->id, esc_attr($value), $required
                );
                break;
                
            case 'number':
                $output = sprintf(
                    '<input type="number" id="%s" name="field_values[%d]" value="%s" %s class="small-text">',
                    $field_id, $field->id, esc_attr($value), $required
                );
                break;
                
            case 'date':
                $output = sprintf(
                    '<input type="date" id="%s" name="field_values[%d]" value="%s" %s class="regular-text">',
                    $field_id, $field->id, esc_attr($value), $required
                );
                break;
                
            case 'select':
                $options = explode(',', $field->field_options);
                $output = sprintf('<select id="%s" name="field_values[%d]" %s>', $field_id, $field->id, $required);
                $output .= '<option value="">' . __('Select...', 'job-automator-pro') . '</option>';
                foreach ($options as $option) {
                    $option = trim($option);
                    $selected = selected($value, $option, false);
                    $output .= sprintf('<option value="%s" %s>%s</option>', esc_attr($option), $selected, esc_html($option));
                }
                $output .= '</select>';
                break;
                
            case 'checkbox':
                $checked = checked($value, '1', false);
                $output = sprintf(
                    '<label><input type="checkbox" id="%s" name="field_values[%d]" value="1" %s %s> %s</label>',
                    $field_id, $field->id, $checked, $required, esc_html($field->field_label)
                );
                break;
        }
        
        return $output;
    }
    
    public static function validate_field_name($field_name, $exclude_id = 0) {
        global $wpdb;
        
        $fields_table = $wpdb->prefix . 'jap_custom_fields';
        
        $query = "SELECT COUNT(*) FROM $fields_table WHERE field_name = %s AND status = 'active'";
        $params = array($field_name);
        
        if ($exclude_id > 0) {
            $query .= " AND id != %d";
            $params[] = $exclude_id;
        }
        
        $count = $wpdb->get_var($wpdb->prepare($query, $params));
        
        return $count == 0;
    }
}