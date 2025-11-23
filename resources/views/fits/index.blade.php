@extends('layouts.app')

@section('title', 'Fits with Converse | Outfit Inspiration')

@section('content')
<style>
    /* Converse Style Custom CSS */
    .section-title {
        font-family: 'Oswald', sans-serif;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #121212;
    }
    .fit-card {
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }
    .fit-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    .fit-image {
        aspect-ratio: 4 / 5; /* Aspect ratio suitable for fashion imagery */
        object-fit: cover;
    }
    .fit-tag {
        background-color: #dc3545; /* Converse red */
        color: white;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.75rem;
    }
    .tip-card {
        border-left: 5px solid #121212;
        background-color: #f8f8f8;
        padding: 20px;
    }
</style>

<div class="container mx-auto px-4 py-12 md:py-20">

    <section class="text-center mb-16 bg-gray-100 p-8 rounded-lg shadow-md">
        <h1 class="text-4xl md:text-6xl section-title mb-3">
            CONVERSE OUTFIT INSPIRATION
        </h1>
        <p class="text-xl text-gray-600 font-light max-w-3xl mx-auto">
            Discover the latest outfit pairings, from classic to modern, to keep your Converse looking their best.
        </p>
    </section>
    
    <hr>

    
    <section class="my-16">
        <h2 class="text-3xl section-title mb-10 text-center">
            STYLE PRINCIPLES
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="tip-card">
                <h3 class="font-bold text-lg mb-2 uppercase">1. Minimalism</h3>
                <p class="text-gray-700 text-sm">
                    Converse are an icon of simplicity. Pair them with classic jeans, a white tee, or a denim jacket — let the shoes be the focal point.
                </p>
            </div>
            
            <div class="tip-card">
                <h3 class="font-bold text-lg mb-2 uppercase">2. Balance Proportions</h3>
                <p class="text-gray-700 text-sm">
                    For high-tops, opt for skinny jeans, cuffed wide-leg trousers, or short skirts to highlight the shoe collar and keep proportions balanced.
                </p>
            </div>
            
            <div class="tip-card">
                <h3 class="font-bold text-lg mb-2 uppercase">3. Monochrome Colors</h3>
                <p class="text-gray-700 text-sm">
                    Black and white Converse pair perfectly with monochrome outfits (black, white, gray, navy) for a modern, understated look.
                </p>
            </div>
        </div>
    </section>

    <hr>

    <section class="my-16">
        <h2 class="text-3xl section-title mb-10 text-center">
            LOOKBOOK: STREET STYLE INSPIRATION
        </h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

            <div class="fit-card bg-white shadow-xl">
                <img src="{{ asset('images/fit1.jpg') }}" alt="Classic High-Top Outfit" class="w-full fit-image">
                <div class="p-4">
                    <span class="fit-tag mb-2 inline-block">Chuck 70</span>
                    <h4 class="font-bold text-base mb-1">Classic & Jeans</h4>
                    <p class="text-gray-500 text-xs">Pair with straight-leg jeans with cuffs and a bomber jacket.</p>
                </div>
            </div>

            <div class="fit-card bg-white shadow-xl">
                <img src="{{ asset('images/fit2.jpg') }}" alt="Feminine Dress Outfit" class="w-full fit-image">
                <div class="p-4">
                    <span class="fit-tag mb-2 inline-block" style="background-color: #007bff;">Lifestyle</span>
                    <h4 class="font-bold text-base mb-1">Maxi Dress & Low-Tops</h4>
                    <p class="text-gray-500 text-xs">Mix flowing maxi dresses with bright low-top sneakers for contrast.</p>
                </div>
            </div>

            <div class="fit-card bg-white shadow-xl">
                <img src="{{ asset('images/fit3.jpg') }}" alt="Streetwear Utility Outfit" class="w-full fit-image">
                <div class="p-4">
                    <span class="fit-tag mb-2 inline-block">Streetwear</span>
                    <h4 class="font-bold text-base mb-1">Cargo Pants & Hoodie</h4>
                    <p class="text-gray-500 text-xs">A strong streetwear look with cargo pants and an oversized hoodie.</p>
                </div>
            </div>

            <div class="fit-card bg-white shadow-xl">
                <img src="{{ asset('images/fit4.jpg') }}" alt="Business Casual Outfit" class="w-full fit-image">
                <div class="p-4">
                    <span class="fit-tag mb-2 inline-block" style="background-color: #343a40;">Office Look</span>
                    <h4 class="font-bold text-base mb-1">Trousers & Blazer</h4>
                    <p class="text-gray-500 text-xs">Upgrade business casual with white or cream Converse.</p>
                </div>
            </div>

        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('products.index') }}" 
               class="inline-block bg-black text-white px-8 py-3 font-bold uppercase text-sm rounded-md hover:bg-gray-800 transition duration-300">
                Shop All Shoes
            </a>
        </div>
    </section>

</div>
@endsection