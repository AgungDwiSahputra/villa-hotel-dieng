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
- Alpine.js for interactive components, form validation, and dynamic behavior
- Custom animations and transitions defined in Tailwind config
- Responsive design with mobile-first approach
- DataTables integration with server-side processing and export capabilities (Excel, CSV, PDF)
- Separate stylesheets for admin (app.css) and landing page (landing.css)

**Promo Management System**:
- Dynamic discount configuration (percentage and fixed amount)
- Flexible targeting options (all products, specific categories, individual products)
- Category and product-level discount overrides
- Schedule-based promo activation with start/end dates
- Automatic expiration and status management
- Usage tracking and limit management (max usage per promo)
- Real-time promo status management (active/inactive)
- Advanced filtering and search capabilities via DataTables
- Export functionality for promo data (Excel, CSV, PDF)
- Promo code generation and validation

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