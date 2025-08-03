<?php if (!defined('ABSPATH')) exit; ?>

<div class="wrap jap-categories">
    <div class="jap-header">
        <div class="jap-header-icon">
            <span class="dashicons dashicons-category"></span>
        </div>
        <h1 class="jap-header-title"><?php _e('Categories Management', 'job-automator-pro'); ?></h1>
    </div>

    <div class="jap-categories-grid">
        <!-- Company Categories -->
        <div class="jap-categories-section">
            <div class="jap-section-header">
                <span class="dashicons dashicons-building"></span>
                <h2><?php _e('Company Categories', 'job-automator-pro'); ?></h2>
                <button class="button button-primary jap-btn-add-category" data-type="company">
                    <span class="dashicons dashicons-plus"></span>
                    <?php _e('Add', 'job-automator-pro'); ?>
                </button>
            </div>
            
            <div class="jap-categories-table-container">
                <table class="wp-list-table widefat fixed striped jap-categories-table">
                    <thead>
                        <tr>
                            <th><?php _e('Name', 'job-automator-pro'); ?></th>
                            <th><?php _e('Color', 'job-automator-pro'); ?></th>
                            <th><?php _e('Status', 'job-automator-pro'); ?></th>
                            <th><?php _e('Actions', 'job-automator-pro'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="jap-company-categories-tbody">
                        <?php 
                        $company_categories = JAP_Database::get_company_categories();
                        if (!empty($company_categories)): 
                        ?>
                            <?php foreach ($company_categories as $category): ?>
                                <tr data-id="<?php echo esc_attr($category->id); ?>" data-type="company">
                                    <td class="category-name">
                                        <strong><?php echo esc_html($category->name); ?></strong>
                                    </td>
                                    <td class="category-color">
                                        <div class="jap-color-preview">
                                            <span class="jap-color-circle" style="background-color: <?php echo esc_attr($category->color); ?>"></span>
                                            <code><?php echo esc_html($category->color); ?></code>
                                        </div>
                                    </td>
                                    <td class="category-status">
                                        <span class="jap-status jap-status-<?php echo esc_attr($category->status); ?>">
                                            <?php echo esc_html(ucfirst($category->status)); ?>
                                        </span>
                                    </td>
                                    <td class="category-actions">
                                        <div class="jap-action-buttons">
                                            <button class="button button-small jap-btn-edit jap-btn-edit-category" 
                                                    data-id="<?php echo esc_attr($category->id); ?>" 
                                                    data-type="company"
                                                    title="<?php _e('Edit', 'job-automator-pro'); ?>">
                                                <span class="dashicons dashicons-edit"></span>
                                            </button>
                                            <button class="button button-small jap-btn-delete jap-btn-delete-category" 
                                                    data-id="<?php echo esc_attr($category->id); ?>" 
                                                    data-type="company"
                                                    title="<?php _e('Delete', 'job-automator-pro'); ?>">
                                                <span class="dashicons dashicons-trash"></span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="jap-no-results">
                                    <?php _e('No categories found.', 'job-automator-pro'); ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Template Categories -->
        <div class="jap-categories-section">
            <div class="jap-section-header">
                <span class="dashicons dashicons-media-document"></span>
                <h2><?php _e('Template Categories', 'job-automator-pro'); ?></h2>
                <button class="button button-primary jap-btn-add-category" data-type="template">
                    <span class="dashicons dashicons-plus"></span>
                    <?php _e('Add', 'job-automator-pro'); ?>
                </button>
            </div>
            
            <div class="jap-categories-table-container">
                <table class="wp-list-table widefat fixed striped jap-categories-table">
                    <thead>
                        <tr>
                            <th><?php _e('Name', 'job-automator-pro'); ?></th>
                            <th><?php _e('Color', 'job-automator-pro'); ?></th>
                            <th><?php _e('Status', 'job-automator-pro'); ?></th>
                            <th><?php _e('Actions', 'job-automator-pro'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="jap-template-categories-tbody">
                        <?php 
                        $template_categories = JAP_Database::get_template_categories();
                        if (!empty($template_categories)): 
                        ?>
                            <?php foreach ($template_categories as $category): ?>
                                <tr data-id="<?php echo esc_attr($category->id); ?>" data-type="template">
                                    <td class="category-name">
                                        <strong><?php echo esc_html($category->name); ?></strong>
                                    </td>
                                    <td class="category-color">
                                        <div class="jap-color-preview">
                                            <span class="jap-color-circle" style="background-color: <?php echo esc_attr($category->color); ?>"></span>
                                            <code><?php echo esc_html($category->color); ?></code>
                                        </div>
                                    </td>
                                    <td class="category-status">
                                        <span class="jap-status jap-status-<?php echo esc_attr($category->status); ?>">
                                            <?php echo esc_html(ucfirst($category->status)); ?>
                                        </span>
                                    </td>
                                    <td class="category-actions">
                                        <div class="jap-action-buttons">
                                            <button class="button button-small jap-btn-edit jap-btn-edit-category" 
                                                    data-id="<?php echo esc_attr($category->id); ?>" 
                                                    data-type="template"
                                                    title="<?php _e('Edit', 'job-automator-pro'); ?>">
                                                <span class="dashicons dashicons-edit"></span>
                                            </button>
                                            <button class="button button-small jap-btn-delete jap-btn-delete-category" 
                                                    data-id="<?php echo esc_attr($category->id); ?>" 
                                                    data-type="template"
                                                    title="<?php _e('Delete', 'job-automator-pro'); ?>">
                                                <span class="dashicons dashicons-trash"></span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="jap-no-results">
                                    <?php _e('No categories found.', 'job-automator-pro'); ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Category Information -->
    <div class="jap-info-section">
        <div class="jap-section-header">
            <span class="dashicons dashicons-info"></span>
            <h2><?php _e('Category Information', 'job-automator-pro'); ?></h2>
        </div>
        
        <div class="jap-info-grid">
            <div class="jap-info-column">
                <h3><?php _e('Company Categories', 'job-automator-pro'); ?></h3>
                
                <p><?php _e('Organize companies by type, industry, or any classification that makes sense for your workflow. Examples:', 'job-automator-pro'); ?></p>
                
                <div class="jap-example-list">
                    <div class="jap-example-item">
                        <strong><?php _e('Government', 'job-automator-pro'); ?></strong>
                    </div>
                    <div class="jap-example-item">
                        <strong><?php _e('Private Company', 'job-automator-pro'); ?></strong>
                    </div>
                    <div class="jap-example-item">
                        <strong><?php _e('Bank', 'job-automator-pro'); ?></strong>
                    </div>
                    <div class="jap-example-item">
                        <strong><?php _e('NGO', 'job-automator-pro'); ?></strong>
                    </div>
                    <div class="jap-example-item">
                        <strong><?php _e('University', 'job-automator-pro'); ?></strong>
                    </div>
                </div>
            </div>
            
            <div class="jap-info-column">
                <h3><?php _e('Template Categories', 'job-automator-pro'); ?></h3>
                
                <p><?php _e('Group templates by purpose or content type to make them easier to find and manage. Examples:', 'job-automator-pro'); ?></p>
                
                <div class="jap-example-list">
                    <div class="jap-example-item">
                        <strong><?php _e('Job Templates', 'job-automator-pro'); ?></strong>
                    </div>
                    <div class="jap-example-item">
                        <strong><?php _e('Notice Templates', 'job-automator-pro'); ?></strong>
                    </div>
                    <div class="jap-example-item">
                        <strong><?php _e('Announcement Templates', 'job-automator-pro'); ?></strong>
                    </div>
                    <div class="jap-example-item">
                        <strong><?php _e('Email Templates', 'job-automator-pro'); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Category Modal -->
<div id="jap-category-modal" class="jap-modal" style="display: none;">
    <div class="jap-modal-content">
        <div class="jap-modal-header">
            <h3 id="jap-category-modal-title"><?php _e('Add Category', 'job-automator-pro'); ?></h3>
            <span class="jap-modal-close">&times;</span>
        </div>
        <div class="jap-modal-body">
            <form id="jap-category-form">
                <input type="hidden" id="jap-category-id" name="category_id" value="">
                <input type="hidden" id="jap-category-type" name="category_type" value="">
                
                <div class="jap-form-group">
                    <label for="jap-category-name"><?php _e('Category Name:', 'job-automator-pro'); ?></label>
                    <input type="text" id="jap-category-name" name="category_name" required>
                </div>
                
                <div class="jap-form-group">
                    <label for="jap-category-color"><?php _e('Category Color:', 'job-automator-pro'); ?></label>
                    <div class="jap-color-input-group">
                        <input type="color" id="jap-category-color" name="category_color" value="#2c3e50">
                        <input type="text" id="jap-category-color-text" name="category_color_text" value="#2c3e50" pattern="^#[0-9A-Fa-f]{6}$">
                    </div>
                    <p class="description"><?php _e('Choose a color to represent this category visually.', 'job-automator-pro'); ?></p>
                </div>
                
                <div class="jap-form-group">
                    <label for="jap-category-status"><?php _e('Status:', 'job-automator-pro'); ?></label>
                    <select id="jap-category-status" name="category_status">
                        <option value="active"><?php _e('Active', 'job-automator-pro'); ?></option>
                        <option value="inactive"><?php _e('Inactive', 'job-automator-pro'); ?></option>
                    </select>
                </div>
                
                <div class="jap-form-actions">
                    <button type="submit" class="button button-primary"><?php _e('Save Category', 'job-automator-pro'); ?></button>
                    <button type="button" class="button jap-modal-close"><?php _e('Cancel', 'job-automator-pro'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.jap-categories-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    margin-bottom: 30px;
}

.jap-categories-section {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.jap-categories-table-container {
    overflow-x: auto;
}

.jap-color-preview {
    display: flex;
    align-items: center;
    gap: 10px;
}

.jap-color-circle {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid #e9ecef;
    display: inline-block;
}

.jap-color-input-group {
    display: flex;
    gap: 10px;
    align-items: center;
}

.jap-color-input-group input[type="color"] {
    width: 50px;
    height: 40px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.jap-color-input-group input[type="text"] {
    width: 100px;
    font-family: monospace;
}

.jap-example-list {
    display: grid;
    gap: 8px;
}

.jap-example-item {
    padding: 8px 12px;
    background: #f8f9fa;
    border-radius: 6px;
    border-left: 3px solid #4285f4;
}

@media (max-width: 768px) {
    .jap-categories-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    // Add category button
    $('.jap-btn-add-category').on('click', function() {
        var type = $(this).data('type');
        openCategoryModal(type);
    });
    
    // Edit category button
    $('.jap-btn-edit-category').on('click', function() {
        var id = $(this).data('id');
        var type = $(this).data('type');
        editCategory(id, type);
    });
    
    // Delete category button
    $('.jap-btn-delete-category').on('click', function() {
        var id = $(this).data('id');
        var type = $(this).data('type');
        
        if (confirm(jap_ajax.strings.confirm_delete)) {
            deleteCategory(id, type, $(this).closest('tr'));
        }
    });
    
    // Color input synchronization
    $('#jap-category-color').on('change', function() {
        $('#jap-category-color-text').val($(this).val());
    });
    
    $('#jap-category-color-text').on('input', function() {
        var color = $(this).val();
        if (/^#[0-9A-Fa-f]{6}$/.test(color)) {
            $('#jap-category-color').val(color);
        }
    });
    
    // Category form submission
    $('#jap-category-form').on('submit', function(e) {
        e.preventDefault();
        saveCategoryForm($(this));
    });
    
    function openCategoryModal(type) {
        $('#jap-category-modal-title').text(type === 'company' ? 'Add Company Category' : 'Add Template Category');
        $('#jap-category-form')[0].reset();
        $('#jap-category-id').val('');
        $('#jap-category-type').val(type);
        $('#jap-category-color').val('#2c3e50');
        $('#jap-category-color-text').val('#2c3e50');
        $('#jap-category-modal').fadeIn(300);
    }
    
    function editCategory(id, type) {
        // Get category data and populate form
        var $row = $('tr[data-id="' + id + '"][data-type="' + type + '"]');
        var name = $row.find('.category-name strong').text();
        var color = $row.find('.jap-color-circle').css('background-color');
        
        // Convert RGB to hex
        var hex = rgbToHex(color);
        
        $('#jap-category-modal-title').text(type === 'company' ? 'Edit Company Category' : 'Edit Template Category');
        $('#jap-category-id').val(id);
        $('#jap-category-type').val(type);
        $('#jap-category-name').val(name);
        $('#jap-category-color').val(hex);
        $('#jap-category-color-text').val(hex);
        $('#jap-category-modal').fadeIn(300);
    }
    
    function saveCategoryForm($form) {
        var formData = $form.serialize();
        formData += '&action=jap_save_category&nonce=' + jap_ajax.nonce;
        
        $.ajax({
            url: jap_ajax.ajax_url,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Error: ' + response.data);
                }
            },
            error: function() {
                alert(jap_ajax.strings.error);
            }
        });
    }
    
    function deleteCategory(id, type, $row) {
        $.ajax({
            url: jap_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'jap_delete_category',
                id: id,
                type: type,
                nonce: jap_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    $row.fadeOut(300, function() {
                        $(this).remove();
                    });
                } else {
                    alert('Error: ' + response.data);
                }
            },
            error: function() {
                alert(jap_ajax.strings.error);
            }
        });
    }
    
    function rgbToHex(rgb) {
        var result = rgb.match(/\d+/g);
        if (result) {
            return "#" + ((1 << 24) + (parseInt(result[0]) << 16) + (parseInt(result[1]) << 8) + parseInt(result[2])).toString(16).slice(1);
        }
        return '#000000';
    }
});
</script>