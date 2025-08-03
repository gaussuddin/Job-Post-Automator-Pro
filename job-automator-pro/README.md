# Job Automator Pro - WordPress Plugin

A professional WordPress plugin for automating job post creation with company management, template system, and custom fields.

## Features

### 🏢 Company Management
- Create and manage unlimited companies
- Categorize companies by type (Government, Private, NGO, etc.)
- Store company contact information (email, phone)
- Custom field support for additional company data

### 📄 Template System
- Create reusable job post templates
- Template categories for better organization
- Dynamic placeholder system ({{company_name}}, {{company_email}}, etc.)
- Rich text editing with WordPress editor integration

### 🔧 Custom Fields
- Create custom fields for companies
- Multiple field types: text, textarea, email, URL, number, date, select, checkbox
- Required/optional field validation
- Easy integration with templates using {{field_name}} syntax

### 🎨 Categories Management
- Separate categories for companies and templates
- Color-coded category system
- Visual organization and filtering

### ⚡ Job Post Generator
- 3-step wizard interface
- Company and template selection
- Real-time content preview
- Generated content with professional formatting
- Copy to clipboard or insert to WordPress editor

### 🎛️ Settings & Permissions
- Role-based access control
- Customizable user permissions for each feature
- Import/export functionality
- System information dashboard
- Database statistics

### 🎨 Modern UI/UX
- Beautiful, responsive admin interface
- Modern card-based design
- Interactive modals and forms
- Real-time search and filtering
- Loading states and animations

## Installation

1. Download the plugin files
2. Upload the `job-automator-pro` folder to `/wp-content/plugins/`
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Access the plugin via 'Job Automator Pro' in the WordPress admin menu

## Usage

### Getting Started

1. **Add Categories**: Go to Categories page and create company/template categories
2. **Create Custom Fields**: Define custom fields for storing additional company data
3. **Add Companies**: Create companies with contact information and custom field values
4. **Create Templates**: Build job post templates with placeholders
5. **Generate Job Posts**: Use the job generator to create professional job posts

### Available Placeholders

- `{{company_name}}` - Company name
- `{{company_email}}` - Company email address
- `{{company_phone}}` - Company phone number
- `{{current_date}}` - Current date
- `{{current_year}}` - Current year
- `{{field_name}}` - Any custom field (replace field_name with actual field name)

### Template Example

```html
{{company_name}} job circular {{current_year}} has been published. 
{{company_name}} has released the job circular PDF and notice on its official website.

For more information, contact: {{company_email}}

Company Details:
- Name: {{company_name}}
- Email: {{company_email}}
- Phone: {{company_phone}}
```

## Database Tables

The plugin creates the following database tables:

- `wp_jap_companies` - Company information
- `wp_jap_templates` - Job post templates
- `wp_jap_custom_fields` - Custom field definitions
- `wp_jap_company_categories` - Company categories
- `wp_jap_template_categories` - Template categories
- `wp_jap_company_field_values` - Custom field values for companies

## File Structure

```
job-automator-pro/
├── job-automator-pro.php          # Main plugin file
├── includes/
│   ├── class-database.php         # Database operations
│   ├── class-admin.php            # Admin interface
│   ├── class-ajax.php             # AJAX handlers
│   ├── class-companies.php        # Company management
│   ├── class-templates.php        # Template management
│   ├── class-fields.php           # Custom fields
│   ├── class-categories.php       # Category management
│   └── class-job-generator.php    # Job generation logic
├── templates/
│   ├── dashboard.php              # Main dashboard
│   ├── companies-list.php         # Companies listing
│   ├── templates-list.php         # Templates listing
│   ├── fields-list.php            # Fields listing
│   ├── categories.php             # Categories management
│   ├── job-generator.php          # Job generator interface
│   └── settings.php               # Plugin settings
├── assets/
│   ├── css/
│   │   └── admin.css              # Admin styles
│   └── js/
│       └── admin.js               # Admin JavaScript
└── README.md                      # Documentation
```

## System Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- MySQL 5.6 or higher

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Security Features

- Nonce verification for all AJAX requests
- Input sanitization and validation
- SQL injection prevention with prepared statements
- Role-based access control
- XSS protection with proper escaping

## Performance Optimizations

- Efficient database queries with proper indexing
- Lazy loading for large datasets
- Minified CSS and JavaScript
- Optimized images and icons
- Caching-friendly code structure

## Customization

The plugin is built with extensibility in mind:

- Hook system for custom functionality
- Template override support
- CSS customization options
- JavaScript event system
- Filter and action hooks

## Support

For support and feature requests, please contact the plugin developer.

## License

This plugin is licensed under the GPL v2 or later.

## Changelog

### Version 2.0.0
- Initial release
- Complete company management system
- Template system with placeholders
- Custom fields functionality
- Job post generator
- Modern admin interface
- Role-based permissions
- Import/export features

---

**Job Automator Pro** - Streamline your job posting workflow with professional automation tools.