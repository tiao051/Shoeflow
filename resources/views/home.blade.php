@extends('layouts.app')

@section('title', 'Home - Shoeler')

@section('content')

<!-- Hero Section - Converse Style -->
<section class="converse-hero">
    <div class="hero-wrapper">
        @if($banners->isNotEmpty())
            @foreach($banners->take(1) as $banner)
                <img src="{{ $banner->image_url ?? 'https://via.placeholder.com/1920x600' }}" 
                     alt="{{ $banner->title }}" class="hero-image">
                <div class="hero-content">
                    <h1 class="hero-title">{{ $banner->title }}</h1>
                    <p class="hero-subtitle">{{ $banner->description }}</p>
                    <a href="{{ route('shoes.index') }}" class="hero-cta">Shop Now</a>
                </div>
            @endforeach
        @else
            <div class="hero-placeholder">
                <h1 class="hero-title">Welcome to Shoeler</h1>
                <p class="hero-subtitle">Discover Your Perfect Style</p>
                <a href="{{ route('shoes.index') }}" class="hero-cta">Shop Now</a>
            </div>
        @endif
    </div>
</section>

<!-- Trending Styles Section - Converse Style -->
<section class="trending-styles py-5">
    <div class="container-fluid">
        <div class="container mb-5">
            <h2 class="section-title">Trending Styles</h2>
        </div>

        <div class="products-grid">
            @forelse($featuredShoes as $shoe)
                <div class="product-tile">
                    <a href="{{ route('shoes.show', $shoe) }}" class="product-link">
                        <div class="product-image-wrapper">
                            <img src="{{ $shoe->image_url ?? 'https://via.placeholder.com/400x500' }}" 
                                 alt="{{ $shoe->name }}" class="product-image">
                            <div class="product-overlay">
                                <span class="product-overlay-text">View Product</span>
                            </div>
                        </div>
                    </a>
                    <div class="product-info">
                        <h3 class="product-name">{{ $shoe->name }}</h3>
                        <p class="product-category">{{ $shoe->category->name ?? 'Shoes' }}</p>
                        <p class="product-price">${{ number_format($shoe->price, 2) }}</p>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 40px;">
                    <p class="text-muted">No featured shoes available</p>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('shoes.index') }}" class="view-all-btn">View All Products</a>
        </div>
    </div>
</section>

<!-- Shop by Category - Converse Style -->
@if($categories->isNotEmpty())
    <section class="shop-categories py-5 bg-white">
        <div class="container-fluid">
            <div class="container mb-5">
                <h2 class="section-title">Shop by Category</h2>
            </div>

            <div class="categories-grid">
                @foreach($categories as $category)
                    <div class="category-tile">
                        <a href="{{ route('shoes.index', ['category' => $category->slug ?? '']) }}" 
                           class="category-link">
                            <div class="category-image-wrapper">
                                <img src="{{ $category->image_url ?? 'https://via.placeholder.com/600x400' }}" 
                                     alt="{{ $category->name }}" class="category-image">
                                <div class="category-overlay">
                                    <h3 class="category-name">{{ $category->name }}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- From Our Community Section - Converse Style -->
<section class="from-community py-5 bg-light">
    <div class="container text-center">
        <h2 class="section-title mb-4">From Our Community</h2>
        <p class="community-subtitle">Follow us on social media for inspiration and product updates</p>
        
        <div class="row g-4 mt-4">
            <div class="col-md-4">
                <div class="community-card">
                    <div class="community-icon">📸</div>
                    <h4>Share Your Style</h4>
                    <p class="text-muted">Tag us in your photos for a chance to be featured</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="community-card">
                    <div class="community-icon">❤️</div>
                    <h4>Join the Community</h4>
                    <p class="text-muted">Connect with shoe lovers from around the world</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="community-card">
                    <div class="community-icon">🎉</div>
                    <h4>Exclusive Perks</h4>
                    <p class="text-muted">Get early access to new releases and special offers</p>
                </div>
            </div>
        </div>

        <div class="social-links mt-5">
            <a href="#" class="social-btn">Instagram</a>
            <a href="#" class="social-btn">Facebook</a>
            <a href="#" class="social-btn">Twitter</a>
        </div>
    </div>
</section>

<!-- Newsletter Section - Converse Style -->
<section class="newsletter-section py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="section-title mb-3">Never Miss a Beat</h2>
                <p class="lead text-muted">Be the first to hear about product launches, collaborations, and more when you sign up for our emails.</p>
            </div>
            <div class="col-lg-6">
                <form class="newsletter-form">
                    <div class="input-group input-group-lg">
                        <input type="email" class="form-control" placeholder="Enter your email" required>
                        <button class="btn btn-dark fw-bold" type="submit">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="benefits-section py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="benefit-card text-center">
                    <div class="benefit-icon">🚚</div>
                    <h4>Fast, Free Shipping</h4>
                    <p class="text-muted small">Free Shipping on every order nationwide</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="benefit-card text-center">
                    <div class="benefit-icon">↩️</div>
                    <h4>Worry-Free Returns</h4>
                    <p class="text-muted small">Easy returns within 30 days</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="benefit-card text-center">
                    <div class="benefit-icon">💳</div>
                    <h4>Secure Payment</h4>
                    <p class="text-muted small">Multiple payment options available</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="benefit-card text-center">
                    <div class="benefit-icon">🛡️</div>
                    <h4>Authentic Guarantee</h4>
                    <p class="text-muted small">100% genuine products guaranteed</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Hero Section */
.converse-hero {
    margin-top: -56px;
    padding-top: 56px;
    background: #f5f5f5;
}

.hero-wrapper {
    position: relative;
    height: 600px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero-image {
    position: absolute;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 1;
}

.hero-placeholder {
    position: absolute;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #000 0%, #333 100%);
    color: white;
    z-index: 1;
}

.hero-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: white;
    z-index: 2;
    width: 90%;
    max-width: 600px;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 15px;
    line-height: 1.1;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.hero-subtitle {
    font-size: 1.3rem;
    margin-bottom: 30px;
    opacity: 0.95;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}

.hero-cta {
    display: inline-block;
    padding: 14px 40px;
    background: white;
    color: #000;
    text-decoration: none;
    font-weight: 600;
    border-radius: 3px;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.hero-cta:hover {
    background: #f0f0f0;
    transform: translateY(-2px);
}

/* Section Title */
.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0;
    letter-spacing: -0.5px;
}

/* Trending Styles Section */
.trending-styles {
    background: white;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.product-tile {
    cursor: pointer;
    transition: transform 0.3s ease;
}

.product-tile:hover {
    transform: translateY(-5px);
}

.product-link {
    text-decoration: none;
    color: inherit;
}

.product-image-wrapper {
    position: relative;
    background: #f5f5f5;
    overflow: hidden;
    height: 350px;
    margin-bottom: 15px;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.product-tile:hover .product-image {
    transform: scale(1.05);
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.3s ease;
}

.product-tile:hover .product-overlay {
    background: rgba(0, 0, 0, 0.3);
}

.product-overlay-text {
    color: white;
    font-size: 0.9rem;
    font-weight: 600;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-tile:hover .product-overlay-text {
    opacity: 1;
}

.product-info {
    text-align: center;
}

.product-name {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 8px;
    color: #000;
}

.product-category {
    font-size: 0.85rem;
    color: #999;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.product-price {
    font-size: 1.1rem;
    font-weight: 700;
    color: #000;
}

.view-all-btn {
    display: inline-block;
    padding: 12px 35px;
    background: #000;
    color: white;
    text-decoration: none;
    font-weight: 600;
    border-radius: 2px;
    transition: all 0.3s ease;
}

.view-all-btn:hover {
    background: #333;
}

/* Categories Section */
.shop-categories {
    background: white;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 20px;
}

.category-tile {
    cursor: pointer;
    overflow: hidden;
    height: 400px;
}

.category-link {
    text-decoration: none;
    display: block;
    height: 100%;
}

.category-image-wrapper {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.category-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.category-tile:hover .category-image {
    transform: scale(1.08);
}

.category-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    top: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.5), rgba(0,0,0,0) 60%);
    display: flex;
    align-items: flex-end;
    padding: 30px 20px;
}

.category-name {
    color: white;
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0;
}

/* From Community Section */
.from-community {
    background: #f9f9f9;
}

.community-subtitle {
    font-size: 1.2rem;
    color: #666;
}

.community-card {
    padding: 30px;
    background: white;
    border-radius: 8px;
    transition: box-shadow 0.3s ease;
}

.community-card:hover {
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.community-icon {
    font-size: 3rem;
    margin-bottom: 15px;
}

.community-card h4 {
    font-weight: 600;
    margin-bottom: 10px;
}

.social-links {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.social-btn {
    display: inline-block;
    padding: 10px 25px;
    background: #000;
    color: white;
    text-decoration: none;
    border-radius: 2px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.social-btn:hover {
    background: #333;
    transform: translateY(-2px);
}

/* Newsletter Section */
.newsletter-form {
    display: flex;
    gap: 10px;
}

.newsletter-form .form-control {
    border: 1px solid #ddd;
}

/* Benefits Section */
.benefit-card {
    padding: 30px;
    background: white;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.benefit-card:hover {
    transform: translateY(-5px);
}

.benefit-icon {
    font-size: 2.5rem;
    margin-bottom: 15px;
}

.benefit-card h4 {
    font-weight: 600;
    margin-bottom: 10px;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.2rem;
    }

    .hero-subtitle {
        font-size: 1rem;
    }

    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }

    .categories-grid {
        grid-template-columns: 1fr;
    }

    .section-title {
        font-size: 1.8rem;
    }

    .newsletter-form {
        flex-direction: column;
    }
}
</style>

@endsection
