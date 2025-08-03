<?php
if (!defined('ABSPATH')) {
    exit;
}

class JAP_Ajax {
    
    public function __construct() {
        add_action('wp_ajax_jap_get_company', array($this, 'get_company'));
        add_action('wp_ajax_jap_get_template', array($this, 'get_template'));
        add_action('wp_ajax_jap_generate_job_post', array($this, 'generate_job_post'));
        add_action('wp_ajax_jap_search_companies', array($this, 'search_companies'));
        add_action('wp_ajax_jap_search_templates', array($this, 'search_templates'));
        add_action('wp_ajax_jap_search_fields', array($this, 'search_fields'));
        add_action('wp_ajax_jap_filter_companies', array($this, 'filter_companies'));
        add_action('wp_ajax_jap_filter_templates', array($this, 'filter_templates'));
        add_action('wp_ajax_jap_delete_company', array($this, 'delete_company'));
        add_action('wp_ajax_jap_delete_template', array($this, 'delete_template'));
        add_action('wp_ajax_jap_delete_field', array($this, 'delete_field'));
        add_action('wp_ajax_jap_save_company', array($this, 'save_company'));
        add_action('wp_ajax_jap_save_template', array($this, 'save_template'));
        add_action('wp_ajax_jap_save_field', array($this, 'save_field'));
        add_action('wp_ajax_jap_save_category', array($this, 'save_category'));
        add_action('wp_ajax_jap_delete_category', array($this, 'delete_category'));
        add_action('wp_ajax_jap_import_data', array($this, 'import_data'));
        add_action('wp_ajax_jap_export_companies', array($this, 'export_companies'));
        add_action('wp_ajax_jap_export_templates', array($this, 'export_templates'));
        add_action('wp_ajax_jap_export_fields', array($this, 'export_fields'));
    }
    
    private function verify_nonce() {
        if (!wp_verify_nonce($_POST['nonce'], 'jap_nonce')) {
            wp_die('Security check failed');
        }
    }
    
    public function get_company() {
        $this->verify_nonce();
        
        $company_id = intval($_POST['company_id']);
        
        global $wpdb;
        $companies_table = $wpdb->prefix . 'jap_companies';
        $categories_table = $wpdb->prefix . 'jap_company_categories';
        
        $company = $wpdb->get_row($wpdb->prepare(
            "SELECT c.*, cat.name as category_name, cat.color as category_color 
             FROM $companies_table c 
             LEFT JOIN $categories_table cat ON c.category_id = cat.id 
             WHERE c.id = %d AND c.status = 'active'",
            $company_id
        ));
        
        if ($company) {
            wp_send_json_success($company);
        } else {
            wp_send_json_error('Company not found');
        }
    }
    
    public function get_template() {
        $this->verify_nonce();
        
        $template_id = intval($_POST['template_id']);
        
        global $wpdb;
        $templates_table = $wpdb->prefix . 'jap_templates';
        $categories_table = $wpdb->prefix . 'jap_template_categories';
        
        $template = $wpdb->get_row($wpdb->prepare(
            "SELECT t.*, cat.name as category_name, cat.color as category_color 
             FROM $templates_table t 
             LEFT JOIN $categories_table cat ON t.category_id = cat.id 
             WHERE t.id = %d AND t.status = 'active'",
            $template_id
        ));
        
        if ($template) {
            wp_send_json_success($template);
        } else {
            wp_send_json_error('Template not found');
        }
    }
    
    public function generate_job_post() {
        $this->verify_nonce();
        
        $company_id = intval($_POST['company_id']);
        $template_id = intval($_POST['template_id']);
        
        global $wpdb;
        
        // Get company data
        $companies_table = $wpdb->prefix . 'jap_companies';
        $company = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $companies_table WHERE id = %d",
            $company_id
        ));
        
        // Get template data
        $templates_table = $wpdb->prefix . 'jap_templates';
        $template = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $templates_table WHERE id = %d",
            $template_id
        ));
        
        if (!$company || !$template) {
            wp_send_json_error('Company or template not found');
        }
        
        // Get custom field values for the company
        $field_values_table = $wpdb->prefix . 'jap_company_field_values';
        $custom_fields_table = $wpdb->prefix . 'jap_custom_fields';
        
        $field_values = $wpdb->get_results($wpdb->prepare(
            "SELECT cf.field_name, cfv.field_value 
             FROM $field_values_table cfv 
             JOIN $custom_fields_table cf ON cfv.field_id = cf.id 
             WHERE cfv.company_id = %d",
            $company_id
        ));
        
        // Process template content
        $content = $template->content;
        
        // Replace company placeholders
        $content = str_replace('{{company_name}}', $company->name, $content);
        $content = str_replace('{{company_email}}', $company->email, $content);
        $content = str_replace('{{company_phone}}', $company->phone, $content);
        
        // Replace custom field placeholders
        foreach ($field_values as $field_value) {
            $content = str_replace('{{' . $field_value->field_name . '}}', $field_value->field_value, $content);
        }
        
        // Add some dynamic content based on the template (as shown in the screenshot)
        $generated_content = $this->format_job_post_content($content, $company, $template);
        
        wp_send_json_success(array('content' => $generated_content));
    }
    
    private function format_job_post_content($content, $company, $template) {
        // Create formatted job post content similar to the screenshot
        $formatted_content = '<div class="jap-generated-post">';
        
        $formatted_content .= '<p>' . $content . '</p>';
        
        $formatted_content .= '<h3 style="text-align: center; color: #007cba;">' . $company->name . ' Job Circular 2025</h3>';
        
        $formatted_content .= '<p>' . $company->name . ' job circular 2025 has been published on ' . date('j F Y') . ' in the daily newspapers and official website. ';
        $formatted_content .= 'Interested eligible male and female candidates can submit job application online. ';
        $formatted_content .= 'If you\'re seeking ' . $company->name . ' job circular 2025, this post is crucial for you.</p>';
        
        $formatted_content .= '<h3 style="text-align: center; color: #007cba;">' . $company->name . ' Job Total Vacancy</h3>';
        
        $formatted_content .= '<table border="1" style="width: 100%; border-collapse: collapse; margin: 20px 0;">';
        $formatted_content .= '<tr style="background-color: #f5f5f5;">';
        $formatted_content .= '<th style="padding: 10px; text-align: center;">Total Post Category</th>';
        $formatted_content .= '<th style="padding: 10px; text-align: center;">Total Vacancies</th>';
        $formatted_content .= '</tr>';
        $formatted_content .= '<tr>';
        $formatted_content .= '<td style="padding: 10px; text-align: center;">04</td>';
        $formatted_content .= '<td style="padding: 10px; text-align: center;">05</td>';
        $formatted_content .= '</tr>';
        $formatted_content .= '</table>';
        
        $formatted_content .= '<h3 style="text-align: center; color: #007cba;">' . $company->name . ' Job Post Name and Vacancy Details</h3>';
        
        $formatted_content .= '<table border="1" style="width: 100%; border-collapse: collapse; margin: 20px 0;">';
        $formatted_content .= '<tr style="background-color: #f5f5f5;">';
        $formatted_content .= '<th style="padding: 10px;">Sl No</th>';
        $formatted_content .= '<th style="padding: 10px;">Post Name</th>';
        $formatted_content .= '<th style="padding: 10px;">Number of Vacancies</th>';
        $formatted_content .= '<th style="padding: 10px;">Job Details</th>';
        $formatted_content .= '</tr>';
        $formatted_content .= '<tr>';
        $formatted_content .= '<td style="padding: 10px; text-align: center;">01</td>';
        $formatted_content .= '<td style="padding: 10px;">Research Officer</td>';
        $formatted_content .= '<td style="padding: 10px; text-align: center;">02</td>';
        $formatted_content .= '<td style="padding: 10px;">Full Details</td>';
        $formatted_content .= '</tr>';
        $formatted_content .= '</table>';
        
        $formatted_content .= '</div>';
        
        return $formatted_content;
    }
    
    public function search_companies() {
        $this->verify_nonce();
        
        $search = sanitize_text_field($_POST['search']);
        $companies = JAP_Database::get_companies($search, '', 20, 0);
        
        ob_start();
        if (!empty($companies)) {
            foreach ($companies as $company) {
                $this->render_company_row($company);
            }
        } else {
            echo '<tr><td colspan="6" class="jap-no-results">' . __('No results found.', 'job-automator-pro') . '</td></tr>';
        }
        $html = ob_get_clean();
        
        wp_send_json_success(array('html' => $html));
    }
    
    public function search_templates() {
        $this->verify_nonce();
        
        $search = sanitize_text_field($_POST['search']);
        $templates = JAP_Database::get_templates($search, '', 20, 0);
        
        ob_start();
        if (!empty($templates)) {
            foreach ($templates as $template) {
                $this->render_template_row($template);
            }
        } else {
            echo '<tr><td colspan="5" class="jap-no-results">' . __('No results found.', 'job-automator-pro') . '</td></tr>';
        }
        $html = ob_get_clean();
        
        wp_send_json_success(array('html' => $html));
    }
    
    public function delete_company() {
        $this->verify_nonce();
        
        $id = intval($_POST['id']);
        
        global $wpdb;
        $companies_table = $wpdb->prefix . 'jap_companies';
        
        $result = $wpdb->update(
            $companies_table,
            array('status' => 'inactive'),
            array('id' => $id),
            array('%s'),
            array('%d')
        );
        
        if ($result !== false) {
            wp_send_json_success();
        } else {
            wp_send_json_error('Failed to delete company');
        }
    }
    
    public function delete_template() {
        $this->verify_nonce();
        
        $id = intval($_POST['id']);
        
        global $wpdb;
        $templates_table = $wpdb->prefix . 'jap_templates';
        
        $result = $wpdb->update(
            $templates_table,
            array('status' => 'inactive'),
            array('id' => $id),
            array('%s'),
            array('%d')
        );
        
        if ($result !== false) {
            wp_send_json_success();
        } else {
            wp_send_json_error('Failed to delete template');
        }
    }
    
    public function delete_field() {
        $this->verify_nonce();
        
        $id = intval($_POST['id']);
        
        global $wpdb;
        $fields_table = $wpdb->prefix . 'jap_custom_fields';
        
        $result = $wpdb->update(
            $fields_table,
            array('status' => 'inactive'),
            array('id' => $id),
            array('%s'),
            array('%d')
        );
        
        if ($result !== false) {
            wp_send_json_success();
        } else {
            wp_send_json_error('Failed to delete field');
        }
    }
    
    public function export_companies() {
        $this->verify_nonce();
        
        $companies = JAP_Database::get_companies('', '', 1000, 0);
        
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="companies-export-' . date('Y-m-d') . '.json"');
        
        echo json_encode($companies, JSON_PRETTY_PRINT);
        exit;
    }
    
    public function export_templates() {
        $this->verify_nonce();
        
        $templates = JAP_Database::get_templates('', '', 1000, 0);
        
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="templates-export-' . date('Y-m-d') . '.json"');
        
        echo json_encode($templates, JSON_PRETTY_PRINT);
        exit;
    }
    
    public function export_fields() {
        $this->verify_nonce();
        
        $fields = JAP_Database::get_custom_fields();
        
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="fields-export-' . date('Y-m-d') . '.json"');
        
        echo json_encode($fields, JSON_PRETTY_PRINT);
        exit;
    }
    
    private function render_company_row($company) {
        ?>
        <tr data-id="<?php echo esc_attr($company->id); ?>">
            <td class="company-name">
                <strong><?php echo esc_html($company->name); ?></strong>
            </td>
            <td class="company-category">
                <?php if ($company->category_name): ?>
                    <span class="jap-category-badge" style="background-color: <?php echo esc_attr($company->category_color); ?>">
                        <?php echo esc_html($company->category_name); ?>
                    </span>
                <?php else: ?>
                    <span class="jap-no-category"><?php _e('No Category', 'job-automator-pro'); ?></span>
                <?php endif; ?>
            </td>
            <td class="company-email">
                <?php echo $company->email ? esc_html($company->email) : '-'; ?>
            </td>
            <td class="company-phone">
                <?php echo $company->phone ? esc_html($company->phone) : '-'; ?>
            </td>
            <td class="company-status">
                <span class="jap-status jap-status-<?php echo esc_attr($company->status); ?>">
                    <?php echo esc_html(ucfirst($company->status)); ?>
                </span>
            </td>
            <td class="company-actions">
                <div class="jap-action-buttons">
                    <a href="<?php echo admin_url('admin.php?page=jap-companies&action=edit&id=' . $company->id); ?>" 
                       class="button button-small jap-btn-edit" title="<?php _e('Edit', 'job-automator-pro'); ?>">
                        <span class="dashicons dashicons-edit"></span>
                    </a>
                    <button class="button button-small jap-btn-delete" 
                            data-id="<?php echo esc_attr($company->id); ?>" 
                            title="<?php _e('Delete', 'job-automator-pro'); ?>">
                        <span class="dashicons dashicons-trash"></span>
                    </button>
                </div>
            </td>
        </tr>
        <?php
    }
    
    private function render_template_row($template) {
        ?>
        <tr data-id="<?php echo esc_attr($template->id); ?>">
            <td class="template-name">
                <strong><?php echo esc_html($template->name); ?></strong>
            </td>
            <td class="template-category">
                <?php if ($template->category_name): ?>
                    <span class="jap-category-badge" style="background-color: <?php echo esc_attr($template->category_color); ?>">
                        <?php echo esc_html($template->category_name); ?>
                    </span>
                <?php else: ?>
                    <span class="jap-no-category"><?php _e('No Category', 'job-automator-pro'); ?></span>
                <?php endif; ?>
            </td>
            <td class="template-description">
                <?php 
                $content = wp_trim_words($template->content, 15, '...');
                echo esc_html($content); 
                ?>
            </td>
            <td class="template-status">
                <span class="jap-status jap-status-<?php echo esc_attr($template->status); ?>">
                    <?php echo esc_html(ucfirst($template->status)); ?>
                </span>
            </td>
            <td class="template-actions">
                <div class="jap-action-buttons">
                    <a href="<?php echo admin_url('admin.php?page=jap-templates&action=edit&id=' . $template->id); ?>" 
                       class="button button-small jap-btn-edit" title="<?php _e('Edit', 'job-automator-pro'); ?>">
                        <span class="dashicons dashicons-edit"></span>
                    </a>
                    <button class="button button-small jap-btn-delete" 
                            data-id="<?php echo esc_attr($template->id); ?>" 
                            title="<?php _e('Delete', 'job-automator-pro'); ?>">
                        <span class="dashicons dashicons-trash"></span>
                    </button>
                </div>
            </td>
        </tr>
        <?php
    }
}