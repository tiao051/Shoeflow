@extends('layouts.app')

@section('title', 'Dashboard - Converse Vietnam')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">

<style>
    /* Heartbeat animation */
    @keyframes converse-pop {
        0% { transform: scale(1); }
        50% { transform: scale(1.4); }
        100% { transform: scale(1); }
    }
    .heart-animate {
        animation: converse-pop 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }

    /* Converse Toast Style */
    #converse-toast {
        visibility: hidden;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    #converse-toast.show {
        visibility: visible;
        opacity: 1;
        transform: translateY(0);
    }
    
    /* Scrollbar hiding */
    #new-arrivals-carousel::-webkit-scrollbar { display: none; }
    #new-arrivals-carousel { -ms-overflow-style: none; scrollbar-width: none; }
    
    .group:hover img { transform: scale(1.05); }
</style>

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
                
                <a href="{{ route('products.show', $product->id) }}" class="block relative overflow-hidden h-64">
                    <img src="{{ asset($product->image ?? 'images/placeholder.jpg') }}" 
                         class="w-full h-full object-cover rounded-t-lg transition duration-200 group-hover:opacity-90 group-hover:scale-105" 
                         alt="{{ $product->name }} - {{ $product->color ?? '' }}"
                         onerror="this.onerror=null;this.src='https://placehold.co/400x400/000000/FFFFFF?text={{ urlencode($product->name ?? 'Product') }}';">
                    
                    <span class="absolute top-2 left-2 bg-black text-white text-xs px-2 py-1 font-bold rounded-md">NEW</span>
                </a>

                <div class="p-4">
                    <a href="{{ route('products.show', $product->id) }}">
                        <h5 class="font-bold uppercase text-base mb-1 truncate hover:text-gray-600 transition">{{ $product->name }}</h5>
                    </a>
                    
                    <p class="text-gray-500 text-sm mb-2 truncate">{{ $product->color ?? 'Multiple Colors' }}</p>
                    
                    <div class="flex justify-between items-center mb-3">
                        <p class="font-bold text-lg">{{ number_format($product->price, 0, ',', '.') }} ₫</p>
                        
                        <form action="{{ route('wishlist.store') }}" method="POST" class="inline-block relative js-wishlist-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <button type="submit" class="group/btn transition duration-150 ease-in-out" title="Add to Wishlist">
                                <svg id="heart-icon-{{ $product->id }}" xmlns="http://www.w3.org/2000/svg" 
                                     class="w-6 h-6 text-black group-hover/btn:text-red-600 transition-colors duration-200" 
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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

<div id="converse-toast" class="fixed bottom-5 right-5 z-50 bg-black text-white px-6 py-4 shadow-2xl flex items-center gap-3 border-l-4 border-red-600 font-bold tracking-wide font-sans">
    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
    </svg>
    <div>
        <span class="block text-sm uppercase text-red-500" id="toast-title">WISHLIST UPDATED</span>
        <span class="text-xs text-gray-300 font-normal uppercase" id="toast-message">Item added to your collection.</span>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Auto-scroll functionality
    const carousel = document.getElementById('new-arrivals-carousel');
    if (carousel) {
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
    }

    // 2. AJAX Wishlist Logic
    const wishlistForms = document.querySelectorAll('.js-wishlist-form');
    const toast = document.getElementById('converse-toast');
    const toastTitle = document.getElementById('toast-title');
    const toastMessage = document.getElementById('toast-message');

    wishlistForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const productId = this.querySelector('input[name="product_id"]').value;
            const heartIcon = document.getElementById(`heart-icon-${productId}`);

            fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', // Important for Laravel to detect AJAX
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.status === 401) {
                    window.location.href = "{{ route('login') }}";
                    return;
                }
                return response.json();
            })
            .then(data => {
                if (!data) return;

                // Update Toast content
                toastTitle.textContent = data.status === 'info' ? 'NOTE' : 'SUCCESS';
                toastMessage.textContent = data.message;

                // Show Toast
                toast.classList.add('show');
                setTimeout(() => { toast.classList.remove('show'); }, 3000);

                // Animate Heart if success
                if (data.status === 'success') {
                    heartIcon.classList.remove('text-black');
                    heartIcon.classList.add('text-red-600', 'fill-current', 'heart-animate');
                    
                    // Reset animation class for re-trigger
                    setTimeout(() => {
                        heartIcon.classList.remove('heart-animate');
                    }, 400);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
</script>
@endsection