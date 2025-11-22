<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'CONVERSE | Official Store')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Oswald:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Oswald', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        /* --- RESET & BASE --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            /* Tailwind Inter is set above, here is custom base */
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f5f5f5;
            color: #1a1a1a;
            overflow-x: hidden;
        }

        a { text-decoration: none; color: inherit; transition: all 0.3s ease; }
        ul { list-style: none; }

        /* Typography Override */
        h1, h2, h3, h4, h5, .brand-font {
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
        }

        /* --- PROMO BANNER --- */
        .promo-banner {
            background: #f0f0f0;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e0e0e0;
            text-align: center;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .promo-banner a:hover { text-decoration: underline; }

        /* --- TOP BAR --- */
        .top-bar {
            background: white;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.75rem;
            color: #666;
            display: none;
        }
        @media (min-width: 769px) { .top-bar.visible { display: block; } }

        .top-bar-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 2rem;
        }
        .top-bar-item { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; }
        .top-bar-item img { height: 0.75rem; width: 1rem; }
        .top-bar-item svg { height: 1rem; width: 1rem; }

        /* --- HEADER --- */
        header {
            background: white;
            border-bottom: 1px solid #e0e0e0;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 4rem;
        }
        .logo {
            font-family: 'Oswald', sans-serif;
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 2px;
            color: #000;
        }
        .nav-center {
            display: none;
            gap: 2.5rem;
            align-items: center;
            flex: 1;
            margin-left: 3rem;
        }
        @media (min-width: 992px) { .nav-center { display: flex; } }

        .nav-center a {
            font-weight: 700;
            font-size: 0.95rem;
            white-space: nowrap;
        }
        .nav-center a:hover { color: #666; }
        .nav-center a.sale { color: #e53e3e; }
        
        .nav-right {
            display: flex;
            gap: 1.5rem;
            align-items: center;
            margin-left: auto;
        }
        .header-icon svg { height: 1.5rem; width: 1.5rem; stroke-width: 2; }
        
        .search-btn {
            background: #000; color: white; border: none;
            padding: 0 1rem; height: 4rem; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
        }
        .search-btn svg { stroke: white; width: 1.5rem; height: 1.5rem; }

        .hamburger { display: block; background: none; border: none; cursor: pointer; padding: 0.5rem; }
        @media (min-width: 992px) { .hamburger { display: none; } }
        .hamburger svg { width: 1.5rem; height: 1.5rem; }

        /* Mobile Menu */
        .mobile-menu {
            display: none;
            position: absolute; top: 100%; left: 0; right: 0;
            background: white; border-top: 1px solid #e0e0e0;
            padding: 1rem 0;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .mobile-menu.open { display: block; }
        .mobile-menu a {
            display: block; padding: 1rem 2rem;
            border-bottom: 1px solid #f0f0f0;
            font-weight: 600;
        }

        /* --- SHARED COMPONENTS (Buttons, Layout) --- */
        .container-custom {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .btn-primary-custom {
            background: white; color: black;
            padding: 0.8rem 2.5rem; border: none; border-radius: 50px;
            font-weight: 700; cursor: pointer; letter-spacing: 1px;
            display: inline-block;
        }
        .btn-primary-custom:hover { background: #f0f0f0; transform: translateY(-2px); color: black;}

        .btn-secondary-custom {
            background: black; color: white;
            padding: 0.8rem 2.5rem; border: none; border-radius: 50px;
            font-weight: 700; cursor: pointer; letter-spacing: 1px;
            display: inline-block;
        }
        .btn-secondary-custom:hover { background: #333; transform: translateY(-2px); color: white;}

        .section-title {
            font-size: 2.5rem; font-weight: 900;
            margin-bottom: 2.5rem; letter-spacing: 1px;
            text-align: center;
        }

        /* --- FOOTER --- */
        footer {
            background: #1a1a1a;
            color: white;
            padding: 3rem 2rem;
            padding-bottom: 0;
            text-align: center;
            margin-top: auto;
        }
    </style>
    
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    @include('partials.header')

    <main class="flex-grow-1">
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.querySelector('.hamburger');
            const mobileMenu = document.getElementById('mobileMenu');

            if(hamburger && mobileMenu) {
                hamburger.addEventListener('click', () => {
                    mobileMenu.classList.toggle('open');
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>