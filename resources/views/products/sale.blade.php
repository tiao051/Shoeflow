@extends('layouts.app')

@section('title', 'SALE UP TO 50% | CONVERSE VIETNAM')

@push('styles')
<style>
/* --- FILTER/SORT BUTTON --- */
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

/* --- AJAX LOADING SPINNER --- */
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
    border-top: 3px solid #dc3545;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* --- PRODUCT CARD STYLES --- */
.product-card {
    border: none;
    background: transparent;
    margin-bottom: 40px;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.product-card:hover {
    transform: translateY(-5px) scale(1.01);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}
.image-wrapper {
    position: relative;
    overflow: hidden;
    background-color: #f4f4f4;
    aspect-ratio: 1 / 1;
}
.image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
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
.card-info {
    padding-top: 15px;
}
.product-title {
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 5px;
    line-height: 1.4;
    text-transform: uppercase;
}
.product-category {
    font-size: 0.85rem;
    color: #757575;
    margin-bottom: 5px;
}
.product-price {
    font-family: 'Oswald', sans-serif;
    color: #121212;
}

/* --- SALE PAGE STYLES --- */
.font-sale {
    font-family: 'Oswald', sans-serif;
    font-weight: 900;
    letter-spacing: 2px;
}
.text-title-sale {
    font-size: 4rem;
    line-height: 1;
}
.sale-highlight {
    color: #dc3545;
}
.hero-sale {
    background: linear-gradient(145deg, #121212 0%, #dc3545 100%);
    color: white;
    padding-top: 5rem;
    padding-bottom: 5rem;
    margin-bottom: 2rem;
    position: relative;
    z-index: 10;
}
.sale-cta {
    background-color: #ffc107;
    color: #121212;
    border: 2px solid #ffc107;
    font-weight: 700 !important;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}
.sale-cta:hover {
    background-color: #ffffff;
    color: #dc3545;
    border-color: #dc3545;
    box-shadow: 0 6px 15px rgba(220, 53, 69, 0.5);
    transform: translateY(-2px);
}
@media (max-width: 768px) {
    .text-title-sale { font-size: 3rem; }
}

.product-grid-container {
    padding-top: 2rem;
    z-index: 20;
    position: relative;
    background-color: white;
}
</style>
@endpush

@section('content')
{{-- HERO SECTION --}}
<section class="hero-sale">
    <div class="container text-center">
        <h1 class="font-sale text-title-sale mb-3">
            <span class="sale-highlight">FLASH SALE</span><br> UP TO 50% OFF
        </h1>
        <p class="text-xl md:text-2xl text-gray-300">
            Grab your dream pair before they're gone forever.
        </p>
        <div class="mt-8">
            <div class="btn sale-cta px-5 py-3 rounded-pill text-uppercase shadow-lg">
                Shop Now!
            </div>
        </div>
    </div>
</section>

{{-- PRODUCT GRID & FILTER --}}
<div class="container product-grid-container" id="product-list">
    <h2 class="text-3xl font-sale text-gray-800 mb-6 border-b-2 border-sale-highlight pb-2 text-uppercase">
        {{ $categoryName }}
    </h2>

    <div id="product-list-container">
        @if($products->isEmpty())
            <div class="text-center py-10">
                <p class="text-gray-600 text-xl">
                    Sorry, no products are currently on sale. Please check back later!
                </p>
            </div>
        @else
            @include('partials.product-cards', ['products' => $products])
        @endif
    </div>

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

    function fetchProducts(url) {
        const fetchUrl = new URL(url, window.location.origin);
        history.pushState(null, '', fetchUrl.toString());

        if (productListContainer) {
            productListContainer.innerHTML = `
                <div class="row">
                    <div class="col-12 loading-indicator text-center py-5">
                        <div class="converse-spinner"></div>
                        <p class="loading-text mt-3">LOADING SALE ITEMS...</p>
                    </div>
                </div>
            `;
        }
        if (paginationContainer) paginationContainer.innerHTML = '';

        fetch(fetchUrl.toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (productListContainer) productListContainer.innerHTML = data.product_list;
            if (paginationContainer) paginationContainer.innerHTML = `<nav>${data.pagination}</nav>`;
            rebindAllListeners();
        })
        .catch(err => console.error('Error fetching products:', err));
    }

    function handlePaginationClick(e) {
        e.preventDefault();
        fetchProducts(this.href);
    }

    function rebindPaginationLinks() {
        if (!paginationContainer) return;
        paginationContainer.querySelectorAll('a.page-link').forEach(link => {
            link.removeEventListener('click', handlePaginationClick);
            link.addEventListener('click', handlePaginationClick);
        });
    }

    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', this.value);
            url.searchParams.set('page', 1);
            fetchProducts(url.toString());
        });
    }

    window.addEventListener('popstate', () => fetchProducts(window.location.href));

    function rebindAllListeners() {
        rebindPaginationLinks();
    }

    rebindAllListeners();
});
</script>
@endpush
