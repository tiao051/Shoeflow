<div class="top-bar visible bg-gray-100 text-gray-800 text-xs py-2 border-b border-gray-200">
    <div class="top-bar-content container mx-auto px-4 relative flex justify-between items-center h-6">
        <div class="top-bar-item flex items-center space-x-2 z-10">
            <img src="https://www.converse.vn/media/wysiwyg/VN_Flag.jpg" alt="VN" class="w-4 h-3 rounded shadow">
            <span class="font-medium">VN</span>
        </div>

        <div class="absolute inset-0 flex justify-center items-center promo-content text-center font-bold text-xs pointer-events-none">
            <a href="#" class="hover:underline pointer-events-auto text-black">
                <span>Up to 400K off for order from 2 mil - Shop Now!</span>
            </a>
        </div>

        <div class="flex items-center space-x-6 text-xs font-normal text-gray-600 z-10">
            <a href="#" class="top-bar-item hover:text-black hidden md:flex items-center space-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Store Locator</span>
            </a>
            <a href="#" class="top-bar-item hover:text-black hidden lg:flex items-center space-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M10 16h.01" />
                </svg>
                <span>Track Order</span>
            </a>
            <a href="#" class="top-bar-item hover:text-black hidden lg:flex items-center space-x-1">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 4v-4z" />
                 </svg>
                <span>Help</span>
            </a>
        </div>
    </div>
</div>
<hr class="border-gray-200 hidden md:block" />

<header class="bg-white sticky top-0 z-[100] shadow-md">
    <div class="container mx-auto px-4 header-content flex items-center justify-between h-16">
        
        <a href="{{ url('/') }}" class="logo text-2xl font-extrabold tracking-widest text-black flex-shrink-0">CONVERSE</a>
        
        <div class="nav-center hidden lg:flex space-x-8 mx-12 text-sm">
            <a href="#" class="font-bold hover:text-gray-600 transition-colors">Run Star Trainer</a>
            <a href="{{ route('fits.index') }}" class="font-bold hover:text-gray-600 transition-colors">Fits with Converse</a>
            <a href="#" class="font-bold hover:text-gray-600 transition-colors">Limited Edition</a>
            <a href="#" class="sale font-bold text-red-600 hover:text-red-800 transition-colors">Sale Up To 50%</a>
        </div>

        <div class="nav-right space-x-6 ml-auto relative flex items-center flex-shrink-0">
            
            <a href="/profile" class="header-icon hover:text-gray-600 transition-colors hidden md:block">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </a>

            <a href="/wishlist" class="header-icon hover:text-gray-600 transition-colors hidden md:block">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 22l7.682-7.318a4.5 4.5 0 00-6.364-6.364L12 7.682l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </a>
            
            <a href="{{ route('cart.checkout') }}" class="header-icon hover:text-gray-600 transition-colors relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            
                <span id="cart-count" class="absolute -top-2 -right-2 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                    {{ $cartCount ?? 0 }}
                </span>
            </a>

            <div id="search-container" class="relative z-50 h-16 w-16 -mr-8 -my-6 flex-shrink-0">
                
                <form action="{{ route('search.index') }}" method="GET" 
                      id="search-form"
                      class="absolute right-0 top-0 h-full bg-white flex items-center shadow-2xl border border-black transition-all duration-500 ease-in-out w-16 overflow-visible">
                    
                    <input type="text" 
                           name="q"
                           id="search-input"
                           placeholder="Search something..." 
                           class="w-full h-full bg-transparent outline-none border-none text-base font-medium text-black placeholder-gray-500 pl-6 pr-16 opacity-0 pointer-events-none transition-opacity duration-300"
                           autocomplete="off">

                    <button type="submit" 
                            class="absolute right-0 top-0 h-16 w-16 bg-black text-white border-l border-black flex items-center justify-center hover:bg-gray-800 transition-colors cursor-pointer z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>

                    <div id="search-suggestions" 
                         class="absolute top-full left-0 w-full max-h-80 overflow-y-auto bg-white border border-t-0 border-black shadow-xl hidden z-40">
                    </div>
                </form>
            </div>
            
            <button class="hamburger ml-4 lg:hidden header-icon hover:text-gray-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <div class="mobile-menu hidden lg:hidden bg-white border-t border-gray-200 py-4 absolute w-full" id="mobileMenu">
        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Run Star Trainer</a>
        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Men</a>
        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Women</a>
        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Limited Edition</a>
        <a href="#" class="block px-4 py-2 hover:bg-gray-100 sale text-red-600">Sale Up To 50%</a>
        <a href="#" class="block px-4 py-2 hover:bg-gray-100 border-t mt-2">Sign In</a>
    </div>
</header>
<script>
const BASE_URL = '{{ asset('/') }}';
    
document.addEventListener("DOMContentLoaded", function() {
    // Declare required variables
    const container = document.getElementById('search-container');
    const form = document.getElementById('search-form');
    const input = document.getElementById('search-input');
    const suggestionsBox = document.getElementById('search-suggestions');
    let debounceTimer; // Debounce timer for live search

    // search open/close logic
    function openSearch() {
        // Open the search form
        form.classList.remove('w-16');
        form.classList.add('w-[300px]');

        // Reveal the input
        input.classList.remove('opacity-0', 'pointer-events-none');
        input.classList.add('opacity-100', 'pointer-events-auto');
    }

    function closeSearch() {
        // Only close if the user is NOT typing (input is not focused)
        if (document.activeElement !== input) {
            // Close the form
            form.classList.remove('w-[300px]');
            form.classList.add('w-16');

            // Hide input and suggestions box
            input.classList.remove('opacity-100', 'pointer-events-auto');
            input.classList.add('opacity-0', 'pointer-events-none');
            suggestionsBox.classList.add('hidden');
        }
    }

    // Mouse enter & focus events
    container.addEventListener('mouseenter', openSearch);
    container.addEventListener('mouseleave', closeSearch);
    input.addEventListener('focus', openSearch);

    // Blur event (when clicking outside)
    input.addEventListener('blur', function () {
        setTimeout(closeSearch, 200);
    });

    // Live search logic
    input.addEventListener('input', function () {
        const keyword = this.value.trim();

        clearTimeout(debounceTimer);

        if (keyword.length < 2) {
            suggestionsBox.classList.add('hidden');
            suggestionsBox.innerHTML = '';
            return;
        }

        debounceTimer = setTimeout(() => {
            fetchSuggestions(keyword);
        }, 200);
    });

    function fetchSuggestions(keyword) {
        fetch(`/search/suggestions?q=${encodeURIComponent(keyword)}`)
            .then(response => response.json())
            .then(products => {
                if (products.length > 0) {
                    renderSuggestions(products);
                    suggestionsBox.classList.remove('hidden');
                } else {
                    suggestionsBox.innerHTML = '<div class="p-3 text-sm text-gray-500">No results found for "' + keyword + '".</div>';
                    suggestionsBox.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Fetch Error:', error);
                suggestionsBox.innerHTML = '<div class="p-3 text-sm text-red-500">Error fetching results.</div>';
                suggestionsBox.classList.remove('hidden');
            });
    }

    function renderSuggestions(products) {
        const html = products.map(product => {
        const imagePath = product.image || 'images/placeholder.jpg'; 
        
        return `
            <a href="/product/${product.slug || product.id}" class="flex items-center p-3 hover:bg-gray-100 border-b last:border-b-0 transition-colors">
                <img src="${BASE_URL}${imagePath}" 
                     alt="${product.name}" 
                     class="w-10 h-10 object-cover mr-3 border border-gray-200"
                     onerror="this.onerror=null;this.src='${BASE_URL}images/placeholder.jpg';"> 
                <div>
                    <div class="text-sm font-bold text-black line-clamp-1">${product.name}</div>
                    
                    ${product.category ? `<div class="text-xs text-gray-500">Category: ${product.category.name}</div>` : ''} 
                    
                    <div class="text-xs text-red-600 font-semibold">${product.price ? new Intl.NumberFormat('vi-VN').format(product.price) + ' ₫' : 'Contact for price'}</div>
                </div>
            </a>
        `;
    }).join('');
        
        // Add "View all" button
        const viewAll = `
            <a href="/search?q=${input.value}" class="block p-3 text-center text-xs font-bold bg-gray-50 text-black hover:bg-gray-200 uppercase tracking-wider">
                View all results for "${input.value}"
            </a>
        `;
        
        suggestionsBox.innerHTML = html + viewAll;
    }

    // Hide suggestions when clicking outside
    document.addEventListener('click', function (e) {
        // If click is NOT inside the search form
        if (!form.contains(e.target)) {
            suggestionsBox.classList.add('hidden');
        }
    });
});
</script>