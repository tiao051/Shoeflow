# Shoeler - Shoe Store Management System

A comprehensive web-based shoe store management system built with **Laravel 11**, **MySQL**, and **Clean Architecture** principles. This application provides a complete e-commerce solution for managing and selling shoes online with separate interfaces for customers and administrators.

---

## � Quick Start with Docker (Recommended)

**The easiest way to run Shoeler - just one command!**

### Prerequisites
- Install [Docker Desktop](https://www.docker.com/products/docker-desktop) (includes Docker Compose)

### Start the Application

**On Windows:**
```bash
start.bat
```

**On Mac/Linux:**
```bash
./start.sh
```

**Or manually:**
```bash
docker compose up -d
```

### Access the Application

- **Application**: http://localhost:8000
- **Admin Dashboard**: http://localhost:8000/admin
- **phpMyAdmin**: http://localhost:8080

**Admin Login:**
- Email: `admin@shoeler.com`
- Password: `password`

👉 **For complete Docker documentation, see [DOCKER_GUIDE.md](DOCKER_GUIDE.md)**

---

##  Table of Contents

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

Shoeler is a full-featured e-commerce platform for shoe retailers, built with Laravel 11 and following Clean Architecture principles. The application separates business logic from infrastructure concerns, making it maintainable, testable, and scalable.

**Key Characteristics:**

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
- Search functionality
- Product detail pages with images and specifications
- Customer reviews and ratings

**Shopping Experience**
- Session-based shopping cart
- Size and quantity selection
- Real-time price calculation including tax and shipping
- Promo code application
- Multiple payment methods (COD, Bank Transfer, Credit Card, E-Wallet)

**User Account**
- User registration and authentication
- Profile management
- Order history and tracking
- Shipping address management
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
- Order status updates (Pending, Processing, Shipped, Delivered, Cancelled)
- Payment status tracking
- Customer information access

**Marketing Tools**
- Promotional discount codes with constraints
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

**Development:**
- PSR-4 Autoloading
- PSR-12 Coding Standards

---

## Architecture

### Clean Architecture Implementation

The application follows Clean Architecture principles, organizing code into distinct layers with clear dependencies:

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

**Layer Responsibilities:**

1. **Domain Layer**: Pure business logic, framework-independent
   - Defines business entities and their behavior
   - Declares repository interfaces without implementation details

2. **Application Layer**: Application-specific business rules
   - Implements use cases (ShoeService, OrderService, CartService)
   - Orchestrates data flow between domain and infrastructure

3. **Infrastructure Layer**: Technical implementation details
   - Implements repository interfaces using Eloquent
   - Handles database queries and data persistence

4. **Presentation Layer**: User interface and HTTP handling
   - Controllers receive requests and return responses
   - Views render HTML using Blade templates
   - Middleware handles authentication and authorization

**Design Patterns:**

- Repository Pattern for data access abstraction
- Service Pattern for business logic encapsulation
- Dependency Injection for loose coupling
- Interface-based programming for flexibility

**Principles Applied:**

- Single Responsibility Principle
- Dependency Inversion Principle
- Don't Repeat Yourself (DRY)
- Keep It Simple (KISS)

---

## Installation

### Prerequisites

**Using Docker:**
- Docker Desktop (Windows/Mac) or Docker Engine (Linux)

**Manual Installation:**
- PHP >= 8.2
- Composer >= 2.0
- MySQL >= 8.0
- Web server (Apache/Nginx) or use PHP built-in server

### Docker Installation (Recommended)

1. Clone the repository
```bash
git clone <repository-url>
cd shoeler
```

2. Start the application
```bash
docker compose up -d
```

3. Access the application
- Application: http://localhost:8000
- phpMyAdmin: http://localhost:8080
- Admin login: admin@shoeler.com / password

The Docker setup automatically handles:
- Dependency installation
- Environment configuration
- Database creation and migration
- Sample data seeding
- Server startup

### Manual Installation

1. Clone the repository
```bash
git clone <repository-url>
cd shoeler
```

2. Install PHP dependencies
```bash
composer install
```

3. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database in `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shoeler_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

5. Create database
```sql
CREATE DATABASE shoeler_db;
```

6. Run migrations and seed data
```bash
php artisan migrate
php artisan db:seed
```

7. Create storage symlink
```bash
php artisan storage:link
```

8. Start the development server
```bash
php artisan serve
```

9. Visit http://localhost:8000

---

## Project Structure

```
shoeler/
├── app/                        # Application layer
│   ├── Http/
│   │   ├── Controllers/        # HTTP controllers
│   │   │   ├── Admin/          # Admin controllers
│   │   │   ├── Auth/           # Authentication controllers
│   │   │   └── ...             # Customer controllers
│   │   └── Middleware/         # Custom middleware
│   ├── Models/                 # Eloquent models
│   └── Providers/              # Service providers
│
├── bootstrap/                  # Application bootstrap
│   ├── app.php                 # Application bootstrap
│   └── providers.php           # Service provider registration
│
├── config/                     # Configuration files
│   ├── app.php
│   ├── database.php
│   └── ...
│
├── database/                   # Database files
│   ├── migrations/             # Database migrations
│   ├── seeders/                # Database seeders
│   └── factories/              # Model factories
│
├── public/                     # Public assets
│   ├── index.php               # Entry point
│   └── storage/                # Symlink to storage
│
├── resources/                  # Views and assets
│   └── views/                  # Blade templates
│       ├── layouts/            # Layout templates
│       ├── auth/               # Authentication views
│       ├── admin/              # Admin views
│       ├── shoes/              # Product views
│       └── ...
│
├── routes/                     # Route definitions
│   ├── web.php                 # Web routes
│   └── console.php             # Console routes
│
├── src/                        # Clean Architecture layers
│   ├── Domain/                 # Domain layer
│   │   ├── Entities/           # Business entities
│   │   └── Repositories/       # Repository interfaces
│   │
│   ├── Application/            # Application layer
│   │   └── Services/           # Business services
│   │
│   └── Infrastructure/         # Infrastructure layer
│       └── Repositories/       # Repository implementations
│
├── storage/                    # Storage files
│   ├── app/
│   │   └── public/             # Public uploads
│   ├── framework/
│   └── logs/
│
├── .env.example                # Environment template
├── composer.json               # PHP dependencies
└── README.md                   # This file
```

---

## Database Schema

### Core Tables

1. **users** - User accounts (customers and admins)
2. **categories** - Product categories
3. **shoes** - Product catalog
4. **orders** - Customer orders
5. **order_items** - Order line items
6. **addresses** - User shipping addresses
7. **reviews** - Product reviews and ratings
8. **promotions** - Discount codes and vouchers
9. **banners** - Homepage promotional banners
10. **contacts** - Customer inquiries

### Key Relationships

- `categories` → `shoes` (1-to-many)
- `users` → `orders` (1-to-many)
- `users` → `addresses` (1-to-many)
- `users` → `reviews` (1-to-many)
- `orders` → `order_items` (1-to-many)
- `shoes` → `reviews` (1-to-many)
- `shoes` → `order_items` (1-to-many)

---

## Usage

### For Customers

1. **Browse Products**
   - Visit homepage to see featured shoes
   - Click "All Shoes" to browse complete catalog
   - Use filters to narrow down products
   - Click on product to view details

2. **Add to Cart**
   - Select size and quantity
   - Click "Add to Cart"
   - View cart from navigation menu

3. **Checkout**
   - Click "Proceed to Checkout" from cart
   - Fill in shipping information
   - Select payment method
   - Apply promo code (optional)
   - Confirm order

4. **Manage Account**
   - Register/Login from navigation
   - Update profile information
   - View order history
   - Manage shipping addresses
   - Write product reviews

### For Administrators

1. **Login**
   - Use admin credentials: `admin@shoeler.com` / `password`
   - Access admin panel from navigation

2. **Manage Categories**
   - Navigate to Categories
   - Create, edit, or delete categories
   - Set category status (active/inactive)

3. **Manage Products**
   - Navigate to Shoes
   - Add new shoes with details
   - Upload product images
   - Set prices and discounts
   - Manage stock levels
   - Mark products as featured

4. **Manage Orders**
   - View all orders
   - Update order status (pending → processing → shipped → delivered)
   - Update payment status
   - View order details and customer info

5. **Manage Promotions**
   - Create discount codes
   - Set discount type (percentage/fixed)
   - Define validity period
   - Set usage limits

6. **Manage Banners**
   - Upload promotional banners
   - Set display order
   - Add links to banner images

---

## Development

### Running Artisan Commands

**With Docker:**
```bash
docker compose exec app php artisan <command>
```

**Examples:**
```bash
# Clear cache
docker compose exec app php artisan cache:clear

# Run migrations
docker compose exec app php artisan migrate

# Create new migration
docker compose exec app php artisan make:migration create_example_table

# Create new controller
docker compose exec app php artisan make:controller ExampleController

# List all routes
docker compose exec app php artisan route:list
```

### Database Operations

**Reset database:**
```bash
docker compose exec app php artisan migrate:fresh --seed
```

**Access MySQL CLI:**
```bash
docker compose exec mysql mysql -u shoeler -p
# Password: shoeler123
```

### Logs

**View application logs:**
```bash
docker compose logs -f app
```

**View specific service logs:**
```bash
docker compose logs -f mysql
docker compose logs -f phpmyadmin
```

### Stopping the Application

```bash
docker compose down
```

### Code Quality

The codebase follows PSR-12 coding standards and implements:
- Meaningful variable and function names
- Single Responsibility Principle
- DRY (Don't Repeat Yourself)
- Proper error handling
- Input validation on all forms
- Eloquent ORM to prevent SQL injection

---

## Security

- Password hashing with bcrypt
- CSRF protection on all forms
- SQL injection prevention via Eloquent ORM
- XSS protection via Blade templating
- Role-based access control
- Middleware authentication
- Session management
- Input validation

---

## 🎨 UI/UX Design

### Design Principles

- **Minimalist**: Clean and uncluttered interface
- **Responsive**: Mobile-first approach
- **Accessible**: Semantic HTML and ARIA labels
- **Consistent**: Uniform color scheme and typography
- **User-friendly**: Intuitive navigation and clear CTAs

### Color Scheme

- Primary: `#2c3e50` (Dark blue-gray)
- Secondary: `#34495e` (Slate)
- Accent: `#7f8c8d` (Gray)
- Background: `#ffffff` (White)
- Light Background: `#f8f9fa` (Light gray)

---

## 🧪 Testing

### Manual Testing Checklist

- [ ] User registration and login
- [ ] Product browsing and filtering
- [ ] Add to cart functionality
- [ ] Checkout process
- [ ] Order placement
- [ ] Admin CRUD operations
- [ ] File uploads
- [ ] Form validations
- [ ] Responsive design

---

## 📝 Code Quality

### Clean Code Principles Applied

1. **Meaningful Names**: Variables, functions, and classes have descriptive names
2. **Single Responsibility**: Each class/function has one clear purpose
3. **DRY (Don't Repeat Yourself)**: No code duplication
4. **KISS (Keep It Simple)**: Simple, straightforward solutions
5. **SOLID Principles**: Proper object-oriented design
6. **Separation of Concerns**: Clear layer boundaries

---

## 🚀 Deployment

### Production Checklist

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false`
3. Configure proper database credentials
4. Set up SSL certificate (HTTPS)
5. Configure mail server
6. Optimize autoloader: `composer install --optimize-autoloader --no-dev`
7. Cache configuration: `php artisan config:cache`
8. Cache routes: `php artisan route:cache`
9. Cache views: `php artisan view:cache`
10. Set proper file permissions

---

## 🤝 Contributing

Contributions are welcome! Please follow these guidelines:

1. Fork the repository
2. Create a feature branch
3. Follow coding standards (PSR-12)
4. Write meaningful commit messages
5. Create pull request with description

---

## 📄 License

This project is licensed under the MIT License.

---

## 👨‍💻 Developer

Developed with ❤️ using Laravel 11 and Clean Architecture principles.

---

## 📞 Support

For support and questions:
- Email: info@shoeler.com
- Documentation: This README file
- Issues: Use GitHub Issues

---

## 🙏 Acknowledgments

- Laravel Framework
- Bootstrap Team
- Bootstrap Icons
- All open-source contributors

---

**Happy Coding! 🎉**
