@extends('layouts.app')

@section('title', 'Dashboard - Converse Vietnam')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">

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
    
    <section class="mb-12">
        <h2 class="text-center mb-8 font-extrabold uppercase text-3xl md:text-4xl" 
            style="font-family: 'Oswald', sans-serif;">
            Shop By Category
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="relative bg-white rounded-xl shadow-lg overflow-hidden transition duration-300 hover:shadow-2xl group">
                <div class="bg-gray-100 flex items-center justify-center h-80">
                    <img src="{{ asset('images/cate1.jpg') }}" 
                         alt="Chuck Taylor Shoes" 
                         class="w-full h-full object-cover transition duration-200 group-hover:scale-105"
                         onerror="this.onerror=null;this.src='https://placehold.co/400x320/E5E7EB/4B5563?text=Chuck+Taylor';">
                </div>
                <div class="p-6 text-center">
                    <h3 class="font-bold text-lg uppercase">Chuck Taylor</h3>
                    <p class="text-gray-500 text-sm">Classic high tops & low tops</p>
                </div>
                
               <a href="{{ route('products.index', ['category' => 'chuck-taylor']) }}" class="absolute inset-0 z-10"></a>
            </div>

            <div class="relative bg-white rounded-xl shadow-lg overflow-hidden transition duration-300 hover:shadow-2xl group">
                <div class="bg-gray-100 flex items-center justify-center h-80">
                    <img src="{{ asset('images/cate2.jpg') }}" 
                         alt="One Star Shoes" 
                         class="w-full h-full object-cover transition duration-200 group-hover:scale-105"
                         onerror="this.onerror=null;this.src='https://placehold.co/400x320/E5E7EB/4B5563?text=One+Star';">
                </div>
                <div class="p-6 text-center">
                    <h3 class="font-bold text-lg uppercase">One Star</h3>
                    <p class="text-gray-500 text-sm">Retro basketball style</p>
                </div>

               <a href="{{ route('products.index', ['category' => 'one-star']) }}" class="absolute inset-0 z-10"></a>
            </div>

            <div class="relative bg-white rounded-xl shadow-lg overflow-hidden transition duration-300 hover:shadow-2xl group">
                <div class="bg-gray-100 flex items-center justify-center h-80">
                    <img src="{{ asset('images/cate3.jpg') }}" 
                         alt="All Star Shoes" 
                         class="w-full h-full object-cover transition duration-200 group-hover:scale-105"
                         onerror="this.onerror=null;this.src='https://placehold.co/400x320/E5E7EB/4B5563?text=All+Star';">
                </div>
                <div class="p-6 text-center">
                    <h3 class="font-bold text-lg uppercase">All Star</h3>
                    <p class="text-gray-500 text-sm">Heritage basketball sneakers</p>
                </div>

               <a href="{{ route('products.index', ['category' => 'all-star']) }}" class="absolute inset-0 z-10"></a>
            </div>
        </div>
    </section>

    <section class="mb-12">
        <h2 class="text-center mb-8 font-extrabold uppercase text-3xl md:text-4xl" 
            style="font-family: 'Oswald', sans-serif;">
            New Arrivals
        </h2>
        
        <div id="new-arrivals-carousel" 
             class="flex overflow-x-auto whitespace-nowrap space-x-6 pb-4 scroll-smooth snap-x snap-mandatory">
            
            @foreach($newArrivals as $product)
            <div class="inline-block w-64 min-w-64 snap-center group relative bg-white transition duration-300 hover:shadow-lg rounded-lg">
                
                {{-- [EDIT] Wrap the image in an <a> linking to the product detail page --}}
                <a href="{{ route('products.show', $product->id) }}" class="block relative overflow-hidden h-64">
                    <img src="{{ asset($product->image ?? 'images/placeholder.jpg') }}" 
                         class="w-full h-full object-cover rounded-t-lg transition duration-200 group-hover:opacity-90 group-hover:scale-105" 
                         alt="{{ $product->name }} - {{ $product->color ?? '' }}"
                         onerror="this.onerror=null;this.src='https://placehold.co/400x400/000000/FFFFFF?text={{ urlencode($product->name ?? 'Product') }}';">
                    
                    <span class="absolute top-2 left-2 bg-black text-white text-xs px-2 py-1 font-bold rounded-md">NEW</span>
                </a>

                <div class="p-4">
                    {{-- [EDIT] Product name links to the detail page --}}
                    <a href="{{ route('products.show', $product->id) }}">
                        <h5 class="font-bold uppercase text-base mb-1 truncate hover:text-gray-600 transition">{{ $product->name }}</h5>
                    </a>
                    
                    <p class="text-gray-500 text-sm mb-2 truncate">{{ $product->color ?? 'Multiple Colors' }}</p>
                    
                    <div class="flex justify-between items-center mb-3">
                        <p class="font-bold text-lg">{{ number_format($product->price, 0, ',', '.') }} ₫</p>
                        
                        <form action="{{ route('wishlist.store') }}" method="POST" class="inline-block">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="text-black hover:text-red-600 transition duration-150" title="Add to Wishlist">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-.318-.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </form>
                    </div>

                    <a href="{{ route('products.show', $product->id) }}" 
                       class="block border border-black text-black px-4 py-2 text-xs uppercase font-bold text-center hover:bg-black hover:text-white transition duration-200">
                        View Details
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center text-sm text-gray-500 mt-4">
            ← Swipe or scroll to view more products →
        </div>
    </section>

    {{-- Other sections kept intact --}}
    <section class="bg-black text-white text-center py-16 mb-12 rounded-xl px-5">
        <h2 class="font-extrabold uppercase mb-4 text-3xl md:text-4xl" style="font-family: 'Oswald', sans-serif;">
            Custom Your Style
        </h2>
        <p class="mb-8 text-gray-400 text-lg">Design your own unique Converse sneakers.</p>
        <button class="bg-white text-black px-8 py-4 font-bold uppercase text-sm rounded-lg shadow-lg hover:bg-gray-200 transition duration-300">
            Start Customizing
        </button>
    </section>

    <section class="text-center py-12 bg-gray-50 rounded-xl">
        <div class="max-w-xl mx-auto px-5">
            <h2 class="font-extrabold uppercase mb-2 text-2xl md:text-3xl" style="font-family: 'Oswald', sans-serif;">
                Stay In The Loop
            </h2>
            <p class="text-gray-500 mb-6">Subscribe to get special offers and updates.</p>
            <div class="flex">
                <input type="email" class="flex-grow p-3 border border-gray-300 rounded-l-lg text-sm focus:ring-0 focus:border-black" placeholder="Enter your email address">
                <button class="bg-black text-white p-3 rounded-r-lg hover:bg-gray-800 transition duration-150 uppercase font-bold text-sm" type="button">
                    Subscribe
                </button>
            </div>
        </div>
    </section>
</div>

<style>
/* Hide default browser horizontal scrollbar */
#new-arrivals-carousel::-webkit-scrollbar { display: none; }
#new-arrivals-carousel { -ms-overflow-style: none; scrollbar-width: none; }
.hover\:bg-black:hover { color: white !important; }
/* Allow image scale on hover */
.group:hover img { transform: scale(1.05); }
</style>

<script>
// Auto-scroll functionality
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('new-arrivals-carousel');
    if (!carousel) return; 

    const scrollDistance = 256 + 24;
    let scrollPosition = 0;
    let direction = 1;
    let scrollInterval;

    function autoScroll() {
        if (carousel.scrollWidth <= carousel.clientWidth) { clearInterval(scrollInterval); return; }
        const newScrollPosition = scrollPosition + (direction * scrollDistance);
        const maxScrollLeft = carousel.scrollWidth - carousel.clientWidth;

        if (direction === 1) {
            if (newScrollPosition >= maxScrollLeft) { direction = -1; scrollPosition = maxScrollLeft; } 
            else { scrollPosition = newScrollPosition; }
        } else {
            if (newScrollPosition <= 0) { direction = 1; scrollPosition = 0; } 
            else { scrollPosition = newScrollPosition; }
        }
        carousel.scrollTo({ left: scrollPosition, behavior: 'smooth' });
    }

    const startAutoScroll = () => {
        if (carousel.scrollWidth > carousel.clientWidth) { scrollInterval = setInterval(autoScroll, 4000); }
    };
    startAutoScroll();
    const stopAutoScroll = () => clearInterval(scrollInterval);
    
    carousel.addEventListener('mouseenter', stopAutoScroll);
    carousel.addEventListener('touchstart', stopAutoScroll);
    carousel.addEventListener('mouseleave', startAutoScroll);
    carousel.addEventListener('touchend', startAutoScroll);
    window.addEventListener('resize', () => { stopAutoScroll(); startAutoScroll(); });
});
</script>
@endsection