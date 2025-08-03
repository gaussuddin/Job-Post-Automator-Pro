<?php if (!defined('ABSPATH')) exit; ?>

<div class="wrap jap-companies">
    <div class="jap-header">
        <div class="jap-header-icon">
            <span class="dashicons dashicons-building"></span>
        </div>
        <h1 class="jap-header-title"><?php _e('Companies Management', 'job-automator-pro'); ?></h1>
    </div>

    <div class="jap-toolbar">
        <div class="jap-toolbar-left">
            <div class="jap-search-box">
                <input type="text" id="jap-company-search" placeholder="<?php _e('Search companies...', 'job-automator-pro'); ?>" value="<?php echo esc_attr(isset($_GET['search']) ? $_GET['search'] : ''); ?>">
                <span class="dashicons dashicons-search"></span>
            </div>
            
            <div class="jap-filter-box">
                <select id="jap-category-filter">
                    <option value=""><?php _e('All Categories', 'job-automator-pro'); ?></option>
                    <?php 
                    $categories = JAP_Database::get_company_categories();
                    foreach ($categories as $category): 
                    ?>
                        <option value="<?php echo esc_attr($category->id); ?>" <?php selected(isset($_GET['category']) ? $_GET['category'] : '', $category->id); ?>>
                            <?php echo esc_html($category->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="dashicons dashicons-arrow-down-alt2"></span>
            </div>
        </div>
        
        <div class="jap-toolbar-right">
            <button class="button jap-btn-secondary" id="jap-export-companies">
                <span class="dashicons dashicons-download"></span>
                <?php _e('Export', 'job-automator-pro'); ?>
            </button>
            
            <button class="button jap-btn-secondary" id="jap-import-companies">
                <span class="dashicons dashicons-upload"></span>
                <?php _e('Import', 'job-automator-pro'); ?>
            </button>
            
            <a href="<?php echo admin_url('admin.php?page=jap-companies&action=add'); ?>" class="button button-primary jap-btn-primary">
                <span class="dashicons dashicons-plus"></span>
                <?php _e('Add Company', 'job-automator-pro'); ?>
            </a>
        </div>
    </div>

    <div class="jap-table-container">
        <table class="wp-list-table widefat fixed striped jap-companies-table">
            <thead>
                <tr>
                    <th class="sortable" data-sort="name">
                        <?php _e('Company Name', 'job-automator-pro'); ?>
                        <span class="dashicons dashicons-arrow-up-alt2"></span>
                    </th>
                    <th class="sortable" data-sort="category">
                        <?php _e('Category', 'job-automator-pro'); ?>
                        <span class="dashicons dashicons-arrow-up-alt2"></span>
                    </th>
                    <th><?php _e('Email', 'job-automator-pro'); ?></th>
                    <th><?php _e('Phone', 'job-automator-pro'); ?></th>
                    <th><?php _e('Status', 'job-automator-pro'); ?></th>
                    <th><?php _e('Actions', 'job-automator-pro'); ?></th>
                </tr>
            </thead>
            <tbody id="jap-companies-tbody">
                <?php 
                $search = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
                $category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
                $companies = JAP_Database::get_companies($search, $category, 20, 0);
                
                if (!empty($companies)): 
                ?>
                    <?php foreach ($companies as $company): ?>
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

    <div class="jap-pagination">
        <div class="jap-pagination-info">
            <?php
            $total = count($companies);
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

<!-- Import Modal -->
<div id="jap-import-modal" class="jap-modal" style="display: none;">
    <div class="jap-modal-content">
        <div class="jap-modal-header">
            <h3><?php _e('Import Companies', 'job-automator-pro'); ?></h3>
            <span class="jap-modal-close">&times;</span>
        </div>
        <div class="jap-modal-body">
            <form id="jap-import-form" enctype="multipart/form-data">
                <div class="jap-form-group">
                    <label for="jap-import-file"><?php _e('Select File:', 'job-automator-pro'); ?></label>
                    <input type="file" id="jap-import-file" name="import_file" accept=".csv,.json" required>
                    <p class="description"><?php _e('Supported formats: CSV, JSON', 'job-automator-pro'); ?></p>
                </div>
                
                <div class="jap-form-actions">
                    <button type="submit" class="button button-primary"><?php _e('Import', 'job-automator-pro'); ?></button>
                    <button type="button" class="button jap-modal-close"><?php _e('Cancel', 'job-automator-pro'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>