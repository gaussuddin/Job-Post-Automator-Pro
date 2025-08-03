<?php if (!defined('ABSPATH')) exit; ?>

<div class="wrap jap-fields">
    <div class="jap-header">
        <div class="jap-header-icon">
            <span class="dashicons dashicons-admin-settings"></span>
        </div>
        <h1 class="jap-header-title"><?php _e('Custom Fields Management', 'job-automator-pro'); ?></h1>
    </div>

    <div class="jap-toolbar">
        <div class="jap-toolbar-left">
            <div class="jap-search-box">
                <input type="text" id="jap-field-search" placeholder="<?php _e('Search fields...', 'job-automator-pro'); ?>" value="<?php echo esc_attr(isset($_GET['search']) ? $_GET['search'] : ''); ?>">
                <span class="dashicons dashicons-search"></span>
            </div>
        </div>
        
        <div class="jap-toolbar-right">
            <button class="button jap-btn-secondary" id="jap-export-fields">
                <span class="dashicons dashicons-download"></span>
                <?php _e('Export', 'job-automator-pro'); ?>
            </button>
            
            <button class="button jap-btn-secondary" id="jap-import-fields">
                <span class="dashicons dashicons-upload"></span>
                <?php _e('Import', 'job-automator-pro'); ?>
            </button>
            
            <a href="<?php echo admin_url('admin.php?page=jap-fields&action=add'); ?>" class="button button-primary jap-btn-primary">
                <span class="dashicons dashicons-plus"></span>
                <?php _e('Add Field', 'job-automator-pro'); ?>
            </a>
        </div>
    </div>

    <div class="jap-table-container">
        <table class="wp-list-table widefat fixed striped jap-fields-table">
            <thead>
                <tr>
                    <th class="sortable" data-sort="field_label">
                        <?php _e('Field Label', 'job-automator-pro'); ?>
                        <span class="dashicons dashicons-arrow-up-alt2"></span>
                    </th>
                    <th><?php _e('Field Name', 'job-automator-pro'); ?></th>
                    <th class="sortable" data-sort="field_type">
                        <?php _e('Type', 'job-automator-pro'); ?>
                        <span class="dashicons dashicons-arrow-up-alt2"></span>
                    </th>
                    <th><?php _e('Required', 'job-automator-pro'); ?></th>
                    <th><?php _e('Status', 'job-automator-pro'); ?></th>
                    <th><?php _e('Actions', 'job-automator-pro'); ?></th>
                </tr>
            </thead>
            <tbody id="jap-fields-tbody">
                <?php 
                $fields = JAP_Database::get_custom_fields();
                
                if (!empty($fields)): 
                ?>
                    <?php foreach ($fields as $field): ?>
                        <tr data-id="<?php echo esc_attr($field->id); ?>">
                            <td class="field-label">
                                <strong><?php echo esc_html($field->field_label); ?></strong>
                            </td>
                            <td class="field-name">
                                <code><?php echo esc_html($field->field_name); ?></code>
                            </td>
                            <td class="field-type">
                                <span class="jap-field-type jap-type-<?php echo esc_attr($field->field_type); ?>">
                                    <?php echo esc_html(ucfirst($field->field_type)); ?>
                                </span>
                            </td>
                            <td class="field-required">
                                <?php if ($field->is_required): ?>
                                    <span class="jap-badge jap-badge-required"><?php _e('Required', 'job-automator-pro'); ?></span>
                                <?php else: ?>
                                    <span class="jap-badge jap-badge-optional"><?php _e('Optional', 'job-automator-pro'); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="field-status">
                                <span class="jap-status jap-status-<?php echo esc_attr($field->status); ?>">
                                    <?php echo esc_html(ucfirst($field->status)); ?>
                                </span>
                            </td>
                            <td class="field-actions">
                                <div class="jap-action-buttons">
                                    <a href="<?php echo admin_url('admin.php?page=jap-fields&action=edit&id=' . $field->id); ?>" 
                                       class="button button-small jap-btn-edit" title="<?php _e('Edit', 'job-automator-pro'); ?>">
                                        <span class="dashicons dashicons-edit"></span>
                                    </a>
                                    <button class="button button-small jap-btn-delete" 
                                            data-id="<?php echo esc_attr($field->id); ?>" 
                                            title="<?php _e('Delete', 'job-automator-pro'); ?>">
                                        <span class="dashicons dashicons-trash"></span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="jap-no-results">
                            <?php _e('No results found.', 'job-automator-pro'); ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Field Information Section -->
    <div class="jap-info-section">
        <div class="jap-section-header">
            <span class="dashicons dashicons-info"></span>
            <h2><?php _e('Field Information', 'job-automator-pro'); ?></h2>
        </div>
        
        <div class="jap-info-grid">
            <div class="jap-info-column">
                <h3><?php _e('Field Types', 'job-automator-pro'); ?></h3>
                
                <div class="jap-field-type-list">
                    <div class="jap-field-type-item">
                        <strong><?php _e('Text:', 'job-automator-pro'); ?></strong>
                        <span><?php _e('Single line text input', 'job-automator-pro'); ?></span>
                    </div>
                    
                    <div class="jap-field-type-item">
                        <strong><?php _e('Textarea:', 'job-automator-pro'); ?></strong>
                        <span><?php _e('Multi-line text input', 'job-automator-pro'); ?></span>
                    </div>
                    
                    <div class="jap-field-type-item">
                        <strong><?php _e('Email:', 'job-automator-pro'); ?></strong>
                        <span><?php _e('Email address input', 'job-automator-pro'); ?></span>
                    </div>
                    
                    <div class="jap-field-type-item">
                        <strong><?php _e('URL:', 'job-automator-pro'); ?></strong>
                        <span><?php _e('Website URL input', 'job-automator-pro'); ?></span>
                    </div>
                    
                    <div class="jap-field-type-item">
                        <strong><?php _e('Number:', 'job-automator-pro'); ?></strong>
                        <span><?php _e('Numeric input', 'job-automator-pro'); ?></span>
                    </div>
                    
                    <div class="jap-field-type-item">
                        <strong><?php _e('Date:', 'job-automator-pro'); ?></strong>
                        <span><?php _e('Date picker', 'job-automator-pro'); ?></span>
                    </div>
                    
                    <div class="jap-field-type-item">
                        <strong><?php _e('Select:', 'job-automator-pro'); ?></strong>
                        <span><?php _e('Dropdown selection', 'job-automator-pro'); ?></span>
                    </div>
                    
                    <div class="jap-field-type-item">
                        <strong><?php _e('Checkbox:', 'job-automator-pro'); ?></strong>
                        <span><?php _e('Yes/No checkbox', 'job-automator-pro'); ?></span>
                    </div>
                </div>
            </div>
            
            <div class="jap-info-column">
                <h3><?php _e('Usage in Templates', 'job-automator-pro'); ?></h3>
                
                <p><?php _e('Custom fields can be used in templates using the following syntax:', 'job-automator-pro'); ?></p>
                
                <div class="jap-code-example">
                    <code>{{field_name}}</code>
                </div>
                
                <p class="description">
                    <?php _e('Replace "field_name" with the actual field name. Field names must be unique and contain only lowercase letters, numbers, and underscores.', 'job-automator-pro'); ?>
                </p>
            </div>
        </div>
    </div>
</div>