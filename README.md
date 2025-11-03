# Shoeler - Shoe Store Management System

A comprehensive e-commerce platform built with Laravel 11 and MySQL, implementing Clean Architecture principles for maintainability and scalability.

---

## Quick Start

### Using Docker (Recommended)

```bash
docker compose up -d
```

The application will automatically:
- Install all dependencies
- Configure the database
- Run migrations and seeders
- Start the development server

**Access Points:**
- Application: http://localhost:8000
- Admin Panel: http://localhost:8000/admin
- phpMyAdmin: http://localhost:8080

**Default Credentials:**
- Admin: admin@shoeler.com / password
- User: john@example.com / password

For complete Docker documentation, see [DOCKER_GUIDE.md](DOCKER_GUIDE.md)

---

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Architecture](#architecture)
- [Installation](#installation)
- [Project Structure](#project-structure)
- [Database Schema](#database-schema)
- [Usage](#usage)
- [Development](#development)
- [Security](#security)
- [License](#license)

---

## Overview

Shoeler is a full-featured e-commerce platform designed for shoe retailers. Built with Laravel 11, it follows Clean Architecture principles to ensure separation of concerns, making the codebase maintainable, testable, and scalable.

**Core Capabilities:**

- Clean Architecture with distinct Domain, Application, Infrastructure, and Presentation layers
- Repository pattern for data access abstraction
- Service layer for business logic encapsulation
- Dependency injection for loose coupling
- Responsive UI with Bootstrap 5
- Role-based access control (Admin/Customer)
- Session-based shopping cart
- Advanced search and filtering
- Product review and rating system
- Promotional discount system

---

## Features

### Customer Interface

**Product Catalog**
- Browse shoes with pagination
- Advanced filtering (category, brand, price range, size)
- Keyword search functionality
- Product detail pages with images and specifications
- Customer reviews and ratings

**Shopping Experience**
- Session-based shopping cart
- Size and quantity selection
- Real-time price calculation (subtotal, tax, shipping)
- Promotional code application
- Multiple payment methods (COD, Bank Transfer, Credit Card, E-Wallet)

**User Account**
- User registration and authentication
- Profile management
- Order history and tracking
- Multiple shipping addresses
- Product review submission

### Administration Panel

**Dashboard**
- Sales analytics and statistics
- Revenue tracking
- Order status overview
- User metrics

**Catalog Management**
- CRUD operations for products and categories
- Stock level management
- Image uploads
- Discount/promotion configuration
- Featured product selection

**Order Management**
- Order listing and search
- Status updates (Pending, Processing, Shipped, Delivered, Cancelled)
- Payment status tracking
- Customer information access

**Marketing Tools**
- Promotional discount codes with usage constraints
- Homepage banner management
- Featured product promotion

---

## Technology Stack

**Backend:**
- Laravel 11 (PHP Framework)
- PHP 8.2+
- MySQL 8.0+
- Eloquent ORM
- Laravel Authentication

**Frontend:**
- Blade Templating Engine
- Bootstrap 5.3
- Bootstrap Icons
- Vanilla JavaScript

**Infrastructure:**
- Docker & Docker Compose
- Composer (Dependency Management)

**Development Standards:**
- PSR-4 Autoloading
- PSR-12 Coding Standards
- SOLID Principles

---

## Architecture

### Clean Architecture Implementation

The application follows Clean Architecture principles with clear separation of concerns across four distinct layers:

```
src/
├── Domain/                  # Enterprise Business Rules
│   ├── Entities/           # Core business objects (Category, Shoe, Order)
│   └── Repositories/       # Repository contracts (interfaces)
│
├── Application/            # Application Business Rules
│   └── Services/          # Use cases and orchestration logic
│
└── Infrastructure/         # Framework & External Integrations
    └── Repositories/      # Eloquent repository implementations

app/                        # Presentation Layer (Laravel)
├── Http/
│   ├── Controllers/       # Request handlers
│   └── Middleware/        # Request filters
├── Models/                # Eloquent models
└── Providers/             # Dependency injection bindings
```

### Layer Responsibilities

**1. Domain Layer** (Pure Business Logic)
- Defines business entities and their behavior
- Declares repository interfaces without implementation details
- Framework-independent and contains no external dependencies

**2. Application Layer** (Use Cases)
- Implements application-specific business rules
- Contains services: ShoeService, OrderService, CartService, etc.
- Orchestrates data flow between domain and infrastructure

**3. Infrastructure Layer** (Technical Implementation)
- Implements repository interfaces using Eloquent ORM
- Handles database queries and data persistence
- Manages external integrations

**4. Presentation Layer** (User Interface)
- Controllers handle HTTP requests and responses
- Blade templates render HTML views
- Middleware manages authentication and authorization

### Design Patterns

- **Repository Pattern**: Abstracts data access logic
- **Service Pattern**: Encapsulates business logic
- **Dependency Injection**: Achieves loose coupling
- **Interface-based Programming**: Enables flexibility and testability

### Principles Applied

- Single Responsibility Principle (SRP)
- Dependency Inversion Principle (DIP)
- Don't Repeat Yourself (DRY)
- Keep It Simple, Stupid (KISS)

For detailed architecture documentation, see [ARCHITECTURE.md](ARCHITECTURE.md)

---

## Installation

### Prerequisites

**Docker Installation (Recommended):**
- Docker Desktop (Windows/Mac) or Docker Engine (Linux)

**Manual Installation:**
- PHP >= 8.2
- Composer >= 2.0
- MySQL >= 8.0
- Web server (Apache/Nginx) or PHP built-in server

### Docker Setup (Recommended)

**1. Clone the repository**
```bash
git clone https://github.com/tiao051/Shoeflow.git
cd shoeler
```

**2. Start the application**
```bash
docker compose up -d
```

**3. Access the application**
- Application: http://localhost:8000
- Admin Panel: http://localhost:8000/admin
- phpMyAdmin: http://localhost:8080

The Docker setup automatically handles:
- Composer dependency installation
- Environment file generation
- Application key generation
- Database creation and migration
- Sample data seeding
- Storage symlink creation
- Development server startup

### Manual Setup

**1. Clone the repository**
```bash
git clone https://github.com/tiao051/Shoeflow.git
cd shoeler
```

**2. Install dependencies**
```bash
composer install
```

**3. Configure environment**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Configure database**

Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shoeler_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

**5. Create database**
```sql
CREATE DATABASE shoeler_db;
```

**6. Run migrations and seeders**
```bash
php artisan migrate
php artisan db:seed
```

**7. Create storage symlink**
```bash
php artisan storage:link
```

**8. Start development server**
```bash
php artisan serve
```

**9. Access the application**

Visit http://localhost:8000

---

## Project Structure

```
shoeler/
├── app/                        # Laravel Application Layer
│   ├── Http/
│   │   ├── Controllers/        # Request handlers
│   │   │   ├── Admin/          # Admin controllers
│   │   │   └── ...             # Customer controllers
│   │   └── Middleware/         # Custom middleware
│   ├── Models/                 # Eloquent models
│   └── Providers/              # Service providers
│
├── config/                     # Configuration files
│   ├── app.php
│   ├── database.php
│   └── ...
│
├── database/
│   ├── migrations/             # Database schema migrations
│   ├── seeders/                # Sample data seeders
│   └── factories/              # Model factories
│
├── public/                     # Public web root
│   └── index.php               # Application entry point
│
├── resources/
│   └── views/                  # Blade templates
│       ├── layouts/            # Layout templates
│       ├── admin/              # Admin views
│       ├── auth/               # Authentication views
│       └── ...                 # Customer views
│
├── routes/
│   └── web.php                 # Web route definitions
│
├── src/                        # Clean Architecture Layers
│   ├── Domain/
│   │   ├── Entities/           # Business entities
│   │   └── Repositories/       # Repository interfaces
│   ├── Application/
│   │   └── Services/           # Business services
│   └── Infrastructure/
│       └── Repositories/       # Repository implementations
│
├── storage/                    # Application storage
│   ├── app/public/             # Public file uploads
│   ├── framework/              # Framework cache/sessions
│   └── logs/                   # Application logs
│
├── docker-compose.yml          # Docker service definitions
├── Dockerfile                  # Docker image configuration
├── .env.example                # Environment template
└── composer.json               # PHP dependencies
```

---

## Database Schema

### Tables

1. **users** - User accounts (customers and administrators)
2. **categories** - Product category taxonomy
3. **shoes** - Product catalog with specifications
4. **orders** - Customer purchase orders
5. **order_items** - Line items for each order
6. **addresses** - User shipping addresses
7. **reviews** - Product reviews and ratings
8. **promotions** - Discount codes and vouchers
9. **banners** - Homepage promotional banners
10. **contacts** - Customer support inquiries

### Relationships

- categories → shoes (one-to-many)
- users → orders (one-to-many)
- users → addresses (one-to-many)
- users → reviews (one-to-many)
- orders → order_items (one-to-many)
- shoes → reviews (one-to-many)
- shoes → order_items (one-to-many)

---

## Usage

### Customer Workflow

**1. Browse Products**
- Visit homepage for featured products
- Navigate to "All Shoes" for complete catalog
- Apply filters (category, brand, price, size)
- Search by keyword

**2. Shopping Cart**
- Select product size and quantity
- Add items to cart
- Update quantities or remove items
- View cart summary

**3. Checkout**
- Proceed to checkout from cart
- Enter shipping information
- Select payment method
- Apply promotional code (optional)
- Review and confirm order

**4. Account Management**
- Register new account or login
- Update profile information
- View order history
- Manage shipping addresses
- Submit product reviews

### Administrator Workflow

**1. Access Admin Panel**
- Login with admin credentials
- Navigate to /admin

**2. Manage Categories**
- Create, edit, delete categories
- Toggle active/inactive status
- Set category slugs

**3. Manage Products**
- Add new products with details
- Upload product images
- Set pricing and discounts
- Manage inventory levels
- Mark products as featured

**4. Manage Orders**
- View all customer orders
- Update order status
- Track payment status
- View customer details

**5. Manage Promotions**
- Create discount codes
- Set discount type (percentage/fixed amount)
- Define validity period
- Configure usage limits and minimum purchase amounts

**6. Manage Banners**
- Upload promotional banners
- Configure display order
- Set banner links

---

## Development

### Docker Commands

**View logs:**
```bash
# All services
docker compose logs -f

# Application only
docker compose logs -f app

# Database only
docker compose logs -f mysql
```

**Restart services:**
```bash
docker compose restart
```

**Stop services:**
```bash
docker compose down
```

**Rebuild containers:**
```bash
docker compose up -d --build
```

### Artisan Commands (with Docker)

```bash
# Clear application cache
docker compose exec app php artisan cache:clear

# Clear configuration cache
docker compose exec app php artisan config:clear

# Run migrations
docker compose exec app php artisan migrate

# Rollback migrations
docker compose exec app php artisan migrate:rollback

# Reset database with fresh data
docker compose exec app php artisan migrate:fresh --seed

# Create new controller
docker compose exec app php artisan make:controller ExampleController

# Create new migration
docker compose exec app php artisan make:migration create_example_table

# List all routes
docker compose exec app php artisan route:list
```

### Database Access

**MySQL CLI:**
```bash
docker compose exec mysql mysql -u shoeler -p
# Password: shoeler123
```

**phpMyAdmin:**

Visit http://localhost:8080
- Server: mysql
- Username: shoeler
- Password: shoeler123

### Code Quality Standards

The codebase adheres to:
- PSR-12 coding standards
- Meaningful variable and function naming
- Single Responsibility Principle
- DRY (Don't Repeat Yourself)
- Comprehensive input validation
- Proper error handling
- SQL injection prevention via Eloquent ORM

---

## Security

**Authentication & Authorization:**
- Bcrypt password hashing
- Session-based authentication
- Role-based access control (Admin/Customer)
- CSRF token protection on all forms

**Data Protection:**
- SQL injection prevention via Eloquent ORM
- XSS protection via Blade templating
- Input validation and sanitization
- Prepared database statements

**Best Practices:**
- Environment variables for sensitive configuration
- Secure session management
- HTTP-only cookies
- Database credentials excluded from version control

---

## License

This project is licensed under the MIT License.

---

## Additional Resources

- [DOCKER_GUIDE.md](DOCKER_GUIDE.md) - Complete Docker documentation
- [QUICKSTART.md](QUICKSTART.md) - Quick reference guide
- [ARCHITECTURE.md](ARCHITECTURE.md) - Detailed architecture documentation

---

Developed with Laravel 11 implementing Clean Architecture principles.
