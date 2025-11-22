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
            <h1 class="m-0" style="font-size: 2.5rem;">All Sneakers</h1>
        </div>
        <div class="col-6 text-end">
            <select id="sort" class="filter-btn">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low - High</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High - Low</option>
            </select>
        </div>
    </div>

    <!-- Product list container -->
    <div id="product-list" class="row">
        @include('partials.product_cards', ['products' => $products])
    </div>

    <!-- Pagination wrapper -->
    <div class="d-flex justify-content-center my-5" id="pagination">
        <nav>
            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
        </nav>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productList = document.getElementById('product-list');
    const pagination = document.getElementById('pagination');
    const sortSelect = document.getElementById('sort');
    const productsIndexRoute = "{{ route('products.index') }}";

    function fetchProducts(url, sort) {
        const fetchUrl = new URL(url, window.location.origin);
        if (sort && sort !== 'newest') fetchUrl.searchParams.set('sort', sort);
        else fetchUrl.searchParams.delete('sort');

        history.pushState(null, '', fetchUrl.toString());

        fetch(fetchUrl.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.json())
            .then(data => {
                // Render products
                let html = '';
                data.products.forEach(p => {
                    const productUrl = `/products/${p.id}`;
                    const formattedPrice = parseFloat(p.price).toLocaleString('vi-VN', { minimumFractionDigits: 0 });
                    html += `
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="product-card position-relative">
                                <div class="image-wrapper">
                                    ${p.is_new ? '<span class="badge-custom">NEW</span>' : ''}
                                    <img src="/${p.image}" alt="${p.name}">
                                </div>
                                <div class="card-info">
                                    <div class="product-title">${p.name}</div>
                                    <div class="product-category">Classic / Lifestyle</div>
                                    <div class="product-price">${formattedPrice} ₫</div>
                                </div>
                                <a href="${productUrl}" class="stretched-link"></a>
                            </div>
                        </div>`;
                });
                productList.innerHTML = html;

                // Render pagination (giữ nav wrapper)
                pagination.innerHTML = `<nav>${data.pagination}</nav>`;

                // Rebind click events cho pagination links
                rebindPaginationLinks();
            })
            .catch(err => console.error('Error fetching products:', err));
    }

    function handlePaginationClick(e) {
        e.preventDefault();
        const url = this.href;
        fetchProducts(url, sortSelect.value);
    }

    function rebindPaginationLinks() {
        pagination.querySelectorAll('a.page-link').forEach(link => {
            link.removeEventListener('click', handlePaginationClick);
            link.addEventListener('click', handlePaginationClick);
        });
    }

    // Sort change
    sortSelect.addEventListener('change', function() {
        fetchProducts(productsIndexRoute, this.value);
    });

    // Bind initial pagination
    rebindPaginationLinks();
});
</script>
@endpush
