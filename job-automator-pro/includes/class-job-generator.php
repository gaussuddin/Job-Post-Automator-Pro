<?php
if (!defined('ABSPATH')) {
    exit;
}

class JAP_Job_Generator {
    
    public static function generate($company_id, $template_id) {
        global $wpdb;
        
        // Get company data
        $company = JAP_Companies::get($company_id);
        if (!$company) {
            return new WP_Error('invalid_company', __('Company not found', 'job-automator-pro'));
        }
        
        // Get template data
        $template = JAP_Templates::get($template_id);
        if (!$template) {
            return new WP_Error('invalid_template', __('Template not found', 'job-automator-pro'));
        }
        
        // Get custom field values for the company
        $field_values = JAP_Companies::get_field_values($company_id);
        $field_data = array();
        foreach ($field_values as $field) {
            $field_data[$field->field_name] = $field->field_value;
        }
        
        // Process template content
        $content = JAP_Templates::process_content($template->content, $company, $field_data);
        
        // Generate formatted content
        $formatted_content = self::format_job_post($content, $company, $template);
        
        return array(
            'content' => $formatted_content,
            'company' => $company,
            'template' => $template,
            'field_values' => $field_data
        );
    }
    
    private static function format_job_post($content, $company, $template) {
        $output = '<div class="jap-generated-post">';
        
        // Add introduction paragraph
        $output .= '<p>' . $content . '</p>';
        
        // Add company-specific header
        $output .= '<h3 style="text-align: center; color: #007cba; margin: 30px 0 20px 0;">';
        $output .= esc_html($company->name) . ' Job Circular ' . date('Y');
        $output .= '</h3>';
        
        // Add publication information
        $output .= '<p style="text-align: justify; line-height: 1.6;">';
        $output .= esc_html($company->name) . ' job circular ' . date('Y') . ' has been published on ' . date('j F Y') . ' ';
        $output .= 'in the daily newspapers and official website. ';
        $output .= 'Interested eligible male and female candidates can submit job application online. ';
        $output .= 'If you\'re seeking ' . esc_html($company->name) . ' job circular ' . date('Y') . ', this post is crucial for you.';
        $output .= '</p>';
        
        // Add vacancy table header
        $output .= '<h3 style="text-align: center; color: #007cba; margin: 30px 0 20px 0;">';
        $output .= esc_html($company->name) . ' Job Total Vacancy';
        $output .= '</h3>';
        
        // Add vacancy summary table
        $output .= '<table border="1" style="width: 100%; border-collapse: collapse; margin: 20px 0; font-family: Arial, sans-serif;">';
        $output .= '<tr style="background-color: #f5f5f5;">';
        $output .= '<th style="padding: 12px; text-align: center; font-weight: bold; border: 1px solid #ddd;">Total Post Category</th>';
        $output .= '<th style="padding: 12px; text-align: center; font-weight: bold; border: 1px solid #ddd;">Total Vacancies</th>';
        $output .= '</tr>';
        $output .= '<tr>';
        $output .= '<td style="padding: 12px; text-align: center; border: 1px solid #ddd;">04</td>';
        $output .= '<td style="padding: 12px; text-align: center; border: 1px solid #ddd;">05</td>';
        $output .= '</tr>';
        $output .= '</table>';
        
        // Add detailed vacancy table header
        $output .= '<h3 style="text-align: center; color: #007cba; margin: 30px 0 20px 0;">';
        $output .= esc_html($company->name) . ' Job Post Name and Vacancy Details';
        $output .= '</h3>';
        
        // Add detailed vacancy table
        $output .= '<table border="1" style="width: 100%; border-collapse: collapse; margin: 20px 0; font-family: Arial, sans-serif;">';
        $output .= '<tr style="background-color: #f5f5f5;">';
        $output .= '<th style="padding: 12px; border: 1px solid #ddd; font-weight: bold;">Sl No</th>';
        $output .= '<th style="padding: 12px; border: 1px solid #ddd; font-weight: bold;">Post Name</th>';
        $output .= '<th style="padding: 12px; border: 1px solid #ddd; font-weight: bold;">Number of Vacancies</th>';
        $output .= '<th style="padding: 12px; border: 1px solid #ddd; font-weight: bold;">Job Details</th>';
        $output .= '</tr>';
        $output .= '<tr>';
        $output .= '<td style="padding: 12px; text-align: center; border: 1px solid #ddd;">01</td>';
        $output .= '<td style="padding: 12px; border: 1px solid #ddd;">Research Officer</td>';
        $output .= '<td style="padding: 12px; text-align: center; border: 1px solid #ddd;">02</td>';
        $output .= '<td style="padding: 12px; border: 1px solid #ddd;">Full Details</td>';
        $output .= '</tr>';
        $output .= '</table>';
        
        // Add application information
        $output .= '<h3 style="text-align: center; color: #007cba; margin: 30px 0 20px 0;">';
        $output .= 'Application Process';
        $output .= '</h3>';
        
        $output .= '<p style="text-align: justify; line-height: 1.6;">';
        $output .= 'The job application will start on ' . date('j F Y', strtotime('+7 days')) . ' at 10:00 AM ';
        $output .= 'and will end on ' . date('j F Y', strtotime('+30 days')) . ' at 5:00 PM. ';
        if ($company->email) {
            $output .= 'For more information, contact: ' . esc_html($company->email) . '. ';
        }
        $output .= 'Read the full article carefully to get complete information about ';
        $output .= esc_html($company->name) . ' job circular ' . date('Y') . '.';
        $output .= '</p>';
        
        $output .= '</div>';
        
        return $output;
    }
    
    public static function export_as_html($content) {
        $html = '<!DOCTYPE html>';
        $html .= '<html lang="en">';
        $html .= '<head>';
        $html .= '<meta charset="UTF-8">';
        $html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<title>Job Post - Generated by Job Automator Pro</title>';
        $html .= '<style>';
        $html .= 'body { font-family: Arial, sans-serif; line-height: 1.6; margin: 40px; color: #333; }';
        $html .= 'h3 { color: #007cba; }';
        $html .= 'table { width: 100%; border-collapse: collapse; margin: 20px 0; }';
        $html .= 'th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }';
        $html .= 'th { background-color: #f5f5f5; font-weight: bold; }';
        $html .= 'p { text-align: justify; }';
        $html .= '</style>';
        $html .= '</head>';
        $html .= '<body>';
        $html .= $content;
        $html .= '</body>';
        $html .= '</html>';
        
        return $html;
    }
    
    public static function get_available_placeholders() {
        return array(
            '{{company_name}}' => __('Company Name', 'job-automator-pro'),
            '{{company_email}}' => __('Company Email', 'job-automator-pro'),
            '{{company_phone}}' => __('Company Phone', 'job-automator-pro'),
            '{{current_date}}' => __('Current Date', 'job-automator-pro'),
            '{{current_year}}' => __('Current Year', 'job-automator-pro')
        );
    }
}