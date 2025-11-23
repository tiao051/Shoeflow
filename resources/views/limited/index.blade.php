@extends('layouts.app')

@section('title', 'CONVERSE x A-TRAK | CHUCK 70 RENEW — LIMITED EDITION')

@section('content')
<style>
    /* Custom Fonts & Styling for "High-Fashion x Street" Vibe */
    .font-exclusive {
        font-family: 'Oswald', sans-serif;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    /* Main title sizing */
    .text-massive {
        font-size: 3.5rem;
        line-height: 1.1;
    }

    /* Hero Section Styling (Dark, Dramatic) */
    .limited-hero {
        background: linear-gradient(135deg, #0f0f0f 0%, #303030 100%);
        min-height: 80vh;
        color: white;
        position: relative;
        overflow: hidden;
    }

    /* Badge styling */
    .limited-badge {
        background-color: #dc3545;
        padding: 6px 12px;
        font-size: 1.1rem;
        font-weight: 700;
        display: inline-block;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
    }

    /* Countdown Styling */
    .countdown-timer {
        font-size: 1.8rem;
        font-weight: 700;
        color: #ffc107;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 6px 12px;
        border-radius: 5px;
        display: inline-flex;
    }

    /* Add to Cart Button Styling (Unique Color) */
    .add-to-cart-limited {
        background-color: #ffc107;
        color: black;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s;
        padding: 10px 24px;
        font-size: 0.9rem;
    }

    .add-to-cart-limited:hover {
        background-color: #e0a800;
        transform: scale(1.02);
    }

    /* Story/Details Styling */
    .story-section h3 {
        font-family: 'Oswald', sans-serif;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 15px;
    }

    .why-limited-list li {
        margin-bottom: 10px;
        font-size: 1.1rem;
        border-left: 3px solid #dc3545;
        padding-left: 10px;
    }

    /* HERO IMAGE EFFECTS */
    .hero-shoe-image {
        filter: drop-shadow(0px 10px 25px rgba(0, 0, 0, 0.6));
        transform: rotate(-15deg) scale(0.95);
        transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94), filter 0.3s ease-in-out;
        max-width: 100%;
        height: auto;
    }

    .hero-shoe-container:hover .hero-shoe-image {
        transform: rotate(-10deg) scale(1.0);
        filter: drop-shadow(0px 15px 35px rgba(0, 0, 0, 0.8));
    }

    /* Effects for gallery thumbnails */
    .gallery-image {
        filter: drop-shadow(0px 5px 15px rgba(0,0,0,0.3));
        transition: transform 0.3s ease-in-out, filter 0.3s ease-in-out;
    }

    .gallery-image:hover {
        transform: translateY(-5px) scale(1.02);
        filter: drop-shadow(0px 8px 20px rgba(0,0,0,0.5));
    }

    /* Adjust massive text size for mobile */
    @media (max-width: 768px) {
        .text-massive {
            font-size: 2rem;
        }

        .limited-badge, .countdown-timer {
            font-size: 1rem;
            padding: 5px 10px;
        }

        .add-to-cart-limited {
            padding: 8px 16px;
            font-size: 0.8rem;
        }
    }

</style>

@php
    // Mock data for CONVERSE CHUCK 70 RENEW x A-TRAK
    $product = (object)[
        'id' => 2001,
        'name' => 'CONVERSE CHUCK 70 RENEW x A-TRAK',
        'year' => 2025,
        'price' => 3990000,
        'resale_value' => 4500000,
        'total_stock' => 500,
        'current_number' => 241,
        'release_type' => 'Drop',
        'release_end_timestamp' => now()->addDays(7)->timestamp,
        'current_status' => 'AVAILABLE'
    ];
@endphp

{{-- HERO SECTION --}}
<section class="limited-hero flex items-center justify-center p-8 md:p-16">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center z-10">

        {{-- Left: Text & Pressure --}}
        <div>
            <span class="limited-badge font-exclusive mb-4">🔥 LIMITED RELEASE: {{ $product->year }}</span>

            <h1 class="font-exclusive text-massive my-4 leading-tight">
                {{ $product->name }}
            </h1>

            <div class="text-xl md:text-2xl text-red-500 font-bold mb-4">
                "DESIGNED IN COLLABORATION WITH A-TRAK FOR CONVERSE"
            </div>

            <p class="text-lg mb-8 text-gray-400 font-exclusive">
                A sustainable reinterpretation of a classic silhouette — the Chuck 70 Renew meets A-TRAK's street-forward aesthetic.
            </p>

            {{-- Countdown Timer --}}
            <div id="countdown-display" class="countdown-timer mb-8">SOLD OUT</div>

            {{-- Price & Add to Cart --}}
            <div class="flex flex-col items-start gap-3">
                <p class="text-2xl font-exclusive text-red-600 font-black">
                    PRICE: {{ number_format($product->price, 0, ',', '.') }} ₫
                </p>

                <button class="add-to-cart-limited px-10 py-4 text-sm rounded-lg shadow-xl" data-product-id="{{ $product->id }}">
                    ADD TO CART
                </button>

                <p class="text-xs text-gray-400 mt-2">Estimated resale: ~ {{ number_format($product->resale_value, 0, ',', '.') }} ₫</p>
            </div>
        </div>

        {{-- Right: Artistic Image --}}
        <div class="relative flex justify-center items-center hero-shoe-container">
            <img
                src="{{ asset('images/special-removebg.png') }}"
                alt="{{ $product->name }} Exclusive"
                class="w-full max-w-lg object-contain hero-shoe-image"
                onerror="this.onerror=null;this.src='https://placehold.co/600x600/121212/FFFFFF?text=OFF-WHITE+JORDAN+1';"
            />
        </div>
    </div>
</section>

{{-- STORY & DETAILS --}}
<section class="max-w-7xl mx-auto py-16 px-4 md:px-8 bg-white">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12 story-section">

        {{-- Section: Story --}}
        <div class="md:col-span-2">
            <h2 class="text-3xl section-title mb-6">CONVERSE x A-TRAK — CHUCK 70 RENEW</h2>

            <p class="text-gray-700 text-lg mb-4">
                The CHUCK 70 RENEW x A-TRAK merges Converse heritage with contemporary, club-inspired details. Reworked using recycled materials and thoughtful design cues, this release is both performance-minded and street-ready.
            </p>

            <p class="text-gray-700 text-lg">
                A-TRAK contributes bespoke graphic treatments and color blocking inspired by electronic music culture, while Converse provides the classic Chuck 70 foundation updated for modern wear.
            </p>
        </div>

        {{-- Section: Exclusivity & Number --}}
        <div class="bg-gray-100 p-6 rounded-lg text-center flex flex-col justify-center">
            <h3 class="text-2xl text-red-600 mb-4">SCARCITY</h3>

            <p class="text-4xl font-exclusive font-black text-black my-4">$2,000 – $10,000+</p>
            <p class="text-sm text-gray-600 uppercase">CURRENT RESALE VALUE</p>
        </div>
    </div>
</section>

{{-- WHY IT'S LIMITED --}}
<section class="max-w-7xl mx-auto py-16 px-4 md:px-8">
    <h2 class="text-3xl section-title mb-8 text-center">WHY THIS RELEASE IS SPECIAL</h2>

    <div class="max-w-4xl mx-auto">
        <ul class="why-limited-list text-gray-800">
            <li>Exclusive collaboration between Converse and A-TRAK combining heritage and contemporary design.</li>
            <li>Constructed with Renew materials and limited-run components unique to this release.</li>
            <li>Special A-TRAK graphics and colorways not available on standard Chuck 70 models.</li>
            <li>Low global quantity: only {{ number_format($product->total_stock, 0, ',', '.') }} pairs produced.</li>
            <li><strong>No planned restock:</strong> this release is a one-time limited edition.</li>
        </ul>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const productData = {
        releaseType: '{{ $product->release_type }}',
        releaseEndTimestamp: {{ $product->release_end_timestamp }},
        currentStatus: '{{ $product->current_status }}' // retrieve status from PHP
    };

    const countdownDisplay = document.getElementById('countdown-display');
    const limitedButton = document.querySelector('.add-to-cart-limited');

    // Disable countdown and purchase button if already SOLD OUT
    if (productData.currentStatus === 'SOLD OUT') {
        if (countdownDisplay) {
            countdownDisplay.innerHTML = 'SOLD OUT';
            countdownDisplay.style.backgroundColor = 'rgba(220, 53, 69, 0.5)';
        }

        if (limitedButton) {
            limitedButton.disabled = true;
            limitedButton.textContent = 'SOLD OUT';
            limitedButton.classList.remove('add-to-cart-limited');
            limitedButton.classList.add('bg-gray-600', 'hover:bg-gray-600', 'text-white');
        }

        return;
    }

    // Countdown logic (runs only if not SOLD OUT)
    if (countdownDisplay) {
        function updateCountdown() {
            const now = Math.floor(Date.now() / 1000);
            const distance = productData.releaseEndTimestamp - now;

            if (distance < 0) {
                countdownDisplay.innerHTML = 'SALE ENDED / SOLD OUT';

                if (limitedButton) {
                    limitedButton.disabled = true;
                    limitedButton.textContent = 'SOLD OUT';
                    limitedButton.classList.remove('add-to-cart-limited');
                    limitedButton.classList.add('bg-gray-600', 'hover:bg-gray-600', 'text-white');
                }

                clearInterval(interval);
                return;
            }

            const days = Math.floor(distance / (60 * 60 * 24));
            const hours = Math.floor((distance % (60 * 60 * 24)) / (60 * 60));
            const minutes = Math.floor((distance % (60 * 60)) / 60);
            const seconds = Math.floor(distance % 60);

            const displayHours = String(hours).padStart(2, '0');
            const displayMinutes = String(minutes).padStart(2, '0');
            const displaySeconds = String(seconds).padStart(2, '0');

            const prefix = productData.releaseType === 'End' ? 'ENDS IN' : 'DROPS IN';

            if (days > 0) {
                countdownDisplay.innerHTML = `${prefix} ${days} DAYS ${displayHours}:${displayMinutes}:${displaySeconds}`;
            } else {
                countdownDisplay.innerHTML = `${prefix} ${displayHours}:${displayMinutes}:${displaySeconds}`;
            }
        }

        const interval = setInterval(updateCountdown, 1000);
        updateCountdown();
    }
});
</script>
@endpush