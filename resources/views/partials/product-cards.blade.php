<div class="row">
    @foreach($products as $product)
        <div class="col-6 col-md-4 col-lg-3 mb-4">
            <div class="product-card position-relative h-100">
                <div class="image-wrapper">
                    {{-- Badge NEW logic --}}
                    @if($loop->index < 3 && $products->currentPage() == 1) 
                        <span class="badge-custom">NEW</span>
                    @endif
                    
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                </div>
                
                <div class="card-info mt-2">
                    <div class="product-title font-weight-bold">{{ $product->name }}</div>
                    <div class="product-category text-muted small">
                        {{ $product->category->name ?? 'Classic / Lifestyle' }}
                    </div>
                    <div class="product-price font-weight-bold">
                        {{ number_format($product->price, 0, ',', '.') }} ₫
                    </div>
                </div>
                
                <a href="{{ route('products.show', $product->id) }}" class="stretched-link"></a>
            </div>
        </div>
    @endforeach
</div>