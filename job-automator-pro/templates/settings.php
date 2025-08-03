<?php if (!defined('ABSPATH')) exit; ?>

<div class="wrap jap-settings">
    <div class="jap-header">
        <div class="jap-header-icon">
            <span class="dashicons dashicons-admin-settings"></span>
        </div>
        <h1 class="jap-header-title"><?php _e('Plugin Settings', 'job-automator-pro'); ?></h1>
    </div>

    <form method="post" action="">
        <?php wp_nonce_field('jap_save_settings', 'jap_settings_nonce'); ?>
        
        <div class="jap-settings-grid">
            <!-- Role Permissions -->
            <div class="jap-settings-section">
                <div class="jap-section-header">
                    <span class="dashicons dashicons-admin-users"></span>
                    <h2><?php _e('Role Permissions', 'job-automator-pro'); ?></h2>
                </div>
                
                <div class="jap-settings-content">
                    <p class="description"><?php _e('Who can access the plugin dashboard', 'job-automator-pro'); ?></p>
                    
                    <div class="jap-permission-group">
                        <h3><?php _e('Dashboard Access', 'job-automator-pro'); ?></h3>
                        <div class="jap-permission-list">
                            <label><input type="checkbox" name="jap_permissions[]" value="administrator" checked disabled> <?php _e('Administrator', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_permissions[]" value="editor" checked> <?php _e('Editor', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_permissions[]" value="author"> <?php _e('Author', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_permissions[]" value="contributor"> <?php _e('Contributor', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_permissions[]" value="subscriber"> <?php _e('Subscriber', 'job-automator-pro'); ?></label>
                        </div>
                    </div>
                    
                    <div class="jap-permission-group">
                        <h3><?php _e('Company Management', 'job-automator-pro'); ?></h3>
                        <div class="jap-permission-list">
                            <label><input type="checkbox" name="jap_company_permissions[]" value="administrator" checked disabled> <?php _e('Administrator', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_company_permissions[]" value="editor" checked> <?php _e('Editor', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_company_permissions[]" value="author"> <?php _e('Author', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_company_permissions[]" value="contributor"> <?php _e('Contributor', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_company_permissions[]" value="subscriber"> <?php _e('Subscriber', 'job-automator-pro'); ?></label>
                        </div>
                        <p class="description"><?php _e('Who can manage companies', 'job-automator-pro'); ?></p>
                    </div>
                    
                    <div class="jap-permission-group">
                        <h3><?php _e('Template Management', 'job-automator-pro'); ?></h3>
                        <div class="jap-permission-list">
                            <label><input type="checkbox" name="jap_template_permissions[]" value="administrator" checked disabled> <?php _e('Administrator', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_template_permissions[]" value="editor" checked> <?php _e('Editor', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_template_permissions[]" value="author"> <?php _e('Author', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_template_permissions[]" value="contributor"> <?php _e('Contributor', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_template_permissions[]" value="subscriber"> <?php _e('Subscriber', 'job-automator-pro'); ?></label>
                        </div>
                        <p class="description"><?php _e('Who can manage templates', 'job-automator-pro'); ?></p>
                    </div>
                    
                    <div class="jap-permission-group">
                        <h3><?php _e('Field Management', 'job-automator-pro'); ?></h3>
                        <div class="jap-permission-list">
                            <label><input type="checkbox" name="jap_field_permissions[]" value="administrator" checked disabled> <?php _e('Administrator', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_field_permissions[]" value="editor"> <?php _e('Editor', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_field_permissions[]" value="author"> <?php _e('Author', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_field_permissions[]" value="contributor"> <?php _e('Contributor', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_field_permissions[]" value="subscriber"> <?php _e('Subscriber', 'job-automator-pro'); ?></label>
                        </div>
                        <p class="description"><?php _e('Who can manage custom fields', 'job-automator-pro'); ?></p>
                    </div>
                    
                    <div class="jap-permission-group">
                        <h3><?php _e('Category Management', 'job-automator-pro'); ?></h3>
                        <div class="jap-permission-list">
                            <label><input type="checkbox" name="jap_category_permissions[]" value="administrator" checked disabled> <?php _e('Administrator', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_category_permissions[]" value="editor"> <?php _e('Editor', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_category_permissions[]" value="author"> <?php _e('Author', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_category_permissions[]" value="contributor"> <?php _e('Contributor', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_category_permissions[]" value="subscriber"> <?php _e('Subscriber', 'job-automator-pro'); ?></label>
                        </div>
                        <p class="description"><?php _e('Who can manage categories', 'job-automator-pro'); ?></p>
                    </div>
                    
                    <div class="jap-permission-group">
                        <h3><?php _e('Job Generator Access', 'job-automator-pro'); ?></h3>
                        <div class="jap-permission-list">
                            <label><input type="checkbox" name="jap_generator_permissions[]" value="administrator" checked disabled> <?php _e('Administrator', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_generator_permissions[]" value="editor" checked> <?php _e('Editor', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_generator_permissions[]" value="author" checked> <?php _e('Author', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_generator_permissions[]" value="contributor"> <?php _e('Contributor', 'job-automator-pro'); ?></label>
                            <label><input type="checkbox" name="jap_generator_permissions[]" value="subscriber"> <?php _e('Subscriber', 'job-automator-pro'); ?></label>
                        </div>
                        <p class="description"><?php _e('Who can use the job post generator', 'job-automator-pro'); ?></p>
                    </div>
                </div>
            </div>

            <!-- General Settings -->
            <div class="jap-settings-section">
                <div class="jap-section-header">
                    <span class="dashicons dashicons-admin-generic"></span>
                    <h2><?php _e('General Settings', 'job-automator-pro'); ?></h2>
                </div>
                
                <div class="jap-settings-content">
                    <div class="jap-setting-group">
                        <label for="jap_items_per_page"><?php _e('Items Per Page', 'job-automator-pro'); ?></label>
                        <input type="number" id="jap_items_per_page" name="jap_items_per_page" 
                               value="<?php echo esc_attr(get_option('jap_items_per_page', 20)); ?>" 
                               min="5" max="100" step="5">
                        <p class="description"><?php _e('Number of items to display per page in tables', 'job-automator-pro'); ?></p>
                    </div>
                    
                    <div class="jap-setting-group">
                        <label for="jap_ui_theme"><?php _e('UI Theme', 'job-automator-pro'); ?></label>
                        <select id="jap_ui_theme" name="jap_ui_theme">
                            <option value="modern" <?php selected(get_option('jap_ui_theme', 'modern'), 'modern'); ?>><?php _e('Modern', 'job-automator-pro'); ?></option>
                            <option value="classic" <?php selected(get_option('jap_ui_theme', 'modern'), 'classic'); ?>><?php _e('Classic', 'job-automator-pro'); ?></option>
                        </select>
                        <p class="description"><?php _e('Choose the interface theme', 'job-automator-pro'); ?></p>
                    </div>
                    
                    <div class="jap-setting-group">
                        <label>
                            <input type="checkbox" name="jap_auto_save" value="1" 
                                   <?php checked(get_option('jap_auto_save', 1), 1); ?>>
                            <?php _e('Enable Auto-Save', 'job-automator-pro'); ?>
                        </label>
                        <p class="description"><?php _e('Automatically save forms as you type', 'job-automator-pro'); ?></p>
                    </div>
                    
                    <div class="jap-setting-group">
                        <label>
                            <input type="checkbox" name="jap_notifications" value="1" 
                                   <?php checked(get_option('jap_notifications', 1), 1); ?>>
                            <?php _e('Enable Notifications', 'job-automator-pro'); ?>
                        </label>
                        <p class="description"><?php _e('Show success/error notifications for user actions', 'job-automator-pro'); ?></p>
                    </div>
                    
                    <div class="jap-setting-group">
                        <label>
                            <input type="checkbox" name="jap_debug_mode" value="1" 
                                   <?php checked(get_option('jap_debug_mode', 0), 1); ?>>
                            <?php _e('Enable Debug Mode', 'job-automator-pro'); ?>
                        </label>
                        <p class="description"><?php _e('Log debug information for troubleshooting', 'job-automator-pro'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Import/Export Settings -->
        <div class="jap-settings-section jap-full-width">
            <div class="jap-section-header">
                <span class="dashicons dashicons-admin-tools"></span>
                <h2><?php _e('Import/Export Settings', 'job-automator-pro'); ?></h2>
            </div>
            
            <div class="jap-settings-content">
                <div class="jap-settings-row">
                    <div class="jap-setting-group">
                        <label>
                            <input type="checkbox" name="jap_export_data" value="1" 
                                   <?php checked(get_option('jap_export_data', 1), 1); ?>>
                            <?php _e('Enable Data Export', 'job-automator-pro'); ?>
                        </label>
                        <p class="description"><?php _e('Allow users to export data in JSON/CSV format', 'job-automator-pro'); ?></p>
                    </div>
                    
                    <div class="jap-setting-group">
                        <label>
                            <input type="checkbox" name="jap_import_data" value="1" 
                                   <?php checked(get_option('jap_import_data', 1), 1); ?>>
                            <?php _e('Enable Data Import', 'job-automator-pro'); ?>
                        </label>
                        <p class="description"><?php _e('Allow users to import data from JSON/CSV files', 'job-automator-pro'); ?></p>
                    </div>
                </div>
                
                <div class="jap-settings-row">
                    <div class="jap-setting-group">
                        <label for="jap_max_file_size"><?php _e('Maximum Import File Size', 'job-automator-pro'); ?></label>
                        <select id="jap_max_file_size" name="jap_max_file_size">
                            <option value="1" <?php selected(get_option('jap_max_file_size', 5), 1); ?>>1 MB</option>
                            <option value="2" <?php selected(get_option('jap_max_file_size', 5), 2); ?>>2 MB</option>
                            <option value="5" <?php selected(get_option('jap_max_file_size', 5), 5); ?>>5 MB</option>
                            <option value="10" <?php selected(get_option('jap_max_file_size', 5), 10); ?>>10 MB</option>
                        </select>
                        <p class="description"><?php _e('Maximum allowed file size for imports', 'job-automator-pro'); ?></p>
                    </div>
                    
                    <div class="jap-setting-group">
                        <label for="jap_allowed_file_types"><?php _e('Allowed File Types', 'job-automator-pro'); ?></label>
                        <input type="text" id="jap_allowed_file_types" name="jap_allowed_file_types" 
                               value="<?php echo esc_attr(get_option('jap_allowed_file_types', 'json,csv')); ?>">
                        <p class="description"><?php _e('File types allowed for import/export', 'job-automator-pro'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="jap-settings-section jap-full-width">
            <div class="jap-section-header">
                <span class="dashicons dashicons-info"></span>
                <h2><?php _e('System Information', 'job-automator-pro'); ?></h2>
            </div>
            
            <div class="jap-settings-content">
                <div class="jap-system-info-grid">
                    <div class="jap-system-info-column">
                        <h3><?php _e('Plugin Information', 'job-automator-pro'); ?></h3>
                        
                        <div class="jap-info-item">
                            <strong><?php _e('Plugin Version:', 'job-automator-pro'); ?></strong>
                            <span><?php echo JAP_VERSION; ?></span>
                        </div>
                        
                        <div class="jap-info-item">
                            <strong><?php _e('Plugin Directory:', 'job-automator-pro'); ?></strong>
                            <span><?php echo JAP_PLUGIN_PATH; ?></span>
                        </div>
                        
                        <div class="jap-info-item">
                            <strong><?php _e('Plugin URL:', 'job-automator-pro'); ?></strong>
                            <span><?php echo JAP_PLUGIN_URL; ?></span>
                        </div>
                        
                        <div class="jap-info-item">
                            <strong><?php _e('Text Domain:', 'job-automator-pro'); ?></strong>
                            <span>job-automator-pro</span>
                        </div>
                    </div>
                    
                    <div class="jap-system-info-column">
                        <h3><?php _e('System Information', 'job-automator-pro'); ?></h3>
                        
                        <div class="jap-info-item">
                            <strong><?php _e('WordPress Version:', 'job-automator-pro'); ?></strong>
                            <span><?php echo get_bloginfo('version'); ?></span>
                        </div>
                        
                        <div class="jap-info-item">
                            <strong><?php _e('PHP Version:', 'job-automator-pro'); ?></strong>
                            <span><?php echo PHP_VERSION; ?></span>
                        </div>
                        
                        <div class="jap-info-item">
                            <strong><?php _e('MySQL Version:', 'job-automator-pro'); ?></strong>
                            <span><?php echo $wpdb->db_version(); ?></span>
                        </div>
                        
                        <div class="jap-info-item">
                            <strong><?php _e('Memory Limit:', 'job-automator-pro'); ?></strong>
                            <span><?php echo ini_get('memory_limit'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Database Statistics -->
        <div class="jap-settings-section jap-full-width">
            <div class="jap-section-header">
                <span class="dashicons dashicons-database"></span>
                <h2><?php _e('Database Statistics', 'job-automator-pro'); ?></h2>
            </div>
            
            <div class="jap-settings-content">
                <?php $stats = JAP_Database::get_stats(); ?>
                <div class="jap-stats-grid">
                    <div class="jap-stat-item">
                        <div class="jap-stat-number"><?php echo esc_html($stats['companies']); ?></div>
                        <div class="jap-stat-label"><?php _e('Companies', 'job-automator-pro'); ?></div>
                    </div>
                    
                    <div class="jap-stat-item">
                        <div class="jap-stat-number"><?php echo esc_html($stats['templates']); ?></div>
                        <div class="jap-stat-label"><?php _e('Templates', 'job-automator-pro'); ?></div>
                    </div>
                    
                    <div class="jap-stat-item">
                        <div class="jap-stat-number"><?php echo esc_html($stats['fields']); ?></div>
                        <div class="jap-stat-label"><?php _e('Fields', 'job-automator-pro'); ?></div>
                    </div>
                    
                    <div class="jap-stat-item">
                        <div class="jap-stat-number"><?php echo esc_html($stats['categories']); ?></div>
                        <div class="jap-stat-label"><?php _e('Categories', 'job-automator-pro'); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="jap-settings-footer">
            <button type="submit" name="submit" class="button button-primary button-large">
                <span class="dashicons dashicons-yes"></span>
                <?php _e('Save Settings', 'job-automator-pro'); ?>
            </button>
        </div>
    </form>
</div>

<style>
.jap-settings-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    margin-bottom: 30px;
}

.jap-settings-section {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.jap-settings-section.jap-full-width {
    grid-column: 1 / -1;
    margin-bottom: 20px;
}

.jap-settings-content {
    padding: 25px;
}

.jap-setting-group {
    margin-bottom: 25px;
}

.jap-setting-group:last-child {
    margin-bottom: 0;
}

.jap-setting-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #1d1d1f;
}

.jap-setting-group input[type="text"],
.jap-setting-group input[type="number"],
.jap-setting-group select {
    width: 100%;
    max-width: 300px;
    padding: 8px 12px;
    border: 2px solid #e9ecef;
    border-radius: 6px;
    font-size: 14px;
}

.jap-permission-group {
    margin-bottom: 30px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid #4285f4;
}

.jap-permission-group h3 {
    margin: 0 0 15px 0;
    color: #1d1d1f;
}

.jap-permission-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 10px;
}

.jap-permission-list label {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
    font-weight: normal;
    cursor: pointer;
}

.jap-settings-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

.jap-system-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

.jap-system-info-column h3 {
    margin: 0 0 20px 0;
    color: #1d1d1f;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 10px;
}

.jap-info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #f1f1f1;
}

.jap-info-item:last-child {
    border-bottom: none;
}

.jap-info-item strong {
    color: #6c757d;
}

.jap-info-item span {
    color: #1d1d1f;
    font-family: monospace;
    font-size: 13px;
}

.jap-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
}

.jap-stat-item {
    text-align: center;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    border-top: 4px solid #4285f4;
}

.jap-stat-item .jap-stat-number {
    font-size: 32px;
    font-weight: 700;
    color: #1d1d1f;
    margin-bottom: 5px;
}

.jap-stat-item .jap-stat-label {
    color: #6c757d;
    font-weight: 500;
}

.jap-settings-footer {
    text-align: center;
    padding: 30px 0;
}

.jap-settings-footer .button-large {
    padding: 12px 30px;
    font-size: 16px;
    font-weight: 500;
    border-radius: 25px;
    background: linear-gradient(135deg, #4285f4 0%, #34a853 100%);
    border: none;
    color: white;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
}

.jap-settings-footer .button-large:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(66, 133, 244, 0.3);
    color: white;
}

@media (max-width: 768px) {
    .jap-settings-grid {
        grid-template-columns: 1fr;
    }
    
    .jap-settings-row {
        grid-template-columns: 1fr;
    }
    
    .jap-system-info-grid {
        grid-template-columns: 1fr;
    }
    
    .jap-permission-list {
        grid-template-columns: 1fr;
    }
}
</style>