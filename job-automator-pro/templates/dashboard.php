<?php if (!defined('ABSPATH')) exit; ?>

<div class="wrap jap-dashboard">
    <div class="jap-header">
        <div class="jap-header-icon">
            <span class="dashicons dashicons-businessman"></span>
        </div>
        <h1 class="jap-header-title"><?php _e('Job Automator Pro Dashboard', 'job-automator-pro'); ?></h1>
    </div>

    <!-- Stats Cards -->
    <div class="jap-stats-grid">
        <div class="jap-stat-card jap-stat-companies">
            <div class="jap-stat-number"><?php echo esc_html($stats['companies']); ?></div>
            <div class="jap-stat-label"><?php _e('Companies', 'job-automator-pro'); ?></div>
        </div>
        
        <div class="jap-stat-card jap-stat-templates">
            <div class="jap-stat-number"><?php echo esc_html($stats['templates']); ?></div>
            <div class="jap-stat-label"><?php _e('Templates', 'job-automator-pro'); ?></div>
        </div>
        
        <div class="jap-stat-card jap-stat-fields">
            <div class="jap-stat-number"><?php echo esc_html($stats['fields']); ?></div>
            <div class="jap-stat-label"><?php _e('Custom Fields', 'job-automator-pro'); ?></div>
        </div>
        
        <div class="jap-stat-card jap-stat-categories">
            <div class="jap-stat-number"><?php echo esc_html($stats['categories']); ?></div>
            <div class="jap-stat-label"><?php _e('Categories', 'job-automator-pro'); ?></div>
        </div>
    </div>

    <div class="jap-dashboard-grid">
        <!-- Quick Actions -->
        <div class="jap-dashboard-section">
            <div class="jap-section-header">
                <span class="dashicons dashicons-plus-alt"></span>
                <h2><?php _e('Quick Actions', 'job-automator-pro'); ?></h2>
            </div>
            
            <div class="jap-quick-actions">
                <a href="<?php echo admin_url('admin.php?page=jap-companies&action=add'); ?>" class="jap-quick-action jap-action-company">
                    <span class="dashicons dashicons-building"></span>
                    <?php _e('Add New Company', 'job-automator-pro'); ?>
                </a>
                
                <a href="<?php echo admin_url('admin.php?page=jap-templates&action=add'); ?>" class="jap-quick-action jap-action-template">
                    <span class="dashicons dashicons-media-document"></span>
                    <?php _e('Create Template', 'job-automator-pro'); ?>
                </a>
                
                <a href="#" class="jap-quick-action jap-action-generate" id="jap-generate-job">
                    <span class="dashicons dashicons-edit"></span>
                    <?php _e('Generate Job Post', 'job-automator-pro'); ?>
                </a>
                
                <a href="#" class="jap-quick-action jap-action-import" id="jap-import-data">
                    <span class="dashicons dashicons-upload"></span>
                    <?php _e('Import Data', 'job-automator-pro'); ?>
                </a>
            </div>
        </div>

        <!-- System Information -->
        <div class="jap-dashboard-section">
            <div class="jap-section-header">
                <span class="dashicons dashicons-info"></span>
                <h2><?php _e('System Information', 'job-automator-pro'); ?></h2>
            </div>
            
            <div class="jap-system-info">
                <div class="jap-info-row">
                    <span class="jap-info-label"><?php _e('Plugin Version:', 'job-automator-pro'); ?></span>
                    <span class="jap-info-value"><?php echo JAP_VERSION; ?></span>
                </div>
                
                <div class="jap-info-row">
                    <span class="jap-info-label"><?php _e('WordPress Version:', 'job-automator-pro'); ?></span>
                    <span class="jap-info-value"><?php echo get_bloginfo('version'); ?></span>
                </div>
                
                <div class="jap-info-row">
                    <span class="jap-info-label"><?php _e('PHP Version:', 'job-automator-pro'); ?></span>
                    <span class="jap-info-value"><?php echo PHP_VERSION; ?></span>
                </div>
                
                <div class="jap-info-row">
                    <span class="jap-info-label"><?php _e('Database Version:', 'job-automator-pro'); ?></span>
                    <span class="jap-info-value"><?php echo $wpdb->db_version(); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="jap-dashboard-grid">
        <!-- Recent Companies -->
        <div class="jap-dashboard-section">
            <div class="jap-section-header">
                <span class="dashicons dashicons-building"></span>
                <h2><?php _e('Recent Companies', 'job-automator-pro'); ?></h2>
            </div>
            
            <div class="jap-recent-items">
                <?php 
                $recent_companies = JAP_Database::get_companies('', '', 5, 0);
                if (!empty($recent_companies)): 
                ?>
                    <?php foreach ($recent_companies as $company): ?>
                        <div class="jap-recent-item">
                            <div class="jap-recent-title"><?php echo esc_html($company->name); ?></div>
                            <?php if ($company->category_name): ?>
                                <div class="jap-recent-meta">
                                    <span class="jap-category-badge" style="background-color: <?php echo esc_attr($company->category_color); ?>">
                                        <?php echo esc_html($company->category_name); ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="jap-no-items"><?php _e('No companies found. Create your first company to get started.', 'job-automator-pro'); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Templates -->
        <div class="jap-dashboard-section">
            <div class="jap-section-header">
                <span class="dashicons dashicons-media-document"></span>
                <h2><?php _e('Recent Templates', 'job-automator-pro'); ?></h2>
            </div>
            
            <div class="jap-recent-items">
                <?php 
                $recent_templates = JAP_Database::get_templates('', '', 5, 0);
                if (!empty($recent_templates)): 
                ?>
                    <?php foreach ($recent_templates as $template): ?>
                        <div class="jap-recent-item">
                            <div class="jap-recent-title"><?php echo esc_html($template->name); ?></div>
                            <?php if ($template->category_name): ?>
                                <div class="jap-recent-meta">
                                    <span class="jap-category-badge" style="background-color: <?php echo esc_attr($template->category_color); ?>">
                                        <?php echo esc_html($template->category_name); ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="jap-no-items"><?php _e('No templates found. Create your first template to get started.', 'job-automator-pro'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Job Generator Modal -->
<div id="jap-job-generator-modal" class="jap-modal" style="display: none;">
    <div class="jap-modal-content">
        <div class="jap-modal-header">
            <h3><?php _e('Job Post Generator', 'job-automator-pro'); ?></h3>
            <span class="jap-modal-close">&times;</span>
        </div>
        <div class="jap-modal-body">
            <div id="jap-job-generator-content">
                <?php include JAP_PLUGIN_PATH . 'templates/job-generator.php'; ?>
            </div>
        </div>
    </div>
</div>