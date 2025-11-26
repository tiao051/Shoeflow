@extends('layouts.app')

@section('title', 'Dashboard - Converse Vietnam')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">

<style>
    .view-details-btn:hover {
        color: white !important; /* use !important to ensure override */
        background-color: black;
    }

    /* Heartbeat animation */
    @keyframes converse-pop {
        0%   { transform: scale(1); }
        50%  { transform: scale(1.4); }
        100% { transform: scale(1); }
    }

    .heart-animate {
        animation: converse-pop 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }

    /* Converse toast (hidden by default) */
    #converse-toast {
        visibility: hidden;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    #converse-toast.show {
        visibility: visible;
        opacity: 1;
        transform: translateY(0);
    }

    /* Hide scrollbars for the carousel */
    #new-arrivals-carousel::-webkit-scrollbar { display: none; }
    #new-arrivals-carousel { -ms-overflow-style: none; scrollbar-width: none; }

    .group:hover img { transform: scale(1.05); }
</style>

<section class="flex items-center justify-center min-h-[500px] text-white py-20 px-5"
         style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
    <div class="text-center">
        <h1 class="text-6xl md:text-8xl font-extrabold uppercase mb-4 tracking-wider"
            style="font-family: 'Oswald', sans-serif;">CHUCK TAYLOR</h1>

        <p class="text-xl font-light mb-8">ICONIC STYLE. TIMELESS COMFORT.</p>

        <a href="{{ url('/products') }}"
           class="inline-block bg-white text-black px-8 py-4 font-bold uppercase text-sm rounded-lg shadow-lg hover:bg-gray-200 transition duration-300">
            Shop Now
        </a>
    </div>
</section>

<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    
    <section class="mb-12">
        <h2 class="text-center mb-8 font-extrabold uppercase text-3xl md:text-4xl" 
            style="font-family: 'Oswald', sans-serif;">
            Shop By Category
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="relative bg-white rounded-xl shadow-lg overflow-hidden transition duration-300 hover:shadow-2xl group">
                <div class="bg-gray-100 flex items-center justify-center h-80">
                    <img src="{{ asset('images/cate1.jpg') }}" 
                          alt="Chuck Taylor Shoes" 
                          class="w-full h-full object-cover transition duration-200 group-hover:scale-105"
                          onerror="this.onerror=null;this.src='https://placehold.co/400x320/E5E7EB/4B5563?text=Chuck+Taylor';">
                </div>
                <div class="p-6 text-center">
                    <h3 class="font-bold text-lg uppercase">Chuck Taylor</h3>
                    <p class="text-gray-500 text-sm">Classic high tops & low tops</p>
                </div>
                <a href="{{ route('products.index', ['category' => 'chuck-taylor']) }}" class="absolute inset-0 z-10"></a>
            </div>

            <div class="relative bg-white rounded-xl shadow-lg overflow-hidden transition duration-300 hover:shadow-2xl group">
                <div class="bg-gray-100 flex items-center justify-center h-80">
                    <img src="{{ asset('images/cate2.jpg') }}" 
                          alt="One Star Shoes" 
                          class="w-full h-full object-cover transition duration-200 group-hover:scale-105"
                          onerror="this.onerror=null;this.src='https://placehold.co/400x320/E5E7EB/4B5563?text=One+Star';">
                </div>
                <div class="p-6 text-center">
                    <h3 class="font-bold text-lg uppercase">One Star</h3>
                    <p class="text-gray-500 text-sm">Retro basketball style</p>
                </div>
                <a href="{{ route('products.index', ['category' => 'one-star']) }}" class="absolute inset-0 z-10"></a>
            </div>

            <div class="relative bg-white rounded-xl shadow-lg overflow-hidden transition duration-300 hover:shadow-2xl group">
                <div class="bg-gray-100 flex items-center justify-center h-80">
                    <img src="{{ asset('images/cate3.jpg') }}" 
                          alt="All Star Shoes" 
                          class="w-full h-full object-cover transition duration-200 group-hover:scale-105"
                          onerror="this.onerror=null;this.src='https://placehold.co/400x320/E5E7EB/4B5563?text=All+Star';">
                </div>
                <div class="p-6 text-center">
                    <h3 class="font-bold text-lg uppercase">All Star</h3>
                    <p class="text-gray-500 text-sm">Heritage basketball sneakers</p>
                </div>
                <a href="{{ route('products.index', ['category' => 'all-star']) }}" class="absolute inset-0 z-10"></a>
            </div>
        </div>
    </section>

    <section class="mb-12">
        <h2 class="text-center mb-8 font-extrabold uppercase text-3xl md:text-4xl" 
            style="font-family: 'Oswald', sans-serif;">
            New Arrivals
        </h2>
        
        <div id="new-arrivals-carousel" 
             class="flex overflow-x-auto whitespace-nowrap space-x-6 pb-4 scroll-smooth snap-x snap-mandatory">
            
            @foreach($newArrivals as $product)
            <div class="inline-block w-64 min-w-64 snap-center group relative bg-white transition duration-300 hover:shadow-lg rounded-lg">

                <a href="{{ route('products.show', $product->id) }}" class="block relative overflow-hidden h-64">
                    <img src="{{ asset($product->image ?? 'images/placeholder.jpg') }}"
                          class="w-full h-full object-cover rounded-t-lg transition duration-200 group-hover:opacity-90 group-hover:scale-105"
                          alt="{{ $product->name }} - {{ $product->color ?? '' }}"
                          onerror="this.onerror=null;this.src='https://placehold.co/400x400/000000/FFFFFF?text={{ urlencode($product->name ?? 'Product') }}';">

                    <span class="absolute top-2 left-2 bg-black text-white text-xs px-2 py-1 font-bold rounded-md">NEW</span>
                </a>

                <div class="p-4">
                    <a href="{{ route('products.show', $product->id) }}">
                        <h5 class="font-bold uppercase text-base mb-1 truncate hover:text-gray-600 transition">{{ $product->name }}</h5>
                    </a>

                    <p class="text-gray-500 text-sm mb-2 truncate">{{ $product->color ?? 'Multiple Colors' }}</p>

                    <div class="flex justify-between items-center mb-3">
                        <p class="font-bold text-lg">{{ number_format($product->price, 0, ',', '.') }} ₫</p>

                        <form action="{{ route('wishlist.store') }}" method="POST" class="inline-block relative js-wishlist-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <button type="submit" class="group/btn transition duration-150 ease-in-out" title="Add to Wishlist">
                                <svg id="heart-icon-{{ $product->id }}" xmlns="http://www.w3.org/2000/svg"
                                      class="w-6 h-6 text-black group-hover/btn:text-red-600 transition-colors duration-200"
                                      fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                     <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-.318-.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </form>
                    </div>

                    <a href="{{ route('products.show', $product->id) }}"
                       class="block border border-black text-black px-4 py-2 text-xs uppercase font-bold text-center view-details-btn transition duration-200">
                        View Details
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center text-sm text-gray-500 mt-4">
            ← Swipe or scroll to view more products →
        </div>
    </section>

    <section class="bg-black text-white text-center py-16 mb-12 rounded-xl px-5">
        <h2 class="font-extrabold uppercase mb-4 text-3xl md:text-4xl" style="font-family: 'Oswald', sans-serif;">
            Custom Your Style
        </h2>
        <p class="mb-8 text-gray-400 text-lg">Design your own unique Converse sneakers.</p>
        <button class="bg-white text-black px-8 py-4 font-bold uppercase text-sm rounded-lg shadow-lg hover:bg-gray-200 transition duration-300">
            Start Customizing
        </button>
    </section>

    <section class="text-center py-12 bg-gray-50 rounded-xl">
        <div class="max-w-xl mx-auto px-5">        
            @auth
                @if (auth()->user()->is_verified)
                    <div class="text-green-600">
                        <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h2 class="font-extrabold uppercase mb-2 text-2xl md:text-3xl" style="font-family: 'Oswald', sans-serif;">
                            You're In The Loop!
                        </h2>
                        <p class="text-gray-600 mb-6">
                            Thank you! You are already subscribed and will receive special offers and updates.
                        </p>
                    </div>
                @else
                    <h2 class="font-extrabold uppercase mb-2 text-2xl md:text-3xl" style="font-family: 'Oswald', sans-serif;">
                        Complete Your Subscription
                    </h2>
                    <p class="text-red-500 font-bold mb-3">
                        Your email ({{ auth()->user()->email }}) is not yet verified.
                    </p>
                    
                    <form class="flex" method="POST" action="{{ route('verification.send.code') }}"> 
                        @csrf 
                        <input type="email" name="email" required value="{{ auth()->user()->email }}" readonly
                            class="flex-grow p-3 border border-gray-300 bg-gray-200 rounded-l-lg text-sm focus:ring-0 focus:border-black" 
                            placeholder="Enter your email address">
                        <button class="bg-black text-white p-3 rounded-r-lg hover:bg-gray-800 transition duration-150 uppercase font-bold text-sm" type="submit">
                            Send Code
                        </button>
                    </form>
                    
                    @error('email')
                        <p class="text-red-500 text-sm mt-2 text-left">{{ $message }}</p>
                    @enderror

                    <p class="text-gray-500 mt-4 text-sm">
                        Verify your email to unlock exclusive member benefits.
                    </p>           
                @endif
            @else
                <h2 class="font-extrabold uppercase mb-2 text-2xl md:text-3xl" style="font-family: 'Oswald', sans-serif;">
                    Stay In The Loop
                </h2>
                <p class="text-gray-500 mb-6">Subscribe to get special offers and updates.</p>
                
                <form class="flex" method="POST" action="{{ route('verification.send.code') }}"> 
                    @csrf 
                    <input type="email" name="email" required
                        class="flex-grow p-3 border border-gray-300 rounded-l-lg text-sm focus:ring-0 focus:border-black" 
                        placeholder="Enter your email address">
                    <button class="bg-black text-white p-3 rounded-r-lg hover:bg-gray-800 transition duration-150 uppercase font-bold text-sm" type="submit">
                        Send Code
                    </button>
                </form>
                @error('email')
                    <p class="text-red-500 text-sm mt-2 text-left">{{ $message }}</p>
                @enderror    
            @endauth
        </div>
    </section>
</div>

<div id="converse-toast" class="fixed bottom-5 right-5 z-[9999] bg-black text-white px-6 py-4 shadow-2xl flex items-center gap-3 border-l-4 border-red-600 font-bold tracking-wide font-sans">
    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
    </svg>
    <div>
        <span class="block text-sm uppercase text-red-500" id="toast-title">WISHLIST UPDATED</span>
        <span class="text-xs text-gray-300 font-normal uppercase" id="toast-message">Item added to your collection.</span>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/simple-peer/9.11.1/simplepeer.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- 1. Auto-scroll functionality for New Arrivals Carousel ---
    const carousel = document.getElementById('new-arrivals-carousel');
    if (carousel) {
        let scrollDistance = 256;          
        let scrollIntervalTime = 1000;     
        let scrollPosition = 0;
        let scrollInterval;

        function autoScroll() {
            const maxScrollLeft = carousel.scrollWidth - carousel.clientWidth;

            if (carousel.scrollWidth <= carousel.clientWidth) {
                clearInterval(scrollInterval);
                return;
            }
            
            if (scrollPosition >= maxScrollLeft) {
                scrollPosition = 0;
            } else {
                scrollPosition += scrollDistance;
            }
            // Make sure we don't exceed max scroll
            if (scrollPosition > maxScrollLeft) {
                scrollPosition = maxScrollLeft;
            }

            carousel.scrollTo({
                left: scrollPosition,
                // Change to 'smooth' if you want a smooth scrolling effect
                behavior: 'smooth' 
            });
        }

        const startAutoScroll = () => {
            // Only start if no interval is currently running
            if (!scrollInterval) { 
                 scrollInterval = setInterval(autoScroll, scrollIntervalTime);
            }
        };

        const stopAutoScroll = () => {
            clearInterval(scrollInterval);
            scrollInterval = null; // Reset to null so it can be restarted
        };

        // Start auto-scrolling when the page loads
        startAutoScroll();

        // **IMPORTANT LOGIC:** Stop scrolling on mouse enter (hover)
        carousel.addEventListener('mouseenter', stopAutoScroll);
        // Stop scrolling on touch start (mobile devices)
        carousel.addEventListener('touchstart', stopAutoScroll); 
        
        // Resume scrolling on mouse leave
        carousel.addEventListener('mouseleave', startAutoScroll);
        // Resume scrolling on touch end (mobile devices)
        carousel.addEventListener('touchend', startAutoScroll); 
        
        // Handle window resize
        window.addEventListener('resize', () => { stopAutoScroll(); startAutoScroll(); });
    }
    // ------------------------------------------------------------------

    // --- 2. AJAX Wishlist Logic (Keep as is) ---
    const wishlistForms = document.querySelectorAll('.js-wishlist-form');
    const toast = document.getElementById('converse-toast');
    const toastTitle = document.getElementById('toast-title');
    const toastMessage = document.getElementById('toast-message');

    wishlistForms.forEach((form) => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const productId = this.querySelector('input[name="product_id"]').value;
            const heartIcon = document.getElementById(`heart-icon-${productId}`);

            fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', // Important for Laravel to detect AJAX
                    'Accept': 'application/json'
                }
            })
                .then((response) => {
                    if (response.status === 401) {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }
                    return response.json();
                })
                .then((data) => {
                    if (!data) return;

                    // Update toast content
                    toastTitle.textContent = data.status === 'info' ? 'NOTE' : 'SUCCESS';
                    toastMessage.textContent = data.message;

                    // Show toast
                    toast.classList.add('show');
                    setTimeout(() => {
                        toast.classList.remove('show');
                    }, 3000);

                    // Animate heart if success
                    if (data.status === 'success') {
                        // Ensure the icon has red fill and animation
                        heartIcon.classList.remove('text-black');
                        heartIcon.classList.add('text-red-600', 'fill-current', 'heart-animate');

                        // Reset animation class for re-trigger
                        setTimeout(() => {
                            heartIcon.classList.remove('heart-animate');
                        }, 400);
                    }
                })
                .catch((error) => console.error('Error:', error));
        });
    });
    
    // --- 3. Email Verification Modal Logic
    const modal = document.getElementById('verification-modal');
    if (modal) {
        const modalContent = document.getElementById('verification-content');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const modalEmailInput = document.getElementById('modal-email-input');
        const modalStatusMessage = document.getElementById('modal-status-message');
        const verifyCodeForm = document.getElementById('verify-code-form');
        const codeErrorDisplay = document.getElementById('code-error');
        const resendLink = document.getElementById('resend-link');
        
        // Function to open/close Modal
        function openModal() {
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            // Trigger animation
            setTimeout(() => {
                modalContent.classList.remove('opacity-0', 'scale-95');
                modalContent.classList.add('opacity-100', 'scale-100');
            }, 10);
        }
        
        function closeModal() {
            modalContent.classList.add('opacity-0', 'scale-95');
            modalContent.classList.remove('opacity-100', 'scale-100');
            // Hide after animation completes
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        // Attach event to close modal
        closeModalBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Find the send code form (only exists if the user is not verified/not logged in)
        const sendCodeForm = document.querySelector('form[action="{{ route('verification.send.code') }}"]');
        
        if (sendCodeForm) {
            // Safely get the email input
            const emailInput = sendCodeForm.querySelector('input[name="email"]');

            // 1. Handle Send Code Form
            sendCodeForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Disable button to prevent duplicate sending
                const submitButton = this.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.textContent = 'Sending...';

                const errorDisplay = document.querySelector('.text-red-500'); 
                if(errorDisplay) errorDisplay.textContent = '';

                fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response =>{
                    return response.json().then(data => {
                                if (!response.ok) {
                                    // Throw error to be handled in catch
                                    throw new Error(data.message || 'Server Error');
                                }
                                return data;
                            });
                })
                .then(data => {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Send Code';

                    if (data.status === 200) {
                        // Code sent successfully: open Modal
                        modalEmailInput.value = emailInput.value;
                        modalStatusMessage.textContent = data.message || 'The code has been sent to your email.';
                        openModal();
                    } else {
                        // Handle validation errors or other non-200 success states (if applicable)
                        alert(data.message || 'Validation failed. Check your email format.');
                    }
                })
                .catch(error => {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Send Code';
                    console.error('Error:', error);
                    alert('An error occurred while sending the email.');
                });
            });
            
            // 2. Handle Verification Code Form
            verifyCodeForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Clear old errors
                codeErrorDisplay.classList.add('hidden');
                
                // Send verification code via AJAX
                fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(res => {
                    if (res.status === 200) {
                        // Success: close modal and redirect home
                        alert(res.body.message || 'Verification successful!');
                        window.location.href = "{{ route('home') }}"; 
                    } else if (res.status === 422) {
                        // Server validation error (invalid/expired code)
                        const errorMessage = res.body.errors && res.body.errors.code ? res.body.errors.code[0] : 'Invalid or expired code.';
                        codeErrorDisplay.textContent = errorMessage;
                        codeErrorDisplay.classList.remove('hidden');
                    } else {
                        alert('An error occurred: ' + (res.body.message || 'Unknown error.'));
                    }
                })
                .catch(error => console.error('Error:', error));
            });
            
            // 3. Handle Resend Code
            resendLink.addEventListener('click', function(e) {
                e.preventDefault();
                
                const currentEmail = modalEmailInput.value;
                if (!currentEmail) return alert('Email missing.');

                modalStatusMessage.textContent = 'Resending code...';
                
                // FormData for resend
                const formData = new FormData();
                formData.append('_token', document.querySelector('input[name="_token"]').value); 
                formData.append('email', currentEmail);
                
                fetch("{{ route('verification.send.code') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(res => {
                    if (res.status === 200) {
                        modalStatusMessage.textContent = 'A new code has been sent!';
                    } else {
                        modalStatusMessage.textContent = 'Failed to resend code. Please check your email.';
                    }
                })
                .catch(error => {
                    console.error('Resend Error:', error);
                    modalStatusMessage.textContent = 'Connection error.';
                });
            });
        }
    }
});
</script>

<div id="verification-modal" class="fixed inset-0 z-[9999] bg-black bg-opacity-70 hidden items-center justify-center transition-opacity" style="backdrop-filter: blur(5px);">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm mx-4 transform transition-all duration-300 scale-95 opacity-0" id="verification-content">
        
        <div class="p-6 border-b text-center relative">
            <h3 class="text-xl font-bold uppercase tracking-wide" style="font-family: 'Oswald', sans-serif;">
                Verify Your Email
            </h3>
            <button id="close-modal-btn" type="button" class="absolute top-4 right-4 text-gray-400 hover:text-black">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="p-6">
            <p class="text-sm text-gray-600 mb-4 text-center" id="modal-status-message">
                A 6-digit verification code has been sent. Please check your email.
            </p>

            <form id="verify-code-form" method="POST" action="{{ route('verification.verify') }}" class="space-y-4">
                @csrf
                
                <input type="hidden" name="email" id="modal-email-input" value="">
                
                <div>
                    <label for="verification_code" class="block text-sm font-medium text-gray-700">
                        Verification Code (6 digits)
                    </label>
                    <input id="verification_code" name="code" type="text" required maxlength="6"
                        class="mt-1 block w-full px-3 py-3 text-2xl text-center border-2 border-gray-400 rounded-lg shadow-inner focus:ring-black focus:border-black tracking-[0.25em]">
                    <p class="mt-2 text-xs text-red-500 hidden" id="code-error"></p>
                </div>

                <button type="submit" id="verify-submit-btn" class="w-full bg-black text-white px-4 py-3 font-bold uppercase rounded-lg hover:bg-gray-800 transition duration-300">
                    Verify Now
                </button>
            </form>

            <div class="text-center mt-4 pt-4 border-t border-gray-100">
                <span class="text-sm text-gray-500">Didn't receive the code? 
                    <a href="#" id="resend-link" class="font-bold text-black hover:text-red-600 transition">Resend</a>
                </span>
            </div>
        </div>
    </div>
</div>
@endsection