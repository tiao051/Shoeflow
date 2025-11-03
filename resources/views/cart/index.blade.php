@extends('layouts.app')

@section('title', 'Shopping Cart - Shoeler')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Shopping Cart</h2>

    @if(empty($cart))
    <div class="text-center py-5">
        <i class="bi bi-cart-x display-1 text-muted"></i>
        <h4 class="mt-3">Your cart is empty</h4>
        <a href="{{ route('shoes.index') }}" class="btn btn-primary mt-3">Continue Shopping</a>
    </div>
    @else
    <div class="row">
        <div class="col-md-8">
            @foreach($cart as $key => $item)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <img src="{{ $item['shoe_image'] ? asset('storage/' . $item['shoe_image']) : 'https://via.placeholder.com/100' }}" 
                                 class="img-fluid rounded" alt="{{ $item['shoe_name'] }}">
                        </div>
                        <div class="col-md-4">
                            <h6>{{ $item['shoe_name'] }}</h6>
                            <p class="text-muted mb-0">Size: {{ $item['size'] }}</p>
                        </div>
                        <div class="col-md-2">
                            <p class="mb-0 fw-bold">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-2">
                            <form action="{{ route('cart.update', $key) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="input-group input-group-sm">
                                    <input type="number" name="quantity" class="form-control" value="{{ $item['quantity'] }}" min="1">
                                    <button type="submit" class="btn btn-outline-secondary">Update</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2 text-end">
                            <p class="mb-2 fw-bold">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                            <form action="{{ route('cart.remove', $key) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 mb-2">Proceed to Checkout</a>
                    <a href="{{ route('shoes.index') }}" class="btn btn-outline-secondary w-100">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
