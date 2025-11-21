@extends('layouts.app')

@section('title', 'Dashboard - Converse Vietnam')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">

<!-- HERO SECTION: CHUCK TAYLOR BANNER -->
<section class="flex items-center justify-center min-h-[500px] text-white py-20 px-5" 
         style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
    <div class="text-center">
        <h1 class="text-6xl md:text-8xl font-extrabold uppercase mb-4 tracking-wider" 
            style="font-family: 'Oswald', sans-serif;">
            CHUCK TAYLOR
        </h1>
        <p class="text-xl font-light mb-8">ICONIC STYLE. TIMELESS COMFORT.</p>
        <a href="{{ url('/products') }}" 
           class="inline-block bg-white text-black px-8 py-4 font-bold uppercase text-sm rounded-lg shadow-lg hover:bg-gray-200 transition duration-300">
            Shop Now
        </a>
    </div>
</section>

<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    
    <!-- SECTION: SHOP BY CATEGORY -->
    <section class="mb-12">
        <h2 class="text-center mb-8 font-extrabold uppercase text-3xl md:text-4xl" 
            style="font-family: 'Oswald', sans-serif;">
            Shop By Category
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Category 1: Chuck Taylor -->
            <div class="relative bg-white rounded-xl shadow-lg overflow-hidden transition duration-300 hover:shadow-2xl">
                <div class="bg-gray-100 flex items-center justify-center h-80">
                    <img src="{{ asset('images/chuck_taylor1.jpg') }}" 
                         alt="Chuck Taylor Shoes" 
                         class="w-full h-full object-cover transition duration-500 hover:scale-105"
                         onerror="this.onerror=null;this.src='https://placehold.co/400x320/E5E7EB/4B5563?text=Chuck+Taylor';">
                </div>
                <div class="p-6 text-center">
                    <h3 class="font-bold text-lg uppercase">Chuck Taylor</h3>
                    <p class="text-gray-500 text-sm">Classic high tops & low tops</p>
                </div>
                <a href="#" class="absolute inset-0 z-10"></a>
            </div>

            <!-- Category 2: One Star -->
            <div class="relative bg-white rounded-xl shadow-lg overflow-hidden transition duration-300 hover:shadow-2xl">
                <div class="bg-gray-100 flex items-center justify-center h-80">
                    <img src="{{ asset('images/one_start1.jpg') }}" 
                         alt="One Star Shoes" 
                         class="w-full h-full object-cover transition duration-500 hover:scale-105"
                         onerror="this.onerror=null;this.src='https://placehold.co/400x320/E5E7EB/4B5563?text=One+Star';">
                </div>
                <div class="p-6 text-center">
                    <h3 class="font-bold text-lg uppercase">One Star</h3>
                    <p class="text-gray-500 text-sm">Retro basketball style</p>
                </div>
                <a href="#" class="absolute inset-0 z-10"></a>
            </div>
            
            <!-- Category 3: All Star -->
            <div class="relative bg-white rounded-xl shadow-lg overflow-hidden transition duration-300 hover:shadow-2xl">
                <div class="bg-gray-100 flex items-center justify-center h-80">
                    <img src="{{ asset('images/all_star1.jpg') }}" 
                         alt="All Star Shoes" 
                         class="w-full h-full object-cover transition duration-500 hover:scale-105"
                         onerror="this.onerror=null;this.src='https://placehold.co/400x320/E5E7EB/4B5563?text=All+Star';">
                </div>
                <div class="p-6 text-center">
                    <h3 class="font-bold text-lg uppercase">All Star</h3>
                    <p class="text-gray-500 text-sm">Heritage basketball sneakers</p>
                </div>
                <a href="#" class="absolute inset-0 z-10"></a>
            </div>
        </div>
    </section>

    <!-- SECTION: NEW ARRIVALS -->
    <section class="mb-12">
        <h2 class="text-center mb-8 font-extrabold uppercase text-3xl md:text-4xl" 
            style="font-family: 'Oswald', sans-serif;">
            New Arrivals
        </h2>
        
        <!-- Carousel Container -->
        <div id="new-arrivals-carousel" 
             class="flex overflow-x-auto whitespace-nowrap space-x-6 pb-4 scroll-smooth snap-x snap-mandatory">
            
            @foreach($newArrivals as $product)
            <div class="inline-block w-64 min-w-64 snap-center group relative bg-white transition duration-300 hover:shadow-lg rounded-lg">
                <div class="relative overflow-hidden h-64">
                    <img src="{{ asset($product->image ?? 'images/placeholder.jpg') }}" 
                         class="w-full h-full object-cover rounded-t-lg transition duration-500 group-hover:opacity-90" 
                         alt="{{ $product->name }} - {{ $product->color ?? '' }}"
                         onerror="this.onerror=null;this.src='https://placehold.co/400x400/000000/FFFFFF?text={{ urlencode($product->name ?? 'Product') }}';">
                    <span class="absolute top-2 left-2 bg-black text-white text-xs px-2 py-1 font-bold rounded-md">NEW</span>
                </div>
                <div class="p-4">
                    <h5 class="font-bold uppercase text-base mb-1 truncate">{{ $product->name }}</h5>
                    <p class="text-gray-500 text-sm mb-2 truncate">{{ $product->color ?? 'Multiple Colors' }}</p>
                    <p class="font-bold mb-3 text-lg">{{ number_format($product->price, 0, ',', '.') }} ₫</p>
                    <a href="#" 
                       class="block border border-black text-black px-4 py-2 text-xs uppercase font-bold text-center hover:bg-black hover:text-white transition duration-200">
                        Add to Cart
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Hint for scrolling -->
        <div class="text-center text-sm text-gray-500 mt-4">
            ← Swipe or scroll to view more products →
        </div>
        
    </section>

    <!-- SECTION: CUSTOMIZATION CALL TO ACTION -->
    <section class="bg-black text-white text-center py-16 mb-12 rounded-xl px-5">
        <h2 class="font-extrabold uppercase mb-4 text-3xl md:text-4xl" 
            style="font-family: 'Oswald', sans-serif;">
            Custom Your Style
        </h2>
        <p class="mb-8 text-gray-400 text-lg">Design your own unique Converse sneakers.</p>
        <button class="bg-white text-black px-8 py-4 font-bold uppercase text-sm rounded-lg shadow-lg hover:bg-gray-200 transition duration-300">
            Start Customizing
        </button>
    </section>

    <!-- SECTION: NEWSLETTER SUBSCRIPTION -->
    <section class="text-center py-12 bg-gray-50 rounded-xl">
        <div class="max-w-xl mx-auto px-5">
            <h2 class="font-extrabold uppercase mb-2 text-2xl md:text-3xl" 
                style="font-family: 'Oswald', sans-serif;">
                Stay In The Loop
            </h2>
            <p class="text-gray-500 mb-6">Subscribe to get special offers and updates.</p>
            <div class="flex">
                <input type="email" 
                       class="flex-grow p-3 border border-gray-300 rounded-l-lg text-sm focus:ring-0 focus:border-black" 
                       placeholder="Enter your email address">
                <button class="bg-black text-white p-3 rounded-r-lg hover:bg-gray-800 transition duration-150 uppercase font-bold text-sm" 
                        type="button">
                    Subscribe
                </button>
            </div>
        </div>
    </section>

</div>

<style>
/* Hide default browser horizontal scrollbar for the scroll container */
#new-arrivals-carousel::-webkit-scrollbar {
    display: none;
}
#new-arrivals-carousel {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}
</style>

<script>
    // Auto-scroll functionality for the carousel
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.getElementById('new-arrivals-carousel');
        if (!carousel) return; 
        
        const scrollDistance = 256 + 24; // Item width + gap
        let scrollPosition = 0;
        let direction = 1; // 1: scroll right, -1: scroll left
        let scrollInterval;

        function autoScroll() {
            if (carousel.scrollWidth <= carousel.clientWidth) {
                 clearInterval(scrollInterval);
                 return;
            }

            const newScrollPosition = scrollPosition + (direction * scrollDistance);
            const maxScrollLeft = carousel.scrollWidth - carousel.clientWidth;

            if (direction === 1) {
                if (newScrollPosition >= maxScrollLeft) {
                    direction = -1;
                    scrollPosition = maxScrollLeft;
                } else {
                    scrollPosition = newScrollPosition;
                }
            } else {
                if (newScrollPosition <= 0) {
                    direction = 1;
                    scrollPosition = 0;
                } else {
                    scrollPosition = newScrollPosition;
                }
            }

            carousel.scrollTo({
                left: scrollPosition,
                behavior: 'smooth'
            });
        }

        const startAutoScroll = () => {
            if (carousel.scrollWidth > carousel.clientWidth) {
                scrollInterval = setInterval(autoScroll, 4000);
            }
        };

        startAutoScroll();

        const stopAutoScroll = () => clearInterval(scrollInterval);
        
        carousel.addEventListener('mouseenter', stopAutoScroll);
        carousel.addEventListener('touchstart', stopAutoScroll);
        carousel.addEventListener('mouseleave', startAutoScroll);
        carousel.addEventListener('touchend', startAutoScroll);

        window.addEventListener('resize', () => {
             stopAutoScroll();
             startAutoScroll();
        });
    });
</script>
@endsection