@extends('layouts.app')

@section('content')
<style>
    /* Hide default spinner buttons */
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    input[type=number] { -moz-appearance: textfield; }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($cartItems->isEmpty())
        <div class="text-center py-12">
            <h2 class="text-2xl font-black text-gray-900 mb-4">Your cart is empty</h2>
            <a href="/products" class="inline-block bg-black text-white px-8 py-3 rounded-full font-bold hover:bg-gray-800 transition">Start Shopping</a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" id="cart-container">
            <div class="lg:col-span-2">
                <h1 class="text-3xl font-black text-gray-900 mb-8 tracking-tight">Shopping Bag</h1>
                
                <div class="space-y-6" id="cart-items-list">
                    @foreach($cartItems as $item)
                        <div id="cart-row-{{ $item->id }}" class="flex gap-6 pb-6 border-b border-gray-200 transition-all duration-300">
                            <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-24 h-24 object-cover rounded">
                            
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 mb-1">{{ strtoupper($item->product->name) }}</h3>
                                <p class="text-sm text-gray-600 mb-3">Size: {{ $item->size }}</p>
                                
                                <div class="flex items-center gap-3 mb-4">
                                    <button onclick="updateQuantity({{ $item->id }}, -1)" class="border border-gray-300 w-8 h-8 flex items-center justify-center hover:bg-gray-100 transition rounded-full">−</button>
                                    
                                    <input type="number" id="quantity-{{ $item->id }}" value="{{ $item->quantity }}" readonly
                                           class="w-12 text-center border-none focus:ring-0 p-0 font-bold text-gray-900 bg-transparent">
                                    
                                    <button onclick="updateQuantity({{ $item->id }}, 1)" class="border border-gray-300 w-8 h-8 flex items-center justify-center hover:bg-gray-100 transition rounded-full">+</button>
                                </div>
                                
                                <p class="font-bold text-gray-900" id="item-total-{{ $item->id }}">
                                    {{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫
                                </p>
                            </div>
                            
                            <button onclick="removeItem({{ $item->id }})" class="text-gray-400 hover:text-red-600 transition h-fit p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded p-6 h-fit sticky top-4">
                <h2 class="text-lg font-black text-gray-900 mb-6 tracking-wide">Order Summary</h2>
                
                <div class="space-y-4 mb-6 pb-6 border-b border-gray-200">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span id="summary-subtotal">{{ number_format($subtotal, 0, ',', '.') }}₫</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Shipping</span>
                        <span id="summary-shipping">
                            @if($shipping == 0) <span class="text-green-600 font-bold">Free</span>
                            @else {{ number_format($shipping, 0, ',', '.') }}₫ @endif
                        </span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Tax (10%)</span>
                        <span id="summary-tax">{{ number_format($tax, 0, ',', '.') }}₫</span>
                    </div>
                </div>
                
                <div class="flex justify-between font-black text-gray-900 text-lg mb-6">
                    <span>Total</span>
                    <span id="summary-total">{{ number_format($total, 0, ',', '.') }}₫</span>
                </div>
                
                <a href="{{ route('cart.checkout') }}" class="block w-full bg-black text-white py-3 rounded-full font-bold text-center hover:bg-gray-800 transition mb-3 shadow-lg">Checkout</a>
                <a href="/products" class="block w-full border-2 border-gray-900 text-gray-900 py-3 rounded-full font-bold text-center hover:bg-gray-50 transition">Continue Shopping</a>
            </div>
        </div>
    @endif
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'VND' })
            .format(amount).replace('₫', '') + '₫';
    };

    function updateQuantity(itemId, change) {
        const input = document.getElementById(`quantity-${itemId}`);
        let newQuantity = parseInt(input.value) + change;
        
        if (newQuantity < 1) 
            removeItem(itemId);

        input.value = newQuantity;

        fetch(`/cart/update/${itemId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ quantity: newQuantity })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                const itemTotalEl = document.getElementById(`item-total-${itemId}`);
                if(itemTotalEl) itemTotalEl.innerText = formatCurrency(data.item_total);
                updateSummary(data.totals);
            }
        })
        .catch(err => console.error(err));
    }

    function removeItem(itemId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to remove this item from your cart?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#000000',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                const row = document.getElementById(`cart-row-${itemId}`);
                if(row) row.style.opacity = '0.5';

                fetch(`/cart/remove/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        if(row) row.remove();
                        updateSummary(data.totals);

                        const headerBadge = document.getElementById('cart-count');
                        if(headerBadge) headerBadge.innerText = data.totals.cart_count;

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                        Toast.fire({
                            icon: 'success',
                            title: 'Item removed successfully'
                        });

                        if(data.totals.cart_count === 0) {
                            window.location.reload();
                        }
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('Error!', 'An error occurred. Please try again.', 'error');
                    if(row) row.style.opacity = '1'; 
                });
            }
        });
    }

    function updateSummary(totals) {
        document.getElementById('summary-subtotal').innerText = formatCurrency(totals.subtotal);
        document.getElementById('summary-tax').innerText = formatCurrency(totals.tax);
        document.getElementById('summary-total').innerText = formatCurrency(totals.total);
        
        const shippingEl = document.getElementById('summary-shipping');
        if (totals.shipping === 0) {
            shippingEl.innerHTML = '<span class="text-green-600 font-bold">Free</span>';
        } else {
            shippingEl.innerText = formatCurrency(totals.shipping);
        }
    }
</script>
@endsection