@extends('layouts.app')

@section('title', 'Trang chủ - Converse Vietnam')

@section('content')
    <section class="hero-section text-center text-white d-flex align-items-center justify-content-center" 
             style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); min-height: 500px; padding: 0 20px;">
        <div class="content">
            <h1 class="display-1 fw-bold" style="font-family: 'Oswald', sans-serif; letter-spacing: 3px;">CHUCK TAYLOR</h1>
            <p class="fs-4 mb-4 fw-light">ICONIC STYLE. TIMELESS COMFORT.</p>
            <a href="{{ url('/products') }}" class="btn btn-light rounded-0 px-5 py-3 fw-bold text-uppercase">Shop Now</a>
        </div>
    </section>

    <div class="container my-5">
        <section class="mb-5">
            <h2 class="text-center mb-5 fw-bold text-uppercase" style="font-family: 'Oswald', sans-serif; font-size: 2.5rem;">Shop By Category</h2>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 rounded-0 shadow-sm h-100">
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                            <span style="font-size: 4rem;">👟</span>
                        </div>
                        <div class="card-body text-center">
                            <h3 class="fw-bold text-uppercase">Chuck Taylor</h3>
                            <p class="text-muted">Classic high tops & low tops</p>
                        </div>
                        <a href="#" class="stretched-link"></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 rounded-0 shadow-sm h-100">
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                            <span style="font-size: 4rem;">⭐</span>
                        </div>
                        <div class="card-body text-center">
                            <h3 class="fw-bold text-uppercase">One Star</h3>
                            <p class="text-muted">Retro basketball style</p>
                        </div>
                        <a href="#" class="stretched-link"></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 rounded-0 shadow-sm h-100">
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                            <span style="font-size: 4rem;">🏀</span>
                        </div>
                        <div class="card-body text-center">
                            <h3 class="fw-bold text-uppercase">All Star</h3>
                            <p class="text-muted">Heritage basketball sneakers</p>
                        </div>
                        <a href="#" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-5">
            <h2 class="text-center mb-5 fw-bold text-uppercase" style="font-family: 'Oswald', sans-serif; font-size: 2.5rem;">New Arrivals</h2>
            <div class="row g-4">
                @for($i = 0; $i < 4; $i++)
                <div class="col-6 col-md-3">
                    <div class="card border-0 rounded-0">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1607522370275-f14206c14896?q=80&w=800&auto=format&fit=crop" class="card-img-top rounded-0" alt="">
                            <span class="position-absolute top-0 start-0 bg-dark text-white px-2 py-1 fw-bold" style="font-size: 0.8rem;">NEW</span>
                        </div>
                        <div class="card-body px-0 pt-3">
                            <h5 class="card-title fw-bold text-uppercase mb-1" style="font-size: 1rem;">Chuck 70 High Top</h5>
                            <p class="text-muted small mb-2">Classic Black</p>
                            <p class="fw-bold">1,890,000 ₫</p>
                            <a href="#" class="btn btn-outline-dark rounded-0 w-100 text-uppercase fw-bold" style="font-size: 0.8rem;">Add to Cart</a>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </section>

        <section class="bg-black text-white text-center py-5 mb-5 px-3">
            <h2 class="fw-bold text-uppercase mb-3" style="font-family: 'Oswald', sans-serif;">Custom Your Style</h2>
            <p class="mb-4 text-white-50 fs-5">Design your own unique Converse sneakers.</p>
            <button class="btn btn-light rounded-0 px-5 py-3 fw-bold text-uppercase">Start Customizing</button>
        </section>

        <section class="text-center py-5" style="background-color: #f8f9fa;">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h2 class="fw-bold text-uppercase mb-2" style="font-family: 'Oswald', sans-serif;">Stay In The Loop</h2>
                    <p class="text-muted mb-4">Subscribe to get special offers and updates.</p>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control rounded-0 p-3" placeholder="Enter your email address">
                        <button class="btn btn-dark rounded-0 px-4 fw-bold text-uppercase" type="button">Subscribe</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection