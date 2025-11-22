@extends('layouts.app')

@section('title', $product->name . ' | CONVERSE')

@push('styles')
<style>
    .font-oswald { font-family: 'Oswald', sans-serif; }
    .text-secondary-custom { color: #757575; }

    .product-container { padding-top: 40px; padding-bottom: 60px; }

    .product-gallery {
        position: relative;
        background-color: #f6f6f6;
        margin-bottom: 20px;
    }
    .main-image-wrapper {
        width: 90%;
        aspect-ratio: 1/1;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: default;
    }
    .main-image-wrapper img {
        width: 100%;
        height: auto;
        object-fit: cover;
        transition: none;
    }
    .main-image-wrapper:hover img {
        transform: none;
    }
    .badge-detail {
        position: absolute;
        top: 20px; left: 20px;
        background: #000;
        color: #fff;
        padding: 5px 12px;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        z-index: 10;
    }

    .product-info-sticky {
        position: sticky;
        top: 100px;
        height: fit-content;
    }

    .product-title-detail {
        font-size: 2.25rem;
        line-height: 1.1;
        text-transform: uppercase;
        margin-bottom: 10px;
        letter-spacing: -0.5px;
    }

    .product-price-detail {
        font-size: 1.5rem;
        font-weight: 500;
        color: #121212;
        margin-bottom: 20px;
    }

    .size-label {
        font-size: 0.9rem;
        font-weight: 700;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
    }
    .size-guide-link {
        text-decoration: underline;
        color: #757575;
        cursor: pointer;
        font-weight: 400;
        transition: color 0.2s;
    }
    .size-guide-link:hover {
        color: #000;
    }

    .size-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
        margin-bottom: 30px;
    }
    .size-option {
        border: 1px solid #e5e5e5;
        padding: 12px 0;
        text-align: center;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s;
    }
    .size-option:hover {
        border-color: #000;
    }
    .size-option.selected {
        background-color: #000;
        color: #fff;
        border-color: #000;
    }
    .size-option.disabled {
        color: #ccc;
        background-color: #f9f9f9;
        cursor: not-allowed;
        border-color: #eee;
        text-decoration: line-through;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        margin-bottom: 40px;
    }
    .btn-add-cart {
        flex: 1;
        background-color: #000;
        color: #fff;
        border: none;
        padding: 18px;
        text-transform: uppercase;
        font-weight: 700;
        font-size: 1rem;
        transition: background 0.3s;
    }
    .btn-add-cart:hover {
        background-color: #333;
    }
    .btn-wishlist-detail {
        width: 58px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e5e5e5;
        background: #fff;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-wishlist-detail:hover {
        border-color: #000;
    }
    .btn-wishlist-detail svg {
        width: 24px; height: 24px;
        transition: fill 0.3s;
    }
    .btn-wishlist-detail.active svg {
        fill: #ff0000; stroke: #ff0000;
    }

    .product-details-accordion details {
        border-top: 1px solid #e5e5e5;
    }
    .product-details-accordion details:last-child {
        border-bottom: 1px solid #e5e5e5;
    }
    .product-details-accordion summary {
        padding: 20px 0;
        font-weight: 700;
        cursor: pointer;
        list-style: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-transform: uppercase;
        font-size: 0.95rem;
    }
    .product-details-accordion summary::-webkit-details-marker {
        display: none;
    }
    .product-details-accordion summary::after {
        content: '+';
        font-size: 1.2rem;
        font-weight: 400;
    }
    .product-details-accordion details[open] summary::after {
        content: '-';
    }
    .accordion-content {
        padding-bottom: 20px;
        font-size: 0.9rem;
        line-height: 1.6;
        color: #555;
    }

    .related-section { margin-top: 80px; }
    .related-title {
        font-size: 1.8rem;
        margin-bottom: 30px;
        text-transform: uppercase;
    }

    .size-guide-modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        background-color: rgba(0,0,0,0.6);
        justify-content: center;
        align-items: center;
        animation: fadeIn 0.3s;
    }

    .size-guide-content {
        background-color: #fff;
        padding: 40px;
        width: 90%;
        max-width: 700px;
        position: relative;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .close-modal {
        color: #aaa;
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        transition: color 0.2s;
        background: none;
        border: none;
        padding: 0;
    }

    .close-modal:hover,
    .close-modal:focus {
        color: #000;
        text-decoration: none;
    }

    .size-table th, .size-table td {
        text-align: center;
        vertical-align: middle;
        font-size: 0.9rem;
        padding: 12px 8px;
    }

    @keyframes fadeIn {
        from {opacity: 0;}
        to {opacity: 1;}
    }

    @media (max-width: 768px) {
        .product-container { padding-top: 0; }
        .product-info-sticky { position: static; padding-top: 20px; }
        .product-title-detail { font-size: 1.8rem; }
        .size-grid { grid-template-columns: repeat(4, 1fr); }
        .size-guide-content { padding: 20px; }
    }
</style>
@endpush

@section('content')
<div class="container product-container">
    
    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-4 d-none d-md-block">
        <ol class="breadcrumb small text-uppercase">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-dark text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-dark text-decoration-none">Sneakers</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- LEFT COLUMN: IMAGES -->
        <div class="col-md-7">
            <div class="product-gallery">
                @if($product->is_new)
                    <span class="badge-detail font-oswald">New Arrival</span>
                @endif
                
                <div class="main-image-wrapper">
                    <!-- Sử dụng ảnh chính từ DB -->
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" id="mainImage">
                </div>
            </div>
            
            <!-- Description for Desktop (Optional placement) -->
            <div class="d-none d-md-block mt-5">
                <h4 class="font-oswald text-uppercase mb-3">About this product</h4>
                <p class="text-secondary">{{ $product->description }}</p>
                <ul class="text-secondary small mt-3">
                    <li>SKU: CON-{{ $product->id }}</li>
                    <li>Stock: {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}</li>
                </ul>
            </div>
        </div>

        <!-- RIGHT COLUMN: INFO & ACTIONS -->
        <div class="col-md-5">
            <div class="product-info-sticky">
                <h1 class="product-title-detail font-oswald">{{ $product->name }}</h1>
                
                <div class="product-price-detail font-oswald">
                    @if($product->sale_price)
                        <span class="text-danger">{{ number_format($product->sale_price, 0, ',', '.') }} ₫</span>
                        <span class="text-decoration-line-through text-secondary ms-2 fs-5">{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                    @else
                        {{ number_format($product->price, 0, ',', '.') }} ₫
                    @endif
                </div>

                <!-- SIZE SELECTOR -->
                <div class="mb-4">
                    <div class="size-label">
                        <span>SELECT SIZE (US)</span>
                        <!-- SỬA TẠI ĐÂY: Thêm sự kiện onclick -->
                        <span class="size-guide-link" onclick="openSizeGuide()">Size Guide</span>
                    </div>
                    
                    <!-- Fake sizes for UI demo -->
                    <div class="size-grid" id="sizeSelector">
                        @foreach(['7', '7.5', '8', '8.5', '9', '9.5', '10', '10.5', '11', '12'] as $size)
                            <div class="size-option" onclick="selectSize(this, '{{ $size }}')">{{ $size }}</div>
                        @endforeach
                    </div>
                    <input type="hidden" id="selectedSize" name="size">
                    <div id="sizeError" class="text-danger small d-none mb-2">Please select a size.</div>
                </div>

                <!-- ACTIONS -->
                <div class="action-buttons">
                    <button class="btn-add-cart" onclick="addToCart()">
                        Add to Cart
                    </button>
                    <button class="btn-wishlist-detail" title="Add to Wishlist">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                        </svg>
                    </button>
                </div>

                <!-- ACCORDION INFO -->
                <div class="product-details-accordion">
                    <!-- Mobile Description -->
                    <div class="d-md-none">
                         <details open>
                            <summary>Description</summary>
                            <div class="accordion-content">
                                {{ $product->description }}
                            </div>
                        </details>
                    </div>

                    <details>
                        <summary>Shipping & Returns</summary>
                        <div class="accordion-content">
                            <p>Free standard shipping on all orders over 1,000,000 ₫.</p>
                            <p>Converse members enjoy free returns. Not a member? Sign up for free.</p>
                        </div>
                    </details>
                    <details>
                        <summary>Reviews (0)</summary>
                        <div class="accordion-content">
                            <p>No reviews yet. Be the first to write a review!</p>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </div>

    <!-- RELATED PRODUCTS -->
    <div class="related-section">
        <h3 class="related-title font-oswald">You May Also Like</h3>
        <div class="row">
            @foreach($relatedProducts as $related)
                <div class="col-6 col-md-3">
                    <div class="product-card position-relative mb-4">
                        <div class="image-wrapper bg-light position-relative" style="aspect-ratio: 1/1; overflow: hidden;">
                             @if($related->is_new)
                                <span class="badge-detail" style="font-size: 0.6rem; padding: 3px 8px; top: 10px; left: 10px;">NEW</span>
                            @endif
                            <img src="{{ asset($related->image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $related->name }}">
                            <a href="{{ route('products.show', $related->id) }}" class="stretched-link"></a>
                        </div>
                        <div class="mt-2">
                            <h6 class="font-oswald text-uppercase mb-0 text-truncate">{{ $related->name }}</h6>
                            <p class="text-secondary mb-1 small">{{ $related->brand }}</p>
                            <span class="fw-bold">{{ number_format($related->price, 0, ',', '.') }} ₫</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- SIZE GUIDE MODAL COMPONENT -->
    <div id="sizeGuideModal" class="size-guide-modal">
        <div class="size-guide-content">
            <button class="close-modal" onclick="closeSizeGuide()">&times;</button>
            
            <div class="text-center mb-4">
                <h2 class="font-oswald">SIZE GUIDE</h2>
                <p class="text-secondary small">Unisex / Men's / Women's</p>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped size-table">
                    <thead class="bg-black text-white font-oswald">
                        <tr>
                            <th>US MEN</th>
                            <th>US WOMEN</th>
                            <th>UK</th>
                            <th>EUR</th>
                            <th>CM</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>3</td><td>5</td><td>3</td><td>35</td><td>22</td></tr>
                        <tr><td>3.5</td><td>5.5</td><td>3.5</td><td>36</td><td>22.5</td></tr>
                        <tr><td>4</td><td>6</td><td>4</td><td>36.5</td><td>23</td></tr>
                        <tr><td>4.5</td><td>6.5</td><td>4.5</td><td>37</td><td>23.5</td></tr>
                        <tr><td>5</td><td>7</td><td>5</td><td>37.5</td><td>24</td></tr>
                        <tr><td>5.5</td><td>7.5</td><td>5.5</td><td>38</td><td>24.5</td></tr>
                        <tr><td>6</td><td>8</td><td>6</td><td>39</td><td>24.5</td></tr>
                        <tr><td>6.5</td><td>8.5</td><td>6.5</td><td>39.5</td><td>25</td></tr>
                        <tr><td>7</td><td>9</td><td>7</td><td>40</td><td>25.5</td></tr>
                        <tr><td>7.5</td><td>9.5</td><td>7.5</td><td>41</td><td>26</td></tr>
                        <tr><td>8</td><td>10</td><td>8</td><td>41.5</td><td>26.5</td></tr>
                        <tr><td>8.5</td><td>10.5</td><td>8.5</td><td>42</td><td>27</td></tr>
                        <tr><td>9</td><td>11</td><td>9</td><td>42.5</td><td>27.5</td></tr>
                        <tr><td>9.5</td><td>11.5</td><td>9.5</td><td>43</td><td>28</td></tr>
                        <tr><td>10</td><td>12</td><td>10</td><td>44</td><td>28.5</td></tr>
                        <tr><td>11</td><td>13</td><td>11</td><td>45</td><td>29.5</td></tr>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3 text-secondary small">
                <p><strong>Fit Tip:</strong> Converse Chuck Taylor All Star sneakers typically run a half size large. We recommend ordering a half size down from your normal size.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // --- SIZE SELECTION LOGIC ---
    function selectSize(element, size) {
        document.querySelectorAll('.size-option').forEach(el => el.classList.remove('selected'));
        element.classList.add('selected');
        document.getElementById('selectedSize').value = size;
        document.getElementById('sizeError').classList.add('d-none');
    }

    function addToCart() {
        const size = document.getElementById('selectedSize').value;
        if (!size) {
            document.getElementById('sizeError').classList.remove('d-none');
            const grid = document.getElementById('sizeSelector');
            grid.style.animation = "shake 0.5s";
            setTimeout(() => grid.style.animation = "", 500);
            return;
        }

        const btn = document.querySelector('.btn-add-cart');
        const originalText = btn.innerText;
        
        btn.innerText = "ADDING...";
        btn.style.opacity = "0.8";
        
        setTimeout(() => {
            btn.innerText = "ADDED TO CART";
            btn.style.backgroundColor = "#4CAF50";
            
            setTimeout(() => {
                btn.innerText = originalText;
                btn.style.backgroundColor = "#000";
                btn.style.opacity = "1";
            }, 2000);
        }, 800);

        console.log(`Adding Product {{ $product->id }}, Size: ${size} to cart.`);
    }

    // --- SIZE GUIDE MODAL LOGIC ---
    function openSizeGuide() {
        document.getElementById('sizeGuideModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeSizeGuide() {
        document.getElementById('sizeGuideModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('sizeGuideModal');
        if (event.target == modal) {
            closeSizeGuide();
        }
    }
</script>

<style>
@keyframes shake {
  0% { transform: translateX(0); }
  25% { transform: translateX(-5px); }
  50% { transform: translateX(5px); }
  75% { transform: translateX(-5px); }
  100% { transform: translateX(0); }
}
</style>
@endpush