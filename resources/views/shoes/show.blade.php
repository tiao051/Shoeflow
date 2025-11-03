@extends('layouts.app')

@section('title', $shoe['name'] . ' - Shoeler')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Product Images -->
        <div class="col-md-6">
            <img src="{{ $shoe['mainImage'] ? asset('storage/' . $shoe['mainImage']) : 'https://via.placeholder.com/600x500' }}" 
                 class="img-fluid rounded" alt="{{ $shoe['name'] }}">
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h2>{{ $shoe['name'] }}</h2>
            <p class="text-muted">{{ $shoe['brand'] }}</p>

            <div class="mb-3">
                @for($i = 1; $i <= 5; $i++)
                    <i class="bi bi-star{{ $i <= $shoe['rating'] ? '-fill' : '' }} text-warning"></i>
                @endfor
                <span class="ms-2">({{ $shoe['reviewCount'] }} reviews)</span>
            </div>

            <div class="mb-4">
                @if($shoe['hasDiscount']())
                    <h3 class="text-danger">Rp {{ number_format($shoe['discountPrice'], 0, ',', '.') }}</h3>
                    <p class="text-decoration-line-through text-muted">Rp {{ number_format($shoe['price'], 0, ',', '.') }}</p>
                @else
                    <h3>Rp {{ number_format($shoe['price'], 0, ',', '.') }}</h3>
                @endif
            </div>

            <div class="mb-3">
                <p><strong>Material:</strong> {{ $shoe['material'] ?? 'N/A' }}</p>
                <p><strong>Color:</strong> {{ $shoe['color'] ?? 'N/A' }}</p>
                <p><strong>Stock:</strong> 
                    @if($shoe['stock'] > 0)
                        <span class="text-success">{{ $shoe['stock'] }} available</span>
                    @else
                        <span class="text-danger">Out of stock</span>
                    @endif
                </p>
            </div>

            @if($shoe['stock'] > 0)
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="shoe_id" value="{{ $shoe['id'] }}">
                <input type="hidden" name="shoe_name" value="{{ $shoe['name'] }}">
                <input type="hidden" name="shoe_image" value="{{ $shoe['mainImage'] }}">
                <input type="hidden" name="price" value="{{ $shoe['getFinalPrice']() }}">

                <div class="mb-3">
                    <label class="form-label"><strong>Select Size:</strong></label>
                    <select name="size" class="form-select" required>
                        <option value="">Choose size...</option>
                        @foreach($shoe['sizes'] as $size)
                            <option value="{{ $size }}">{{ $size }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Quantity:</strong></label>
                    <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $shoe['stock'] }}" required>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-cart-plus"></i> Add to Cart
                </button>
            </form>
            @else
            <button class="btn btn-secondary btn-lg w-100" disabled>Out of Stock</button>
            @endif

            <div class="mt-4">
                <h5>Description</h5>
                <p>{{ $shoe['description'] }}</p>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h4>Customer Reviews</h4>
            @forelse($reviews as $review)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h6>{{ $review['user']['name'] ?? 'Anonymous' }}</h6>
                        <small class="text-muted">{{ date('M d, Y', strtotime($review['created_at'])) }}</small>
                    </div>
                    <div class="mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $review['rating'] ? '-fill' : '' }} text-warning"></i>
                        @endfor
                    </div>
                    <p>{{ $review['comment'] }}</p>
                </div>
            </div>
            @empty
            <p class="text-muted">No reviews yet. Be the first to review this product!</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
