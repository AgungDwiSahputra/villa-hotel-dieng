# Promo Management System

## Overview
Fitur Promo Management memungkinkan admin untuk membuat dan mengelola kampanye promosi dengan berbagai opsi diskon dan target aplikasi.

## Database Structure

### Tables
- **promos** - Tabel utama untuk data promo
- **promo_categories** - Relasi promo dengan kategori produk
- **promo_products** - Relasi promo dengan produk spesifik

### Key Features
- **Flexible Discount Types**: Percentage dan Fixed Amount
- **Target Options**: All Products, Specific Categories, Individual Products
- **Advanced Settings**: Usage limits, date ranges, active/inactive status
- **Override Support**: Custom discount per kategori/produk
- **Auto-generated Promo Codes**: Unique codes for identification

## API Endpoints & Routes

### Admin Routes
- `GET /admin/promo/promo` - Index page dengan DataTable
- `GET /admin/promo/promo/create` - Create form
- `POST /admin/promo/promo` - Store new promo
- `GET /admin/promo/promo/{id}` - Show details
- `GET /admin/promo/promo/{id}/edit` - Edit form
- `PUT /admin/promo/promo/{id}` - Update promo
- `DELETE /admin/promo/promo/{id}` - Delete promo
- `POST /admin/promo/promo/{id}/toggle-status` - Toggle active status
- `POST /admin/promo/promo/{id}/duplicate` - Duplicate promo

## Permissions

### Required Permissions
- `promo view` - View promo list and details
- `promo create` - Create new promos
- `promo edit` - Edit existing promos
- `promo delete` - Delete promos

## Features

### 1. DataTable with Advanced Filtering
- Real-time search
- Sort by columns
- Export to Excel, CSV, PDF
- Column visibility toggle
- Status indicators (Active, Scheduled, Inactive)

### 2. Comprehensive Create/Edit Form
- Basic information (name, code, description)
- Discount configuration (type and value)
- Validity period (start/end dates)
- Usage limits
- Dynamic category/product selection
- Override discounts per item

### 3. Detailed View Page
- Complete promo information
- Usage statistics
- Applied items display
- Summary statistics
- Quick action buttons

### 4. Action Dropdown
- View details
- Edit promo
- Toggle status
- Duplicate promo
- Delete with confirmation

## Promo Status System
- **Active**: Promo is currently valid and usable
- **Scheduled**: Will be active in the future
- **Inactive**: Expired, disabled, or usage limit reached

## Smart Features
- Auto-generation of unique promo codes
- Usage tracking with progress indicators
- Date validation
- Category/product relationship management
- Bulk operations support

## Frontend Components Used
- `x-app-layout` - Main admin layout
- `x-card-component` - Card containers
- `x-modal-component` - Modal dialogs
- `x-input-form-component` - Form inputs
- DataTables with custom columns

## Security Features
- Permission-based access control
- CSRF protection
- Input validation
- SQL injection prevention
- XSS protection

## Usage Examples

### Percentage-based Promo
- Type: Percentage
- Value: 25%
- Target: All Products
- Valid: 30 days
- Usage: Unlimited

### Category-based Promo
- Type: Fixed Amount
- Value: Rp 100,000
- Target: Selected Categories
- Override: 30% for VIP Category
- Valid: Limited period

### Product-specific Promo
- Type: Percentage
- Value: 15%
- Target: Individual Villas
- Override: 20% for Premium Villa
- Usage: 50 times limit

## File Locations

### Controllers
- `app/Http/Controllers/Admin/Promo/PromoController.php`

### Models
- `app/Models/Promo/Promo.php`
- `app/Models/Promo/PromoCategory.php`
- `app/Models/Promo/PromoProduct.php`

### DataTables
- `app/DataTables/Admin/Promo/PromoDataTable.php`

### Views
- `resources/views/admin/promo/promo/index.blade.php`
- `resources/views/admin/promo/promo/create.blade.php`
- `resources/views/admin/promo/promo/edit.blade.php`
- `resources/views/admin/promo/promo/show.blade.php`
- `resources/views/admin/promo/promo/action.blade.php`

### Migrations
- `database/migrations/2025_11_09_000001_create_promos_table.php`
- `database/migrations/2025_11_09_000002_create_promo_categories_table.php`
- `database/migrations/2025_11_09_000003_create_promo_products_table.php`
- `database/migrations/2025_11_09_000004_add_promo_fields_to_produks_table.php`

### Seeders
- `database/seeders/Promo/PromoSeeder.php`

## Access URL
- **Promo Management**: `http://localhost:8000/admin/promo/promo`

## Menu Navigation
The promo management menu is located in the admin sidebar with:
- Icon: Gift Box (bx-gift)
- Label: "Promo Management"
- Permission-based visibility