<!-- START: TOP BAR (includes promo banner, VN, and utility menu) -->
<div class="top-bar visible">
    <!-- Set container to relative so absolute children are positioned correctly -->
    <div class="top-bar-content relative flex justify-between items-center">
        <!-- Left area: VN -->
        <div class="top-bar-item flex items-center space-x-2 z-10">
            <img src="https://www.converse.vn/media/wysiwyg/VN_Flag.jpg" alt="VN" class="w-4 h-3">
            <span>VN</span>
        </div>

        <!-- Center area: promo banner (uses absolute to center over the screen) -->
        <div class="absolute inset-0 flex justify-center items-center promo-content text-center font-bold text-xs md:text-sm pointer-events-none">
            <a href="#" class="hover:underline pointer-events-auto">
                <span>Up to 400K off for order from 2 mil - Shop Now!</span>
            </a>
        </div>

        <!-- Right area: utility menu -->
        <div class="flex items-center space-x-6 text-xs md:text-sm font-normal text-gray-600 z-10">
            <a href="#" class="top-bar-item hover:text-black hidden md:flex">
                <!-- Icon Store Locator -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Store Locator</span>
            </a>
            <a href="#" class="top-bar-item hover:text-black hidden lg:flex">
                <!-- Icon Track Order -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M10 16h.01" />
                </svg>
                <span>Track Order</span>
            </a>
            <a href="#" class="top-bar-item hover:text-black hidden lg:flex">
                 <!-- Icon Help -->
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 4v-4z" />
                </svg>
                <span>Help</span>
            </a>
        </div>
    </div>
</div>
<!-- END: TOP BAR -->

<!-- START: HEADER MAIN -->
<header>
    <div class="header-content">
        <a href="{{ url('/') }}" class="logo">CONVERSE</a>
        
        <div class="nav-center">
            <a href="#" class="font-bold hover:text-gray-600">Run Star Trainer</a>
            <a href="#" class="font-bold hover:text-gray-600">Fits with Converse</a>
            <a href="#" class="font-bold hover:text-gray-600">Limited Edition</a>
            <a href="#" class="sale font-bold text-red-600 hover:text-red-800">Sale Up To 50%</a>
        </div>

        <!-- NAV RIGHT ADJUSTED FOR IMAGE -->
        <div class="nav-right space-x-6 ml-auto">
            
            <!-- Sign In (Icon Only) -->
            <a href="/profile" class="header-icon hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </a>

            <!-- Favorites (Heart) -->
            <a href="/wishlist" class="header-icon hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 22l7.682-7.318a4.5 4.5 0 00-6.364-6.364L12 7.682l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </a>
            
            <!-- Cart Icon -->
            <a href="{{ route('cart.index') }}" class="header-icon hover:text-gray-600 relative group">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            
                <span id="cart-count" class="absolute -top-2 -right-2 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                    {{ $cartCount ?? 0 }}
                </span>
            </a>

            <!-- Search Button (FULL HEIGHT BLACK BLOCK) -->
            <a href="#" class="search-btn h-16 w-16 -mr-8 -my-6 flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </a>
            
            <!-- Hamburger Icon (Only visible on mobile/tablet as per CSS in app.blade.php) -->
            <button class="hamburger">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="#">Run Star Trainer</a>
        <a href="#">Men</a>
        <a href="#">Women</a>
        <a href="#">Limited Edition</a>
        <a href="#" class="sale">Sale Up To 50%</a>
        <a href="#">Sign In</a>
    </div>
</header>
<!-- END: HEADER MAIN -->