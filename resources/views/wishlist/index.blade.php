@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
{{-- Import fonts for Converse styling --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">

<style>
    [x-cloak] { display: none !important; }
    .font-oswald { font-family: 'Oswald', sans-serif; }
    .font-inter { font-family: 'Inter', sans-serif; }
</style>

{{-- IMPORTANT: Place this script early so Alpine.js can find the function --}}
<script>
    window.wishlistManager = function() {
        return {
            // Initial item count (from PHP)
            itemCount: {{ $wishlistItems->count() }},

            // Toast notifications
            toast: {
                visible: false,
                message: ''
            },

            // Init: check for PHP session flash messages
            init() {
                @if(session('success'))
                    this.showToast("{{ session('success') }}");
                @endif
            },

            // Computed property to toggle between Grid and Empty State
            get hasItems() {
                return this.itemCount > 0;
            },

            // Remove item via AJAX
            async removeItem(id) {
                try {
                    const response = await fetch(`/wishlist/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    const result = await response.json();

                    if (response.ok) {
                        // 1. Remove the product DOM element
                        const el = document.getElementById(`wishlist-item-${id}`);
                        if (el) {
                            // Fade/scale effect before removal
                            el.style.opacity = '0';
                            el.style.transform = 'scale(0.9)';

                            setTimeout(() => {
                                el.remove();
                                // 2. Decrement count so Empty State appears if needed
                                this.itemCount--; 
                            }, 300); // Wait 300ms for CSS transition to complete
                        }

                        // 3. Show toast notification
                        this.showToast(result.message || 'Item removed successfully');
                    } else {
                        alert('Error removing item.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            },

            // Show toast notification
            showToast(message) {
                this.toast.message = message;
                this.toast.visible = true;
                setTimeout(() => {
                    this.toast.visible = false;
                }, 3000);
            }
        }
    }
</script>

{{-- Main UI --}}
<div class="bg-white min-h-screen font-inter" x-data="wishlistManager()">
    
    {{-- HEADER SECTION --}}
    <div class="bg-gray-50 py-12 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-6xl font-extrabold uppercase tracking-wider font-oswald text-black mb-2">
                My Wishlist
            </h1>
            <p class="text-gray-500 text-sm md:text-base uppercase tracking-widest">
                Save your favorites. Shop them later.
            </p>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative">

        {{-- 1. TOAST NOTIFICATION (Z-Index 9999 + AJAX Support) --}}
        <div x-cloak 
             x-show="toast.visible" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-full"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-full"
             class="fixed top-24 right-5 z-[9999] bg-black text-white px-6 py-4 rounded shadow-2xl flex items-center gap-3 border-l-4 border-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <div>
                <h4 class="font-bold uppercase text-sm tracking-wider">Success</h4>
                <p class="text-xs text-gray-300" x-text="toast.message"></p>
            </div>
        </div>

        {{-- 2. WISHLIST GRID --}}
        <div id="wishlist-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-10" x-show="hasItems">
            
            @foreach($wishlistItems as $item)
                @php $product = $item->product; @endphp
                
                {{-- PRODUCT CARD (add ID so JS can find and remove it) --}}
                <div id="wishlist-item-{{ $item->id }}" class="wishlist-item group relative flex flex-col transition-all duration-500">
                    
                    {{-- IMAGE --}}
                    <div class="relative aspect-[3/4] w-full overflow-hidden rounded-lg bg-gray-100">
                        <a href="{{ route('products.show', $product->id) }}">
                            <img src="{{ asset($product->image) }}"
                                 alt="{{ $product->name }}" 
                                 class="h-full w-full object-cover object-center transition duration-500 group-hover:scale-105 group-hover:opacity-90"
                                 onerror="this.onerror=null;this.src='https://placehold.co/400x530/E5E7EB/4B5563?text=No+Image';">
                        </a>

                        {{-- REMOVE BUTTON (AJAX) --}}
                        <button type="button" 
                                @click="removeItem({{ $item->id }})"
                                class="absolute top-2 right-2 z-10 bg-white/80 backdrop-blur-sm p-2 rounded-full text-gray-500 hover:text-red-600 hover:bg-white transition shadow-sm transform hover:scale-110"
                                title="Remove from Wishlist">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        @if($product->stock <= 0)
                            <div class="absolute inset-0 bg-white/60 flex items-center justify-center">
                                <span class="bg-black text-white text-xs font-bold px-3 py-1 uppercase tracking-wide">Sold Out</span>
                            </div>
                        @endif
                    </div>

                    {{-- INFO --}}
                    <div class="mt-4 flex flex-col flex-grow">
                        <a href="{{ route('products.show', $product->id) }}">
                            <h3 class="text-sm md:text-base font-bold text-gray-900 uppercase font-oswald tracking-wide truncate">
                                {{ $product->name }}
                            </h3>
                        </a>
                        <p class="mt-1 text-xs md:text-sm text-gray-500">{{ $product->category->name ?? 'Sneakers' }}</p>
                        <div class="mt-2 flex items-center justify-between">
                            <p class="text-sm md:text-base font-bold text-gray-900">
                                {{ number_format($product->price, 0, ',', '.') }}₫
                            </p>
                        </div>
                    </div>

                    {{-- ADD TO CART --}}
                    <div class="mt-4">
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" 
                                        class="w-full flex items-center justify-center bg-black border border-black text-white px-4 py-3 text-xs md:text-sm font-bold uppercase tracking-wider hover:bg-white hover:text-black transition duration-300">
                                    Add to Cart
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full bg-gray-200 text-gray-400 px-4 py-3 text-xs md:text-sm font-bold uppercase tracking-wider cursor-not-allowed">
                                Out of Stock
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- 3. EMPTY STATE (Shown when there are no items or all removed via AJAX) --}}
        <div x-show="!hasItems" x-cloak 
             class="col-span-full flex flex-col items-center justify-center py-16 text-center transition-opacity duration-500">
            <div class="bg-gray-50 p-6 rounded-full mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-.318-.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 font-oswald uppercase mb-2">Your Wishlist is Empty</h2>
            <p class="text-gray-500 mb-8 max-w-md mx-auto">
                Don't let your favorite styles get away. Start browsing and save items you love here.
            </p>
            <a href="{{ route('products.index') }}" 
               class="inline-block bg-black text-white px-8 py-4 font-bold uppercase text-sm tracking-wider hover:bg-gray-800 transition shadow-lg">
                Start Shopping
            </a>
        </div>

    </div>
</div>
@endsection