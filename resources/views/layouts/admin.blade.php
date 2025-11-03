<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Shoeler')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }

        .sidebar .nav-link {
            color: #495057;
            padding: 0.75rem 1rem;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #e9ecef;
            color: #2c3e50;
        }

        .main-content {
            padding: 2rem;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Top Navigation -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Shoeler Admin</a>
            <div class="d-flex">
                <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm me-2">
                    <i class="bi bi-house"></i> View Store
                </a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <nav class="nav flex-column p-3">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('admin.categories.index') }}">
                        <i class="bi bi-tags"></i> Categories
                    </a>
                    <a class="nav-link" href="{{ route('admin.shoes.index') }}">
                        <i class="bi bi-bag"></i> Shoes
                    </a>
                    <a class="nav-link" href="{{ route('admin.orders.index') }}">
                        <i class="bi bi-receipt"></i> Orders
                    </a>
                    <a class="nav-link" href="{{ route('admin.promotions.index') }}">
                        <i class="bi bi-tag"></i> Promotions
                    </a>
                    <a class="nav-link" href="{{ route('admin.banners.index') }}">
                        <i class="bi bi-image"></i> Banners
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
