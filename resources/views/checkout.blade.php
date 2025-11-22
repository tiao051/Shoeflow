@extends('layouts.app')

@section('content')
<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #888; border-radius: 3px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #555; }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        
        <div>
            <h2 class="text-2xl font-black text-gray-900 mb-6 tracking-tight">Shipping Address</h2>
            
            <form action="#" method="POST" id="checkout-form">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="fullname" value="{{ auth()->user()->name ?? '' }}" 
                               class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:border-black transition" 
                               placeholder="Enter your full name" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Phone Number <span class="text-red-500">*</span></label>
                            <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}" 
                                   class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:border-black transition" 
                                   placeholder="090xxxxxxx" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ auth()->user()->email ?? '' }}" 
                                   class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:border-black transition" 
                                   placeholder="email@example.com" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Address <span class="text-red-500">*</span></label>
                        <input type="text" name="address" 
                               class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:border-black transition" 
                               placeholder="Street address, apartment, etc." required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">City / Province <span class="text-red-500">*</span></label>
                            <select name="city" class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:border-black bg-white transition" required>
                                <option value="">Select City</option>
                                <option value="Hanoi">Hanoi</option>
                                <option value="HCM">Ho Chi Minh City</option>
                                <option value="Danang">Da Nang</option>
                                <option value="CanTho">Can Tho</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Payment Method</label>
                            <select name="payment_method" class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:border-black bg-white transition">
                                <option value="cod">COD (Cash on Delivery)</option>
                                <option value="banking">Bank Transfer (QR Code)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Order Notes (Optional)</label>
                        <textarea name="note" rows="3" 
                                  class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:border-black transition" 
                                  placeholder="Ex: Call before delivery..."></textarea>
                    </div>

                    <input type="hidden" name="applied_coupon" id="applied_coupon_input">
                </div>
            </form>
        </div>

        <div class="bg-gray-50 p-8 rounded border border-gray-200 h-fit sticky top-4">
            <h2 class="text-xl font-black text-gray-900 mb-6 tracking-tight">Your Order</h2>

            <div class="space-y-4 mb-6 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
                @foreach($cartItems as $item)
                    <div class="flex gap-4 items-center bg-white p-2 rounded border border-gray-100">
                        <div class="relative flex-shrink-0">
                            <img src="{{ asset($item->product->image ?? 'images/placeholder.jpg') }}" 
                                 onerror="this.src='https://placehold.co/100x100?text=No+Image'"
                                 alt="{{ $item->product->name }}" 
                                 class="w-14 h-14 object-cover rounded border border-gray-200">
                            <span class="absolute -top-2 -right-2 bg-black text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full border border-white">
                                {{ $item->quantity }}
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-sm text-gray-900 truncate">{{ strtoupper($item->product->name) }}</h4>
                            <p class="text-xs text-gray-500">Size: {{ $item->size }}</p>
                        </div>
                        <p class="font-bold text-sm text-gray-900">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫</p>
                    </div>
                @endforeach
            </div>

            <hr class="border-gray-200 my-4">

            <div class="mb-6">
                <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Promo Code</label>
                <div class="flex gap-2 relative">
                    <input type="text" id="coupon_code" 
                           class="flex-1 border border-gray-300 p-3 rounded-l focus:outline-none focus:border-black bg-white text-sm uppercase font-bold tracking-wide placeholder-gray-400" 
                           placeholder="Enter Code">
                    <button type="button" onclick="applyCoupon()" id="btn-apply-coupon"
                            class="bg-gray-200 text-gray-900 px-5 py-2 rounded-r font-bold hover:bg-gray-300 transition text-sm border border-l-0 border-gray-300">
                        Apply
                    </button>
                </div>
                
                <div class="flex justify-between items-center mt-2 min-h-[20px]">
                    <p id="coupon-message" class="text-xs font-bold hidden"></p>
                    
                    <button type="button" onclick="openVoucherModal()" class="text-sm text-blue-600 hover:text-blue-800 hover:underline flex items-center ml-auto font-semibold transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                        Select Voucher
                    </button>
                </div>
            </div>

            <hr class="border-gray-200 my-4">

            <div class="space-y-3 text-sm">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal</span>
                    <span>{{ number_format($subtotal, 0, ',', '.') }}₫</span>
                </div>
                
                <div class="flex justify-between text-gray-600">
                    <span>Shipping</span>
                    <span>
                        @if($shipping == 0)
                            <span class="text-green-600 font-bold">Free</span>
                        @else
                            {{ number_format($shipping, 0, ',', '.') }}₫
                        @endif
                    </span>
                </div>

                <div class="flex justify-between text-gray-600">
                    <span>Tax (10%)</span>
                    <span>{{ number_format($tax, 0, ',', '.') }}₫</span>
                </div>

                <div class="flex justify-between text-red-600 font-bold hidden" id="discount-row">
                    <span>Discount</span>
                    <span id="discount-amount">-0₫</span>
                </div>
            </div>

            <hr class="border-gray-200 my-4">

            <div class="flex justify-between font-black text-xl text-gray-900 mb-6">
                <span>Total</span>
                <span id="final-total" data-original-total="{{ $total }}">{{ number_format($total, 0, ',', '.') }}₫</span>
            </div>

            <button type="submit" form="checkout-form" class="block w-full bg-black text-white py-4 rounded font-bold text-center hover:bg-gray-800 transition shadow-lg transform hover:-translate-y-0.5">
                Place Order
            </button>
            
            <a href="{{ route('cart.index') }}" class="block text-center text-lg text-gray-500 mt-4 hover:text-black no-underline">
                Return to Cart
            </a>
        </div>
    </div>
</div>

<div id="voucher-modal" class="fixed inset-0 z-[9999999] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900 bg-opacity-60 transition-opacity backdrop-blur-sm" onclick="closeVoucherModal()"></div>

    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full relative">
            
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-black text-gray-900" id="modal-title">SELECT VOUCHER</h3>
                <button onclick="closeVoucherModal()" class="text-gray-400 hover:text-black transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="bg-white p-4 max-h-[400px] overflow-y-auto custom-scrollbar space-y-3">
                
                @forelse($vouchers as $v)
                <div class="border border-gray-200 rounded-lg p-3 flex justify-between items-center hover:border-black hover:bg-gray-50 transition group cursor-pointer" onclick="selectVoucher('{{ $v->code }}')">
                    <div class="flex gap-3 items-center">
                        <div class="bg-black text-white w-12 h-12 flex flex-col items-center justify-center rounded font-bold shadow-sm">
                            @if($v->discount_type == 'percent')
                                <span class="text-sm">{{ (int)$v->discount_value }}%</span>
                            @else
                                <span class="text-[10px]">₫</span>
                            @endif
                            <span class="text-[9px] opacity-80">OFF</span>
                        </div>
                        <div>
                            <p class="font-black text-gray-900 text-base group-hover:text-red-600 transition">{{ $v->code }}</p>
                            <p class="text-xs text-gray-500">{{ $v->description }}</p>
                            @if($v->min_order_value > 0)
                                <p class="text-[10px] text-gray-400">Min order: {{ number_format($v->min_order_value, 0, ',', '.') }}₫</p>
                            @endif
                        </div>
                    </div>
                    <button type="button" class="bg-white border border-black text-black text-xs font-bold px-4 py-2 rounded hover:bg-black hover:text-white transition">
                        USE
                    </button>
                </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <p>There are no vouchers available at the moment.</p>
                    </div>
                @endforelse

            </div>

            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeVoucherModal()" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-100 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function openVoucherModal() {
        document.getElementById('voucher-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeVoucherModal() {
        document.getElementById('voucher-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function selectVoucher(code) {
        document.getElementById('coupon_code').value = code;
        closeVoucherModal();
        applyCoupon();
    }

    function applyCoupon() {
        const codeInput = document.getElementById('coupon_code');
        const code = codeInput.value.trim().toUpperCase();
        const messageEl = document.getElementById('coupon-message');
        const btn = document.getElementById('btn-apply-coupon');
        const discountRow = document.getElementById('discount-row');
        const discountAmountEl = document.getElementById('discount-amount');
        const finalTotalEl = document.getElementById('final-total');
        const appliedInput = document.getElementById('applied_coupon_input');

        if (!code) return;

        // Loading UI
        btn.innerText = '...';
        btn.disabled = true;
        messageEl.classList.add('hidden');

        // Call real API from Controller
        fetch('{{ route("cart.check-coupon") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ code: code })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // --- SUCCESS ---
                messageEl.innerText = data.message;
                messageEl.className = 'text-xs font-bold text-green-600 block';

                // Show Discount row
                discountRow.classList.remove('hidden');
                discountRow.classList.add('flex');
                discountAmountEl.innerText = '-' + formatMoney(data.discount);

                // Fill hidden input
                appliedInput.value = data.code;

                // Update Total (Client-side)
                const originalTotal = parseFloat(finalTotalEl.getAttribute('data-original-total'));
                const newTotal = originalTotal - data.discount;
                finalTotalEl.innerText = formatMoney(newTotal > 0 ? newTotal : 0);

            } else {
                // --- FAILURE ---
                messageEl.innerText = data.message;
                messageEl.className = 'text-xs font-bold text-red-600 block';

                // Hide discount row and reset total
                discountRow.classList.add('hidden');
                appliedInput.value = '';
                
                // Reset về giá gốc
                const originalTotal = parseFloat(finalTotalEl.getAttribute('data-original-total'));
                finalTotalEl.innerText = formatMoney(originalTotal);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            messageEl.innerText = 'An error occurred, please try again.';
            messageEl.className = 'text-xs font-bold text-red-600 block';
        })
        .finally(() => {
            btn.innerText = 'Apply';
            btn.disabled = false;
        });
    }

    function formatMoney(amount) {
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount).replace('₫', '') + '₫';
    }
</script>
@endsection