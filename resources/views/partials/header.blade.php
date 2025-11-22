<!-- START: TOP BAR (including banner, VN, and utility menu) -->
<div class="top-bar visible">
    <!-- Add 'relative' to the container to anchor absolutely positioned children -->
    <div class="top-bar-content relative flex justify-between items-center">
        <!-- 1. LEFT AREA: VN -->
        <div class="top-bar-item flex items-center space-x-2 z-10">
            <img src="https://www.converse.vn/media/wysiwyg/VN_Flag.jpg" alt="VN" class="w-4 h-3">
            <span>VN</span>
        </div>

        <!-- 2. CENTER AREA: PROMO BANNER (use absolute positioning to center) -->
        <div class="absolute inset-0 flex justify-center items-center promo-content text-center font-bold text-xs md:text-sm pointer-events-none">
            <a href="#" class="hover:underline pointer-events-auto">
                <span>Up to 400K off for order from 2 mil - Shop Now!</span>
            </a>
        </div>

        <!-- 3. RIGHT AREA: UTILITY MENU -->
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

        <div class="nav-right space-x-6 ml-auto relative flex items-center">
    
    <a href="/profile" class="header-icon hover:text-gray-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
    </a>

    <a href="/wishlist" class="header-icon hover:text-gray-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 22l7.682-7.318a4.5 4.5 0 00-6.364-6.364L12 7.682l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
    </a>
    
    <a href="{{ route('cart.checkout') }}" class="header-icon hover:text-gray-600 relative group">
         <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
        </svg>
    
        <span id="cart-count" class="absolute -top-2 -right-2 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
            {{ $cartCount ?? 0 }}
        </span>
    </a>
<div id="search-container" class="relative z-50 h-16 w-16 -mr-8 -my-6 flex-shrink-0">
    
    <form action="#" method="GET" 
          id="search-form"
          class="absolute right-0 top-0 h-full bg-white flex items-center shadow-2xl border border-black transition-all duration-500 ease-in-out w-16 overflow-hidden">
        
        <input type="text" 
               name="q"
               id="search-input"
               placeholder="Search something" 
               class="w-full h-full bg-transparent outline-none border-none
                      text-base font-medium text-black placeholder-gray-500
                      pl-6 pr-16 opacity-0 pointer-events-none transition-opacity duration-300"
               autocomplete="off">

        <button type="submit" 
                class="absolute right-0 top-0 h-16 w-16 bg-black text-white border-l border-black flex items-center justify-center hover:bg-gray-800 transition-colors cursor-pointer z-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </button>
    </form>
</div>
    
    <button class="hamburger ml-4">
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
 <script>
    document.addEventListener("DOMContentLoaded", function() {
        const container = document.getElementById('search-container');
        const form = document.getElementById('search-form');
        const input = document.getElementById('search-input');

        // Function to OPEN search
        function openSearch() {
            form.classList.remove('w-16');
            form.classList.add('w-[350px]');
            
            input.classList.remove('opacity-0', 'pointer-events-none');
            input.classList.add('opacity-100', 'pointer-events-auto');
        }

        // Function to CLOSE search
        function closeSearch() {
            // Only close if the user is NOT typing (input is not focused)
            if (document.activeElement !== input) {
                form.classList.remove('w-[350px]');
                form.classList.add('w-16');
                
                input.classList.remove('opacity-100', 'pointer-events-auto');
                input.classList.add('opacity-0', 'pointer-events-none');
            }
        }

        // Mouse enter on container (open search)
        container.addEventListener('mouseenter', openSearch);

        // Mouse leave on container (close search)
        container.addEventListener('mouseleave', closeSearch);

        // Focus event (when input is clicked) -> ensure search stays open
        input.addEventListener('focus', openSearch);

        // Blur event (when clicking outside) -> close search
        input.addEventListener('blur', function() {
            // Small delay for smoother UX
            setTimeout(closeSearch, 200);
        });
    });
</script>