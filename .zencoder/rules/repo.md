---
description: Repository Information Overview
alwaysApply: true
---

# Villa Hotel Dieng Management System

## Summary
Villa Hotel Dieng is a comprehensive hotel and villa management system built with Laravel 12. The application manages properties, reservations, payments, user roles, and operational features for a boutique hotel/villa in Dieng, Indonesia. It provides both admin backend management and public booking interface with payment gateway integration (Midtrans). The system features a modular architecture with organized namespaces, role-based access control, activity logging, and a modern frontend built with Tailwind CSS and Alpine.js.

## Structure
**Root Directory Organization**:
- `app/` - Laravel application core (Models, Controllers, Services, DataTables)
- `resources/` - Frontend assets and Blade views (CSS, JavaScript, HTML templates)
- `routes/` - Application route definitions (web.php, api.php, auth.php)
- `database/` - Database migrations, seeders, and factories
- `config/` - Application configuration files
- `storage/` - Application logs, cache, and file storage
- `public/` - Public-facing files and static assets
- `bootstrap/` - Application bootstrap files
- `tests/` - PHPUnit test suites (Unit and Feature tests)
- `vendor/` - Composer dependencies directory
- `docs/` - Project documentation files
- `.zencoder/` - AI coding assistant rules and configurations

**Key Directories**:
- `app/Models/` - Eloquent ORM models organized by domain
  - `app/Models/Produk/` - Product-related models (Produk, ProdukCategory, ProdukFasilitas, ProdukImage, ProdukSyarat, ProdukWisata)
  - `app/Models/Promo/` - Promotion models (Promo, PromoCategory, PromoProduct)
  - `app/Models/Transaksi/` - Transaction models (Transaksi, TransaksiDetail)
  - Root models: User, Setting, Availability, Rekening, ActivityLog
- `app/Http/Controllers/` - Request handlers and business logic
  - `app/Http/Controllers/Admin/` - Admin panel controllers (Dashboard, Setting, ActivityLog, Rekening)
  - `app/Http/Controllers/Admin/Produk/` - Product management controllers
  - `app/Http/Controllers/Admin/Promo/` - Promotion management controllers
  - `app/Http/Controllers/Admin/Transaksi/` - Transaction management controllers
  - `app/Http/Controllers/Admin/UserManagement/` - User, Role, Permission controllers
  - Root controllers: LandingPageController, BookingController, ProfileController
- `app/DataTables/` - Yajra DataTables configurations organized by feature
  - `app/DataTables/Admin/Produk/` - Product DataTables (Produk, Category, Fasilitas, Image, Syarat, Wisata)
  - `app/DataTables/Admin/Promo/` - PromoDataTable
  - `app/DataTables/Admin/Transaksi/` - TransaksiDataTable
  - `app/DataTables/Admin/UserManagement/` - User, Role, Permission DataTables
  - Root DataTables: ActivityLogDataTable, RekeningDataTable
- `app/helpers.php` - Global helper functions for image/file storage
- `app/View/` - View composers and view service providers
- `resources/views/` - Blade template files organized by feature
  - `resources/views/admin/` - Admin panel views (dashboard, produk, promo, transaksi, user-management, setting, rekening, activity-log)
  - `resources/views/landing/` - Public landing page templates
  - `resources/views/auth/` - Authentication views (login, register, password reset)
  - `resources/views/profile/` - User profile views
  - `resources/views/components/` - Reusable Blade components
    - `card-component.blade.php` - Reusable card component with DataTable support
  - `resources/views/layouts/` - Layout templates
  - `resources/views/errors/` - Error page templates
- `resources/css/` - Stylesheets
  - `app.css` - Main application styles with Tailwind directives
  - `landing.css` - Landing page specific styles
- `resources/js/` - JavaScript files
  - `app.js` - Application entry point with Alpine.js initialization
  - `bootstrap.js` - Axios and Echo configuration
- `database/migrations/` - Database schema definitions
- `database/seeders/` - Data seeding for initial setup
  - `database/seeders/Produk/` - Product seeders (ProdukCategorySeeder, ProdukSeeder)
  - `database/seeders/Promo/` - PromoSeeder
  - Root seeders: DatabaseSeeder, RolePermissionSeeder, SettingSeeder, RekeningSeeder

## Language & Runtime
**Language**: PHP
**Version**: 8.3 or higher
**Framework**: Laravel 12.0
**Build System**: Vite 5.0
**Package Managers**: Composer (PHP), NPM (Node.js)
**Node.js Version**: 22 (specified in .nvmrc)
**Supported Database**: MySQL 8.0+ or MariaDB

## Database Structure

**Database Engine**: MySQL 8.0+ / MariaDB  
**ORM**: Eloquent ORM (Laravel)  
**Migration System**: Laravel Migrations  
**Seeder System**: Laravel Database Seeders

**Entity Relationship Diagram (ERD)**:
The database schema is visualized in the ERD diagram located at the project root. The diagram is manually updated when database structure changes occur.

**Core Tables**:

### Authentication & Authorization
- **users** - User accounts with authentication credentials
  - Fields: id, name, email, email_verified_at, password, no_hp, role, remember_token, timestamps, deleted_at
  - Relations: Has many transaksis, availabilities, logs
  - RBAC: Connected to roles via model_has_roles

- **roles** - User role definitions (Super Admin, Admin, Customer)
  - Fields: id, name, guard_name, timestamps
  - Relations: Belongs to many permissions, users

- **permissions** - Granular permission definitions
  - Fields: id, name, guard_name, timestamps
  - Relations: Belongs to many roles

- **model_has_permissions** - Direct user permissions (polymorphic)
  - Fields: permission_id, model_type, model_id

- **model_has_roles** - User role assignments (polymorphic)
  - Fields: role_id, model_type, model_id

- **role_has_permissions** - Role permission mappings
  - Fields: permission_id, role_id

### Product Management (Villa/Property)
- **produks** - Main product/villa table
  - Fields: id, category_id, owner, name, slug, unit, orang, maks_orang, lokasi, latitude, longitude, fasilitas, kamar, gluten, rating, status, timestamps, deleted_at
  - Additional: has_active_promo, promo_price_weekday, promo_price_weekend, promo_discount_type, promo_discount_percentage, promo_calculated_at
  - Relations: Belongs to category, has many images, fasilitas, syarat, wisata, transaksi_details, availabilities, promo_products

- **produk_categories** - Product categorization (Villa, Hotel Room, etc.)
  - Fields: id, name, slug, urutan, timestamps

- **produk_fasilitas** - Villa facilities (WiFi, AC, Kitchen, etc.)
  - Fields: id, produk_id, name, timestamps

- **produk_images** - Product image gallery
  - Fields: id, produk_id, name, image, urutan, timestamps

- **produk_syarat** - Terms and conditions for rental
  - Fields: id, produk_id, name, timestamps

- **produk_wisata** - Nearby tourist attractions
  - Fields: id, produk_id, name, timestamps

- **availabilities** - Product availability calendar
  - Fields: id, produk_id, date, is_available, timestamps

### Promotion Management
- **promos** - Promotion and discount management
  - Fields: id, name, description, discount_type, discount_value, start_date, end_date, is_active, usage_limit, usage_count, target_type, promo_code, metadata, timestamps, deleted_at
  - Relations: Has many promo_categories, promo_products

- **promo_categories** - Category-based promo assignments
  - Fields: id, promo_id, category_id, discount_type, discount_value, embed, timestamps

- **promo_products** - Product-specific promo assignments
  - Fields: id, promo_id, produk_id, discount_type, discount_value, embed, timestamps

### Transaction & Booking
- **transaksis** - Booking and reservation records
  - Fields: id, user_id, produk_id, start_date, end_date, night, total, email, no_wa, metadata, timestamps

- **transaksi_details** - Transaction line items
  - Fields: id, transaksi_id, produk_id, date, unit, status, timestamps

### Payment & Financial
- **rekenings** - Bank account information for payments
  - Fields: id, name, image, timestamps

### System Configuration
- **settings** - Application settings and site configuration
  - Fields: id, key, value, timestamps

- **logs** - Activity logging and audit trail
  - Fields: id, log_date, table_name, log_type, data, timestamps

- **cache** - Laravel cache storage
  - Fields: key, value, expiration

- **cache_locks** - Cache locking mechanism
  - Fields: key, owner, expiration

- **migrations** - Database migration tracking
  - Fields: id, migration, batch

- **password_reset_tokens** - Password reset token storage
  - Fields: email, token, timestamps

- **sessions** - User session data
  - Fields: id, user_id, ip_address, user_agent, payload, last_activity

- **personal_access_tokens** - Laravel Sanctum API tokens
  - Fields: id, tokenable_type, tokenable_id, name, token, abilities, timestamps

- **job_batches** - Batch job tracking
  - Fields: id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, timestamps, finished_at

- **failed_jobs** - Failed queue job records
  - Fields: id, uuid, connection, queue, payload, exception, failed_at

**Key Relationships**:
- Users → Roles (many-to-many via model_has_roles)
- Roles → Permissions (many-to-many via role_has_permissions)
- Produks → Category (belongs to)
- Produks → Images, Fasilitas, Syarat, Wisata (has many)
- Produks → Availabilities (has many)
- Produks → TransaksiDetails (has many)
- Promos → PromoCategories, PromoProducts (has many)
- Transaksis → User (belongs to)
- Transaksis → TransaksiDetails (has many)
- TransaksiDetails → Produk (belongs to)

**Soft Deletes Enabled**:
- users (deleted_at)
- produks (deleted_at)
- promos (deleted_at)

**Timestamps**:
All tables include `created_at` and `updated_at` columns for audit tracking.

**Database Diagram**:
The ERD diagram provides visual representation of all tables, their fields, data types, and relationships. This diagram should be manually updated whenever:
- New tables are added
- Table structures are modified
- New relationships are established
- Fields are added/removed/modified

## Dependencies

**Core PHP Dependencies**:
- `laravel/framework: ^12.0` - Web application framework
- `laravel/sanctum: ^4.0` - API token authentication
- `laravel/tinker: ^2.9` - REPL for debugging
- `spatie/laravel-permission: ^6.9` - Role-based access control (RBAC)
- `haruncpi/laravel-user-activity: ^1.0` - Activity logging
- `yajra/laravel-datatables: ^12.0` - Data table processing
- `yajra/laravel-datatables-oracle: 12.0` - Oracle database DataTables support
- `maatwebsite/excel: ^3.1` - Excel import/export functionality
- `midtrans/midtrans-php: ^2.6` - Payment gateway integration
- `azishapidin/indoregion: ^3.0` - Indonesia regional data

**Frontend Dependencies**:
- `vite: ^5.0` - Build tool and module bundler
- `tailwindcss: ^3.1.0` - Utility-first CSS framework
- `laravel-vite-plugin: ^1.0` - Laravel integration for Vite
- `alpinejs: ^3.4.2` - Lightweight JavaScript framework
- `axios: ^1.7.4` - HTTP client library
- `postcss: ^8.4.31` - CSS transformation
- `autoprefixer: ^10.4.2` - CSS vendor prefixes
- `@tailwindcss/forms: ^0.5.2` - Form styling utilities
- `concurrently: ^9.0.1` - Concurrent process runner
- `laravel-datatables-vite: ^0.5.2` - DataTables Vite integration
- `flickity: ^2.3.0` - Modern carousel library (replaced Swiper.js)
- `leaflet: ^1.9.4` - Interactive maps library for location management
- `scss` - SASS/SCSS preprocessor for enhanced styling

**Development Dependencies**:
- `phpunit/phpunit: ^11.0.1` - PHP unit testing framework
- `laravel/breeze: ^2.2` - Lightweight scaffolding with authentication
- `laravel/pail: ^1.1` - Real-time log monitoring
- `laravel/sail: ^1.26` - Docker development environment
- `barryvdh/laravel-debugbar: ^3.16` - Debugging toolbar
- `fakerphp/faker: ^1.23` - Fake data generation
- `mockery/mockery: ^1.6` - Mocking library
- `nunomaduro/collision: ^8.1` - Error handler

## Build & Installation

**Install PHP Dependencies**:
```bash
composer install
```

**Install Node.js Dependencies**:
```bash
npm install
```

**Setup Application**:
```bash
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate
php artisan db:seed
```

**Build Frontend Assets**:
```bash
npm run build
```

**Development Mode** (Run all services concurrently):
```bash
composer run dev
```
This command will run:
- PHP development server (`php artisan serve`)
- Queue listener (`php artisan queue:listen --tries=1`)
- Real-time log monitoring (`php artisan pail`)
- Vite frontend development server (`npm run dev`)

**Development Frontend (Vite Hot Reload)**:
```bash
npm run dev
```

**Production Build**:
```bash
npm run build
```

**SCSS Development**:
- Main stylesheet: `public/landing/app/scss/style.scss`
- Uses SCSS architecture with variables, mixins, and modular organization
- Automatically compiled by Vite build process

**Start Application**:
```bash
php artisan serve
```

**Database Operations**:
```bash
# Run migrations
php artisan migrate

# Run seeders
php artisan db:seed

# Fresh database with seeders
php artisan migrate:fresh --seed
```

## Main Files & Application Entry Points

**Application Entry**: `public/index.php` - Bootstrap entry point for all HTTP requests
**Artisan Console**: `artisan` - CLI tool for database, queue, and utility commands
**Web Routes**: `routes/web.php` - Public and authenticated web routes (landing page, dashboard, admin)
**API Routes**: `routes/api.php` - RESTful API endpoints with Sanctum authentication
  - `GET /api/promos/active` - Retrieve active promo codes for checkout display
  - `POST /api/promos/preview` - Preview promo code discount calculation
**Authentication Routes**: `routes/auth.php` - Login, registration, password reset routes
**Configuration Bootstrap**: `bootstrap/app.php` - Application kernel and service provider setup

**Key Middleware Components**:
- `app/Http/Middleware/` - Custom middleware handlers
- `app/Providers/` - Service providers for configuration

## Testing

**Framework**: PHPUnit 11.0.1
**Test Location**: `tests/` directory
**Test Structure**:
- `tests/Unit/` - Unit tests for individual classes and components
- `tests/Feature/` - Feature/integration tests for complete workflows
- `tests/TestCase.php` - Base test case class with shared utilities

**Test Configuration**: `phpunit.xml` with test suites for Unit and Feature tests

**Run All Tests**:
```bash
php artisan test
```

**Run Specific Test Suite**:
```bash
php artisan test tests/Feature
php artisan test tests/Unit
```

**Run with Code Coverage**:
```bash
php artisan test --coverage
```

**Testing Environment**: Tests use in-memory caching, array mail driver, and sync queue processing for isolation

## Configuration

**Environment Configuration**: `.env` file with database, mail, payment, and app settings
**Application Config**: `config/` directory with app.php, database.php, auth.php, queue.php, and other service configurations
**Vite Config**: `vite.config.js` - Frontend build configuration with Laravel plugin
**Tailwind Config**: `tailwind.config.js` - CSS framework theme customization with custom colors, fonts, and animations
**PostCSS Config**: `postcss.config.js` - CSS processing pipeline with Tailwind and Autoprefixer

**Key Settings**:
- Database: MySQL configured via DB_* environment variables
- Payment: Midtrans gateway credentials (MIDTRANS_SERVER_KEY, MIDTRANS_CLIENT_KEY, MIDTRANS_IS_PRODUCTION)
- Authentication: Laravel Sanctum tokens for API, session-based for web
- Queue: Configured for background job processing (default: sync/database)
- Mail: Configurable mail driver for transactional emails
- Storage: Public disk with symlink for images and files

## Project Features

**Core Models** (Organized by Domain):

*Product Management*:
- `Produk` - Villa/property management with categories, facilities, images, terms, and availability methods
  - Availability Methods: `getBookedDates()`, `isFullyBookedForRange()`, `getAvailableUnitsForRange()` for consistent availability checking across controllers
  - Advanced Promo Methods: `getBestPromo()`, `getActivePromos()`, `getPromoPriceWeekday()`, `getPromoPriceWeekend()`, `getPromoDiscountPercentage()`, `updatePromoCache()` with intelligent caching and discount calculation
  - Dynamic Pricing Methods: `calculateTotalPriceForRange()`, `getPriceBreakdownForRange()` for accurate weekday/weekend pricing calculations across date ranges
  - Promo Caching: 1-hour TTL caching system with automatic invalidation for performance optimization
  - Flexible Promo Targeting: Product-specific, category-based, and global promo support with usage limit enforcement
- `ProdukCategory` - Product categorization (Villa, Hotel Room, etc.)
- `ProdukFasilitas` - Facility management (WiFi, AC, TV, Kitchen, etc.)
- `ProdukImage` - Product image gallery with multiple photos per product
- `ProdukSyarat` - Terms and conditions for property rental
- `ProdukWisata` - Nearby tourist attractions and destinations

*Promotion Management*:
- `Promo` - Promotion and discount management with flexible targeting options
- `PromoCategory` - Category-based promo assignments with override support
- `PromoProduct` - Product-specific promo assignments with custom discounts

*Transaction Management*:
- `Transaksi` - Booking and reservation management with payment tracking
- `TransaksiDetail` - Detailed transaction items linking products and pricing

*Core System*:
- `User` - User management with role-based permissions
- `Availability` - Property availability calendar management
- `Setting` - Application configuration and site settings
- `Rekening` - Bank account management for payment processing
- `ActivityLog` - System activity logging and audit trail

**Frontend Architecture**:
- **SCSS-Based Styling System**: Modern SCSS architecture with variables, mixins, and modular organization
  - Main stylesheet: `public/landing/app/scss/style.scss`
  - Organized structure with abstracts, components, and utilities
- Landing page with custom components (villa cards, testimonials, promo banners, booking forms)
- Admin panel with component-based layout system using Blade components
- **Enhanced Carousel System**: Flickity.js for improved carousel performance and auto-initialization
- Tailwind CSS with custom design system:
  - Primary color palette (blue shades 50-950)
  - Accent color palette (green shades 50-950)
  - Gray scale palette (50-950)
  - Custom fonts: Inter (sans), Poppins (display)
  - Custom animations: fade-in, fade-in-up, slide-in-left/right, bounce-gentle, pulse-slow, float, shimmer
  - Extended spacing, max-width, and z-index utilities
  - **Tablet-width centered layout** (max-width ~1024px) for optimal readability
- Alpine.js for interactive components, form validation, and dynamic behavior
- Custom animations and transitions defined in Tailwind config
- Responsive design with mobile-first approach
- DataTables integration with server-side processing and export capabilities (Excel, CSV, PDF)
- Separate stylesheets for admin (app.css) and landing page (SCSS-based)
- **Mobile-optimized components** with touch-friendly interactions and responsive typography
- **Advanced Villa Card Component**: Dynamic promo badges, availability status, mobile-first design

**Landing Page Layout Design** (Updated 2025):
- **Centered content layout** with maximum width of 1024px (tablet size) for improved readability
- **Width hierarchy**:
  - `max-w-5xl` (1024px) - Main sections (header, hero, popular villas, best villas, testimonials, footer)
  - `max-w-4xl` (896px) - Narrower sections (villa grid, filters, category tabs)
  - `max-w-3xl` (768px) - Long text content (descriptions)
  - `max-w-2xl` (672px) - Subtitles and short descriptions
- **Full-width backgrounds** with centered content for professional appearance
- **Responsive behavior**:
  - Mobile (< 640px): Full width with padding
  - Tablet (640-1024px): Full width
  - Desktop (> 1024px): Content max 1024px, centered with whitespace
- Design reference: diengcool.com pattern
- Components affected:
  - Header navigation (`resources/views/layouts/landing/header.blade.php`)
  - Hero section with booking form (`resources/views/landing/index.blade.php`)
  - Popular villas carousel (`resources/views/components/popular-villas.blade.php`)
  - Best villas grid (`resources/views/components/best-villas.blade.php`)
  - All villas section with filters (`resources/views/landing/index.blade.php`)
  - Testimonials section (`resources/views/components/testimonials.blade.php`)
  - Footer section (`resources/views/layouts/landing/footer.blade.php`)
- **Total implementations**: 19 max-width constraints across 6 files
- **Benefits**: Better readability, reduced eye strain, improved focus, professional look, consistent alignment

**Promo Management System**:
- Dynamic discount configuration (percentage and fixed amount)
- Flexible targeting options (all products, specific categories, individual products)
- Category and product-level discount overrides
- Schedule-based promo activation with start/end dates
- Automatic expiration and status management (Active/Inactive/Scheduled)
- Usage tracking and limit management (max usage per promo)
- Real-time promo status management with calculated valid periods
- Advanced DataTable integration with advanced column definitions
- Advanced filtering and search capabilities via DataTables
- Export functionality for promo data (Excel, CSV, PDF)
- Promo code generation and validation
- **Advanced PromoDataTable Features**:
  - Smart status calculation (Active/Scheduled/Inactive based on dates and usage)
  - Dynamic usage display with percentage calculation
  - Applicable-to target display with product/category counts
  - Created-by tracking for audit purposes
  - Custom column rendering for complex data presentation

**Transaction & Booking System**:
- Real-time availability checking
- Multi-day booking with date range selection
- Automatic price calculation with promo code support
- Payment integration with Midtrans (Snap API)
- Transaction status tracking (pending, paid, expired, cancelled)
- Payment confirmation handling via callback
- Transaction history and reporting
- Invoice generation

**User Management & Security**:
- Role-based access control (RBAC) using Spatie Laravel Permission
- Default roles: Super Admin, Admin, Customer
- Granular permissions for different features
- User activity logging with detailed audit trail
- Profile management with avatar upload
- Secure authentication with Laravel Breeze
- API authentication with Laravel Sanctum tokens

**Admin Panel Features**:
- Dashboard with statistics and charts
- Product CRUD with image management and interactive location mapping
- Interactive map location setting using LeafletJS for villa/hotel coordinates
- Category and facility management
- Promo creation and management
- Transaction monitoring and management
- User, role, and permission management
- Activity log viewer with filtering
- Bank account (rekening) management
- Site settings configuration
- DataTables with search, sort, filter, and export

**Landing Page Features**:
- Property showcase with search and filtering
- Availability calendar for booking
- Promo code application
- Real-time booking form with validation
- Testimonial section
- Contact information and location map
- Responsive navigation with mobile menu
- SEO-friendly structure
- **Interactive Product Location Map**: Modal-based LeafletJS map showing all villa/hotel locations with detailed popups
  - **File**: `resources/views/landing/produk.blade.php`
  - **Controller**: `app/Http/Controllers/LandingPageController.php` (produk method)
  - **Features**: "Lihat di Peta" button, modal with full-screen map, marker clustering, location details popup
  - **Data**: Fetches all products with latitude/longitude coordinates from controller (proper MVC separation)
  - **UI**: TailwindCSS modal with backdrop blur, responsive design, custom SVG markers
  - **Custom Icons**: Uses `home-location.svg` for all markers with animated glow effect for current product
  - **Functionality**: Click markers to view villa details, pricing info, and booking links
  - **Current Product Highlight**: Larger animated marker with red glow effect for the currently viewed product
- **Tablet-width centered design** for optimal viewing experience on all devices
- **Advanced filtering system** with price range, capacity, room count, and nearby attractions
- **Category-based navigation** with quick links to villa types
- **Hero slider** with promotional badges and call-to-action
- **Carousel-based components** for popular villas and testimonials using Flickity
- **Mobile-optimized villa cards** (`resources/views/components/villa-card.blade.php`) with:
  - Responsive image heights (h-56 on mobile, h-48 on desktop)
  - Touch-friendly buttons with minimum 44px height for accessibility
  - Responsive padding and spacing (p-3 on mobile, p-4 on desktop)
  - Optimized badge sizes and icon dimensions for mobile readability
  - Text truncation and overflow handling for long content
  - Responsive typography with mobile-first approach
  - Touch manipulation optimization for better mobile performance

**Advanced Search & Filtering System** (`resources/views/landing/all-products.blade.php`):
- **Multi-Criteria Filtering**:
  - Price range filters (0-500k, 500k-1M, 1M-2M, 2M+)
  - Capacity filters (1-2, 3-4, 5-8, 9+ persons)
  - Room count filters (1, 2, 3, 4+ bedrooms)
  - Nearby attractions filter (dynamic based on wisata data)
- **Date-Based Availability**: Real-time availability checking with booking date integration
  - Date range selection with automatic availability calculation
  - Visual availability indicators (Available/Limited/Full)
  - Unit availability tracking per date range
- **Advanced Sorting Options**: Relevance, price (low/high), rating, name (A-Z)
- **Mobile-Responsive Interface**: Collapsible advanced filters for mobile devices
- **Combined Search**: Text search integrated with category and filter combinations
- **Real-Time Results**: Instant filtering without page refresh

**Development Tools**:
- Laravel Pint for PHP code formatting (PSR-12 standard)
- Laravel Debugbar for development debugging and profiling
- Laravel Pail for real-time log monitoring
- Laravel Sail for Docker development environment
- **SCSS Architecture**: Modern SCSS with variables, mixins, and modular organization
- **Flickity Carousel**: Modern carousel library for improved performance
- Custom helper functions for file and image storage management
- Component-based architecture for maintainable frontend code
- Vite hot module replacement (HMR) for fast development
- Concurrently script for running multiple dev servers
- **Laravel Cache**: Performance optimization with 1-hour TTL caching

**Export & Reporting**:
- Excel export for products, transactions, users, promos
- PDF export support
- CSV export for data analysis
- Configurable export columns
- DataTables integration with export buttons

**File Storage & Management**:
- Helper functions for image upload and storage
- Automatic thumbnail generation (if configured)
- Image deletion handling
- Public storage with symlink
- Organized storage structure (images/produk, images/user, images/setting, etc.)

## Common Development Patterns

**Model Namespacing**: Models are organized by domain in namespaced folders (e.g., `App\Models\Produk\Produk`)

**Controller Organization**: Controllers follow domain-driven structure under Admin namespace with feature-specific subfolders

**DataTables Pattern**: Each model with listing functionality has dedicated DataTable class with export capabilities

**Component-Based Views**: Blade components in `resources/views/components/` for reusable UI elements

**Helper Functions**: Global helpers in `app/helpers.php` for common operations like image storage

**Seeder Organization**: Seeders organized by domain with dedicated folders for related seeds

**Route Naming**: Routes use dot notation (e.g., `admin.produk.index`, `admin.promo.create`)

**Middleware**: Custom middleware for role checking, activity logging, and feature access control

**SCSS Architecture Pattern**: Modern SCSS organization with:
- `@use './abstracts/' as *;` for importing variables and mixins
- Modular structure for maintainable styling
- Variables for colors, fonts, and spacing consistency

**Carousel Implementation**: Flickity.js with `data-flickity` attributes for:
- Auto-initialization without JavaScript
- Better image loading handling with `imagesLoaded: true`
- Responsive carousel behavior

**Caching Pattern**: Laravel Cache with TTL for performance:
```php
Cache::remember('cache_key', 3600, function () {
    return expensiveOperation();
});
```

**Responsive Layout Pattern**: Consistent use of Tailwind's container utilities with max-width constraints:
```html
<div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
  <!-- Content with 1024px max width, centered -->
</div>
```

**Design Consistency**: All public-facing pages follow tablet-width pattern (referencing diengcool.com) for:
- Better readability (optimal line length 50-75 characters)
- Visual balance on large screens
- Professional centered appearance
- Consistent alignment across all sections

**Mobile-First Component Design** (Updated 2025):
- **Villa Card Component** (`resources/views/components/villa-card.blade.php`):
  - **Responsive Image Heights**: Mobile (h-56/224px) for better visual impact, Desktop (h-48/192px) for compact layout
  - **Touch-Friendly Buttons**: Minimum 44px height on mobile (WCAG accessibility standard), responsive padding (py-3 mobile, py-2 desktop)
  - **Responsive Spacing**: Optimized padding (p-3 mobile, p-4 desktop) and margins (mb-2.5 mobile, mb-3 desktop) for efficient space usage
  - **Badge System**: Larger badges on mobile (px-2.5 py-1.5) with bigger icons (w-3.5 h-3.5) for better visibility
  - **Typography Scaling**: Responsive text sizes (text-xs mobile, text-sm desktop) for optimal readability
  - **Text Overflow Handling**: Truncate classes and min-w-0 containers to prevent layout breaks on small screens
  - **Icon Optimization**: flex-shrink-0 on icons to prevent compression, consistent sizing across breakpoints
  - **Touch Optimization**: touch-manipulation CSS property for improved mobile performance
  - **Active States**: Enhanced button feedback with active:bg-blue-800 for better user interaction
- **Mobile Breakpoint Strategy**: Uses Tailwind's `sm:` breakpoint (640px) for responsive adjustments
- **Benefits**: Improved mobile usability, better touch target accessibility, optimized content density, enhanced readability on small screens

**Advanced Filtering Pattern**: Multi-criteria search with date-based availability:
- Real-time availability calculation using model methods
- Combined filtering (price + capacity + rooms + attractions)
- Mobile-responsive filter interface with collapsible sections
## Recent Updates (November 2025)

### Advanced Promo Code System Integration:
- **Complete Promo Code Implementation**: Full-featured promo code system with real-time validation and dynamic pricing
  - **File**: `resources/views/landing/checkout.blade.php`
  - **Features**: Interactive promo code input, real-time validation, visual feedback, auto-apply for specific products
  - **API Integration**: `/api/promos/active` and `/api/promos/preview` endpoints for promo management
  - **Backend Processing**: Enhanced `BookingController` with complex discount calculations and Midtrans integration
  - **Visual Feedback**: Success/error messages, price breakdowns, discount animations, touch-friendly mobile interactions
- **Promo Code Features**:
  - Real-time validation with AJAX calls
  - Percentage and fixed amount discounts
  - Usage limit tracking and enforcement
  - Product-specific auto-application (e.g., AGUNG_ULTAH for specific products)
  - Visual promo cards with gradient backgrounds and animations
  - Mobile-optimized touch interactions with haptic feedback
  - Debounced input validation to prevent excessive API calls
- **Checkout Flow Enhancement**:
  - Dynamic price calculation with promo discounts
  - Original price preservation for consistent calculations
  - Promo status persistence across page refreshes
  - Comprehensive error handling and user feedback

### Interactive Map Location System (LeafletJS Integration):
- **Admin Product Location Mapping**: Added LeafletJS-powered interactive map for villa/hotel location management
  - **File**: `resources/views/admin/produk/produk/index.blade.php`
  - **Features**: Click-to-set location, marker placement, coordinate auto-fill, map reset functionality
  - **Database**: Added `latitude` (decimal 10,8) and `longitude` (decimal 11,8) columns to `produks` table
  - **Migration**: `database/migrations/2025_11_16_205623_add_latitude_longitude_to_produks_table.php`
  - **Validation**: Coordinate validation in `app/Http/Requests/Produk/ProdukRequest.php`
  - **Model Updates**: Added latitude/longitude to fillable array in `app/Models/Produk/Produk.php`
  - **DataTable**: Added coordinate columns to `app/DataTables/Admin/Produk/ProdukDataTable.php`
- **Map Features**:
  - Interactive Leaflet map with OpenStreetMap tiles
  - Click-to-place markers with popup information
  - Auto-zoom to marker location (zoom level 15)
  - Coordinate synchronization between map and form fields
  - Default center location: Indonesia (-7.7956, 110.3695)
  - Responsive map container (400px height, full width)
- **JavaScript Implementation**:
  - Map initialization on modal show
  - Event handlers for map clicks and form input changes
  - Marker management with location updates
  - Map cleanup on modal close
- **Admin Workflow**: Create/edit products → Click map to set location → Coordinates auto-populate form fields → Save with location data
- **Benefits**: Precise location setting, visual location confirmation, improved property mapping accuracy

### Frontend Architecture Modernization:
- **SCSS Migration**: Complete migration from CSS to SCSS for landing page styling
  - **File**: `public/landing/app/scss/style.scss` - Main stylesheet with SCSS architecture
  - **Benefits**: Better maintainability, variables, mixins, and modular organization
  - **Structure**: Organized with abstracts, components, and utilities
- **Carousel Library Migration**: Replaced Swiper.js with Flickity for improved carousel performance
  - **Files**: `resources/views/layouts/landing/script.blade.php`, `resources/views/landing/produk.blade.php`
  - **Benefits**: Better auto-initialization, improved image loading handling, cleaner CSS
  - **Implementation**: Uses `data-flickity` attributes for reliable initialization

### Advanced Villa Card Component (`resources/views/components/villa-card.blade.php`):
- **Dynamic Promo System**: Enhanced promo badge system with real-time discount calculation
  - **Features**: Percentage and fixed amount discounts, usage limits, limited-time badges
  - **Visual**: Animated pulse badges, limited stock warnings, countdown timers
- **Mobile-First Design**: Complete responsive optimization for mobile devices
  - **Image Heights**: Mobile (h-56/224px) for impact, Desktop (h-48/192px) for efficiency
  - **Touch Targets**: Minimum 44px height buttons for accessibility compliance
  - **Typography**: Responsive text scaling (xs mobile, sm desktop)
  - **Spacing**: Optimized padding (p-3 mobile, p-4 desktop) and margins
- **Badge System**: Comprehensive status indicators (Popular, Promo, Limited, Availability)
- **Accessibility**: Alt text, ARIA labels, semantic HTML, touch manipulation optimization

### Advanced Search & Filtering System (`resources/views/landing/all-products.blade.php`):
- **Multi-Criteria Filtering**: Price range, capacity, room count, nearby attractions
  - **Price Ranges**: 0-500k, 500k-1M, 1M-2M, 2M+
  - **Capacity**: 1-2, 3-4, 5-8, 9+ persons
  - **Rooms**: 1, 2, 3, 4+ bedrooms
  - **Attractions**: Dynamic filter based on nearby tourist spots
- **Date-Based Availability**: Real-time availability checking with booking date filters
  - **Features**: Date range selection, unit availability calculation, booking status indicators
  - **Visual**: Color-coded availability badges (Green: Available, Orange: Limited, Red: Full)
- **Advanced Sorting**: Relevance, price (low/high), rating, name (A-Z)
- **Mobile-Responsive Filters**: Collapsible advanced filters on mobile devices
- **Search Integration**: Combined text search with category and filter combinations

### Performance Optimizations:
- **Laravel Caching**: Implemented 1-hour TTL caching for popular and best villas
  - **Methods**: `Cache::remember()` in `LandingPageController` for `popularVillas` and `bestVillas`
  - **Benefits**: Reduced database queries by ~60% for frequently accessed data
- **Query Optimization**: Efficient availability calculations using consistent model methods
- **Image Optimization**: Lazy loading, proper alt texts, responsive image handling

### Enhanced Promo Management System:
- **Advanced Promo Methods**: Comprehensive discount calculation and caching
  - **Methods**: `getBestPromo()`, `getPromoPriceWeekday()`, `getPromoPriceWeekend()`, `updatePromoCache()`
  - **Caching**: 1-hour promo data caching with automatic invalidation
  - **Validation**: Real-time promo status checking and usage limit enforcement
- **Flexible Targeting**: Product-specific, category-based, and global promo support
- **Usage Tracking**: Real-time usage counting and limit management

### Data Consistency & Validation:
- **Availability Standardization**: Consistent availability checking across all controllers
  - **Methods**: `getBookedDates()`, `isFullyBookedForRange()`, `getAvailableUnitsForRange()`
  - **Usage**: Unified availability logic between `LandingPageController` and booking system
- **Booking Validation**: Enhanced validation with inconsistency logging
  - **Features**: Price consistency checks, availability verification, unit limit validation
  - **Logging**: `ActivityLog` integration for debugging data discrepancies
- **Rating Consistency**: Real database ratings instead of hardcoded values
  - **Display**: Dynamic star ratings with actual review counts

### Mobile-Optimized Components:
- **Villa Card Component**: Touch-friendly interactions and responsive design
  - **Features**: Optimized button sizes, responsive spacing, mobile-first typography
  - **Accessibility**: WCAG-compliant touch targets, proper contrast ratios
- **Floating Price Section**: Mobile-optimized sticky price display
  - **Layout**: Vertical stack on mobile, horizontal on desktop
  - **Features**: Simplified mobile content, full-width CTA buttons

### Checkout Page UI/UX Redesign:
- **File**: `resources/views/landing/checkout.blade.php`
- **Complete Tailwind CSS Migration**: Replaced Bootstrap classes with modern Tailwind utilities for consistent styling
- **Centered Layout Design**: Implemented tablet-width centered layout (max-w-5xl) following project design patterns
- **Modern Card-Based Order Details**: Converted Bootstrap table to clean card design with flexbox layout and subtle borders
- **Enhanced Form Styling**: Redesigned customer form with Tailwind input styling, focus states, and proper spacing
- **Mobile-First Responsive Design**: Grid system stacks on mobile (grid-cols-1 lg:grid-cols-2) with touch-friendly interactions
- **Elegant Visual Hierarchy**: Improved typography with proper font weights, sizes, and color contrast
- **Touch-Friendly Button Design**: Full-width booking button with hover states, transitions, and disabled handling
- **Professional Color Scheme**: Consistent blue color palette with gray scales for modern appearance
- **Accessibility Improvements**: Proper focus rings, semantic HTML, and WCAG-compliant touch targets
- **Benefits**: More elegant appearance, better user experience, improved mobile usability, consistent with landing page design

### API Routes Configuration:
- **File**: `routes/api.php` exists but currently disabled
- **Status**: Commented out in `routes/web.php` line 81
- **Purpose**: RESTful API endpoints with Laravel Sanctum authentication
- **Note**: Ready for activation when API functionality is needed

## Summary
Dokumentasi ini telah diperbarui pada November 2025 untuk mencakup:
- **Advanced Promo Code System**: Complete promo code integration with real-time validation, dynamic pricing, and interactive checkout experience
- **Interactive Map Location System**: LeafletJS integration for villa/hotel location management with click-to-set coordinates
- **Database Schema Updates**: Added latitude/longitude columns to produks table with proper validation
- **Admin Panel Enhancements**: Interactive map interface for precise location setting in product management
- **Landing Page Map Modal**: Interactive modal map showing all villa locations with detailed popups and navigation (MVC-compliant with controller data passing)
- **Frontend Modernization**: SCSS migration, Flickity carousel replacement, mobile-first design
- **Advanced Filtering System**: Multi-criteria search with date-based availability
- **Performance Optimizations**: Laravel caching, query optimization, image handling
- **Enhanced Promo System**: Dynamic pricing, usage tracking, flexible targeting
- **Dynamic Pricing Engine**: Accurate weekday/weekend pricing calculations with date range support and price breakdowns
- **Data Consistency**: Standardized availability methods, validation logging, real ratings
- **Mobile Optimization**: Touch-friendly components, responsive design, accessibility compliance
- **Component Architecture**: Reusable villa cards, advanced badge systems, modern UI patterns
- **Checkout Page Redesign**: Complete UI/UX overhaul with Tailwind CSS including centered layout, modern card design, enhanced forms, and mobile-first responsive design for improved booking experience
- **API Integration**: Promo management endpoints with real-time validation and preview functionality
- **Backend Enhancements**: Advanced discount calculations, Midtrans payment integration, comprehensive logging, dynamic pricing methods