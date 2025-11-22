@extends('layouts.app')

@section('title', $product->name . ' | CONVERSE')

@push('styles')
<!-- ... (keep CSS styles as-is) ... -->
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
<!-- ... (keep HTML body as-is) ... -->
<div class="container product-container">
    
    <!-- NOTE: Laravel success messages hidden because we use AJAX. -->
    @if(session('success'))
        <div class="alert alert-success mb-4 text-center d-none" id="sessionSuccessMessage">
            {{ session('success') }}
        </div>
    @endif

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
                            <!-- Use main image from DB -->
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
                        <span class="size-guide-link" onclick="openSizeGuide()">Size Guide</span>
                    </div>
                    
                    <!-- Fake sizes for UI demo -->
                    <div class="size-grid" id="sizeSelector">
                        @foreach(['7', '7.5', '8', '8.5', '9', '9.5', '10', '10.5', '11', '12'] as $size)
                            <div class="size-option" onclick="selectSize(this, '{{ $size }}')">{{ $size }}</div>
                        @endforeach
                    </div>
                    <!-- This input is used for the JS interface, not for direct form submission -->
                    <input type="hidden" id="selectedSize" name="size">
                    <div id="sizeError" class="text-danger small d-none mb-2">Please select a size!</div>
                </div>

                <!-- ACTIONS -->
                <div class="action-buttons">
                    <button class="btn-add-cart" id="addToCartButton" type="submit" form="addToCartForm">
                        ADD TO CART
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

    <!-- HIDDEN FORM FOR ADD TO CART -->
    <form id="addToCartForm" action="{{ route('cart.add') }}" method="POST" onsubmit="return addToCart(event);">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="quantity" value="1">
        <input type="hidden" name="size" id="form_size">
    </form>

</div>
@endsection

@push('scripts')
<script>
    // --- SIZE SELECTION LOGIC ---
    function selectSize(element, size) {
        document.querySelectorAll('.size-option').forEach(el => el.classList.remove('selected'));
        element.classList.add('selected');
        
        // Update size into the UI input and the hidden form field
        document.getElementById('selectedSize').value = size;
        document.getElementById('form_size').value = size;
        
        document.getElementById('sizeError').classList.add('d-none');
    }

    // --- CART LOGIC (AJAX UPDATE) ---
    async function addToCart(event) {
        // PREVENT PAGE RELOAD
        event.preventDefault(); 
        
        const size = document.getElementById('selectedSize').value;
        const btn = document.getElementById('addToCartButton');
        const form = document.getElementById('addToCartForm');

        // Validation: must select a size first
        if (!size) {
            document.getElementById('sizeError').classList.remove('d-none');
            const grid = document.getElementById('sizeSelector');
            grid.style.animation = "shake 0.5s";
            setTimeout(() => grid.style.animation = "", 500);
            return;
        }
        
        // 1. Loading state (before sending request)
        btn.innerHTML = 'ADDING...'; 
        btn.disabled = true;
        btn.style.opacity = "0.8";

            try {
            // Collect form data
            const formData = new FormData(form);
            
                // 2. Send AJAX request (Fetch API)
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    // Laravel expects the X-Requested-With header to detect AJAX
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

            const result = await response.json();

            // 3. Handle server response
            if (response.ok && result.status === 'success') {
                // Success flash effect
                flashCartSuccess();
                
                // --- [NEW] Update cart count in header ---
                const cartBadge = document.getElementById('cart-count');
                if (cartBadge) {
                    // Update the count from the server response
                    cartBadge.innerText = result.cart_count;

                    // (Optional) Add a small pop animation to draw attention
                    cartBadge.classList.add('scale-150', 'transition-transform'); 
                    setTimeout(() => {
                        cartBadge.classList.remove('scale-150');
                    }, 200);
                }
                // -------------------------------------------------------

                console.log('Product added successfully. Cart Count:', result.cart_count);

            } else {
                // Handle errors returned from server (e.g. product not found, out of stock, not logged in)
                console.error('Error adding to cart:', result.message || 'Unknown error');
                
                 if(response.status === 401) {
                     alert('You need to log in to perform this action!');
                     window.location.href = '/login'; // Redirect if not logged in
                } else {
                     alert('An error occurred: ' + (result.message || 'Unknown error.'));
                }

                // Restore button
                resetCartButton();
            }
        } catch (error) {
            // Handle network / fetch errors
            console.error('Network Error:', error);
            alert('Network error or server not responding.');
            resetCartButton();
        }

        // Prevent default form submission
        return false; 
    }
    
    // Reset button function (used on error)
    function resetCartButton() {
        const btn = document.getElementById('addToCartButton');
        btn.innerHTML = 'ADD TO CART';
        btn.disabled = false;
        btn.style.opacity = "1";
    }

    /**
     * Handle flash effect for the button after a successful add-to-cart
     */
    function flashCartSuccess() {
        const btn = document.getElementById('addToCartButton');
        
        // 1. Switch to success state
        btn.innerHTML = 'ADDED TO CART!';
        btn.classList.add('btn-success-flash'); // Ensure this class is defined in CSS
        btn.classList.remove('bg-black');
        btn.disabled = true; 
        btn.style.opacity = "1";

        // 2. Set a timer to restore the button after 2 seconds
        setTimeout(() => {
            btn.innerHTML = 'ADD TO CART';
            btn.classList.remove('btn-success-flash');
            btn.classList.add('bg-black');
            btn.disabled = false;
        }, 2000); // Flash for 2 seconds
    }

    // --- SIZE GUIDE MODAL LOGIC (unchanged) ---
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
@endpush