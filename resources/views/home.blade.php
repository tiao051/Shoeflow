@extends('layouts.app')

@section('title', 'Home - Shoeler')

@section('content')
<!-- Hero Section -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3">Welcome to Shoeler</h1>
                <p class="lead mb-4">Discover premium quality shoes from top brands. Step into comfort and style.</p>
                <a href="{{ route('shoes.index') }}" class="btn btn-primary btn-lg">Shop Now</a>
            </div>
            <div class="col-lg-6">
                <img src="https://via.placeholder.com/600x400" alt="Hero" class="img-fluid rounded">
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Shop by Category</h2>
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-md-3">
                <a href="{{ route('category.show', $category['slug']) }}" class="text-decoration-none">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="bi bi-bag fs-1 text-primary"></i>
                            <h5 class="card-title mt-3">{{ $category['name'] }}</h5>
                            <p class="card-text text-muted">{{ $category['description'] }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Featured Shoes</h2>
        <div class="row g-4">
            @foreach($featuredShoes as $shoe)
            <div class="col-md-3">
                <div class="card product-card">
                    @if($shoe['hasDiscount']())
                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                            -{{ round((($shoe['price'] - $shoe['discountPrice']) / $shoe['price']) * 100) }}%
                        </span>
                    @endif
                    <img src="{{ $shoe['mainImage'] ? asset('storage/' . $shoe['mainImage']) : 'https://via.placeholder.com/300x250' }}" 
                         class="card-img-top" alt="{{ $shoe['name'] }}">
                    <div class="card-body">
                        <h6 class="card-title">{{ $shoe['name'] }}</h6>
                        <p class="text-muted small mb-2">{{ $shoe['brand'] }}</p>
                        <div class="mb-2">
                            @if($shoe['hasDiscount']())
                                <span class="text-decoration-line-through text-muted">Rp {{ number_format($shoe['price'], 0, ',', '.') }}</span>
                                <br>
                                <span class="fw-bold text-danger">Rp {{ number_format($shoe['discountPrice'], 0, ',', '.') }}</span>
                            @else
                                <span class="fw-bold">Rp {{ number_format($shoe['price'], 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $shoe['rating'] ? '-fill' : '' }} text-warning"></i>
                            @endfor
                            <small class="text-muted">({{ $shoe['reviewCount'] }})</small>
                        </div>
                        <a href="{{ route('shoes.show', $shoe['slug']) }}" class="btn btn-sm btn-outline-primary w-100">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
