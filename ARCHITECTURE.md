# Shoeler - Architecture Documentation

## Clean Architecture Overview

This project implements **Clean Architecture** principles with clear separation of concerns across four distinct layers.

```
┌─────────────────────────────────────────────────────────────────┐
│                        PRESENTATION LAYER                        │
│                     (Framework & Interfaces)                     │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  Controllers, Views, Middleware, Routes                  │  │
│  │  - HTTP Request Handling                                 │  │
│  │  - Response Formatting                                   │  │
│  │  - View Rendering (Blade Templates)                      │  │
│  └──────────────────────────────────────────────────────────┘  │
└───────────────────────────────┬─────────────────────────────────┘
                                │
                                ▼
┌─────────────────────────────────────────────────────────────────┐
│                       APPLICATION LAYER                          │
│                  (Business Logic & Use Cases)                    │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  Services (ShoeService, OrderService, etc.)              │  │
│  │  - Business Rules Implementation                         │  │
│  │  - Use Case Orchestration                                │  │
│  │  - Data Flow Management                                  │  │
│  └──────────────────────────────────────────────────────────┘  │
└───────────────────────────────┬─────────────────────────────────┘
                                │
                                ▼
┌─────────────────────────────────────────────────────────────────┐
│                     INFRASTRUCTURE LAYER                         │
│                  (Data Access & External Services)               │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  Repository Implementations                              │  │
│  │  - Eloquent ORM Integration                              │  │
│  │  - Database Operations                                   │  │
│  │  - External Service Integrations                         │  │
│  └──────────────────────────────────────────────────────────┘  │
└───────────────────────────────┬─────────────────────────────────┘
                                │
                                ▼
┌─────────────────────────────────────────────────────────────────┐
│                         DOMAIN LAYER                             │
│                  (Core Business Entities & Rules)                │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  Entities (Shoe, Order, Category)                        │  │
│  │  Repository Interfaces                                   │  │
│  │  - Pure Business Objects                                 │  │
│  │  - No Framework Dependencies                             │  │
│  └──────────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────────┘
```

## Layer Details

### 1. Domain Layer (`src/Domain/`)

**Purpose**: Contains enterprise business rules and core domain logic.

**Components**:
- **Entities**: Pure business objects (Shoe, Order, Category)
- **Repository Interfaces**: Define data access contracts

**Key Files**:
```
src/Domain/
├── Entities/
│   ├── Category.php
│   ├── Shoe.php
│   └── Order.php
└── Repositories/
    ├── CategoryRepositoryInterface.php
    ├── ShoeRepositoryInterface.php
    ├── OrderRepositoryInterface.php
    ├── ReviewRepositoryInterface.php
    └── PromotionRepositoryInterface.php
```

**Characteristics**:
- ✅ Framework-independent
- ✅ Database-independent
- ✅ No external dependencies
- ✅ Highly testable

### 2. Application Layer (`src/Application/`)

**Purpose**: Contains application-specific business rules and use cases.

**Components**:
- **Services**: Business logic implementation
- **Use Cases**: Application workflows

**Key Files**:
```
src/Application/
└── Services/
    ├── ShoeService.php
    ├── OrderService.php
    ├── CartService.php
    ├── CategoryService.php
    └── ReviewService.php
```

**Responsibilities**:
- 🔄 Orchestrate business operations
- 🔄 Coordinate between repositories
- 🔄 Implement business rules
- 🔄 Data transformation

### 3. Infrastructure Layer (`src/Infrastructure/`)

**Purpose**: Implements interfaces defined in the domain layer.

**Components**:
- **Repository Implementations**: Eloquent-based data access

**Key Files**:
```
src/Infrastructure/
└── Repositories/
    ├── CategoryRepository.php
    ├── ShoeRepository.php
    ├── OrderRepository.php
    ├── ReviewRepository.php
    └── PromotionRepository.php
```

**Responsibilities**:
- 💾 Database operations via Eloquent
- 💾 External service integrations
- 💾 File storage operations
- 💾 Cache management

### 4. Presentation Layer (`app/`)

**Purpose**: Handles HTTP requests and user interface.

**Components**:
- **Controllers**: Request handlers
- **Views**: Blade templates
- **Middleware**: Request filters
- **Models**: Eloquent models

**Key Files**:
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── HomeController.php
│   │   ├── ShoeController.php
│   │   ├── CartController.php
│   │   ├── CheckoutController.php
│   │   ├── ProfileController.php
│   │   ├── Admin/
│   │   │   ├── DashboardController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── ShoeController.php
│   │   │   └── OrderController.php
│   │   └── Auth/
│   │       └── AuthController.php
│   └── Middleware/
│       └── AdminMiddleware.php
├── Models/
│   ├── User.php
│   ├── Category.php
│   ├── Shoe.php
│   ├── Order.php
│   └── ...
└── Providers/
    ├── AppServiceProvider.php
    └── RepositoryServiceProvider.php
```

## Data Flow Diagram

```
┌──────────┐         ┌──────────────┐         ┌──────────────┐
│          │         │              │         │              │
│  User    │────────▶│  Controller  │────────▶│   Service    │
│          │ Request │              │  Calls  │              │
└──────────┘         └──────────────┘         └──────────────┘
                            │                        │
                            │                        ▼
                            │                 ┌──────────────┐
                            │                 │              │
                            │                 │  Repository  │
                            │                 │              │
                            │                 └──────────────┘
                            │                        │
                            │                        ▼
                            │                 ┌──────────────┐
                            │                 │              │
                            │                 │   Eloquent   │
                            │                 │    Model     │
                            │                 │              │
                            │                 └──────────────┘
                            │                        │
                            ▼                        ▼
                      ┌──────────────────────────────────┐
                      │                                  │
                      │           Database               │
                      │                                  │
                      └──────────────────────────────────┘
```

## Dependency Injection

The application uses Laravel's Service Container for dependency injection:

```php
// RepositoryServiceProvider.php
public function register(): void
{
    $this->app->bind(
        CategoryRepositoryInterface::class, 
        CategoryRepository::class
    );
    
    $this->app->bind(
        ShoeRepositoryInterface::class, 
        ShoeRepository::class
    );
    
    // ... more bindings
}
```

## Example Request Flow

### Customer Viewing Product Details

```
1. User visits: /shoes/nike-air-max-90

2. Route: routes/web.php
   └─▶ Route::get('/shoes/{slug}', [ShoeController::class, 'show'])

3. Controller: ShoeController@show
   └─▶ Injects ShoeService
   └─▶ Calls: $this->shoeService->getShoeBySlug($slug)

4. Service: ShoeService@getShoeBySlug
   └─▶ Injects ShoeRepositoryInterface
   └─▶ Calls: $this->shoeRepository->findBySlug($slug)

5. Repository: ShoeRepository@findBySlug
   └─▶ Uses Eloquent Model
   └─▶ Returns: Shoe Entity

6. Entity: Domain\Entities\Shoe
   └─▶ Pure business object
   └─▶ Contains business logic methods

7. View: resources/views/shoes/show.blade.php
   └─▶ Renders product details
   └─▶ Returns HTML to user
```

### Admin Creating New Product

```
1. Admin submits form: POST /admin/shoes

2. Controller: Admin\ShoeController@store
   └─▶ Validates input
   └─▶ Injects ShoeService
   └─▶ Calls: $this->shoeService->createShoe($data)

3. Service: ShoeService@createShoe
   └─▶ Applies business rules
   └─▶ Injects ShoeRepositoryInterface
   └─▶ Calls: $this->shoeRepository->create($data)

4. Repository: ShoeRepository@create
   └─▶ Uses Eloquent Model
   └─▶ Persists to database
   └─▶ Returns: Shoe Entity

5. Controller redirects with success message
```

## Benefits of This Architecture

### 1. Separation of Concerns
- Each layer has a single, well-defined responsibility
- Changes in one layer don't affect others

### 2. Testability
- Domain layer can be tested without framework
- Services can be tested with mocked repositories
- Controllers can be tested with mocked services

### 3. Maintainability
- Clear structure makes code easy to understand
- New features can be added without breaking existing code
- Bug fixes are localized to specific layers

### 4. Flexibility
- Easy to switch databases (change repository implementation)
- Easy to switch frameworks (domain layer is independent)
- Easy to add new features (extend services)

### 5. Scalability
- Layers can be scaled independently
- Clear boundaries enable microservices migration
- Repository pattern enables caching strategies

## SOLID Principles Applied

### Single Responsibility Principle (SRP)
- Each class has one reason to change
- Controllers handle HTTP, Services handle business logic
- Repositories handle data access

### Open/Closed Principle (OCP)
- Open for extension, closed for modification
- New features added via new classes, not modifying existing ones

### Liskov Substitution Principle (LSP)
- Repository interfaces can be substituted with any implementation
- Mock repositories for testing

### Interface Segregation Principle (ISP)
- Repository interfaces are focused and specific
- No fat interfaces

### Dependency Inversion Principle (DIP)
- High-level modules depend on abstractions (interfaces)
- Low-level modules implement interfaces
- Laravel's Service Container manages dependencies

## Database Schema Relationships

```
users ─┬─── orders
       ├─── addresses
       └─── reviews

categories ─── shoes ─┬─── reviews
                      ├─── order_items
                      └─── (category relationship)

orders ─── order_items ─── shoes

promotions (standalone)

banners (standalone)

contacts (standalone)
```

## Conclusion

This Clean Architecture implementation ensures:
- ✅ **Maintainable** codebase
- ✅ **Testable** components
- ✅ **Scalable** structure
- ✅ **Framework-independent** core
- ✅ **Professional** code organization

The architecture allows the application to evolve and adapt to changing requirements while maintaining code quality and developer productivity.
