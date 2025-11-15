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
  - Fields: id, category_id, owner, name, slug, unit, orang, maks_orang, lokasi, fasilitas, kamar, gluten, rating, status, timestamps, deleted_at
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

**Development Dependencies**:
- `phpunit/phpunit: ^11.0.1` - PHP unit testing framework
- `laravel/breeze: ^2.2` - Lightweight scaffolding with authentication
- `laravel/pail: ^1.1` - Real-time log monitoring
- `laravel/pint: ^1.13` - PHP code style fixer
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
- `Produk` - Villa/property management with categories, facilities, images, and terms
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
- Landing page with custom components (villa cards, testimonials, promo banners, booking forms)
- Admin panel with component-based layout system using Blade components
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
- Separate stylesheets for admin (app.css) and landing page (landing.css)
- **Mobile-optimized components** with touch-friendly interactions and responsive typography

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
- Product CRUD with image management
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

**Development Tools**:
- Laravel Pint for PHP code formatting (PSR-12 standard)
- Laravel Debugbar for development debugging and profiling
- Laravel Pail for real-time log monitoring
- Laravel Sail for Docker development environment
- Custom helper functions for file and image storage management
- Component-based architecture for maintainable frontend code
- Vite hot module replacement (HMR) for fast development
- Concurrently script for running multiple dev servers

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
## Recent Updates (November 2025)

### New Features Added:
- **Card Component**: Reusable `card-component.blade.php` with DataTable support for consistent admin UI
- **Enhanced PromoDataTable**: Advanced status calculation, usage tracking, and target display features
- **Improved DatabaseSeeder**: Automated user folder creation and default admin user setup with avatar
- **API Routes Documentation**: API routes currently commented out in `routes/web.php` (line 81)

### Carousel & UI Enhancements:
- **Flickity Carousel Fix**: Resolved carousel initialization issues in product detail page (`resources/views/landing/produk.blade.php`)
  - Added `data-flickity` attribute for reliable auto-initialization
  - Enhanced CSS for proper carousel-cell layout with flex centering
  - Added `imagesLoaded: true` option for better image loading handling
  - Removed duplicate CSS definitions and improved responsive behavior
- **Mobile-Optimized Floating Price Section**: Redesigned bottom sticky price bar for better mobile experience
  - Responsive layout: vertical stack on mobile, horizontal on desktop
  - Simplified content on mobile (hidden weekday/weekend details)
  - Full-width button on mobile with proper touch targets
  - Improved spacing and typography scaling for small screens

### DatabaseSeeder Enhancements:
- Automatic folder creation for user images (`storage/app/public/images/user`)
- Copy default admin avatar from template
- `updateOrCreate` method for safe user creation

### API Routes Configuration:
- **File**: `routes/api.php` exists but not currently loaded
- **Status**: Commented out in `routes/web.php` line 81
- **Purpose**: RESTful API endpoints with Sanctum authentication (when enabled)
- **Note**: To activate API routes, uncomment the require statement in web.php

### Product Detail Page Enhancements (`resources/views/landing/produk.blade.php`):
- **Enhanced Hero Section** dengan modern image gallery menggunakan Swiper.js
  - Slider dengan fade effect dan autoplay
  - Promo badge dengan animasi pulse untuk produk yang sedang promo
  - GLightbox integration untuk lightbox gallery
  - Responsive navigation buttons (hidden on mobile)
- **Enhanced Product Information Grid** dengan layout 2 kolom (lg:grid-cols-2)
  - Info cards dengan icon-based design (ideal untuk, kapasitas, kamar, lokasi)
  - Rating section dengan visual star display
  - Deskripsi produk dengan icon header
- **Enhanced Tabbed Content** untuk Fasilitas, Wisata, dan Syarat & Ketentuan
  - Tab navigation dengan icon dan hover effects
  - Grid layout untuk item display (md:grid-cols-2)
  - "Lihat Selengkapnya" toggle untuk items > 6
  - Color-coded backgrounds (blue untuk fasilitas, green untuk wisata, yellow untuk syarat)
- **Enhanced Booking Section** dengan calendar dan form
  - FullCalendar integration dengan locale Indonesia
  - Date range selection dengan visual highlighting
  - Real-time availability checking
  - Dynamic price calculation (weekday/weekend pricing)
  - Unit quantity selector dengan max validation
  - DP calculation display
  - Booking summary dengan detailed breakdown
- **Enhanced Floating Price Section** (fixed bottom bar)
  - Sticky price display dengan promo badge
  - Weekday/weekend price breakdown
  - CTA button "Pesan Sekarang" dengan smooth scroll ke calendar
- **Enhanced Recommendations Section**
  - Grid layout untuk villa cards (2 cols mobile, 3 cols desktop)
  - Menggunakan `villa-card` component yang sudah mobile-optimized
- **Advanced Styling & Animations**:
  - Custom calendar styles dengan gradient headers
  - Date selection dengan rounded highlights
  - Disabled/full dates dengan visual indicators
  - Fade-in-up animations untuk sections
  - Shimmer loading animation
  - Custom scrollbar styling
  - Mobile-responsive adjustments (calendar, swiper, spacing)
- **JavaScript Enhancements**:
  - Safe library initialization dengan error handling
  - Swiper dengan fade effect dan autoplay
  - FullCalendar dengan date range selection
  - Dynamic price calculation berdasarkan weekday/weekend
  - Unit availability checking per date
  - Tab switching functionality
  - Scroll-based animation triggers
  - Toggle functionality untuk "Lihat Selengkapnya"
- **Responsive Design**:
  - Tablet-width centered layout (max-w-5xl/1024px)
  - Mobile-optimized calendar (smaller day numbers)
  - Hidden swiper navigation on mobile
  - Responsive grid layouts
  - Touch-friendly interactions
- **Integration Features**:
  - Promo price display dengan strikethrough original price
  - Availability calendar dengan booked dates marking
  - Form validation dan submission
  - GLightbox untuk image gallery
  - Smooth scroll behavior

## Summary
Dokumentasi ini telah diperbarui pada November 2025 untuk mencakup:
- Komponen Blade baru (card-component.blade.php)
- Fitur-fitur lanjutan PromoDataTable
- Peningkatan DatabaseSeeder
- Status konfigurasi API routes
- Role assignment for Super Admin user
- **Enhanced Product Detail Page** (`resources/views/landing/produk.blade.php`) dengan modern UI/UX, advanced booking system, dan mobile-responsive design