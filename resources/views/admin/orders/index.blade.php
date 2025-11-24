@extends('admin.layouts.app')

@section('title', 'Orders')
@section('header', 'Order Management')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div x-data="orderManager()">
    
    <div class="flex justify-between items-center mb-6">
        <form method="GET" action="" class="relative w-full md:w-72">
            <input type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="Type & Hit Enter..." 
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm">
            
            <button type="submit" class="absolute left-3 top-2.5 text-gray-400 hover:text-black">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"></path></svg>
            </button>
        </form>
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false" 
                    class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg font-bold text-sm hover:bg-gray-50 transition shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div x-show="open" x-cloak 
                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20 border border-gray-100 py-1">
                <a href="{{ route('admin.orders.export', ['type' => 'day']) }}" 
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-black">
                Export Today
                </a>
                <a href="{{ route('admin.orders.export', ['type' => 'week']) }}" 
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-black">
                Export This Week
                </a>
                <a href="{{ route('admin.orders.export', ['type' => 'month']) }}" 
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-black">
                Export This Month
                </a>
                <a href="{{ route('admin.orders.export', ['type' => 'quarter']) }}" 
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-black">
                Export This Quarter
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4">Order ID</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Payment</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    @foreach($orders as $order)
                    <tr class="hover:bg-gray-50 transition" id="row-{{ $order->id }}">
                        <td class="px-6 py-4 font-bold text-gray-900">#{{ $order->id }}</td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $order->fullname }}</div>
                            <div class="text-xs text-gray-500">{{ $order->phone }}</div>
                        </td>
                        <td class="px-6 py-4 font-bold">{{ number_format($order->total_amount, 0, ',', '.') }}₫</td>
                        <td class="px-6 py-4 uppercase text-xs">{{ $order->payment_method }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'processing' => 'bg-blue-100 text-blue-800',
                                    'shipped' => 'bg-purple-100 text-purple-800',
                                    'delivered' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                                $color = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase {{ $color }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <button @click="viewOrder({{ $order->id }})" class="text-black hover:text-gray-600 font-bold text-xs border border-black px-3 py-1 rounded hover:bg-black hover:text-white transition">
                                View
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $orders->links() }}
        </div>
    </div>

    <div x-show="isOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" @click="isOpen = false">
                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>

            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full">
                
                <div x-show="isLoading" class="p-10 text-center">
                    <svg class="animate-spin h-10 w-10 text-black mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <p class="mt-3 text-gray-500 font-bold">Loading order details...</p>
                </div>

                <div x-show="!isLoading && currentOrder" class="bg-gray-50">
                    <div class="bg-white px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-black text-gray-900">Order #<span x-text="currentOrder?.id"></span></h3>
                            <p class="text-sm text-gray-500" x-text="new Date(currentOrder?.created_at).toLocaleString()"></p>
                        </div>
                        <button @click="isOpen = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3">
                        
                        <div class="p-6 md:col-span-1 space-y-6 border-r border-gray-200 bg-white">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Update Status</label>
                                <select x-model="currentOrder.status" @change="updateStatus()" class="w-full border-gray-300 rounded-lg text-sm font-bold focus:ring-black focus:border-black">
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="shipped">Shipped</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>

                            <div>
                                <h4 class="font-bold text-gray-900 mb-2">Customer Info</h4>
                                <p class="text-sm text-gray-600 flex items-center mb-1">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    <span x-text="currentOrder?.fullname"></span>
                                </p>
                                <p class="text-sm text-gray-600 flex items-center mb-1">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <span x-text="currentOrder?.phone"></span>
                                </p>
                                <p class="text-sm text-gray-600 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <span x-text="currentOrder?.email"></span>
                                </p>
                            </div>

                            <div>
                                <h4 class="font-bold text-gray-900 mb-2">Shipping Address</h4>
                                <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded border border-gray-100" x-text="currentOrder?.address"></p>
                            </div>

                            <div x-show="currentOrder?.note">
                                <h4 class="font-bold text-gray-900 mb-2">Note</h4>
                                <p class="text-sm text-gray-500 italic" x-text="currentOrder?.note"></p>
                            </div>
                        </div>

                        <div class="md:col-span-2 p-6 bg-gray-50">
                            <h4 class="font-bold text-gray-900 mb-4">Order Items</h4>
                            <div class="space-y-3 max-h-[400px] overflow-y-auto pr-2">
                                <template x-for="item in currentOrder?.items" :key="item.id">
                                    <div class="flex items-center bg-white p-3 rounded-lg border border-gray-200">
                                        <div class="h-16 w-16 rounded bg-gray-100 border border-gray-200 flex-shrink-0 overflow-hidden">
                                            <img :src="item.product?.image ? (item.product.image.startsWith('http') ? item.product.image : '/'+item.product.image) : ''" class="h-full w-full object-cover">
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <p class="text-sm font-bold text-gray-900" x-text="item.product_name"></p>
                                            <p class="text-xs text-gray-500">Size: <span class="font-bold" x-text="item.size"></span></p>
                                            <p class="text-xs text-gray-500">Qty: <span class="font-bold" x-text="item.quantity"></span></p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-bold text-gray-900" x-text="formatMoney(item.total)"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div class="mt-6 border-t border-gray-200 pt-4 space-y-2">
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Subtotal</span>
                                    <span x-text="formatMoney(currentOrder?.subtotal)"></span>
                                </div>
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Shipping Fee</span>
                                    <span x-text="formatMoney(currentOrder?.shipping_fee)"></span>
                                </div>
                                <div class="flex justify-between text-sm text-green-600" x-show="currentOrder?.discount_amount > 0">
                                    <span>Discount (<span x-text="currentOrder?.coupon_code"></span>)</span>
                                    <span x-text="'-' + formatMoney(currentOrder?.discount_amount)"></span>
                                </div>
                                <div class="flex justify-between text-lg font-black text-gray-900 pt-2 border-t border-gray-200 mt-2">
                                    <span>Total Amount</span>
                                    <span x-text="formatMoney(currentOrder?.total_amount)"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function orderManager() {
        return {
            isOpen: false,
            isLoading: false,
            currentOrder: null,

            formatMoney(amount) {
                return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount || 0);
            },

            async viewOrder(id) {
                this.isOpen = true;
                this.isLoading = true;
                this.currentOrder = null;

                try {
                    const response = await fetch(`/admin/orders/${id}`);
                    const data = await response.json();
                    
                    if (data.success) {
                        this.currentOrder = data.order;
                    }
                } catch (error) {
                    console.error(error);
                    Swal.fire('Error', 'Could not load order details', 'error');
                    this.isOpen = false;
                } finally {
                    this.isLoading = false;
                }
            },

            async updateStatus() {
                if (!this.currentOrder) return;

                const newStatus = this.currentOrder.status;
                const id = this.currentOrder.id;

                try {
                    const response = await fetch(`/admin/orders/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ status: newStatus })
                    });

                    const data = await response.json();

                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: 'Order status changed successfully.',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                } catch (error) {
                    Swal.fire('Error', 'Failed to update status', 'error');
                }
            }
        }
    }
</script>
@endsection