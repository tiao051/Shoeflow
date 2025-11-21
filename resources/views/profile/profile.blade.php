@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

<div class="bg-gray-50 py-12 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-black text-gray-900 mb-8 tracking-tight uppercase">My Account</h1>

        @if (session('success'))
            <div id="success-alert" 
                class="fixed top-4 left-1/2 transform -translate-x-1/2 z-[9999] 
                        bg-green-100 border border-green-400 text-green-700 px-6 py-3 rounded-lg max-w-lg shadow-xl" 
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const alertElement = document.getElementById('success-alert');
                    if (alertElement) {
                        setTimeout(() => {
                            alertElement.style.opacity = '0';
                            alertElement.style.transition = 'opacity 0.5s ease-out';
                            
                            setTimeout(() => {
                                alertElement.remove();
                            }, 500); 
                        }, 2000);
                    }
                });
            </script>
        @endif

        @error('avatar')
            <div x-data="{ open: true }" x-show="open" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ $message }}</span>
                <span @click="open = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.303l-2.651 3.546a1.2 1.2 0 1 1-1.697-1.697l3.546-2.651-3.546-2.651a1.2 1.2 0 0 1 1.697-1.697l2.651 3.546 2.651-3.546a1.2 1.2 0 0 1 1.697 1.697l-3.546 2.651 3.546 2.651a1.2 1.2 0 0 1 0 1.697z"/></svg>
                </span>
            </div>
        @enderror

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8" x-data="{ currentTab: 'profile' }">
            
            <div class="md:col-span-1 bg-white rounded-lg shadow-lg p-6 h-fit sticky top-24">
                <div class="text-center mb-6">                 
                    <div x-data="{ isHovering: false }" class="relative inline-block mx-auto" @mouseenter="isHovering = true" @mouseleave="isHovering = false">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) . '?v=' . time() : 'https://via.placeholder.com/128/000000/FFFFFF?text=A' }}" 
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

                <nav class="space-y-1">
                    <button @click="currentTab = 'profile'" 
                            :class="{ 'bg-black text-white': currentTab === 'profile', 'text-gray-900 hover:bg-gray-100': currentTab !== 'profile' }"
                            class="w-full text-left px-4 py-3 rounded font-bold transition uppercase">
                        Profile & Update
                    </button>
                    <button @click="currentTab = 'orders'" 
                            :class="{ 'bg-black text-white': currentTab === 'orders', 'text-gray-900 hover:bg-gray-100': currentTab !== 'orders' }"
                            class="w-full text-left px-4 py-3 rounded font-bold transition uppercase">
                        My Orders
                    </button>
                    <button @click="currentTab = 'addresses'" 
                            :class="{ 'bg-black text-white': currentTab === 'addresses', 'text-gray-900 hover:bg-gray-100': currentTab !== 'addresses' }"
                            class="w-full text-left px-4 py-3 rounded font-bold transition uppercase">
                        Addresses
                    </button>
                    <button @click="currentTab = 'settings'" 
                            :class="{ 'bg-black text-white': currentTab === 'settings', 'text-gray-900 hover:bg-gray-100': currentTab !== 'settings' }"
                            class="w-full text-left px-4 py-3 rounded font-bold transition uppercase">
                        Password & Security
                    </button>
                </nav>
            </div>

            <div class="md:col-span-3 space-y-8">

                {{-- TAB 1: PROFILE & INFO UPDATE --}}
                <div x-show="currentTab === 'profile'" class="space-y-6">

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
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number (Optional)</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g., 0901234567" 
                                       class="mt-1 w-full px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:ring-black focus:border-black">
                                @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="bio" class="block text-sm font-medium text-gray-700">Bio / About Me (Optional)</label>
                                <textarea name="bio" id="bio" placeholder="Tell us a little about yourself" 
                                          class="mt-1 w-full px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:ring-black focus:border-black" rows="3">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <button type="submit" class="w-full bg-black text-white py-3 rounded-lg font-bold hover:bg-gray-800 transition uppercase mt-4 shadow-lg">
                                Save Changes
                            </button>
                        </form>
                    </div>
                </div>


                {{-- TAB 2: RECENT ORDERS --}}
                <div x-show="currentTab === 'orders'">
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-lg font-black text-gray-900 mb-6 tracking-wide uppercase">Recent Orders (Last 5)</h2>
                        
                        @forelse($orders as $order)
                            <div class="border-b border-gray-200 py-4 last:border-b-0">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-black text-lg text-gray-900">ORDER #{{ $order->id }}</span>
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
                                    <p class="text-gray-600">{{ $order->items_count ?? 'N/A' }} items</p>
                                    <p class="font-black text-xl text-black">{{ number_format($order->total ?? 0, 0, ',', '.') }}₫</p>
                                </div>
                                <a href="#" class="text-xs font-medium text-black hover:underline mt-2 inline-block">View Details &rarr;</a>
                            </div>
                        @empty
                            <p class="text-gray-600 text-center py-8">You have not placed any recent orders.</p>
                        @endforelse
                        
                        <div class="text-center pt-4">
                            <a href="#" class="text-black font-bold uppercase text-sm hover:underline">View All Orders &rarr;</a>
                        </div>
                    </div>
                </div>

                {{-- TAB 3: ADDRESSES (Placeholder) --}}
                <div x-show="currentTab === 'addresses'">
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-lg font-black text-gray-900 mb-4 tracking-wide uppercase">Shipping Addresses (Placeholder)</h2>
                        <p class="text-gray-600 py-8 text-center">
                            Manage your delivery addresses here. (Feature coming soon!)
                        </p>
                        <a href="#" class="w-full text-center block bg-gray-100 text-black py-3 rounded font-bold hover:bg-gray-200 transition uppercase text-sm">
                            Add New Address
                        </a>
                    </div>
                </div>

                {{-- TAB 4: PASSWORD & SECURITY SETTINGS --}}
                <div x-show="currentTab === 'settings'">
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