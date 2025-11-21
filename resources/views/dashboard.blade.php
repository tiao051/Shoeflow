@extends('layouts.app')

@section('title', 'Dashboard - Converse Vietnam')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
<!--
    Note: This file assumes Tailwind CSS is configured in your project and is extending a base layout
    that includes necessary dependencies like Tailwind and the Inter/Oswald fonts.
-->

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

<!-- MOCK DATA FOR NEW ARRIVALS -->
@php
    $newArrivals = [
        ['name' => 'Chuck 70 High Top', 'color' => 'Classic Black', 'price' => '1,890,000 ₫', 'image' => 'images/chuck_70_hightop1.jpg'],
        ['name' => 'Run Star Motion CX', 'color' => 'White/Black/Gum', 'price' => '2,550,000 ₫', 'image' => 'images/one_start1.jpg'], // Dùng tạm ảnh one_start1
        ['name' => 'Chuck Taylor All Star Lift', 'color' => 'Pink Foam', 'price' => '1,790,000 ₫', 'image' => 'images/all_star1.jpg'], // Dùng tạm ảnh all_star1
        ['name' => 'Chuck 70 Hi Vintage', 'color' => 'Ivory', 'price' => '1,990,000 ₫', 'image' => 'images/chuck_taylor1.jpg'], // Dùng tạm ảnh chuck_taylor1
        ['name' => 'One Star Pro Suede', 'color' => 'Obsidian', 'price' => '2,200,000 ₫', 'image' => 'images/one_start1.jpg'],
        ['name' => 'All Star BB Shift', 'color' => 'Volt Orange', 'price' => '2,100,000 ₫', 'image' => 'images/all_star1.jpg'],
    ];
@endphp

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

    <!-- SECTION: NEW ARRIVALS (SCROLLING CAROUSEL) -->
    <section class="mb-12">
        <h2 class="text-center mb-8 font-extrabold uppercase text-3xl md:text-4xl" 
            style="font-family: 'Oswald', sans-serif;">
            New Arrivals
        </h2>
        
        <!-- CAROUSEL CONTAINER -->
        <!-- Add 'snap-x snap-mandatory' for a better manual swipe experience -->
        <div id="new-arrivals-carousel" 
             class="flex overflow-x-auto whitespace-nowrap space-x-6 pb-4 scroll-smooth snap-x snap-mandatory">
            
            @foreach($newArrivals as $product)
            <div class="inline-block w-64 min-w-64 snap-center group relative bg-white transition duration-300 hover:shadow-lg rounded-lg">
                {{-- Đã thêm h-64 để cố định chiều cao của khung ảnh, tạo tỷ lệ 1:1 (hình vuông) --}}
                <div class="relative overflow-hidden h-64">
                    {{-- The PHP array keys are correctly quoted here: $product['image'], $product['name'], $product['color'] --}}
                    <img src="{{ asset($product['image']) }}" 
                         class="w-full h-full object-cover rounded-t-lg transition duration-500 group-hover:opacity-90" 
                         alt="{{ $product['name'] }} - {{ $product['color'] }}"
                         onerror="this.onerror=null;this.src='https://placehold.co/400x400/000000/FFFFFF?text={{ urlencode($product['name']) }}';">
                    <span class="absolute top-2 left-2 bg-black text-white text-xs px-2 py-1 font-bold rounded-md">NEW</span>
                </div>
                <div class="p-4">
                    <h5 class="font-bold uppercase text-base mb-1 truncate">{{ $product['name'] }}</h5>
                    <p class="text-gray-500 text-sm mb-2 truncate">{{ $product['color'] }}</p>
                    <p class="font-bold mb-3 text-lg">{{ $product['price'] }}</p>
                    <a href="#" 
                       class="block border border-black text-black px-4 py-2 text-xs uppercase font-bold text-center hover:bg-black hover:text-white transition duration-200">
                        Add to Cart
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Dấu hiệu cho người dùng biết có thể cuộn ngang trên desktop/mobile -->
        <div class="text-center text-sm text-gray-500 mt-4">
            ← Vuốt hoặc cuộn để xem thêm sản phẩm →
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
/* Ẩn thanh cuộn ngang mặc định của trình duyệt cho container cuộn */
#new-arrivals-carousel::-webkit-scrollbar {
    display: none;
}
#new-arrivals-carousel {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.getElementById('new-arrivals-carousel');
        const scrollDistance = 256 + 24; // Item width (w-64 = 256px) + gap (space-x-6 = 24px)
        let scrollPosition = 0;
        let direction = 1; // 1: scroll right, -1: scroll left

        // Hàm cuộn carousel
        function autoScroll() {
            // Tính toán vị trí cuộn mới
            const newScrollPosition = scrollPosition + (direction * scrollDistance);

            // Kiểm tra giới hạn cuộn:
            // 1. Nếu cuộn qua bên phải quá nhiều, đảo chiều (scroll back to left)
            if (newScrollPosition >= (carousel.scrollWidth - carousel.clientWidth)) {
                direction = -1;
                scrollPosition = carousel.scrollWidth - carousel.clientWidth; // Đảm bảo cuộn đến cuối cùng
            } 
            // 2. Nếu cuộn qua bên trái (về 0), đảo chiều (scroll back to right)
            else if (newScrollPosition <= 0) {
                direction = 1;
                scrollPosition = 0; // Đảm bảo cuộn về đầu tiên
            } 
            // 3. Nếu vẫn trong giới hạn
            else {
                scrollPosition = newScrollPosition;
            }

            // Thực hiện cuộn mượt mà
            carousel.scrollTo({
                left: scrollPosition,
                behavior: 'smooth'
            });
        }

        // Bắt đầu tự động cuộn sau mỗi 4 giây (4000ms)
        const scrollInterval = setInterval(autoScroll, 4000);

        // Dừng tự động cuộn khi người dùng chạm/di chuột vào carousel
        carousel.addEventListener('mouseenter', () => clearInterval(scrollInterval));
        carousel.addEventListener('touchstart', () => clearInterval(scrollInterval));

        // Tiếp tục tự động cuộn khi người dùng rời khỏi carousel
        carousel.addEventListener('mouseleave', () => {
            // Cần xóa interval cũ trước khi tạo cái mới để tránh tạo nhiều interval
            clearInterval(scrollInterval);
            scrollInterval = setInterval(autoScroll, 4000);
        });
        carousel.addEventListener('touchend', () => {
            // Cần xóa interval cũ trước khi tạo cái mới để tránh tạo nhiều interval
            clearInterval(scrollInterval);
            scrollInterval = setInterval(autoScroll, 4000);
        });
    });
</script>
@endsection