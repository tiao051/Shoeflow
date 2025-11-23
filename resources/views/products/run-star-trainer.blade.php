@extends('layouts.app')

@section('title', 'CONVERSE RUN STAR TRAINER | DYNAMIC & MODERN')

@push('styles')
<style>
    /* Add basic product-card styles (remove if global CSS already contains these) */
    .filter-btn {
        background: transparent;
        border: 1px solid #ddd;
        padding: 8px 20px;
        font-family: 'Oswald', sans-serif;
        font-size: 0.9rem;
        transition: all 0.3s;
        cursor: pointer;
    }
    .filter-btn:hover {
        background: #121212;
        color: white;
        border-color: #121212;
    }
    /* Simple spinner effect (used for AJAX loading) */
    .loading-indicator {
        padding: 60px 0;
        text-align: center;
    }
    .converse-spinner {
        display: block;
        width: 30px;
        height: 30px;
        margin: 15px auto;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #dc3545; /* accent red */
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    /* --- RUN STAR SPECIFIC STYLES --- */
    .font-runstar {
        font-family: 'Montserrat', sans-serif;
        font-weight: 800;
        letter-spacing: 1px;
    }
    .text-title-xl {
        font-size: 3.5rem;
        line-height: 1.1;
    }
    .text-highlight {
        color: #ffc107; /* Accent energy yellow */
    }
    .hero-runstar {
        /* Keep hero banner styling */
        background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%); 
        color: white;
        padding-top: 5rem;
        padding-bottom: 5rem;
        /* Sử dụng padding để thay thế margin-bottom âm và clip-path nếu cần đơn giản hóa */
        margin-bottom: 2rem;
        position: relative;
        z-index: 10;
    }
    .product-grid-container {
        /* Removed large top padding since clip-path is not used */
        padding-top: 2rem; 
        z-index: 20;
        position: relative;
        background-color: white;
    }
    /* Ensure hover style for product cards works */
    .product-card:hover {
        transform: translateY(-5px) scale(1.01);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .product-card {
        border: none;
        background: transparent;
        margin-bottom: 40px; /* Cung cấp khoảng cách dưới */
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    /* Ensure image fills wrapper and excess is clipped */
    .image-wrapper {
        position: relative;
        overflow: hidden; /* <--- KEY: ẨN HỘP GIÀY THỪA BÊN NGOÀI KHUNG ẢNH */
        background-color: #f4f4f4;
        aspect-ratio: 1 / 1; /* Đảm bảo tỷ lệ 1:1 */
    }

    .image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Đảm bảo ảnh lấp đầy khung wrapper */
        transition: transform 0.5s ease;
    }

    /* Badge position */
    .badge-custom {
        position: absolute;
        top: 10px; 
        left: 10px;
        z-index: 10; 
        background-color: #121212;
        color: white;
        padding: 4px 8px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        border-radius: 0;
    }
    .product-card {
        /* Ensure hover transition doesn't affect text */
        transition: transform 0.3s ease;
    }
    
    .card-info { 
        padding-top: 15px; 
    }

    /* 1. PRODUCT TITLE: Bold and Uppercase */
    .product-title {
        font-size: 1rem; 
        font-weight: 700; 
        margin-bottom: 5px; 
        line-height: 1.4;
        text-transform: uppercase; 
    }
    
    /* 2. SUBTITLE / PRODUCT LINE*/
    .product-category {
        font-size: 0.85rem; 
        color: #757575;
        margin-bottom: 5px;
    }

    /* 3. PRICE: Use dedicated font and bolder weight */
    .product-price {
        font-family: 'Oswald', sans-serif;
        color: #121212;
    }

    .runstar-cta {
        /* Ensure bold text weight (700) */
        font-weight: 700 !important;

        background-color: #ffffff;
        color: #121212;
        border: 2px solid #121212;

        /* Hover effect */
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .runstar-cta:hover {
        background-color: #ffc107; /* Highlight yellow */
        color: #121212;
        border-color: #ffc107;
        box-shadow: 0 6px 15px rgba(255, 193, 7, 0.5);
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .text-title-xl { font-size: 2.5rem; }
        .hero-runstar { padding-top: 3rem; padding-bottom: 3rem; }
    }
</style>
@endpush

@section('content')

{{-- HERO SECTION --}}
<section class="hero-runstar">
    {{-- Thay thế Tailwind max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 bằng container/row Bootstrap --}}
    <div class="container text-center"> 
        <h1 class="font-runstar text-title-xl mb-3">
            <span class="text-highlight">RUN STAR</span> MOTION & TRAINER
        </h1>
        <p class="text-xl md:text-2xl text-gray-300">
            Design that defies gravity. The boldest aesthetic for the modern sneakerhead.
        </p>
        <div class="mt-8">
        <a href="#product-list" class="btn runstar-cta px-5 py-3 rounded-pill font-weight-bold text-uppercase shadow-lg">
            Explore The Collection
        </a>
    </div>
    </div>
</section>


{{-- 2. FILTER BAR & PRODUCT GRID (Dùng cấu trúc Bootstrap/AJAX) --}}
<div class="container product-grid-container" id="product-list"> 

    {{-- CUSTOM HEADER --}}
    <h2 class="text-3xl font-runstar text-gray-800 mb-6 border-b-2 border-highlight pb-2 text-uppercase">{{ $categoryName }}</h2>
    
    {{-- FILTER/SORT BAR (Sử dụng lại cấu trúc filter-bar row/col từ index) --}}
    <div class="filter-bar row mt-4 mb-4">
        <div class="col-6">{{-- Leave empty or display product count if needed --}}</div>
        
        <div class="col-6 text-end">
            <select id="sort" class="filter-btn">
                {{-- Set default to 'newest' to match controller/AJAX --}}
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low - High</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High - Low</option>
            </select>
        </div>
    </div>

    {{-- PRODUCT LIST CONTAINER (AJAX updates this; partial includes the card loop) --}}
    <div id="product-list-container">
        @if($products->isEmpty())
            <div class="text-center py-10">
                 <p class="text-gray-600 text-xl">No Run Star products found.</p>
            </div>
        @else
            {{-- Include partial that contains the loop and product cards --}}
            @include('partials.product-cards', ['products' => $products])
        @endif
    </div>

    {{-- PAGINATION CONTAINER --}}
    <div class="d-flex justify-content-center my-5" id="pagination-container">
        <nav>
            @if(!$products->isEmpty())
                {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
            @endif
        </nav>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productListContainer = document.getElementById('product-list-container');
    const paginationContainer = document.getElementById('pagination-container');
    const sortSelect = document.getElementById('sort');
    // Current products index path (unused variable preserved if needed later)
    const productsIndexRoute = new URL(window.location.href).pathname;

    // Common function to fetch and update content
    function fetchProducts(url) {
        const fetchUrl = new URL(url, window.location.origin);

        // Update browser URL (History API)
        history.pushState(null, '', fetchUrl.toString());

        // Show loading state
        if (productListContainer) {
            productListContainer.innerHTML = `
                <div class="row">
                    <div class="col-12 loading-indicator">
                        <div class="converse-spinner"></div>
                        <p class="loading-text">LOADING SNEAKERS...</p>
                    </div>
                </div>
            `;
        }

        if (paginationContainer) {
            paginationContainer.innerHTML = '';
        }

        fetch(fetchUrl.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            // Update product list and pagination
            if (productListContainer) productListContainer.innerHTML = data.product_list;
            if (paginationContainer) paginationContainer.innerHTML = `<nav>${data.pagination}</nav>`;
            // Rebind click events for new pagination links
            rebindPaginationLinks();
        })
        .catch(err => console.error('Error fetching products:', err));
    }

    // Rebind click events for pagination links (guard for missing container)
    function rebindPaginationLinks() {
        if (!paginationContainer) return;
        paginationContainer.querySelectorAll('a.page-link').forEach(link => {
            link.removeEventListener('click', handlePaginationClick);
            link.addEventListener('click', handlePaginationClick);
        });
    }

    // Handle pagination link clicks
    function handlePaginationClick(e) {
        e.preventDefault();
        const url = this.href;
        fetchProducts(url);
    }

    // Handle sort selection change
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            const url = new URL(window.location.href);
            // Add/update 'sort' parameter
            url.searchParams.set('sort', sortValue);
            // Reset to page 1 when sorting
            url.searchParams.set('page', 1);

            fetchProducts(url.toString());
        });
    }

    // Handle browser Back/Forward (popstate)
    window.addEventListener('popstate', function(e) {
        // Reload content from URL after back/forward
        fetchProducts(window.location.href);
    });

    // Bind initial pagination events on first page load
    rebindPaginationLinks();
});
</script>
@endpush