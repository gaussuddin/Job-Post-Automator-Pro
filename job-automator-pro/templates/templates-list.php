<?php if (!defined('ABSPATH')) exit; ?>

<div class="wrap jap-templates">
    <div class="jap-header">
        <div class="jap-header-icon">
            <span class="dashicons dashicons-media-document"></span>
        </div>
        <h1 class="jap-header-title"><?php _e('Templates Management', 'job-automator-pro'); ?></h1>
    </div>

    <div class="jap-toolbar">
        <div class="jap-toolbar-left">
            <div class="jap-search-box">
                <input type="text" id="jap-template-search" placeholder="<?php _e('Search templates...', 'job-automator-pro'); ?>" value="<?php echo esc_attr(isset($_GET['search']) ? $_GET['search'] : ''); ?>">
                <span class="dashicons dashicons-search"></span>
            </div>
        </div>
        
        <div class="jap-toolbar-right">
            <button class="button jap-btn-secondary" id="jap-export-templates">
                <span class="dashicons dashicons-download"></span>
                <?php _e('Export', 'job-automator-pro'); ?>
            </button>
            
            <button class="button jap-btn-secondary" id="jap-import-templates">
                <span class="dashicons dashicons-upload"></span>
                <?php _e('Import', 'job-automator-pro'); ?>
            </button>
            
            <a href="<?php echo admin_url('admin.php?page=jap-templates&action=add'); ?>" class="button button-primary jap-btn-primary">
                <span class="dashicons dashicons-plus"></span>
                <?php _e('Add Template', 'job-automator-pro'); ?>
            </a>
        </div>
    </div>

    <div class="jap-table-container">
        <table class="wp-list-table widefat fixed striped jap-templates-table">
            <thead>
                <tr>
                    <th class="sortable" data-sort="name">
                        <?php _e('Template Name', 'job-automator-pro'); ?>
                        <span class="dashicons dashicons-arrow-up-alt2"></span>
                    </th>
                    <th class="sortable" data-sort="category">
                        <?php _e('Category', 'job-automator-pro'); ?>
                        <span class="dashicons dashicons-arrow-up-alt2"></span>
                    </th>
                    <th><?php _e('Description', 'job-automator-pro'); ?></th>
                    <th><?php _e('Status', 'job-automator-pro'); ?></th>
                    <th><?php _e('Actions', 'job-automator-pro'); ?></th>
                </tr>
            </thead>
            <tbody id="jap-templates-tbody">
                <?php 
                $search = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
                $category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
                $templates = JAP_Database::get_templates($search, $category, 20, 0);
                
                if (!empty($templates)): 
                ?>
                    <?php foreach ($templates as $template): ?>
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
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="jap-no-results">
                            <?php _e('No results found.', 'job-automator-pro'); ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="jap-pagination">
        <div class="jap-pagination-info">
            <?php
            $total = count($templates);
            if ($total > 0) {
                printf(__('Showing %d results', 'job-automator-pro'), $total);
            }
            ?>
        </div>
        
        <div class="jap-pagination-links">
            <!-- Pagination will be handled by JavaScript -->
        </div>
    </div>
</div>