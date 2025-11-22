@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
{{-- CSS to prevent tab flicker on initial page load --}}
<style>
    [x-cloak] { display: none !important; }
</style>

<div class="bg-gray-50 py-12 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-black text-gray-900 mb-8 tracking-tight uppercase">My Account</h1>

        {{-- Main layout. Read the ?tab=... parameter from the URL; default to 'profile' --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8" 
             x-data="{ currentTab: new URLSearchParams(window.location.search).get('tab') || 'profile' }">
            
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
                    {{-- Each button updates `currentTab` and pushes the new URL state to the browser --}}
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
                                // Split full name into first and last name for the form
                                $nameParts = explode(' ', $user->name);
                                $firstName = array_shift($nameParts);
                                $lastName = implode(' ', $nameParts);
                            @endphp

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $firstName) }}" 
                                           class="mt-1 w-full px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:ring-black focus:border-black" required>
                                    @error('first_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $lastName) }}" 
                                           class="mt-1 w-full px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:ring-black focus:border-black" required>
                                    @error('last_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                                       class="mt-1 w-full px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:ring-black focus:border-black" required>
                                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g., 0901234567" 
                                       class="mt-1 w-full px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:ring-black focus:border-black">
                                @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                                <textarea name="bio" id="bio" rows="3" 
                                          class="mt-1 w-full px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:ring-black focus:border-black">{{ old('bio', $user->bio) }}</textarea>
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
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-lg font-black text-gray-900 mb-6 tracking-wide uppercase">Recent Orders</h2>
                        
                        @forelse($orders as $order)
                            <div class="border-b border-gray-200 py-4 last:border-b-0">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-black text-lg text-gray-900">ORDER #{{ $order->id }}</span>
                                    
                                    {{-- Status Badge --}}
                                    @php
                                        $statusKey = trim(strtolower($order->status)); 
                                        $statusClasses = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'processing' => 'bg-blue-100 text-blue-800',
                                            'shipped' => 'bg-indigo-100 text-indigo-800',
                                            'delivered' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                        ];
                                        $statusClass = $statusClasses[$statusKey] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="text-xs font-semibold px-3 py-1 rounded-full uppercase {{ $statusClass }}">{{ $order->status }}</span>
                                </div>

                                <p class="text-sm text-gray-600 mb-2">Placed on: {{ $order->created_at->format('M d, Y') }}</p>
                                
                                <div class="flex justify-between items-center">
                                    {{-- Display item count and exact order total --}}
                                    <p class="text-gray-600">{{ $order->items_count }} items</p>
                                    <p class="font-black text-xl text-black">{{ number_format($order->total_amount, 0, ',', '.') }}₫</p>
                                </div>

                                {{-- Link to the order detail page --}}
                                <a href="{{ route('orders.show', $order->id) }}" class="text-xs font-medium text-black hover:underline mt-2 inline-block">View Details &rarr;</a>
                            </div>
                        @empty
                            <div class="text-gray-600 text-center py-8">
                                <p class="mb-4">You have not placed any recent orders.</p>
                                <a href="{{ route('products.index') }}" class="inline-block bg-black text-white px-6 py-2 rounded font-bold text-sm">SHOP NOW</a>
                            </div>
                        @endforelse
                        
                        @if($orders->isNotEmpty())
                            <div class="text-center pt-4">
                                <a href="#" class="text-black font-bold uppercase text-sm hover:underline">View All Orders &rarr;</a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- TAB 3: ADDRESSES --}}
                <div x-show="currentTab === 'addresses'" x-cloak>
                    
                    {{-- IMPORTANT: Place the script here so Alpine can initialize immediately --}}
                    <script>
                        // Define the address manager function
                        window.addressManager = function() {
                            return {
                                addressModalOpen: false,
                                isLoading: false,
                                isEditing: false,
                                editId: null,
                                formData: {
                                    full_name: '',
                                    phone: '',
                                    address_line: '',
                                    city: '',
                                    district: '',
                                    ward: '',
                                    is_default: false
                                },

                                // Reset form and open modal for adding a new address
                                openModal() {
                                    this.isEditing = false;
                                    this.editId = null;
                                    this.formData = {
                                        full_name: '',
                                        phone: '',
                                        address_line: '',
                                        city: '',
                                        district: '',
                                        ward: '',
                                        is_default: false
                                    };
                                    this.addressModalOpen = true;
                                },

                                // Populate form and open modal for editing
                                editAddress(address) {
                                    this.isEditing = true;
                                    this.editId = address.id;
                                    
                                    // Clone data object
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
                                    
                                    // Default: create new (POST)
                                    let url = "{{ route('addresses.store') }}";
                                    let method = 'POST';

                                    // If editing, switch to update (PUT)
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
                                    try {
                                        const response = await fetch(`/addresses/${id}`, {
                                            method: 'DELETE',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'Accept': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                            }
                                        });

                                        if (response.ok) {
                                            const el = document.getElementById(`address-card-${id}`);
                                            if(el) el.remove();
                                        } else {
                                            const res = await response.json();
                                            alert(res.message || 'Cannot delete');
                                        }
                                    } catch (e) { 
                                        console.error(e); 
                                    }
                                },

                                async setAsDefault(id) {
                                    try {
                                        const response = await fetch(`/addresses/${id}/default`, {
                                            method: 'PATCH',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'Accept': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                            }
                                        });
                                        if (response.ok) {
                                            window.location.reload();
                                        }
                                    } catch (e) { 
                                        console.error(e); 
                                    }
                                }
                            }
                        }
                    </script>

                    {{-- GIAO DIỆN CHÍNH --}}
                    {{-- Gọi hàm addressManager() tại đây --}}
                    <div x-data="addressManager()"> 
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            {{-- Header --}}
                            <div class="flex justify-between items-center mb-6 border-b pb-4">
                                <div>
                                    <h2 class="text-xl font-black text-gray-900 tracking-wide uppercase">My Addresses</h2>
                                    <p class="text-sm text-gray-500 mt-1">Manage your delivery locations.</p>
                                </div>
                                <button @click="openModal()" 
                                        class="bg-black text-white px-5 py-2.5 rounded-lg font-bold text-xs uppercase hover:bg-gray-800 transition flex items-center gap-2 shadow hover:shadow-lg transform hover:-translate-y-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add New
                                </button>
                            </div>

                            {{-- ADDRESS LIST --}}
                            <div class="flex flex-col space-y-4">
                                @forelse($addresses ?? [] as $address)
                                    <div class="address-item relative bg-white border rounded-xl p-5 transition-all duration-300 hover:shadow-md flex flex-col md:flex-row md:items-center justify-between gap-4
                                                {{ $address->is_default ? 'border-black ring-1 ring-black bg-gray-50' : 'border-gray-200' }}"
                                        id="address-card-{{ $address->id }}">
                                        
                                        {{-- Left: Info --}}
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

                                        {{-- Right: Actions --}}
                                        <div class="flex items-center gap-4 md:border-l md:pl-6 border-gray-200">
                                            @if(!$address->is_default)
                                                <button @click="setAsDefault({{ $address->id }})" 
                                                        class="text-xs font-bold text-gray-500 hover:text-black uppercase transition whitespace-nowrap hover:underline">
                                                    Set Default
                                                </button>
                                                <div class="h-4 w-px bg-gray-300 hidden md:block"></div>
                                            @else
                                                <span class="text-green-600 font-bold text-xs uppercase flex items-center gap-1 whitespace-nowrap">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                    Selected
                                                </span>
                                                <div class="h-4 w-px bg-gray-300 hidden md:block"></div>
                                            @endif
                                            
                                            {{-- Button: Edit (Pass full object) --}}
                                            <button @click='editAddress(@json($address))'
                                                    class="text-gray-400 hover:text-blue-600 p-2 rounded-full hover:bg-blue-50 transition" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>

                                            {{-- Button: Delete --}}
                                            @if(!$address->is_default)
                                                <button @click="deleteAddress({{ $address->id }})" 
                                                        class="text-gray-400 hover:text-red-600 p-2 rounded-full hover:bg-red-50 transition" 
                                                        title="Delete">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                                        <p class="text-gray-500">No addresses found. Add one to get started.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- MODAL FORM --}}
                        <div x-show="addressModalOpen" 
                            class="fixed inset-0 z-[9999] overflow-y-auto" style="display: none;">
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
                                                <label for="is_default" class="ml-2 block text-sm text-gray-900 cursor-pointer select-none">Set as default shipping address</label>
                                            </div>
                                        </div>

                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse sm:items-center border-t gap-3">
                                            {{-- Nút SAVE (Màu đen) --}}
                                            <button 
                                                type="submit" 
                                                class="h-12 w-full inline-flex justify-center items-center rounded-lg border border-transparent shadow-sm px-6 bg-black text-base font-bold text-white hover:bg-gray-800 sm:w-auto uppercase transition disabled:opacity-50"
                                                :disabled="isLoading">
                                                <span x-text="isLoading ? 'Saving...' : (isEditing ? 'Update Address' : 'Save Address')"></span>
                                            </button>

                                            {{-- Nút CANCEL (Màu trắng) --}}
                                            <button 
                                                type="button" 
                                                @click="addressModalOpen = false" 
                                                class="h-12 w-full inline-flex justify-center items-center rounded-lg border border-gray-300 shadow-sm px-6 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 sm:w-auto uppercase transition">
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
                                <input type="password" name="current_password" id="current_password" required 
                                       class="mt-1 w-full px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:ring-black focus:border-black">
                                @error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                                    <input type="password" name="password" id="password" required 
                                           class="mt-1 w-full px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:ring-black focus:border-black">
                                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" required 
                                           class="mt-1 w-full px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:ring-black focus:border-black">
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
    </div>
</div>
@endsection