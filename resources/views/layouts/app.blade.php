<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shoeler - Premium Shoe Store')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #7f8c8d;
            --light-bg: #f8f9fa;
            --border-color: #dee2e6;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--primary-color);
            background-color: #ffffff;
        }

        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }

        .nav-link {
            color: var(--secondary-color) !important;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: var(--accent-color) !important;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .card {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            transition: box-shadow 0.3s;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .product-card {
            position: relative;
            overflow: hidden;
        }

        .product-card img {
            transition: transform 0.3s;
            height: 250px;
            object-fit: cover;
        }

        .product-card:hover img {
            transform: scale(1.05);
        }

        .badge {
            font-weight: 500;
        }

        .footer {
            background-color: var(--light-bg);
            border-top: 1px solid var(--border-color);
            padding: 2rem 0;
            margin-top: 4rem;
        }

        .alert {
            border-radius: 8px;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Shoeler</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shoes.index') }}">All Shoes</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart"></i> Cart
                            @if(session()->has('shopping_cart'))
                                <span class="badge bg-primary">{{ count(session('shopping_cart')) }}</span>
                            @endif
                        </a>
                    </li>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Admin
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.index') }}">
                                <i class="bi bi-person"></i> Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Shoeler</h5>
                    <p class="text-muted">Premium shoe store with the best collection of branded shoes.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-muted text-decoration-none">Home</a></li>
                        <li><a href="{{ route('shoes.index') }}" class="text-muted text-decoration-none">All Shoes</a></li>
                        <li><a href="{{ route('cart.index') }}" class="text-muted text-decoration-none">Cart</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Us</h5>
                    <p class="text-muted">
                        Email: info@shoeler.com<br>
                        Phone: +62 812-3456-7890
                    </p>
                </div>
            </div>
            <hr>
            <div class="text-center text-muted">
                <p>&copy; {{ date('Y') }} Shoeler. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
