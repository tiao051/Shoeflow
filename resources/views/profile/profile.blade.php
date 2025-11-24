@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<style>
    [x-cloak] { display: none !important; }
</style>

<div class="bg-gray-50 py-12 min-h-screen"
     x-data="{ 
        currentTab: new URLSearchParams(window.location.search).get('tab') || 'profile',
        showModal: false, 
        selectedOrder: null, 
        loadingDetails: false,
        
        fetchOrderDetails(orderId, route) {
            this.loadingDetails = true;
            this.showModal = true;
            this.selectedOrder = null;

            fetch(route)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                this.selectedOrder = data.order;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Không thể tải chi tiết đơn hàng.');
                this.showModal = false;
            }).finally(() => {
                this.loadingDetails = false;
            });
        },

        // Helper format tiền tệ trong JS
        formatMoney(amount) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
        }
     }">

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-black text-gray-900 mb-8 tracking-tight uppercase">My Account</h1>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            
            {{-- LEFT COLUMN: MENU & AVATAR --}}
            <div class="md:col-span-1 bg-white rounded-lg shadow-lg p-6 h-fit sticky top-24">
                <div class="text-center mb-6">                  
                    {{-- Avatar Upload --}}
                    <div x-data="{ isHovering: false }" class="relative inline-block mx-auto" @mouseenter="isHovering = true" @mouseleave="isHovering = false">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) . '?v=' . time() : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}" 
                             alt="{{ $user->name }}" 
                             class="w-24 h-24 rounded-full mx-auto object-cover border-4 border-gray-100 shadow-md">

                        <div x-show="isHovering"
                             @click="$refs.avatarInput.click()"
                             class="absolute inset-0 w-24 h-24 rounded-full bg-black bg-opacity-50 flex items-center justify-center cursor-pointer transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white w-6 h-6">
                                <path d="M17 3a2.85 2.85 0 0 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </div>
                    </div>
       
                    <form id="avatarUploadForm" action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" class="hidden" x-ref="avatarUploadForm">
                        @csrf
                        <input type="file" name="avatar" x-ref="avatarInput" accept="image/*" @change="$refs.avatarUploadForm.submit()">
                    </form>
                    
                    <h2 class="text-xl font-black text-gray-900 uppercase mt-4">{{ $user->name }}</h2>
                    <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                </div>

                {{-- Navigation Menu --}}
                <nav class="space-y-1">
                    <button @click="currentTab = 'profile'; window.history.pushState({}, '', '?tab=profile')" 
                            :class="{ 'bg-black text-white': currentTab === 'profile', 'text-gray-900 hover:bg-gray-100': currentTab !== 'profile' }"
                            class="w-full text-left px-4 py-3 rounded font-bold transition uppercase">
                        Profile & Update
                    </button>
                    <button @click="currentTab = 'orders'; window.history.pushState({}, '', '?tab=orders')" 
                            :class="{ 'bg-black text-white': currentTab === 'orders', 'text-gray-900 hover:bg-gray-100': currentTab !== 'orders' }"
                            class="w-full text-left px-4 py-3 rounded font-bold transition uppercase">
                        My Orders
                    </button>
                    <button @click="currentTab = 'addresses'; window.history.pushState({}, '', '?tab=addresses')" 
                            :class="{ 'bg-black text-white': currentTab === 'addresses', 'text-gray-900 hover:bg-gray-100': currentTab !== 'addresses' }"
                            class="w-full text-left px-4 py-3 rounded font-bold transition uppercase">
                        Addresses
                    </button>
                    <button @click="currentTab = 'settings'; window.history.pushState({}, '', '?tab=settings')" 
                            :class="{ 'bg-black text-white': currentTab === 'settings', 'text-gray-900 hover:bg-gray-100': currentTab !== 'settings' }"
                            class="w-full text-left px-4 py-3 rounded font-bold transition uppercase">
                        Password & Security
                    </button>
                    <div class="pt-4 mt-2 border-t border-gray-100 !p-0">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 rounded font-bold transition uppercase text-red-600 hover:bg-red-50 hover:text-red-700">
                                Log Out
                            </button>
                        </form>
                    </div>
                </nav>
            </div>

            {{-- RIGHT COLUMN: CONTENT --}}
            <div class="md:col-span-3 space-y-8">

                {{-- TAB 1: PROFILE --}}
                <div x-show="currentTab === 'profile'" x-cloak>
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-lg font-black text-gray-900 mb-4 tracking-wide uppercase">Update Personal Details</h2>
                        
                        <form id="updateProfileForm" action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PATCH')

                            @php
                                $nameParts = explode(' ', $user->name);
                                $firstName = array_shift($nameParts);
                                $lastName = implode(' ', $nameParts);
                            @endphp

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $firstName) }}" class="mt-1 w-full px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:ring-black focus:border-black" required>
                                    @error('first_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $lastName) }}" class="mt-1 w-full px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:ring-black focus:border-black" required>
                                    @error('last_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 w-full px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:ring-black focus:border-black" required>
                                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 w-full px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:ring-black focus:border-black">
                                @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                                <textarea name="bio" id="bio" rows="3" class="mt-1 w-full px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:ring-black focus:border-black">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <button type="submit" class="w-full bg-black text-white py-3 rounded-lg font-bold hover:bg-gray-800 transition uppercase mt-4 shadow-lg">
                                Save Changes
                            </button>
                        </form>
                    </div>
                </div>

                {{-- TAB 2: ORDERS --}}
                <div x-show="currentTab === 'orders'" x-cloak>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 bg-gray-50">
                            <h2 class="text-xl font-bold text-gray-900 tracking-tight">Recent Orders</h2>
                        </div>
                        
                        <div class="divide-y divide-gray-100">
                            @forelse($orders as $order)
                                @php
                                    $firstItem = $order->items->first();
                                    $product = $firstItem ? $firstItem->product : null;
                                    $remainingItems = $order->items->count() - 1;

                                    $statusClasses = [
                                        'pending'    => 'bg-yellow-50 text-yellow-700 ring-yellow-600/20',
                                        'processing' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                                        'shipped'    => 'bg-indigo-50 text-indigo-700 ring-indigo-600/20',
                                        'delivered'  => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                        'cancelled'  => 'bg-red-50 text-red-700 ring-red-600/20',
                                    ];
                                    $statusKey = trim(strtolower($order->status));
                                    $statusClass = $statusClasses[$statusKey] ?? 'bg-gray-50 text-gray-600 ring-gray-500/10';
                                @endphp

                                <div class="p-6 hover:bg-gray-50 transition duration-150 ease-in-out group">
                                    <div class="flex flex-col sm:flex-row gap-6">
                                        {{-- 1. Product Image --}}
                                        <div class="relative flex-shrink-0">
                                            <div class="w-24 h-24 rounded-lg overflow-hidden border border-gray-200 bg-gray-100">
                                                @if($product && $product->image)
                                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($remainingItems > 0)
                                                <span class="absolute -bottom-2 -right-2 bg-black text-white text-xs font-bold px-2 py-1 rounded-full shadow-sm">
                                                    +{{ $remainingItems }}
                                                </span>
                                            @endif
                                        </div>

                                        {{-- 2. Order Info --}}
                                        <div class="flex-1 min-w-0 flex flex-col justify-between">
                                            <div>
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h3 class="text-base font-bold text-gray-900 truncate pr-4">
                                                            {{ $product ? $product->name : 'Product Unavailable' }}
                                                            @if($remainingItems > 0)
                                                                <span class="text-gray-500 font-normal text-sm ml-1">& {{ $remainingItems }} others</span>
                                                            @endif
                                                        </h3>
                                                        
                                                        {{-- FIX LỖI QUANTITY TẠI ĐÂY: Dùng items->sum('quantity') --}}
                                                        <p class="text-xs text-gray-500 mt-1 flex items-center gap-2">
                                                            <span>Quantity: {{ $order->items->sum('quantity') }}</span>
                                                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                                            <span>{{ $order->created_at->format('M d, Y') }}</span>
                                                        </p>
                                                    </div>
                                                    
                                                    <p class="hidden sm:block text-lg font-black text-gray-900">
                                                        {{ number_format($order->total_amount, 0, ',', '.') }}₫
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex items-center justify-between mt-4 sm:mt-0">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ring-1 ring-inset {{ $statusClass }} uppercase tracking-wide">
                                                    {{ $order->status }}
                                                </span>

                                                <div class="flex items-center gap-4">
                                                    <p class="sm:hidden font-black text-gray-900">
                                                        {{ number_format($order->total_amount, 0, ',', '.') }}₫
                                                    </p>
                                                    {{-- NÚT VIEW DETAILS --}}
                                                    <a href="#" 
                                                       @click.prevent="fetchOrderDetails({{ $order->id }}, '{{ route('profile.orders.details', $order->id) }}')" 
                                                       class="inline-flex items-center text-sm font-semibold text-black hover:text-gray-600 hover:underline">
                                                        View Details <span aria-hidden="true" class="ml-1">&rarr;</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12 px-6">
                                    <div class="mx-auto h-24 w-24 text-gray-200 mb-4">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    </div>
                                    <h3 class="mt-2 text-sm font-semibold text-gray-900">No orders placed yet</h3>
                                    <div class="mt-6">
                                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-bold rounded-md text-white bg-black hover:bg-gray-800 focus:outline-none uppercase tracking-wider">
                                            Shop Now
                                        </a>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- TAB 3: ADDRESSES --}}
                <div x-show="currentTab === 'addresses'" x-cloak>
                    <script>
                        window.addressManager = function() {
                            return {
                                addressModalOpen: false,
                                isLoading: false,
                                isEditing: false,
                                editId: null,
                                formData: {
                                    full_name: '', phone: '', address_line: '', city: '', district: '', ward: '', is_default: false
                                },
                                openModal() {
                                    this.isEditing = false;
                                    this.editId = null;
                                    this.formData = { full_name: '', phone: '', address_line: '', city: '', district: '', ward: '', is_default: false };
                                    this.addressModalOpen = true;
                                },
                                editAddress(address) {
                                    this.isEditing = true;
                                    this.editId = address.id;
                                    this.formData = {
                                        full_name: address.full_name,
                                        phone: address.phone,
                                        address_line: address.address_line,
                                        city: address.city,
                                        district: address.district,
                                        ward: address.ward || '',
                                        is_default: Boolean(address.is_default)
                                    };
                                    this.addressModalOpen = true;
                                },
                                async submitForm() {
                                    this.isLoading = true;
                                    let url = "{{ route('addresses.store') }}";
                                    let method = 'POST';
                                    if (this.isEditing) {
                                        url = `/addresses/${this.editId}`; 
                                        method = 'PUT'; 
                                    }
                                    try {
                                        const response = await fetch(url, {
                                            method: method,
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'Accept': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                            },
                                            body: JSON.stringify(this.formData)
                                        });
                                        const result = await response.json();
                                        if (response.ok) {
                                            window.location.reload(); 
                                        } else {
                                            alert('Error: ' + (result.message || JSON.stringify(result.errors)));
                                        }
                                    } catch (error) {
                                        console.error('Error:', error);
                                        alert('Something went wrong.');
                                    } finally {
                                        this.isLoading = false;
                                    }
                                },
                                async deleteAddress(id) {
                                    if(!confirm('Are you sure?')) return;
                                    try {
                                        const response = await fetch(`/addresses/${id}`, {
                                            method: 'DELETE',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                            }
                                        });
                                        if (response.ok) {
                                            document.getElementById(`address-card-${id}`).remove();
                                        } else {
                                            alert('Cannot delete');
                                        }
                                    } catch (e) { console.error(e); }
                                },
                                async setAsDefault(id) {
                                    try {
                                        const response = await fetch(`/addresses/${id}/default`, {
                                            method: 'PATCH',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                            }
                                        });
                                        if (response.ok) window.location.reload();
                                    } catch (e) { console.error(e); }
                                }
                            }
                        }
                    </script>

                    <div x-data="addressManager()"> 
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <div class="flex justify-between items-center mb-6 border-b pb-4">
                                <div>
                                    <h2 class="text-xl font-black text-gray-900 tracking-wide uppercase">My Addresses</h2>
                                    <p class="text-sm text-gray-500 mt-1">Manage your delivery locations.</p>
                                </div>
                                <button @click="openModal()" class="bg-black text-white px-5 py-2.5 rounded-lg font-bold text-xs uppercase hover:bg-gray-800 transition flex items-center gap-2 shadow">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add New
                                </button>
                            </div>

                            <div class="flex flex-col space-y-4">
                                @forelse($addresses ?? [] as $address)
                                    <div class="address-item relative bg-white border rounded-xl p-5 transition-all duration-300 hover:shadow-md flex flex-col md:flex-row md:items-center justify-between gap-4 {{ $address->is_default ? 'border-black ring-1 ring-black bg-gray-50' : 'border-gray-200' }}" id="address-card-{{ $address->id }}">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-1">
                                                <h3 class="font-black text-gray-900 text-lg uppercase">{{ $address->full_name }}</h3>
                                                @if($address->is_default)
                                                    <span class="bg-black text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">Default</span>
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-600 flex items-center gap-2 mb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                                <span class="font-semibold">{{ $address->phone }}</span>
                                            </div>
                                            <div class="text-sm text-gray-600">
                                                {{ $address->address_line }}, {{ $address->ward }}, {{ $address->district }}, <span class="font-bold text-black">{{ $address->city }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4 md:border-l md:pl-6 border-gray-200">
                                            @if(!$address->is_default)
                                                <button @click="setAsDefault({{ $address->id }})" class="text-xs font-bold text-gray-500 hover:text-black uppercase transition whitespace-nowrap hover:underline">Set Default</button>
                                                <div class="h-4 w-px bg-gray-300 hidden md:block"></div>
                                            @endif
                                            <button @click='editAddress(@json($address))' class="text-gray-400 hover:text-blue-600 p-2 rounded-full hover:bg-blue-50 transition" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                            </button>
                                            @if(!$address->is_default)
                                                <button @click="deleteAddress({{ $address->id }})" class="text-gray-400 hover:text-red-600 p-2 rounded-full hover:bg-red-50 transition" title="Delete">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                                        <p class="text-gray-500">No addresses found.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- ADDRESS MODAL --}}
                        <div x-show="addressModalOpen" class="fixed inset-0 z-[9999] overflow-y-auto" style="display: none;">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" @click="addressModalOpen = false"></div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                                <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                                    <div class="bg-black px-4 py-3 sm:px-6 flex justify-between items-center">
                                        <h3 class="text-lg font-bold text-white uppercase" x-text="isEditing ? 'Update Address' : 'Add New Address'"></h3>
                                        <button @click="addressModalOpen = false" class="text-gray-400 hover:text-white">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                    <form @submit.prevent="submitForm">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 space-y-4">
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Full Name</label>
                                                    <input type="text" x-model="formData.full_name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Phone</label>
                                                    <input type="text" x-model="formData.phone" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Address</label>
                                                <input type="text" x-model="formData.address_line" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm">
                                            </div>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">City</label>
                                                    <input type="text" x-model="formData.city" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">District</label>
                                                    <input type="text" x-model="formData.district" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Ward (Optional)</label>
                                                <input type="text" x-model="formData.ward" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm">
                                            </div>
                                            <div class="flex items-center bg-gray-50 p-3 rounded-lg mt-2">
                                                <input type="checkbox" id="is_default" x-model="formData.is_default" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded cursor-pointer">
                                                <label for="is_default" class="ml-2 block text-sm text-gray-900 cursor-pointer select-none">Set as default</label>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse sm:items-center border-t gap-3">
                                            <button type="submit" class="h-12 w-full inline-flex justify-center items-center rounded-lg border border-transparent shadow-sm px-6 bg-black text-base font-bold text-white hover:bg-gray-800 sm:w-auto uppercase transition disabled:opacity-50" :disabled="isLoading">
                                                <span x-text="isLoading ? 'Saving...' : (isEditing ? 'Update Address' : 'Save Address')"></span>
                                            </button>
                                            <button type="button" @click="addressModalOpen = false" class="h-12 w-full inline-flex justify-center items-center rounded-lg border border-gray-300 shadow-sm px-6 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 sm:w-auto uppercase transition">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB 4: SETTINGS --}}
                <div x-show="currentTab === 'settings'" x-cloak>
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-lg font-black text-gray-900 mb-4 tracking-wide uppercase">Change Password</h2>
                        <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                <input type="password" name="current_password" id="current_password" required class="mt-1 w-full px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:ring-black focus:border-black">
                                @error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                                    <input type="password" name="password" id="password" required class="mt-1 w-full px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:ring-black focus:border-black">
                                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 w-full px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:ring-black focus:border-black">
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-black text-white py-3 rounded-lg font-bold hover:bg-gray-800 transition uppercase mt-4 shadow-lg">
                                Update Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showModal = false"></div>
            
            <div x-show="showModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 class="flex items-center justify-center p-4 min-h-full pointer-events-none">
                
                <div class="relative bg-white rounded-lg shadow-xl max-w-4xl w-full mx-auto my-8 overflow-hidden pointer-events-auto">
                    <button @click="showModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 z-10">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    <div x-cloak>
                        {{-- LOADING --}}
                        <template x-if="loadingDetails">
                            <div class="p-12 text-center text-gray-500">
                                <svg class="animate-spin h-8 w-8 text-black mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                <p>Loading order details...</p>
                            </div>
                        </template>

                        {{-- CONTENT --}}
                        <template x-if="selectedOrder && !loadingDetails">
                            <div class="grid grid-cols-1 lg:grid-cols-3 divide-x divide-gray-100">
                                <div class="lg:col-span-2 p-8">
                                    <h3 class="text-2xl font-black text-gray-900 mb-6">Order #<span x-text="selectedOrder.id"></span></h3>
                                    
                                    <div class="grid grid-cols-2 gap-4 text-sm mb-6 pb-4 border-b border-gray-100">
                                        <div><p class="font-semibold text-gray-700">Date:</p><p x-text="new Date(selectedOrder.created_at).toLocaleDateString()"></p></div>
                                        <div><p class="font-semibold text-gray-700">Status:</p><span class="uppercase font-bold" x-text="selectedOrder.status"></span></div>
                                        <div><p class="font-semibold text-gray-700">Payment:</p><p x-text="selectedOrder.payment_method"></p></div>
                                    </div>

                                    <h4 class="text-lg font-bold text-gray-800 mb-4">Products</h4>
                                    <div class="space-y-4 max-h-80 overflow-y-auto pr-2">
                                        <template x-for="item in selectedOrder.items" :key="item.id">
                                            <div class="flex items-center gap-4 p-3 border border-gray-100 rounded-lg">
                                                <div class="w-16 h-16 rounded-md overflow-hidden flex-shrink-0 bg-gray-100">
                                                    {{-- Xử lý hiển thị ảnh sản phẩm --}}
                                                    <img x-show="item.product && item.product.image" :src="'{{ asset('') }}' + item.product.image" class="w-full h-full object-cover">
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="font-semibold text-gray-900" x-text="item.product ? item.product.name : 'Unknown Product'"></p>
                                                    <p class="text-xs text-gray-500">Size: <span x-text="item.size ?? 'N/A'"></span></p>
                                                </div>
                                                <div class="text-right flex-shrink-0">
                                                    <p class="text-sm font-semibold" x-text="'x' + item.quantity"></p>
                                                    <p class="text-xs text-gray-700" x-text="formatMoney(item.total || (item.price * item.quantity))"></p>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <div class="p-8 lg:col-span-1 bg-gray-50">
                                    <h4 class="text-lg font-bold text-gray-800 mb-4">Shipping Info</h4>
                                    <div class="space-y-2 text-sm pb-6 border-b border-gray-100">
                                        <p><span class="font-semibold">To:</span> <span x-text="selectedOrder.fullname"></span></p>
                                        <p><span class="font-semibold">Phone:</span> <span x-text="selectedOrder.phone"></span></p>
                                        <p><span class="font-semibold">Address:</span> <span x-text="selectedOrder.address"></span></p>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-800 mt-6 mb-4">Billing</h4>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between"><span>Subtotal</span><span x-text="formatMoney(selectedOrder.subtotal)"></span></div>
                                        <div class="flex justify-between"><span>Discount</span><span class="text-red-600" x-text="'- ' + formatMoney(selectedOrder.discount_amount)"></span></div>
                                        <div class="flex justify-between"><span>Shipping</span><span x-text="formatMoney(selectedOrder.shipping_fee)"></span></div>
                                        <div class="flex justify-between font-bold pt-4 border-t border-gray-200 text-lg">
                                            <span>TOTAL</span><span class="text-black" x-text="formatMoney(selectedOrder.total_amount)"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        {{-- END MODAL --}}

    </div>
</div>
@endsection