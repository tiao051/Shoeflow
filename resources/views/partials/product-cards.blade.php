{{-- REMOVE: do not include `@extends('layouts.app')` or `@section('title')` in a partial --}}

{{-- Add inline <style> here to ensure Wishlist/Toast styles are always available.
    Ideally move these styles into `products/index.blade.php` when not updating via AJAX.
    Keeping them here ensures the wishlist logic works immediately after partial loads. --}}
<style>
    /* Heartbeat animation */
    @keyframes converse-pop {
        0% { transform: scale(1); }
        50% { transform: scale(1.4); }
        100% { transform: scale(1); }
    }
    
    .heart-animate {
        animation: converse-pop 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }

    /* Converse Toast Style (corner notification) */
    #converse-toast {
        visibility: hidden;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999; /* Ensure it appears above other content */
        background-color: #000;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 24px;
        border-left: 4px solid #dc3545; /* Converse red color */
        box-shadow: 0 10px 15px rgba(0,0,0,0.2);
    }
    
    #converse-toast.show {
        visibility: visible;
        opacity: 1;
        transform: translateY(0);
    }

    /* Text inside the toast */
    #toast-title {
        display: block;
        font-family: 'Oswald', sans-serif;
        font-weight: 700;
        text-transform: uppercase;
        line-height: 1;
        margin-bottom: 4px;
    }
    #toast-message {
        display: block;
        font-size: 0.75rem;
        color: #d1d5db;
        text-transform: uppercase;
    }
</style>

{{-- REMOVE: <div class="container py-5"> --}}
<div class="row">
    @foreach($products as $product)
        <div class="col-6 col-md-4 col-lg-3 mb-4">
            <div class="product-card position-relative h-100">
                
                {{-- 2. IMAGE (click to view details) --}}
                <div class="image-wrapper position-relative">
                    {{-- Keep existing NEW badge display logic --}}
                    @if($loop->index < 3 && $products->currentPage() == 1) 
                        <span class="badge-custom">NEW</span>
                    @endif
                    
                    <a href="{{ route('products.show', $product->id) }}" class="d-block">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid transition duration-300 hover:opacity-90">
                    </a>
                </div>
                
                <div class="card-info mt-2">
                    {{-- 3. PRODUCT NAME (click to view details) --}}
                    <div class="product-title font-weight-bold">
                        <a href="{{ route('products.show', $product->id) }}" class="text-black text-decoration-none hover:text-gray-600 transition">
                            {{ $product->name }}
                        </a>
                    </div>

                    <div class="product-category text-muted small">
                        {{ $product->category?->name ?? 'Classic / Lifestyle' }}
                    </div>

                    {{-- 4. PRICE & WISHLIST (side-by-side; wishlist uses AJAX) --}}
                    <div class="d-flex justify-content-between align-items-center mt-1">
                        
                        <div class="product-price font-weight-bold">
                            {{ number_format($product->price, 0, ',', '.') }} ₫
                        </div>

                        {{-- Wishlist form --}}
                        <form action="{{ route('wishlist.store') }}" method="POST" class="js-wishlist-form"> 
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                            <button type="submit" class="group/btn transition duration-150 ease-in-out d-flex align-items-center p-1 border-0 bg-transparent" title="Add to Wishlist">
                                <svg id="heart-icon-{{ $product->id }}" xmlns="http://www.w3.org/2000/svg" 
                                    class="w-6 h-6 text-black group-hover/btn:text-red-600 transition-colors duration-200" 
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-.318-.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- Giữ Toast và Script ở đây để chúng được tải khi AJAX cập nhật danh sách --}}
<div id="converse-toast">
    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
    </svg>
    <div>
        <span id="toast-title">WISHLIST UPDATED</span>
        <span id="toast-message">Item added to your collection.</span>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all wishlist forms rendered in the loop
    const wishlistForms = document.querySelectorAll('.js-wishlist-form');
    const toast = document.getElementById('converse-toast');
    const toastTitle = document.getElementById('toast-title');
    const toastMessage = document.getElementById('toast-message');

    // Note: need to unbind and rebind event listeners for forms when this partial is reloaded via AJAX
    // The `products/index.blade.php` view takes care of this after an AJAX load, but we keep
    // this logic here to ensure newly added forms function correctly.

    wishlistForms.forEach(form => {
        // Remove any previous listener to avoid duplicate handlers (for AJAX reloads)
        form.removeEventListener('submit', handleWishlistSubmit);
        form.addEventListener('submit', handleWishlistSubmit);
    });

    function handleWishlistSubmit(e) {
        e.preventDefault(); // Prevent page reload
        const form = this;

        // Get product ID from hidden input
        const productId = form.querySelector('input[name="product_id"]').value;
        // Find the corresponding heart icon
        const heartIcon = document.getElementById(`heart-icon-${productId}`);

        // Send background request (AJAX)
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest', // Notify Laravel this is an AJAX request
                'Accept': 'application/json'
            }
        })
        .then(response => {
            // If not authenticated (401) -> redirect to login
            if (response.status === 401) {
                window.location.href = "{{ route('login') }}";
                return;
            }
            return response.json();
        })
        .then(data => {
            if (!data) return;

            // 1. Update toast content
            toastTitle.textContent = data.status === 'info' ? 'NOTE' : 'SUCCESS';
            toastMessage.textContent = data.message;

            // 2. Show toast
            toast.classList.add('show');
            // Auto-hide after 3 seconds
            setTimeout(() => { toast.classList.remove('show'); }, 3000);

            // 3. Icon effect (only when add is successful)
            if (data.status === 'success') {
                // Change heart color to red and enable fill
                heartIcon.classList.remove('text-black');
                heartIcon.classList.add('text-red-600', 'fill-current'); 

                // Add animation class and remove it after it finishes so it can run again
                heartIcon.parentNode.classList.add('heart-animate');
                setTimeout(() => {
                    heartIcon.parentNode.classList.remove('heart-animate');
                }, 400);
            }
        })
        .catch(error => console.error('Error:', error));
    }
});
</script>
    {{-- REMOVE: @endsection (partials should not include section directives) --}}