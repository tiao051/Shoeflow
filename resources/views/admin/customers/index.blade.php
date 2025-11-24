@extends('admin.layouts.app')

@section('title', 'Customers')
@section('header', 'Customer Management')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div x-data="customerManager()">
    
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
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-4">Customer</th>
                    <th class="px-6 py-4">Contact</th>
                    <th class="px-6 py-4 text-center">Total Orders</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                @foreach($customers as $customer)
                <tr id="row-{{ $customer->id }}" class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden mr-3">
                                @if($customer->avatar)
                                    <img src="{{ asset('storage/' . $customer->avatar) }}" class="h-full w-full object-cover">
                                @else
                                    <span class="font-bold text-gray-500">{{ substr($customer->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div>
                                <div class="font-bold text-gray-900">{{ $customer->name }}</div>
                                <div class="text-xs text-gray-500">Joined: {{ $customer->created_at->format('M Y') }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-gray-900">{{ $customer->email }}</div>
                        <div class="text-xs text-gray-500">{{ $customer->phone ?? 'No phone' }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-bold">{{ $customer->orders_count }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium cursor-pointer"
                              :class="isActive({{ $customer->id }}) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                              @click="toggleStatus({{ $customer->id }}, '{{ $customer->name }}')"
                              x-text="isActive({{ $customer->id }}) ? 'Active' : 'Blocked'">
                        </span>
                        <div x-init="initCustomerState({{ $customer->id }}, {{ $customer->is_active }})"></div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button @click="viewCustomer({{ $customer->id }})" class="text-black hover:text-gray-600 font-bold text-xs border border-black px-3 py-1 rounded hover:bg-black hover:text-white transition">
                            View Profile
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-100">{{ $customers->links() }}</div>
    </div>

    <div x-show="isOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" @click="isOpen = false">
                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>

            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl w-full">
                
                <div x-show="isLoading" class="p-12 text-center">
                    <svg class="animate-spin h-8 w-8 text-black mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>

                <div x-show="!isLoading && currentCustomer" class="bg-white">
                    <div class="bg-black px-6 py-4 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-full bg-white flex items-center justify-center overflow-hidden">
                                <img :src="currentCustomer?.avatar ? '/storage/'+currentCustomer.avatar : 'https://ui-avatars.com/api/?name='+currentCustomer?.name" class="h-full w-full object-cover">
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white" x-text="currentCustomer?.name"></h3>
                                <p class="text-xs text-gray-400" x-text="currentCustomer?.email"></p>
                            </div>
                        </div>
                        <button @click="isOpen = false" class="text-gray-400 hover:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="flex border-b border-gray-200">
                        <button @click="activeTab = 'info'" :class="activeTab === 'info' ? 'border-black text-black' : 'border-transparent text-gray-500 hover:text-gray-700'" class="flex-1 py-3 px-4 text-sm font-bold border-b-2 transition">Information</button>
                        <button @click="activeTab = 'orders'" :class="activeTab === 'orders' ? 'border-black text-black' : 'border-transparent text-gray-500 hover:text-gray-700'" class="flex-1 py-3 px-4 text-sm font-bold border-b-2 transition">Orders History</button>
                        <button @click="activeTab = 'addresses'" :class="activeTab === 'addresses' ? 'border-black text-black' : 'border-transparent text-gray-500 hover:text-gray-700'" class="flex-1 py-3 px-4 text-sm font-bold border-b-2 transition">Addresses</button>
                    </div>

                    <div class="p-6 min-h-[300px]">
                        
                        <div x-show="activeTab === 'info'" class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div><p class="text-xs text-gray-500 uppercase font-bold">Full Name</p><p class="text-sm font-semibold" x-text="currentCustomer?.name"></p></div>
                                <div><p class="text-xs text-gray-500 uppercase font-bold">Phone</p><p class="text-sm font-semibold" x-text="currentCustomer?.phone || 'N/A'"></p></div>
                                <div><p class="text-xs text-gray-500 uppercase font-bold">Verified</p><p class="text-sm font-semibold" x-text="currentCustomer?.is_verified ? 'Yes' : 'No'"></p></div>
                                <div><p class="text-xs text-gray-500 uppercase font-bold">Joined Date</p><p class="text-sm font-semibold" x-text="new Date(currentCustomer?.created_at).toLocaleDateString()"></p></div>
                            </div>
                            <div><p class="text-xs text-gray-500 uppercase font-bold">Bio</p><p class="text-sm text-gray-600 italic" x-text="currentCustomer?.bio || 'No bio provided.'"></p></div>
                            
                            <div class="pt-4 mt-4 border-t border-gray-100">
                                <button @click="toggleStatus(currentCustomer.id, currentCustomer.name)" 
                                        class="w-full py-2 rounded font-bold text-white text-sm transition"
                                        :class="customerStates[currentCustomer?.id] ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700'"
                                        x-text="customerStates[currentCustomer?.id] ? 'Block User' : 'Unblock User'">
                                </button>
                            </div>
                        </div>

                        <div x-show="activeTab === 'orders'">
                            <div class="overflow-y-auto max-h-[300px]">
                                <template x-if="currentCustomer?.orders && currentCustomer.orders.length > 0">
                                    <table class="w-full text-left text-sm">
                                        <thead class="bg-gray-50 text-xs uppercase text-gray-500 sticky top-0">
                                            <tr>
                                                <th class="px-4 py-2">ID</th>
                                                <th class="px-4 py-2">Total</th>
                                                <th class="px-4 py-2">Status</th>
                                                <th class="px-4 py-2">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            <template x-for="order in currentCustomer.orders" :key="order.id">
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-4 py-2 font-bold" x-text="'#'+order.id"></td>
                                                    <td class="px-4 py-2" x-text="formatMoney(order.total_amount)"></td>
                                                    <td class="px-4 py-2"><span class="text-xs font-bold uppercase" x-text="order.status"></span></td>
                                                    <td class="px-4 py-2 text-gray-500" x-text="new Date(order.created_at).toLocaleDateString()"></td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </template>
                                <template x-if="!currentCustomer?.orders || currentCustomer.orders.length === 0">
                                    <p class="text-center text-gray-400 py-10">No orders found.</p>
                                </template>
                            </div>
                        </div>

                        <div x-show="activeTab === 'addresses'">
                            <div class="space-y-3 max-h-[300px] overflow-y-auto">
                                <template x-for="addr in currentCustomer?.addresses" :key="addr.id">
                                    <div class="border border-gray-200 rounded p-3 hover:bg-gray-50">
                                        <div class="flex justify-between">
                                            <p class="font-bold text-sm" x-text="addr.full_name"></p>
                                            <template x-if="addr.is_default"><span class="bg-black text-white text-[10px] px-2 rounded">Default</span></template>
                                        </div>
                                        <p class="text-xs text-gray-500" x-text="addr.phone"></p>
                                        <p class="text-sm text-gray-700 mt-1" x-text="addr.address_line + ', ' + (addr.ward ? addr.ward + ', ' : '') + addr.district + ', ' + addr.city"></p>
                                    </div>
                                </template>
                                <template x-if="!currentCustomer?.addresses || currentCustomer.addresses.length === 0">
                                    <p class="text-center text-gray-400 py-10">No addresses saved.</p>
                                </template>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function customerManager() {
        return {
            isOpen: false,
            isLoading: false,
            search: '',
            currentCustomer: null,
            activeTab: 'info',
            customerStates: {}, 

            matchesSearch(str) {
                return this.search === '' || str.includes(this.search.toLowerCase());
            },

            formatMoney(amount) {
                return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
            },

            initCustomerState(id, isActive) {
                this.customerStates[id] = isActive;
            },

            isActive(id) {
                return this.customerStates[id];
            },

            async viewCustomer(id) {
                this.isOpen = true;
                this.isLoading = true;
                this.activeTab = 'info';
                this.currentCustomer = null;

                try {
                    const response = await fetch(`/admin/customers/${id}`);
                    const data = await response.json();
                    if (data.success) {
                        this.currentCustomer = data.customer;
                    }
                } catch (e) {
                    console.error(e);
                } finally {
                    this.isLoading = false;
                }
            },

            async toggleStatus(id, name) {
                const currentStatus = this.customerStates[id];
                const action = currentStatus ? 'Block' : 'Unblock';
                const color = currentStatus ? '#d33' : '#28a745';

                Swal.fire({
                    title: `${action} ${name}?`,
                    text: currentStatus ? "User will not be able to login." : "User access will be restored.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: color,
                    confirmButtonText: `Yes, ${action}!`
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            const response = await fetch(`/admin/customers/${id}`, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                }
                            });
                            const data = await response.json();
                            
                            if (data.success) {
                                // Update UI state immediately without reload
                                this.customerStates[id] = data.is_active;
                                if(this.currentCustomer && this.currentCustomer.id === id) {
                                    this.currentCustomer.is_active = data.is_active;
                                }
                                Swal.fire('Updated!', data.message, 'success');
                            } else {
                                Swal.fire('Error', data.message, 'error');
                            }
                        } catch (e) {
                            Swal.fire('Error', 'Something went wrong', 'error');
                        }
                    }
                });
            }
        }
    }
</script>
@endsection