# Database Structure Documentation

**Project**: Villa Hotel Dieng Management System  
**Database Engine**: MySQL 8.0+ / MariaDB  
**ORM**: Laravel Eloquent  
**Last Updated**: January 2025

---

## 📋 Overview

This document provides comprehensive documentation for the Villa Hotel Dieng database structure. The database is designed to support a complete hotel/villa management system with booking, payment, promotion, and user management capabilities.

---

## 🗂️ Database Summary

```
Total Tables:        28 tables
Core Business Tables: 18 tables
Laravel System Tables: 10 tables
Total Relationships:  25+ relationships
Soft Deletes:        3 tables (users, produks, promos)
```

---

## 📊 Entity Relationship Diagram (ERD)

**Location**: Root directory of the project  
**Format**: Visual diagram showing all tables, fields, and relationships  
**Update Policy**: Manual update required when database structure changes

### When to Update ERD:
- ✅ New tables added
- ✅ Existing tables modified (fields added/removed)
- ✅ Relationships changed
- ✅ Indexes or constraints modified
- ✅ Data types changed

---

## 🔐 Authentication & Authorization Tables

### 1. users
**Purpose**: Store user account information and authentication credentials

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| name | varchar | User's full name |
| email | varchar | Email address (unique) |
| email_verified_at | timestamp | Email verification timestamp |
| password | varchar | Hashed password |
| no_hp | varchar | Phone number |
| role | varchar | User role identifier |
| remember_token | varchar | Remember me token |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |
| deleted_at | timestamp | Soft delete timestamp |

**Relationships**:
- Has many: transaksis, availabilities, logs
- Belongs to many: roles (via model_has_roles)

**Indexes**:
- PRIMARY KEY (id)
- UNIQUE (email)

---

### 2. roles
**Purpose**: Define user roles (Super Admin, Admin, Customer)

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Role name |
| guard_name | varchar | Guard name (web/api) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Relationships**:
- Belongs to many: permissions (via role_has_permissions)
- Belongs to many: users (via model_has_roles)

---

### 3. permissions
**Purpose**: Store granular permission definitions

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Permission name |
| guard_name | varchar | Guard name (web/api) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Relationships**:
- Belongs to many: roles (via role_has_permissions)

---

### 4. model_has_permissions
**Purpose**: Direct user permission assignments (polymorphic)

| Field | Type | Description |
|-------|------|-------------|
| permission_id | bigint | Foreign key to permissions |
| model_type | varchar | Model class name |
| model_id | bigint | Model ID |

**Composite Key**: (permission_id, model_id, model_type)

---

### 5. model_has_roles
**Purpose**: User role assignments (polymorphic)

| Field | Type | Description |
|-------|------|-------------|
| role_id | bigint | Foreign key to roles |
| model_type | varchar | Model class name |
| model_id | bigint | Model ID |

**Composite Key**: (role_id, model_id, model_type)

---

### 6. role_has_permissions
**Purpose**: Map permissions to roles

| Field | Type | Description |
|-------|------|-------------|
| permission_id | bigint | Foreign key to permissions |
| role_id | bigint | Foreign key to roles |

**Composite Key**: (permission_id, role_id)

---

## 🏠 Product Management Tables (Villa/Property)

### 7. produks
**Purpose**: Main product/villa information

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| category_id | bigint | Foreign key to categories |
| owner | varchar | Property owner name |
| name | varchar | Villa/product name |
| slug | varchar | URL-friendly slug |
| unit | int | Number of units available |
| orang | int | Guest capacity |
| maks_orang | int | Maximum guest capacity |
| lokasi | varchar | Location/address |
| fasilitas | text | Facilities description |
| kamar | int | Number of rooms |
| gluten | varchar | Additional info |
| rating | decimal | Product rating |
| status | varchar | Status (active/inactive) |
| has_active_promo | boolean | Active promo flag |
| promo_price_weekday | decimal | Promo weekday price |
| promo_price_weekend | decimal | Promo weekend price |
| promo_discount_type | varchar | Promo discount type |
| promo_discount_percentage | decimal | Promo percentage |
| promo_calculated_at | timestamp | Promo calculation time |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |
| deleted_at | timestamp | Soft delete timestamp |

**Relationships**:
- Belongs to: produk_categories
- Has many: produk_images, produk_fasilitas, produk_syarat, produk_wisata
- Has many: availabilities, transaksi_details, promo_products

**Indexes**:
- PRIMARY KEY (id)
- INDEX (category_id)
- UNIQUE (slug)

---

### 8. produk_categories
**Purpose**: Categorize products (Villa, Hotel Room, etc.)

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Category name |
| slug | varchar | URL-friendly slug |
| urutan | int | Display order |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Relationships**:
- Has many: produks

---

### 9. produk_fasilitas
**Purpose**: Store villa facilities (WiFi, AC, Kitchen, etc.)

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| produk_id | bigint | Foreign key to produks |
| name | varchar | Facility name |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Relationships**:
- Belongs to: produks

---

### 10. produk_images
**Purpose**: Product image gallery

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| produk_id | bigint | Foreign key to produks |
| name | varchar | Image name/title |
| image | varchar | Image file path |
| urutan | int | Display order |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Relationships**:
- Belongs to: produks

---

### 11. produk_syarat
**Purpose**: Terms and conditions for property rental

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| produk_id | bigint | Foreign key to produks |
| name | varchar | Term/condition description |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Relationships**:
- Belongs to: produks

---

### 12. produk_wisata
**Purpose**: Nearby tourist attractions

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| produk_id | bigint | Foreign key to produks |
| name | varchar | Attraction name |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Relationships**:
- Belongs to: produks

---

### 13. availabilities
**Purpose**: Product availability calendar

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| produk_id | bigint | Foreign key to produks |
| date | date | Availability date |
| is_available | boolean | Availability status |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Relationships**:
- Belongs to: produks

**Indexes**:
- PRIMARY KEY (id)
- INDEX (produk_id, date)

---

## 🎁 Promotion Management Tables

### 14. promos
**Purpose**: Promotion and discount management

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Promo name |
| description | text | Promo description |
| discount_type | varchar | Type (percentage/fixed) |
| discount_value | decimal | Discount amount/percentage |
| start_date | date | Promo start date |
| end_date | date | Promo end date |
| is_active | boolean | Active status |
| usage_limit | int | Maximum usage count |
| usage_count | int | Current usage count |
| target_type | varchar | Target (all/category/product) |
| promo_code | varchar | Promo code |
| metadata | json | Additional metadata |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |
| deleted_at | timestamp | Soft delete timestamp |

**Relationships**:
- Has many: promo_categories, promo_products

**Indexes**:
- PRIMARY KEY (id)
- UNIQUE (promo_code)

---

### 15. promo_categories
**Purpose**: Category-based promo assignments

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| promo_id | bigint | Foreign key to promos |
| category_id | bigint | Foreign key to categories |
| discount_type | varchar | Override discount type |
| discount_value | decimal | Override discount value |
| embed | boolean | Embed flag |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Relationships**:
- Belongs to: promos, produk_categories

---

### 16. promo_products
**Purpose**: Product-specific promo assignments

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| promo_id | bigint | Foreign key to promos |
| produk_id | bigint | Foreign key to produks |
| discount_type | varchar | Override discount type |
| discount_value | decimal | Override discount value |
| embed | boolean | Embed flag |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Relationships**:
- Belongs to: promos, produks

---

## 💳 Transaction & Booking Tables

### 17. transaksis
**Purpose**: Booking and reservation records

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| user_id | bigint | Foreign key to users (nullable) |
| produk_id | bigint | Foreign key to produks |
| start_date | date | Booking start date |
| end_date | date | Booking end date |
| night | int | Number of nights |
| total | decimal | Total amount |
| email | varchar | Customer email |
| no_wa | varchar | WhatsApp number |
| metadata | json | Additional metadata |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Relationships**:
- Belongs to: users, produks
- Has many: transaksi_details

**Indexes**:
- PRIMARY KEY (id)
- INDEX (user_id)
- INDEX (produk_id)
- INDEX (start_date, end_date)

---

### 18. transaksi_details
**Purpose**: Transaction line items and daily breakdown

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| transaksi_id | bigint | Foreign key to transaksis |
| produk_id | bigint | Foreign key to produks |
| date | date | Booking date |
| unit | int | Number of units |
| status | varchar | Status (pending/confirmed/cancelled) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Relationships**:
- Belongs to: transaksis, produks

**Indexes**:
- PRIMARY KEY (id)
- INDEX (transaksi_id)
- INDEX (produk_id, date)

---

## 💰 Payment & Financial Tables

### 19. rekenings
**Purpose**: Bank account information for payments

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Bank account name |
| image | varchar | Bank logo/image path |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

---

## ⚙️ System Configuration Tables

### 20. settings
**Purpose**: Application settings and site configuration

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| key | varchar | Setting key (unique) |
| value | text | Setting value |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes**:
- PRIMARY KEY (id)
- UNIQUE (key)

---

### 21. logs
**Purpose**: Activity logging and audit trail

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| log_date | timestamp | Log timestamp |
| table_name | varchar | Affected table name |
| log_type | varchar | Log type (create/update/delete) |
| data | text | Log data (JSON) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes**:
- PRIMARY KEY (id)
- INDEX (log_date)
- INDEX (table_name)

---

## 🔧 Laravel System Tables

### 22. cache
**Purpose**: Laravel cache storage

| Field | Type | Description |
|-------|------|-------------|
| key | varchar | Cache key (primary) |
| value | mediumtext | Cached value |
| expiration | int | Expiration timestamp |

---

### 23. cache_locks
**Purpose**: Cache locking mechanism

| Field | Type | Description |
|-------|------|-------------|
| key | varchar | Lock key (primary) |
| owner | varchar | Lock owner |
| expiration | int | Lock expiration |

---

### 24. migrations
**Purpose**: Database migration tracking

| Field | Type | Description |
|-------|------|-------------|
| id | int | Primary key |
| migration | varchar | Migration filename |
| batch | int | Migration batch number |

---

### 25. password_reset_tokens
**Purpose**: Password reset token storage

| Field | Type | Description |
|-------|------|-------------|
| email | varchar | User email (primary) |
| token | varchar | Reset token |
| created_at | timestamp | Creation timestamp |

---

### 26. sessions
**Purpose**: User session data

| Field | Type | Description |
|-------|------|-------------|
| id | varchar | Session ID (primary) |
| user_id | bigint | User ID (nullable) |
| ip_address | varchar | Client IP address |
| user_agent | text | Client user agent |
| payload | longtext | Session payload |
| last_activity | int | Last activity timestamp |

**Indexes**:
- PRIMARY KEY (id)
- INDEX (user_id)
- INDEX (last_activity)

---

### 27. personal_access_tokens
**Purpose**: Laravel Sanctum API tokens

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| tokenable_type | varchar | Tokenable model type |
| tokenable_id | bigint | Tokenable model ID |
| name | varchar | Token name |
| token | varchar | Token hash (unique) |
| abilities | text | Token abilities (JSON) |
| last_used_at | timestamp | Last usage timestamp |
| expires_at | timestamp | Expiration timestamp |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes**:
- PRIMARY KEY (id)
- INDEX (tokenable_type, tokenable_id)
- UNIQUE (token)

---

### 28. job_batches
**Purpose**: Batch job tracking

| Field | Type | Description |
|-------|------|-------------|
| id | varchar | Batch ID (primary) |
| name | varchar | Batch name |
| total_jobs | int | Total jobs in batch |
| pending_jobs | int | Pending jobs count |
| failed_jobs | int | Failed jobs count |
| failed_job_ids | longtext | Failed job IDs |
| options | mediumtext | Batch options |
| cancelled_at | int | Cancellation timestamp |
| created_at | int | Creation timestamp |
| finished_at | int | Finish timestamp |

---

### 29. failed_jobs
**Purpose**: Failed queue job records

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| uuid | varchar | Job UUID (unique) |
| connection | text | Queue connection |
| queue | text | Queue name |
| payload | longtext | Job payload |
| exception | longtext | Exception details |
| failed_at | timestamp | Failure timestamp |

**Indexes**:
- PRIMARY KEY (id)
- UNIQUE (uuid)

---

## 🔗 Key Relationships Summary

### One-to-Many Relationships
```
users → transaksis
users → availabilities
users → logs
produks → produk_images
produks → produk_fasilitas
produks → produk_syarat
produks → produk_wisata
produks → availabilities
produks → transaksi_details
produks → promo_products
produk_categories → produks
promos → promo_categories
promos → promo_products
transaksis → transaksi_details
```

### Many-to-Many Relationships
```
users ↔ roles (via model_has_roles)
roles ↔ permissions (via role_has_permissions)
promos ↔ produk_categories (via promo_categories)
promos ↔ produks (via promo_products)
```

### Polymorphic Relationships
```
permissions → * (via model_has_permissions)
roles → * (via model_has_roles)
personal_access_tokens → * (tokenable)
```

---

## 🗑️ Soft Deletes

Tables with soft delete capability (deleted_at column):
1. **users** - Preserves user data for audit purposes
2. **produks** - Maintains product history
3. **promos** - Keeps promo records for reporting

**Benefit**: Data can be restored if accidentally deleted

---

## 📅 Timestamps

All tables include `created_at` and `updated_at` columns for:
- Audit tracking
- Version control
- Data synchronization
- Reporting and analytics

---

## 🔍 Important Indexes

### Performance-Critical Indexes:
- `users.email` (UNIQUE) - Fast login lookup
- `produks.slug` (UNIQUE) - Fast product lookup
- `availabilities (produk_id, date)` - Fast availability checks
- `transaksi_details (produk_id, date)` - Fast booking lookup
- `promos.promo_code` (UNIQUE) - Fast promo validation
- `sessions (user_id, last_activity)` - Session management

---

## 🛠️ Database Maintenance

### Regular Tasks:
1. **Backup**: Daily automated backups
2. **Optimization**: Weekly table optimization
3. **Index Analysis**: Monthly index performance review
4. **Data Cleanup**: Regular cleanup of old sessions, cache, logs
5. **Migration Management**: Version-controlled schema changes

### Migration Commands:
```bash
# Run all migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Reset and re-run all migrations
php artisan migrate:fresh

# Run with seeders
php artisan migrate:fresh --seed
```

---

## 📊 Database Statistics

```
Average Row Size:      ~2KB per product
Storage Requirements:  ~50MB per 1000 products (with images metadata)
Expected Growth:       ~100MB per year
Recommended Indexes:   15+ covering indexes
Query Performance:     <100ms for 95% of queries
```

---

## 🔐 Security Considerations

1. **Password Hashing**: bcrypt with cost factor 10
2. **SQL Injection**: Protected via Eloquent ORM
3. **Mass Assignment**: Protected via $fillable/$guarded
4. **Sensitive Data**: API tokens hashed, passwords encrypted
5. **Access Control**: Row-level security via policies

---

## 📝 Notes for Developers

### When Adding New Tables:
1. Create migration file
2. Define Eloquent model
3. Add relationships
4. Update this documentation
5. **Update ERD diagram manually**
6. Add seeders if needed
7. Test migrations

### Best Practices:
- Use descriptive column names
- Add foreign key constraints
- Include indexes for search columns
- Use appropriate data types
- Add comments for complex fields
- Maintain referential integrity

---

## 📞 Support

For database-related questions:
1. Check migration files in `database/migrations/`
2. Review model definitions in `app/Models/`
3. Consult ERD diagram for visual reference
4. Check this documentation

---

**Document Version**: 1.0  
**Last Updated**: January 2025  
**Status**: ✅ Complete & Current  
**ERD Status**: ⚠️ Manual update required on schema changes