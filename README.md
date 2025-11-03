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

- [Quick Start with Docker](#-quick-start-with-docker-recommended)
- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Clean Architecture](#clean-architecture)
- [System Requirements](#system-requirements)
- [Installation Guide](#installation-guide)
  - [Docker Setup (Recommended)](#docker-setup-recommended)
  - [Manual Installation](#manual-installation)
- [Project Structure](#project-structure)
- [Database Schema](#database-schema)
- [Usage Guide](#usage-guide)
- [API Documentation](#api-documentation)
- [Screenshots](#screenshots)
- [Contributing](#contributing)
- [License](#license)

---

## 🎯 Overview

Shoeler is a modern shoe store management web application designed following **Clean Architecture** and **Clean Code** principles. It offers a minimalist, responsive UI for both customers and administrators, ensuring seamless user experience across all devices.

### Key Highlights

- ✅ **Clean Architecture**: Separation of concerns with Domain, Application, Infrastructure, and Presentation layers
- ✅ **Clean Code**: Readable, maintainable, and modular codebase
- ✅ **Responsive Design**: Mobile-first approach with Bootstrap 5
- ✅ **Role-based Access**: Admin and User roles with proper authorization
- ✅ **Complete CRUD**: Full Create, Read, Update, Delete operations
- ✅ **Search & Filter**: Advanced product search and filtering capabilities
- ✅ **Reviews System**: Customer reviews and ratings
- ✅ **Promotions**: Discount codes and vouchers
- ✅ **Order Management**: Complete order tracking and management

---

## ✨ Features

### Customer Features

1. **Homepage**
   - Featured shoes carousel
   - Product categories navigation
   - Promotional banners
   - Latest arrivals

2. **Product Browsing**
   - View all shoes with pagination
   - Filter by category, brand, price, size
   - Real-time search functionality
   - Product details with images and reviews
   - Rating and review system

3. **Shopping Cart**
   - Add/update/remove items
   - Automatic price calculation
   - Size selection
   - Quantity management

4. **Checkout Process**
   - Shipping information form
   - Multiple payment methods (COD, Bank Transfer, Credit Card, E-Wallet)
   - Promo code application
   - Order summary and confirmation

5. **User Account**
   - Registration and login
   - Profile management
   - Order history tracking
   - Address book management
   - Review management

### Admin Features

1. **Dashboard**
   - Sales statistics
   - Revenue tracking
   - Order analytics
   - Recent orders overview

2. **Product Management**
   - CRUD operations for shoes
   - Category management
   - Stock tracking
   - Image upload
   - Bulk operations

3. **Order Management**
   - View all orders
   - Update order status
   - Update payment status
   - Order details view
   - Customer information

4. **Promotion Management**
   - Create discount codes
   - Set validity periods
   - Usage limits
   - Minimum purchase requirements

5. **Banner Management**
   - Homepage banner CRUD
   - Image upload
   - Link management
   - Display order control

6. **User Management**
   - View customer list
   - User statistics

---

## 🛠 Tech Stack

### Backend
- **Framework**: Laravel 11
- **Language**: PHP 8.2+
- **Database**: MySQL 8.0+
- **ORM**: Eloquent
- **Authentication**: Laravel Auth

### Frontend
- **Template Engine**: Blade
- **CSS Framework**: Bootstrap 5.3
- **Icons**: Bootstrap Icons
- **JavaScript**: Vanilla JS (minimal)

### Architecture
- **Pattern**: Clean Architecture
- **Principles**: SOLID, DRY, KISS
- **Repository Pattern**: Interface-based repositories
- **Service Layer**: Business logic separation

---

## 🏗 Clean Architecture

This project follows Clean Architecture principles with clear separation of concerns:

```
src/
├── Domain/              # Enterprise Business Rules
│   ├── Entities/        # Business objects
│   └── Repositories/    # Repository interfaces
│
├── Application/         # Application Business Rules
│   └── Services/        # Use cases and business logic
│
└── Infrastructure/      # Frameworks & Drivers
    └── Repositories/    # Repository implementations

app/                     # Presentation Layer
├── Http/
│   ├── Controllers/     # HTTP request handlers
│   └── Middleware/      # Request filters
└── Models/              # Eloquent models
```

### Layer Responsibilities

1. **Domain Layer** (`src/Domain/`)
   - Contains enterprise business rules
   - Defines entities and repository interfaces
   - Independent of frameworks and external dependencies

2. **Application Layer** (`src/Application/`)
   - Contains application-specific business rules
   - Implements use cases and services
   - Orchestrates data flow between layers

3. **Infrastructure Layer** (`src/Infrastructure/`)
   - Implements repository interfaces
   - Handles data persistence
   - Interacts with Eloquent ORM

4. **Presentation Layer** (`app/`)
   - Controllers handle HTTP requests
   - Blade views render UI
   - Middleware handles authentication/authorization

---

## 💻 System Requirements

- PHP >= 8.2
- Composer >= 2.0
- MySQL >= 8.0 or MariaDB >= 10.3
- Node.js >= 18.x (for asset compilation, optional)
- Web Server (Apache/Nginx)

### Recommended
- 2GB RAM minimum
- 1GB free disk space
- Modern web browser (Chrome, Firefox, Safari, Edge)

---

## 📦 Installation Guide

### 1. Clone the Repository

```bash
git clone <repository-url>
cd shoeler
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

```bash
# Copy environment file
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database

Edit `.env` file and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shoeler_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Create Database

```bash
# Using MySQL command line
mysql -u root -p
CREATE DATABASE shoeler_db;
exit;
```

### 6. Run Migrations

```bash
php artisan migrate
```

### 7. Seed Database (Optional)

```bash
php artisan db:seed
```

This will create:
- Admin account: `admin@shoeler.com` / `password`
- Sample users
- Sample categories
- Sample shoes
- Sample promotions

### 8. Create Storage Link

```bash
php artisan storage:link
```

### 9. Start Development Server

```bash
php artisan serve
```

Visit: `http://localhost:8000`

---

## 📁 Project Structure

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

## 🗄 Database Schema

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

## 📖 Usage Guide

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

## 🔒 Security Features

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
