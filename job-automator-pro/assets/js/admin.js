// Job Automator Pro Admin JavaScript

(function($) {
    'use strict';

    // Global variables
    var JAP = {
        selectedCompany: null,
        selectedTemplate: null,
        currentStep: 1
    };

    // Initialize when document is ready
    $(document).ready(function() {
        initDashboard();
        initJobGenerator();
        initModals();
        initSearch();
        initTables();
        initForms();
    });

    // Initialize dashboard functionality
    function initDashboard() {
        // Quick action buttons
        $('#jap-generate-job').on('click', function(e) {
            e.preventDefault();
            openJobGeneratorModal();
        });

        $('#jap-import-data').on('click', function(e) {
            e.preventDefault();
            openImportModal();
        });

        // Stats card hover effects
        $('.jap-stat-card').hover(
            function() {
                $(this).addClass('jap-card-hover');
            },
            function() {
                $(this).removeClass('jap-card-hover');
            }
        );
    }

    // Initialize job generator
    function initJobGenerator() {
        // Step navigation
        $('.jap-step-header').on('click', function() {
            var step = $(this).parent().data('step');
            if (step <= JAP.currentStep + 1) {
                activateStep(step);
            }
        });

        // Company selection
        $(document).on('click', '.jap-btn-select-company', function() {
            var companyId = $(this).data('id');
            selectCompany(companyId);
        });

        // Template selection
        $(document).on('click', '.jap-btn-select-template', function() {
            var templateId = $(this).data('id');
            selectTemplate(templateId);
        });

        // Template filtering
        $('#jap-template-category-filter').on('change', function() {
            filterTemplates($(this).val());
        });

        // Company search
        $('#jap-company-search-input').on('input', function() {
            searchCompanies($(this).val());
        });

        // Generate content
        $('#jap-generate-content').on('click', function() {
            generateJobPost();
        });

        // Change selections
        $('.jap-btn-change-company').on('click', function() {
            changeCompany();
        });

        $('.jap-btn-change-template').on('click', function() {
            changeTemplate();
        });

        // Preview actions
        $('#jap-hide-preview').on('click', function() {
            hidePreview();
        });

        $('#jap-insert-to-editor').on('click', function() {
            insertToEditor();
        });

        $('#jap-copy-to-clipboard').on('click', function() {
            copyToClipboard();
        });

        // Debug and clear options
        $('#jap-clear-all').on('change', function() {
            if ($(this).is(':checked')) {
                clearAllSelections();
            }
        });
    }

    // Initialize modals
    function initModals() {
        // Close modal handlers
        $(document).on('click', '.jap-modal-close', function() {
            closeModal();
        });

        $(document).on('click', '.jap-modal', function(e) {
            if ($(e.target).hasClass('jap-modal')) {
                closeModal();
            }
        });

        // Import modal
        $('#jap-import-companies, #jap-import-templates, #jap-import-fields').on('click', function() {
            openImportModal();
        });

        // Export functionality
        $('#jap-export-companies, #jap-export-templates, #jap-export-fields').on('click', function() {
            var type = $(this).attr('id').replace('jap-export-', '');
            exportData(type);
        });
    }

    // Initialize search functionality
    function initSearch() {
        // Search inputs with debounce
        var searchTimeout;
        $('.jap-search-box input').on('input', function() {
            var $input = $(this);
            var query = $input.val();
            
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                performSearch(query, $input);
            }, 300);
        });

        // Filter dropdowns
        $('.jap-filter-box select').on('change', function() {
            var $select = $(this);
            var value = $select.val();
            performFilter(value, $select);
        });
    }

    // Initialize table functionality
    function initTables() {
        // Sortable headers
        $('.sortable').on('click', function() {
            var column = $(this).data('sort');
            var direction = $(this).hasClass('sort-desc') ? 'asc' : 'desc';
            
            // Remove sorting from other columns
            $('.sortable').removeClass('sort-asc sort-desc');
            
            // Add sorting to current column
            $(this).addClass('sort-' + direction);
            
            sortTable(column, direction);
        });

        // Delete buttons
        $(document).on('click', '.jap-btn-delete', function() {
            var id = $(this).data('id');
            var type = getTableType($(this));
            
            if (confirm(jap_ajax.strings.confirm_delete)) {
                deleteItem(id, type, $(this).closest('tr'));
            }
        });

        // Table row hover effects
        $('table tbody tr').hover(
            function() {
                $(this).addClass('jap-row-hover');
            },
            function() {
                $(this).removeClass('jap-row-hover');
            }
        );
    }

    // Initialize forms
    function initForms() {
        // Import form submission
        $('#jap-import-form').on('submit', function(e) {
            e.preventDefault();
            submitImportForm($(this));
        });

        // Form validation
        $('form').on('submit', function(e) {
            if (!validateForm($(this))) {
                e.preventDefault();
            }
        });
    }

    // Job Generator Functions
    function openJobGeneratorModal() {
        $('#jap-job-generator-modal').fadeIn(300);
        resetJobGenerator();
    }

    function activateStep(step) {
        $('.jap-generator-step').removeClass('jap-step-active');
        $('.jap-generator-step[data-step="' + step + '"]').addClass('jap-step-active');
        JAP.currentStep = step;
    }

    function selectCompany(companyId) {
        showLoading('.jap-company-list');
        
        $.ajax({
            url: jap_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'jap_get_company',
                company_id: companyId,
                nonce: jap_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    JAP.selectedCompany = response.data;
                    displaySelectedCompany(response.data);
                    $('.jap-company-list').hide();
                    $('#jap-selected-company').show();
                    activateStep(2);
                } else {
                    showError(response.data);
                }
            },
            error: function() {
                showError(jap_ajax.strings.error);
            },
            complete: function() {
                hideLoading('.jap-company-list');
            }
        });
    }

    function selectTemplate(templateId) {
        showLoading('.jap-template-grid');
        
        $.ajax({
            url: jap_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'jap_get_template',
                template_id: templateId,
                nonce: jap_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    JAP.selectedTemplate = response.data;
                    displaySelectedTemplate(response.data);
                    $('.jap-template-grid').hide();
                    $('#jap-selected-template').show();
                    activateStep(3);
                } else {
                    showError(response.data);
                }
            },
            error: function() {
                showError(jap_ajax.strings.error);
            },
            complete: function() {
                hideLoading('.jap-template-grid');
            }
        });
    }

    function generateJobPost() {
        if (!JAP.selectedCompany || !JAP.selectedTemplate) {
            showError('Please select both a company and template first.');
            return;
        }

        showLoading('#jap-generate-content');
        
        $.ajax({
            url: jap_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'jap_generate_job_post',
                company_id: JAP.selectedCompany.id,
                template_id: JAP.selectedTemplate.id,
                nonce: jap_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    displayGeneratedContent(response.data.content);
                    $('#jap-content-preview').show();
                } else {
                    showError(response.data);
                }
            },
            error: function() {
                showError(jap_ajax.strings.error);
            },
            complete: function() {
                hideLoading('#jap-generate-content');
            }
        });
    }

    function displaySelectedCompany(company) {
        var html = '<div class="jap-company-card">';
        html += '<h4>' + company.name + '</h4>';
        if (company.category_name) {
            html += '<span class="jap-category-badge" style="background-color: ' + company.category_color + '">';
            html += company.category_name + '</span>';
        }
        if (company.email) {
            html += '<p><strong>Email:</strong> ' + company.email + '</p>';
        }
        if (company.phone) {
            html += '<p><strong>Phone:</strong> ' + company.phone + '</p>';
        }
        html += '</div>';
        
        $('#jap-selected-company-content').html(html);
    }

    function displaySelectedTemplate(template) {
        var html = '<div class="jap-template-card">';
        html += '<h4>' + template.name + '</h4>';
        if (template.category_name) {
            html += '<span class="jap-category-badge" style="background-color: ' + template.category_color + '">';
            html += template.category_name + '</span>';
        }
        html += '<div class="jap-template-content">' + template.content.substring(0, 200) + '...</div>';
        html += '</div>';
        
        $('#jap-selected-template-content').html(html);
    }

    function displayGeneratedContent(content) {
        $('#jap-preview-content').html(content);
    }

    function changeCompany() {
        JAP.selectedCompany = null;
        $('#jap-selected-company').hide();
        $('.jap-company-list').show();
        $('.jap-company-item').removeClass('selected');
        activateStep(1);
    }

    function changeTemplate() {
        JAP.selectedTemplate = null;
        $('#jap-selected-template').hide();
        $('.jap-template-grid').show();
        $('.jap-template-item').removeClass('selected');
        activateStep(2);
    }

    function clearAllSelections() {
        JAP.selectedCompany = null;
        JAP.selectedTemplate = null;
        resetJobGenerator();
    }

    function resetJobGenerator() {
        JAP.currentStep = 1;
        activateStep(1);
        $('#jap-selected-company').hide();
        $('#jap-selected-template').hide();
        $('#jap-content-preview').hide();
        $('.jap-company-list').show();
        $('.jap-template-grid').show();
        $('.jap-company-item, .jap-template-item').removeClass('selected');
        $('#jap-clear-all, #jap-toggle-debug').prop('checked', false);
    }

    function hidePreview() {
        $('#jap-content-preview').fadeOut(300);
    }

    function insertToEditor() {
        var content = $('#jap-preview-content').html();
        
        // Try to insert into WordPress editor if available
        if (typeof tinymce !== 'undefined' && tinymce.activeEditor) {
            tinymce.activeEditor.setContent(content);
            showSuccess('Content inserted into editor.');
        } else if (typeof wp !== 'undefined' && wp.editor) {
            wp.editor.getDefaultPostFormat = function() { return 'html'; };
            showSuccess('Content ready for editor.');
        } else {
            copyToClipboard();
        }
        
        closeModal();
    }

    function copyToClipboard() {
        var content = $('#jap-preview-content').html();
        
        if (navigator.clipboard) {
            navigator.clipboard.writeText(content).then(function() {
                showSuccess('Content copied to clipboard.');
            });
        } else {
            // Fallback for older browsers
            var textArea = document.createElement('textarea');
            textArea.value = content;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showSuccess('Content copied to clipboard.');
        }
    }

    // Search and Filter Functions
    function performSearch(query, $input) {
        var page = $input.closest('.wrap').attr('class');
        
        if (page.includes('jap-companies')) {
            searchItems('companies', query);
        } else if (page.includes('jap-templates')) {
            searchItems('templates', query);
        } else if (page.includes('jap-fields')) {
            searchItems('fields', query);
        }
    }

    function performFilter(value, $select) {
        var page = $select.closest('.wrap').attr('class');
        
        if (page.includes('jap-companies')) {
            filterItems('companies', 'category', value);
        } else if (page.includes('jap-templates')) {
            filterItems('templates', 'category', value);
        }
    }

    function searchItems(type, query) {
        showLoading('.jap-table-container');
        
        $.ajax({
            url: jap_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'jap_search_' + type,
                search: query,
                nonce: jap_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    updateTable(response.data.html);
                } else {
                    showError(response.data);
                }
            },
            error: function() {
                showError(jap_ajax.strings.error);
            },
            complete: function() {
                hideLoading('.jap-table-container');
            }
        });
    }

    function filterItems(type, filterType, value) {
        showLoading('.jap-table-container');
        
        $.ajax({
            url: jap_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'jap_filter_' + type,
                filter_type: filterType,
                filter_value: value,
                nonce: jap_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    updateTable(response.data.html);
                } else {
                    showError(response.data);
                }
            },
            error: function() {
                showError(jap_ajax.strings.error);
            },
            complete: function() {
                hideLoading('.jap-table-container');
            }
        });
    }

    function filterTemplates(categoryId) {
        if (categoryId === '') {
            $('.jap-template-item').show();
        } else {
            $('.jap-template-item').hide();
            $('.jap-template-item[data-category="' + categoryId + '"]').show();
        }
    }

    function searchCompanies(query) {
        if (query === '') {
            $('.jap-company-item').show();
            return;
        }
        
        $('.jap-company-item').each(function() {
            var companyName = $(this).find('.jap-company-name').text().toLowerCase();
            if (companyName.includes(query.toLowerCase())) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    // Table Functions
    function sortTable(column, direction) {
        // Implementation would depend on current table data
        // For now, trigger AJAX request to get sorted data
        var currentPage = getCurrentPage();
        
        $.ajax({
            url: jap_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'jap_sort_' + currentPage,
                column: column,
                direction: direction,
                nonce: jap_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    updateTable(response.data.html);
                }
            }
        });
    }

    function deleteItem(id, type, $row) {
        showLoading($row);
        
        $.ajax({
            url: jap_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'jap_delete_' + type,
                id: id,
                nonce: jap_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    $row.fadeOut(300, function() {
                        $(this).remove();
                    });
                    showSuccess(jap_ajax.strings.success);
                } else {
                    showError(response.data);
                }
            },
            error: function() {
                showError(jap_ajax.strings.error);
            },
            complete: function() {
                hideLoading($row);
            }
        });
    }

    function updateTable(html) {
        $('.jap-table-container tbody').html(html);
    }

    // Modal Functions
    function openImportModal() {
        $('#jap-import-modal').fadeIn(300);
    }

    function closeModal() {
        $('.jap-modal').fadeOut(300);
    }

    function submitImportForm($form) {
        var formData = new FormData($form[0]);
        formData.append('action', 'jap_import_data');
        formData.append('nonce', jap_ajax.nonce);
        
        showLoading($form);
        
        $.ajax({
            url: jap_ajax.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showSuccess('Data imported successfully.');
                    closeModal();
                    location.reload();
                } else {
                    showError(response.data);
                }
            },
            error: function() {
                showError(jap_ajax.strings.error);
            },
            complete: function() {
                hideLoading($form);
            }
        });
    }

    // Export Functions
    function exportData(type) {
        window.location.href = jap_ajax.ajax_url + '?action=jap_export_' + type + '&nonce=' + jap_ajax.nonce;
    }

    // Utility Functions
    function showLoading($element) {
        if (typeof $element === 'string') {
            $element = $($element);
        }
        $element.addClass('jap-loading');
    }

    function hideLoading($element) {
        if (typeof $element === 'string') {
            $element = $($element);
        }
        $element.removeClass('jap-loading');
    }

    function showSuccess(message) {
        showNotification(message, 'success');
    }

    function showError(message) {
        showNotification(message, 'error');
    }

    function showNotification(message, type) {
        var $notification = $('<div class="jap-notification jap-notification-' + type + '">' + message + '</div>');
        $('body').append($notification);
        
        $notification.fadeIn(300).delay(3000).fadeOut(300, function() {
            $(this).remove();
        });
    }

    function validateForm($form) {
        var isValid = true;
        
        $form.find('[required]').each(function() {
            if (!$(this).val().trim()) {
                $(this).addClass('jap-field-error');
                isValid = false;
            } else {
                $(this).removeClass('jap-field-error');
            }
        });
        
        return isValid;
    }

    function getTableType($element) {
        var $table = $element.closest('table');
        
        if ($table.hasClass('jap-companies-table')) {
            return 'company';
        } else if ($table.hasClass('jap-templates-table')) {
            return 'template';
        } else if ($table.hasClass('jap-fields-table')) {
            return 'field';
        }
        
        return 'item';
    }

    function getCurrentPage() {
        var $wrap = $('.wrap');
        
        if ($wrap.hasClass('jap-companies')) {
            return 'companies';
        } else if ($wrap.hasClass('jap-templates')) {
            return 'templates';
        } else if ($wrap.hasClass('jap-fields')) {
            return 'fields';
        }
        
        return 'dashboard';
    }

    // CSS for notifications
    var notificationCSS = `
        .jap-notification {
            position: fixed;
            top: 32px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 6px;
            color: white;
            font-weight: 500;
            z-index: 100001;
            display: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        
        .jap-notification-success {
            background: #4caf50;
        }
        
        .jap-notification-error {
            background: #f44336;
        }
        
        .jap-field-error {
            border-color: #f44336 !important;
            box-shadow: 0 0 0 3px rgba(244, 67, 54, 0.1) !important;
        }
    `;
    
    $('<style>').text(notificationCSS).appendTo('head');

})(jQuery);