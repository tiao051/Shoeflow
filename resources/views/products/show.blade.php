@extends('layouts.app')

@section('title', $product->name . ' | CONVERSE')

@push('styles')
<style>
    /* --- FONTS & BASICS --- */
    .font-oswald { font-family: 'Oswald', sans-serif; }
    .text-secondary-custom { color: #757575; }
    
    /* --- LAYOUT --- */
    .product-container { padding-top: 40px; padding-bottom: 60px; }

    /* --- GALLERY SECTION --- */
    .product-gallery {
        position: relative;
        background-color: #f6f6f6; /* Converse light gray bg */
        margin-bottom: 20px;
    }
    .main-image-wrapper {
        width: 90%; /* Reduced width to make the image smaller */
        aspect-ratio: 1/1;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: default; /* Removed zoom-in cursor */
    }
    .main-image-wrapper img {
        width: 100%;
        height: auto;
        object-fit: cover;
        transition: none; /* Removed zoom effect */
    }
    .main-image-wrapper:hover img {
        transform: none; /* Removed zoom effect */
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

    /* --- INFO SECTION (STICKY) --- */
    .product-info-sticky {
        position: sticky;
        top: 100px; /* Adjust based on your header height */
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

    /* --- SIZE SELECTOR --- */
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
        grid-template-columns: repeat(5, 1fr); /* 5 sizes per row */
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

    /* --- ACTIONS --- */
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
        /* Custom styles for success flash */
        border: 1px solid transparent; /* Ensure border exists for consistency */
    }
    .btn-add-cart:hover:not(:disabled) {
        background-color: #333;
    }
    .btn-add-cart.btn-success-flash {
        background-color: #4CAF50; /* Green color for success */
        border-color: #4CAF50;
        animation: flash-pulse 0.5s 3; /* Flash effect */
    }
    @keyframes flash-pulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(76, 175, 80, 0.7); }
        50% { transform: scale(1.01); box-shadow: 0 0 0 10px rgba(76, 175, 80, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(76, 175, 80, 0); }
    }

    .btn-wishlist-detail {
        width: 58px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #e5e5e5;
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

    /* --- ACCORDION (DETAILS) --- */
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

    /* --- RELATED PRODUCTS --- */
    .related-section { margin-top: 80px; }
    .related-title {
        font-size: 1.8rem;
        margin-bottom: 30px;
        text-transform: uppercase;
    }

    /* --- SIZE GUIDE MODAL --- */
    .size-guide-modal {
        display: none; /* Hidden by default */
        position: fixed;
        z-index: 1050; /* Higher than sticky header */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        background-color: rgba(0,0,0,0.6); /* Black w/ opacity */
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

    @keyframes shake {
      0% { transform: translateX(0); }
      25% { transform: translateX(-5px); }
      50% { transform: translateX(5px); }
      75% { transform: translateX(-5px); }
      100% { transform: translateX(0); }
    }

    /* --- CONVERSE ANIMATIONS & TOAST --- */
    @keyframes converse-pop {
        0% { transform: scale(1); }
        50% { transform: scale(1.4); }
        100% { transform: scale(1); }
    }
    
    /* Apply animation to the SVG when active */
    .btn-wishlist-detail.heart-animate svg {
        animation: converse-pop 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }

    /* --- NEW: Converse Toast Notification --- */
    #converse-toast {
        visibility: hidden;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        background-color: #000;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 24px;
        border-left: 4px solid #dc3545; /* Red accent */
        box-shadow: 0 10px 15px rgba(0,0,0,0.2);
    }
    #converse-toast.show {
        visibility: visible;
        opacity: 1;
        transform: translateY(0);
    }
    #converse-toast .toast-text div:first-child {
        font-family: 'Oswald', sans-serif;
        font-weight: 700;
        text-transform: uppercase;
        line-height: 1;
    }
    #converse-toast .toast-text div:last-child {
        font-size: 0.75rem;
        color: #d1d5db;
        text-transform: uppercase;
    }

    /* --- MOBILE ADJUSTMENTS --- */
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
    
    @if(session('success'))
        <div class="alert alert-success mb-4 text-center d-none" id="sessionSuccessMessage">
            {{ session('success') }}
        </div>
    @endif

    <nav aria-label="breadcrumb" class="mb-4 d-none d-md-block">
        <ol class="breadcrumb small text-uppercase">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-dark text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-dark text-decoration-none">Sneakers</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-7">
            <div class="product-gallery">
                @if($product->is_new)
                    <span class="badge-detail font-oswald">New Arrival</span>
                @endif
                
                <div class="main-image-wrapper">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" id="mainImage">
                </div>
            </div>
            
            <div class="d-none d-md-block mt-5">
                <h4 class="font-oswald text-uppercase mb-3">About this product</h4>
                <p class="text-secondary">{{ $product->description }}</p>
                <ul class="text-secondary small mt-3">
                    <li>SKU: CON-{{ $product->id }}</li>
                    <li>Stock: {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}</li>
                </ul>
            </div>
        </div>

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

                <div class="mb-4">
                    <div class="size-label">
                        <span>SELECT SIZE (US)</span>
                        <span class="size-guide-link" onclick="openSizeGuide()">Size Guide</span>
                    </div>
                    
                    <div class="size-grid" id="sizeSelector">
                        @foreach(['7', '7.5', '8', '8.5', '9', '9.5', '10', '10.5', '11', '12'] as $size)
                            <div class="size-option" onclick="selectSize(this, '{{ $size }}')">{{ $size }}</div>
                        @endforeach
                    </div>
                    <input type="hidden" id="selectedSize" name="size">
                    <div id="sizeError" class="text-danger small d-none mb-2">Please select a size!</div>
                </div>

                <div class="action-buttons">
                    <button class="btn-add-cart" id="addToCartButton" type="submit" form="addToCartForm">
                        ADD TO CART
                    </button>
                    
                    <form id="wishlistForm" action="{{ route('wishlist.store') }}" method="POST" style="display: flex;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        @php
                            $isInWishlist = Auth::check() && \App\Models\Wishlist::where('user_id', Auth::id())->where('product_id', $product->id)->exists();
                        @endphp

                        <button type="submit" id="wishlistBtn" class="btn-wishlist-detail {{ $isInWishlist ? 'active' : '' }}" title="Add to Wishlist">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                    </form>
                </div>

                <div id="converse-toast">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <div class="toast-text">
                        <div id="toast-title">WISHLIST UPDATED</div>
                        <div id="toast-message">Item added to your collection.</div>
                    </div>
                </div>

                <div class="product-details-accordion">
                    <div class="d-md-none">
                         <details open>
                            <summary>Description</summary>
                            <div class="accordion-content">
                                {{ $product->description }}
                            </div>
                        </details>
                    </div>

                    <details class="bg-white rounded-xl shadow-md border border-gray-100 mt-6 overflow-hidden">
                        <summary class="p-4 cursor-pointer flex justify-between items-center bg-gray-50 hover:bg-gray-100 transition">
                            <span class="font-bold text-lg text-gray-800">Shipping & Returns</span>
                        </summary>

                        <div class="accordion-content p-4 divide-y divide-gray-100">
                            <div class="py-3">
                                <p class="text-gray-700">Free standard shipping on all orders over 1,000,000 ₫.</p>
                            </div>
                            <div class="py-3">
                                <p class="text-gray-700">Converse members enjoy free returns. Not a member? Sign up for free.</p>
                            </div>
                        </div>
                    </details>
                    
                    <div x-data="productReviews({{ $product->id }})" x-init="fetchReviews()">
                        <details class="bg-white rounded-xl shadow-md border border-gray-100 mt-6 overflow-hidden">
                            
                            {{-- SUMMARY HEADER --}}
                            <summary class="p-4 cursor-pointer flex justify-between items-center bg-gray-50 hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-3">
                                    <span class="font-bold text-lg text-gray-800">
                                        Reviews 
                                        <span x-text="'(' + summary.total_reviews + ')'"></span>
                                    </span>
                                    
                                    <template x-if="summary.total_reviews > 0">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <span class="font-bold text-black mr-2 text-base" x-text="summary.average_rating"></span>
                                            
                                            {{-- Star Visualization --}}
                                            <div class="flex text-yellow-400">
                                                <template x-for="star in 5" :key="star">
                                                    <svg class="w-4 h-4 fill-current" :class="star <= Math.round(summary.average_rating) ? 'text-yellow-400' : 'text-gray-300'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.054-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.054z"/></svg>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                
                            </summary>

                            {{-- CONTENT: REVIEWS LIST --}}
                            <div class="accordion-content p-4 divide-y divide-gray-100">
                                <template x-if="summary.total_reviews === 0">
                                    <p class="text-gray-500 text-center py-4">No reviews yet. Be the first to share your experience!</p>
                                </template>
                                
                                <template x-for="review in reviews" :key="review.id">
                                    <div class="py-4">
                                        <div class="flex items-center justify-between mb-2">
                                            {{-- User and Date --}}
                                            <div class="flex items-center space-x-2">
                                                <img :src="review.user.avatar ? '/storage/' + review.user.avatar : 'https://ui-avatars.com/api/?name=' + review.user.name" class="w-8 h-8 rounded-full object-cover">
                                                <span class="font-semibold text-sm" x-text="review.user.name"></span>
                                            </div>
                                            <span class="text-xs text-gray-400" x-text="new Date(review.created_at).toLocaleDateString()"></span>
                                        </div>

                                        {{-- Rating Stars --}}
                                        <div class="flex items-center mb-2">
                                            <div class="flex text-yellow-400 mr-2">
                                                <template x-for="star in 5" :key="star">
                                                    <svg class="w-4 h-4 fill-current" :class="star <= review.rating ? 'text-yellow-400' : 'text-gray-300'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.054-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.054z"/></svg>
                                                </template>
                                            </div>
                                            <span class="text-sm font-medium text-gray-600" x-text="review.rating + '/5'"></span>
                                        </div>

                                        {{-- Comment --}}
                                        <p class="text-gray-700 text-sm" x-text="review.comment || '(No comment provided)'"></p>
                                    </div>
                                </template>
                                
                                <template x-if="summary.total_reviews > reviews.length">
                                    <div class="pt-4 text-center">
                                        <button class="text-sm font-semibold text-black hover:underline">View All <span x-text="summary.total_reviews"></span> Reviews</button>
                                    </div>
                                </template>
                            </div>
                        </details>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    <div class="related-section">
        <div class="container">
            <h3 class="related-title font-oswald">You May Also Like</h3>
            
            <div class="row g-3 g-md-4"> 
                @foreach($relatedProducts as $related)
                    <div class="col-6 col-md-3">
                        <div class="product-card position-relative mb-4">
                            <div class="image-wrapper bg-light position-relative" style="aspect-ratio: 1/1;">
                                @if($related->is_new)
                                    <span class="badge-detail" style="font-size: 0.6rem; padding: 4px 8px; top: 10px; left: 10px;">NEW</span>
                                @endif
                                
                                <img src="{{ asset($related->image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $related->name }}">
                                
                                <a href="{{ route('products.show', $related->id) }}" class="stretched-link"></a>
                            </div>

                            <div class="card-info">
                                <h6 class="font-oswald text-uppercase text-truncate fw-bold">{{ $related->name }}</h6>
                                <p class="text-secondary mb-1 small">{{ $related->brand }}</p>
                                <span class="fw-bold text-dark">{{ number_format($related->price, 0, ',', '.') }} ₫</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

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

    <form id="addToCartForm" action="{{ route('cart.add') }}" method="POST" onsubmit="return addToCart(event);">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="quantity" value="1">
        <input type="hidden" name="size" id="form_size">
    </form>

</div> @endsection

@push('scripts')
<script>
    // Listen for alpine:init event to register component
    document.addEventListener('alpine:init', () => {
        Alpine.data('productReviews', (productId) => ({
            productId: productId,
            summary: { average_rating: 0, total_reviews: 0 },
            reviews: [],
            isLoading: false,

            async fetchReviews() {
                this.isLoading = true;
                try {
                    // Call API (Ensure this URL matches the Route in web.php)
                    const response = await fetch(`/reviews/summary/${this.productId}`);
                    
                    if (!response.ok) throw new Error('Failed to fetch');
                    
                    const data = await response.json();
                    
                    this.summary.average_rating = data.average_rating || 0;
                    this.summary.total_reviews = data.total_reviews || 0;
                    this.reviews = data.reviews || [];

                } catch (error) {
                    console.error("Error fetching reviews:", error);
                } finally {
                    this.isLoading = false;
                }
            }
        }));
    });

    // --- Other JS functions (Keep as is) ---
    function selectSize(element, size) {
        document.querySelectorAll('.size-option').forEach(el => el.classList.remove('selected'));
        element.classList.add('selected');
        document.getElementById('selectedSize').value = size;
        document.getElementById('form_size').value = size;
        document.getElementById('sizeError').classList.add('d-none');
    }

    // Add to Cart Logic
    async function addToCart(event) {
        event.preventDefault(); 
        const size = document.getElementById('selectedSize').value;
        const btn = document.getElementById('addToCartButton');
        const form = document.getElementById('addToCartForm');

        if (!size) {
            document.getElementById('sizeError').classList.remove('d-none');
            const grid = document.getElementById('sizeSelector');
            grid.style.animation = "shake 0.5s";
            setTimeout(() => grid.style.animation = "", 500);
            return false;
        }
        
        // Loading Effect
        const originalText = btn.innerHTML;
        btn.innerHTML = 'ADDING...'; 
        btn.disabled = true;
        btn.style.opacity = "0.8";

        try {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            const result = await response.json();

            if (response.ok && (result.status === 'success' || result.cart_count)) {
                // Success
                btn.innerHTML = 'ADDED TO CART!';
                btn.classList.add('btn-success-flash');
                
                // Update header cart count (if available)
                const cartBadge = document.getElementById('cart-count');
                if (cartBadge && result.cart_count) cartBadge.innerText = result.cart_count;

                // Reset button after 2s
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.classList.remove('btn-success-flash');
                    btn.disabled = false;
                    btn.style.opacity = "1";
                }, 2000);
            } else {
                // Server error (e.g., not logged in)
                if(response.status === 401) {
                     window.location.href = "{{ route('login') }}";
                } else {
                     alert(result.message || 'Error adding to cart');
                     btn.innerHTML = originalText;
                     btn.disabled = false;
                     btn.style.opacity = "1";
                }
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Something went wrong.');
            btn.innerHTML = originalText;
            btn.disabled = false;
            btn.style.opacity = "1";
        }
        return false; 
    }
    
    // Wishlist Logic
    document.addEventListener('DOMContentLoaded', function() {
        const wishlistForm = document.getElementById('wishlistForm');
        if (wishlistForm) {
            wishlistForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const btn = document.getElementById('wishlistBtn');
                const toast = document.getElementById('converse-toast');
                const toastTitle = document.getElementById('toast-title');
                const toastMessage = document.getElementById('toast-message');

                fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                })
                .then(res => {
                    if (res.status === 401) { window.location.href = "{{ route('login') }}"; return; }
                    return res.json();
                })
                .then(data => {
                    if (!data) return;
                    toastTitle.textContent = data.status === 'info' ? 'NOTE' : 'SUCCESS';
                    toastMessage.textContent = data.message;
                    toast.classList.add('show');
                    setTimeout(() => toast.classList.remove('show'), 3000);
                    
                    if (data.status === 'success') {
                        btn.classList.toggle('active');
                        btn.classList.add('heart-animate');
                        setTimeout(() => btn.classList.remove('heart-animate'), 400);
                    }
                });
            });
        }
    });
    
    // Size Guide Modal
    function openSizeGuide() {
        document.getElementById('sizeGuideModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    function closeSizeGuide() {
        document.getElementById('sizeGuideModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }
</script>
@endpush