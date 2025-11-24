<div 
    x-show="showModal" 
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto" 
    aria-labelledby="modal-title" role="dialog" aria-modal="true"
>
    {{-- Background Overlay --}}
    <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    
    {{-- Modal Panel --}}
    <div 
        x-show="showModal" 
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="flex items-center justify-center p-4 min-h-full"
    >
        <div class="relative bg-white rounded-lg shadow-xl max-w-4xl w-full mx-auto my-8 overflow-hidden">
            
            {{-- Close Button --}}
            <button @click="showModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 z-10">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <div x-cloak>
                {{-- LOADING STATE --}}
                <template x-if="loadingDetails">
                    <div class="p-8 text-center text-gray-500">
                        <svg class="animate-spin h-8 w-8 text-black mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <p class="mt-2">Loading order details...</p>
                    </div>
                </template>

                {{-- CONTENT STATE --}}
                <template x-if="selectedOrder">
                    <div class="grid grid-cols-1 lg:grid-cols-3 divide-x divide-gray-100">
                        
                        {{-- Cột 1 & 2: Order Summary and Items --}}
                        <div class="lg:col-span-2 p-8">
                            <h3 class="text-2xl font-black text-gray-900 mb-6">Order #<span x-text="selectedOrder.id"></span> Details</h3>

                            {{-- Order Summary --}}
                            <div class="grid grid-cols-2 gap-4 text-sm mb-6 pb-4 border-b border-gray-100">
                                <div>
                                    <p class="font-semibold text-gray-700">Date Placed:</p>
                                    <p x-text="new Date(selectedOrder.created_at).toLocaleDateString()"></p>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-700">Status:</p>
                                    <span x-bind:class="{ 
                                        'bg-yellow-50 text-yellow-700 ring-yellow-600/20': selectedOrder.status === 'pending',
                                        'bg-emerald-50 text-emerald-700 ring-emerald-600/20': selectedOrder.status === 'delivered',
                                        'bg-gray-50 text-gray-600 ring-gray-500/10': selectedOrder.status !== 'pending' && selectedOrder.status !== 'delivered'
                                    }" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ring-1 ring-inset uppercase tracking-wide" x-text="selectedOrder.status"></span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-700">Payment Method:</p>
                                    <p x-text="selectedOrder.payment_method"></p>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-700">Coupon Used:</p>
                                    <p x-text="selectedOrder.coupon_code ?? 'None'"></p>
                                </div>
                            </div>
                            
                            {{-- Item List --}}
                            <h4 class="text-lg font-bold text-gray-800 mb-4">Products (<span x-text="selectedOrder.items.length"></span>)</h4>
                            <div class="space-y-4 max-h-80 overflow-y-auto pr-2">
                                <template x-for="item in selectedOrder.items" :key="item.id">
                                    <div class="flex items-center gap-4 p-3 border border-gray-100 rounded-lg">
                                        <div class="w-16 h-16 rounded-md overflow-hidden flex-shrink-0 bg-gray-100">
                                            <img x-show="item.product && item.product.image" :src="'{{ asset('') }}' + item.product.image" :alt="item.product_name" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-gray-900" x-text="item.product_name"></p>
                                            <p class="text-xs text-gray-500">Size/Option: <span x-text="item.size ?? 'N/A'"></span></p>
                                        </div>
                                        <div class="text-right flex-shrink-0">
                                            <p class="text-sm font-semibold" x-text="'x' + item.quantity"></p>
                                            <p class="text-xs text-gray-700" x-text="new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(item.total)"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>

                        </div>

                        {{-- Cột 3: Customer and Total --}}
                        <div class="p-8 lg:col-span-1 bg-gray-50">
                            <h4 class="text-lg font-bold text-gray-800 mb-4">Shipping Information</h4>
                            <div class="space-y-3 text-sm pb-6 border-b border-gray-100">
                                <div>
                                    <p class="font-semibold text-gray-700">Recipient:</p>
                                    <p x-text="selectedOrder.fullname"></p>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-700">Phone:</p>
                                    <p x-text="selectedOrder.phone"></p>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-700">Shipping Address:</p>
                                    <p x-text="selectedOrder.address"></p>
                                </div>
                                <div x-show="selectedOrder.note">
                                    <p class="font-semibold text-gray-700">Note:</p>
                                    <p x-text="selectedOrder.note"></p>
                                </div>
                            </div>
                            
                            {{-- Totals Summary --}}
                            <h4 class="text-lg font-bold text-gray-800 mt-6 mb-4">Billing Summary</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span>Subtotal (<span x-text="selectedOrder.items.length"></span> items)</span>
                                    <span x-text="new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(selectedOrder.subtotal)"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Discount (<span x-text="selectedOrder.coupon_code ?? '0'"></span>)</span>
                                    <span class="text-red-600" x-text="'— ' + new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(selectedOrder.discount_amount)"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Shipping Fee</span>
                                    <span x-text="new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(selectedOrder.shipping_fee)"></span>
                                </div>
                                <div class="flex justify-between font-bold pt-4 border-t border-gray-200 text-lg">
                                    <span>TOTAL</span>
                                    <span class="text-black" x-text="new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(selectedOrder.total_amount)"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>