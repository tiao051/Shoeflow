@foreach($products as $product)
<div class="col-6 col-md-4 col-lg-3">
    <div class="product-card position-relative">
        <div class="image-wrapper">
            @if($loop->index < 3) 
                <span class="badge-custom">NEW</span>
            @endif
            <img src="{{ $product->image }}" alt="{{ $product->name }}">
        </div>
        <div class="card-info">
            <div class="product-title">{{ $product->name }}</div>
            <div class="product-category">Classic / Lifestyle</div>
            <div class="product-price">{{ number_format($product->price, 0, ',', '.') }} ₫</div>
        </div>
        <a href="{{ route('products.show', $product->id) }}" class="stretched-link"></a>
    </div>
</div>
@endforeach
@endif
