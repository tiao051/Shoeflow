@extends('layouts.app')

@section('title', 'All Sneakers | CONVERSE')

{{-- Đẩy CSS riêng của trang này vào stack 'styles' trong layout --}}
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

    /* Tags */
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

    /* Pagination Override */
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
                <form action="{{ route('products.index') }}" method="GET" class="d-inline-block">
                    <select name="sort" class="filter-btn" onchange="this.form.submit()">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low - High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High - Low</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Top Rated</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="row">
            @foreach($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card position-relative">
                        <div class="image-wrapper">
                            @if($loop->index < 3) 
                                <span class="badge-custom">NEW</span>
                            @endif

                            <img src="{{ $product->image}}" 
                                 alt="{{ $product->name }}">
                        </div>

                        <div class="card-info">
                            <div class="product-title">{{ $product->name }}</div>
                            <div class="product-category">Classic / Lifestyle</div> 
                            <div class="product-price">
                                {{ number_format($product->price, 0, ',', '.') }} ₫
                            </div>
                        </div>

                        <a href="{{ route('products.show', $product->id) }}" class="stretched-link"></a>
                    </div>
                </div>
            @endforeach

            @if($products->count() == 0)
                <div class="col-12 text-center py-5">
                    <h3>No products found.</h3>
                    <a href="{{ route('products.index') }}" class="btn btn-dark mt-3 rounded-0 px-4">VIEW ALL</a>
                </div>
            @endif
        </div>

        <div class="d-flex justify-content-center my-5">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection