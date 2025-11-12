---
description: Repository Information Overview
alwaysApply: true
---

# Villa Hotel Dieng Management System

## Summary
Villa Hotel Dieng is a comprehensive hotel and villa management system built with Laravel 12. The application manages properties, reservations, payments, user roles, and operational features for a boutique hotel/villa in Dieng, Indonesia. It provides both admin backend management and public booking interface with payment gateway integration.

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

**Key Directories**:
- `app/Models/` - Eloquent ORM models for database entities (User, Produk, Transaksi, etc.)
- `app/Http/Controllers/` - Request handlers and business logic
- `app/DataTables/` - Yajra DataTables configurations
- `app/helpers.php` - Global helper functions for image/file storage
- `resources/views/` - Blade template files organized by feature
- `resources/views/landing/` - Public landing page templates
- `resources/views/components/` - Reusable Blade components
- `resources/css/` - Tailwind CSS stylesheets (app.css, landing.css)
- `resources/js/` - Alpine.js and Vite entry points
- `database/migrations/` - Database schema definitions
- `database/seeders/` - Data seeding for initial setup

## Language & Runtime
**Language**: PHP
**Version**: 8.3 or higher
**Framework**: Laravel 12.0
**Build System**: Vite 5.0
**Package Managers**: Composer (PHP), NPM (Node.js)
**Node.js Version**: 22 (specified in .nvmrc)
**Supported Database**: MySQL 8.0+

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

# Fresh database
php artisan migrate:fresh --seed
```

## Main Files & Application Entry Points

**Application Entry**: `public/index.php` - Bootstrap entry point for all HTTP requests
**Artisan Console**: `artisan` - CLI tool for database, queue, and utility commands
**Web Routes**: `routes/web.php` - Public and authenticated web routes (landing page, dashboard)
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
**Vite Config**: `vite.config.js` - Frontend build configuration
**Tailwind Config**: `tailwind.config.js` - CSS framework theme customization
**PostCSS Config**: `postcss.config.js` - CSS processing pipeline

**Key Settings**:
- Database: MySQL configured via DB_* environment variables
- Payment: Midtrans gateway credentials in .env
- Authentication: Laravel Sanctum tokens for API
- Queue: Configured for background job processing
- Mail: Configurable mail driver for transactional emails

## Project Features

**Core Models**:
- `Produk` - Villa/property management with categories, facilities, images, and terms
- `Transaksi` - Booking and reservation management with payment tracking
- `User` - User management with role-based permissions
- `Availability` - Property availability management
- `Setting` - Application configuration management
- `Promo` - Promotion and discount management with flexible targeting options
- `PromoCategory` - Category-based promo assignments with override support
- `PromoProduct` - Product-specific promo assignments with custom discounts

**Frontend Architecture**:
- Landing page with custom components (villa cards, testimonials, promo banners)
- Admin panel with component-based layout system using Blade components
- Tailwind CSS with custom color schemes (primary, accent, gray palettes)
- Alpine.js for interactive components and form validation
- Custom animations and transitions defined in Tailwind config
- Responsive design with mobile-first approach
- DataTables integration with server-side processing and export capabilities

**Promo Management System**:
- Dynamic discount configuration (percentage and fixed amount)
- Flexible targeting options (all products, specific categories, individual products)
- Category and product-level discount overrides
- Schedule-based promo activation with automatic expiration
- Usage tracking and limit management
- Real-time promo status management
- Advanced filtering and search capabilities
- Export functionality for promo data (Excel, CSV, PDF)

**Development Tools**:
- Laravel Pint for code formatting
- Laravel Debugbar for development debugging
- Laravel Sail for Docker development environment
- Custom helper functions for file and image storage
- Component-based architecture for maintainable frontend code

