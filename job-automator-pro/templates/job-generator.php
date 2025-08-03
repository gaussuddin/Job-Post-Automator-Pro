<?php if (!defined('ABSPATH')) exit; ?>

<div class="jap-job-generator">
    <div class="jap-generator-header">
        <h2><?php _e('Job Post Generator', 'job-automator-pro'); ?></h2>
        <p><?php _e('Generate professional job posts using company data and templates', 'job-automator-pro'); ?></p>
    </div>

    <form id="jap-job-generator-form">
        <!-- Step 1: Select Company -->
        <div class="jap-generator-step jap-step-active" data-step="1">
            <div class="jap-step-header">
                <div class="jap-step-number">1</div>
                <div class="jap-step-title"><?php _e('Step 1: Select Company', 'job-automator-pro'); ?></div>
            </div>
            
            <div class="jap-step-content">
                <div class="jap-company-search">
                    <input type="text" id="jap-company-search-input" placeholder="<?php _e('Search companies...', 'job-automator-pro'); ?>">
                </div>
                
                <div class="jap-company-list" id="jap-company-list">
                    <?php 
                    $companies = JAP_Database::get_companies('', '', 10, 0);
                    foreach ($companies as $company): 
                    ?>
                        <div class="jap-company-item" data-id="<?php echo esc_attr($company->id); ?>">
                            <div class="jap-company-info">
                                <div class="jap-company-name"><?php echo esc_html($company->name); ?></div>
                                <?php if ($company->category_name): ?>
                                    <span class="jap-category-badge" style="background-color: <?php echo esc_attr($company->category_color); ?>">
                                        <?php echo esc_html($company->category_name); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="jap-company-actions">
                                <button type="button" class="button jap-btn-select-company" data-id="<?php echo esc_attr($company->id); ?>">
                                    <?php _e('Select', 'job-automator-pro'); ?>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="jap-selected-company" id="jap-selected-company" style="display: none;">
                    <div class="jap-selected-header">
                        <h4><?php _e('Selected Company:', 'job-automator-pro'); ?></h4>
                        <button type="button" class="button jap-btn-change-company"><?php _e('Change', 'job-automator-pro'); ?></button>
                    </div>
                    <div class="jap-selected-content" id="jap-selected-company-content">
                        <!-- Selected company will be displayed here -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Select Template -->
        <div class="jap-generator-step" data-step="2">
            <div class="jap-step-header">
                <div class="jap-step-number">2</div>
                <div class="jap-step-title"><?php _e('Step 2: Select Template', 'job-automator-pro'); ?></div>
            </div>
            
            <div class="jap-step-content">
                <div class="jap-template-filter">
                    <label for="jap-template-category-filter"><?php _e('Filter by Category:', 'job-automator-pro'); ?></label>
                    <select id="jap-template-category-filter">
                        <option value=""><?php _e('All Categories', 'job-automator-pro'); ?></option>
                        <?php 
                        $template_categories = JAP_Database::get_template_categories();
                        foreach ($template_categories as $category): 
                        ?>
                            <option value="<?php echo esc_attr($category->id); ?>">
                                <?php echo esc_html($category->name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="jap-template-grid" id="jap-template-grid">
                    <?php 
                    $templates = JAP_Database::get_templates('', '', 20, 0);
                    foreach ($templates as $template): 
                    ?>
                        <div class="jap-template-item" data-id="<?php echo esc_attr($template->id); ?>" data-category="<?php echo esc_attr($template->category_id); ?>">
                            <div class="jap-template-header">
                                <h4><?php echo esc_html($template->name); ?></h4>
                                <?php if ($template->category_name): ?>
                                    <span class="jap-category-badge" style="background-color: <?php echo esc_attr($template->category_color); ?>">
                                        <?php echo esc_html($template->category_name); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="jap-template-preview">
                                <?php echo esc_html(wp_trim_words($template->content, 20, '...')); ?>
                            </div>
                            <div class="jap-template-actions">
                                <button type="button" class="button jap-btn-select-template" data-id="<?php echo esc_attr($template->id); ?>">
                                    <?php _e('Select', 'job-automator-pro'); ?>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="jap-selected-template" id="jap-selected-template" style="display: none;">
                    <div class="jap-selected-header">
                        <h4><?php _e('Selected Template:', 'job-automator-pro'); ?></h4>
                        <button type="button" class="button jap-btn-change-template"><?php _e('Change', 'job-automator-pro'); ?></button>
                    </div>
                    <div class="jap-selected-content" id="jap-selected-template-content">
                        <!-- Selected template will be displayed here -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3: Generate Content -->
        <div class="jap-generator-step" data-step="3">
            <div class="jap-step-header">
                <div class="jap-step-number">3</div>
                <div class="jap-step-title"><?php _e('Step 3: Generate Content', 'job-automator-pro'); ?></div>
            </div>
            
            <div class="jap-step-content">
                <div class="jap-generator-actions">
                    <button type="button" id="jap-generate-content" class="button button-primary">
                        <span class="dashicons dashicons-admin-tools"></span>
                        <?php _e('Generate Job Post', 'job-automator-pro'); ?>
                    </button>
                    
                    <div class="jap-generator-options">
                        <label>
                            <input type="checkbox" id="jap-clear-all" />
                            <?php _e('Clear All', 'job-automator-pro'); ?>
                        </label>
                        
                        <label>
                            <input type="checkbox" id="jap-toggle-debug" />
                            <?php _e('Toggle Debug', 'job-automator-pro'); ?>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Content Preview -->
    <div class="jap-content-preview" id="jap-content-preview" style="display: none;">
        <div class="jap-preview-header">
            <h3><?php _e('Content Preview', 'job-automator-pro'); ?></h3>
            <div class="jap-preview-actions">
                <button type="button" id="jap-hide-preview" class="button"><?php _e('Hide Preview', 'job-automator-pro'); ?></button>
            </div>
        </div>
        
        <div class="jap-preview-content" id="jap-preview-content">
            <!-- Generated content will be displayed here -->
        </div>
        
        <div class="jap-preview-footer">
            <button type="button" id="jap-insert-to-editor" class="button button-primary">
                <span class="dashicons dashicons-edit"></span>
                <?php _e('Insert to Editor', 'job-automator-pro'); ?>
            </button>
            
            <button type="button" id="jap-copy-to-clipboard" class="button">
                <span class="dashicons dashicons-admin-page"></span>
                <?php _e('Copy HTML to Clipboard', 'job-automator-pro'); ?>
            </button>
        </div>
    </div>
</div>

<script type="text/template" id="jap-generated-content-template">
    <div class="jap-generated-post">
        <p>BPATC job circular 2025 has been published. Bangladesh Public Administration Training Centre has 
        released the job circular PDF and notice on its official website www.bpatc.gov.bd and in daily newspapers. 
        Interested eligible male and female candidates can submit job application online through the 
        bpatc.teletalk.com.bd website. If you're seeking Bangladesh Public Administration Training Centre job 
        circular 2025, this post is crucial for you. In this article, we will discuss the entire BPATC job circular, 
        covering details such as exam names, eligibility criteria, application procedures, selection process, 
        important dates and much more. So, read the full article carefully to get complete information about 
        BPATC job circular 2025.</p>

        <h3 style="text-align: center; color: #007cba;">BPATC Job Circular 2025</h3>

        <p>BPATC job circular 2025 has been published on 19 June 2025 in the daily Jugantor newspaper and 
        www.bpatc.gov.bd. A total of 5 people of 5 categories of posts through this BPATC circular 2025. 
        The job application will start on 26 June 2025 at 10:00 AM and will end on 20 July 2025 at 5:00 PM. 
        The BPATC job application official website is bpatc.teletalk.com.bd.</p>

        <h3 style="text-align: center; color: #007cba;">BPATC Job Total Vacancy</h3>

        <table border="1" style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr style="background-color: #f5f5f5;">
                <th style="padding: 10px; text-align: center;">Total Post Category</th>
                <th style="padding: 10px; text-align: center;">Total Vacancies</th>
            </tr>
            <tr>
                <td style="padding: 10px; text-align: center;">04</td>
                <td style="padding: 10px; text-align: center;">05</td>
            </tr>
        </table>

        <h3 style="text-align: center; color: #007cba;">BPATC Job Post Name and Vacancy Details</h3>

        <table border="1" style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr style="background-color: #f5f5f5;">
                <th style="padding: 10px;">Sl No</th>
                <th style="padding: 10px;">Post Name</th>
                <th style="padding: 10px;">Number of Vacancies</th>
                <th style="padding: 10px;">Job Details</th>
            </tr>
            <tr>
                <td style="padding: 10px; text-align: center;">01</td>
                <td style="padding: 10px;">Research Officer</td>
                <td style="padding: 10px; text-align: center;">02</td>
                <td style="padding: 10px;">Full Details</td>
            </tr>
        </table>
    </div>
</script>