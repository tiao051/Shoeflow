@extends('layouts.app')

@section('title', 'All Sneakers | CONVERSE')

@push('styles')
<style>
    /* --- FILTER BAR --- */
    .filter-bar {
        padding: 20px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
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

    /* --- PRODUCT CARD STYLE --- */
    .product-card {
        border: none;
        background: transparent;
        margin-bottom: 40px;
        cursor: pointer;
        transition: transform 0.3s ease;
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

    .product-card:hover .image-wrapper img {
        transform: scale(1.05);
    }

    .badge-custom {
        position: absolute;
        top: 10px; left: 10px;
        background-color: #121212;
        color: white;
        padding: 4px 8px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        border-radius: 0;
    }

    .card-info { padding-top: 15px; }

    .product-title {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 5px;
        line-height: 1.4;
    }

    .product-category {
        font-size: 0.85rem;
        color: #757575;
        margin-bottom: 5px;
    }

    .product-price {
        font-family: 'Oswald', sans-serif;
        font-size: 1.1rem;
        font-weight: 500;
        color: #121212;
    }

    .stretched-link::after {
        position: absolute;
        top: 0; right: 0; bottom: 0; left: 0;
        z-index: 1; content: "";
    }

    .pagination .page-item .page-link {
        color: #121212; border: none; font-weight: 600; padding: 10px 15px;
    }
    .pagination .page-item.active .page-link {
        background-color: #121212; color: white; border-radius: 0;
    }
    .pagination .page-item .page-link:hover {
        background-color: #eee;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="filter-bar row mt-4 mb-4">
        <div class="col-6">
            <h1 class="m-0 text-uppercase" style="font-size: 2.5rem; font-weight: 900; font-family: 'Oswald', sans-serif;">
                {{ $categoryName }}
            </h1>
        </div>
        
        <div class="col-6 text-end">
            <select id="sort" class="filter-btn">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low - High</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High - Low</option>
            </select>
        </div>
        
    </div>
    
    <div id="product-list-container">
        @include('partials.product-cards')
    </div>

    <div class="d-flex justify-content-center my-5" id="pagination-container">
        <nav>
            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
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
    // Current products index path
    const productsIndexRoute = new URL(window.location.href).pathname;

    // Common function to fetch and update content
    function fetchProducts(url) {
        const fetchUrl = new URL(url, window.location.origin);

        // Update browser URL (History API)
        history.pushState(null, '', fetchUrl.toString());

        // Optional: show loading state
        productListContainer.innerHTML = '<div class="row"><div class="col-12 text-center my-5"><p>Loading products...</p></div></div>';
        paginationContainer.innerHTML = '';

        fetch(fetchUrl.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            // Update product list and pagination
            productListContainer.innerHTML = data.product_list;
            paginationContainer.innerHTML = `<nav>${data.pagination}</nav>`;
            // Rebind click events for new pagination links
            rebindPaginationLinks();
        })
        .catch(err => console.error('Error fetching products:', err));
    }

    // Rebind click events for pagination links
    function rebindPaginationLinks() {
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
    sortSelect.addEventListener('change', function() {
        const sortValue = this.value;
        const url = new URL(window.location.href);
        // Add/update 'sort' parameter
        url.searchParams.set('sort', sortValue);
        // Reset to page 1 when sorting
        url.searchParams.set('page', 1);

        fetchProducts(url.toString());
    });
    
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