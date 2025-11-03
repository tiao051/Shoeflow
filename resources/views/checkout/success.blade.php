@extends('layouts.app')

@section('title', 'Order Success - Shoeler')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-4">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                <h2 class="mt-3">Order Placed Successfully!</h2>
                <p class="text-muted">Thank you for your purchase. Your order has been received and is being processed.</p>
            </div>

            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Order Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Order Number:</strong>
                        </div>
                        <div class="col-6">
                            {{ $order['order_number'] }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Order Date:</strong>
                        </div>
                        <div class="col-6">
                            {{ date('M d, Y H:i', strtotime($order['created_at'])) }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Payment Method:</strong>
                        </div>
                        <div class="col-6">
                            {{ ucwords(str_replace('_', ' ', $order['payment_method'])) }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Total Amount:</strong>
                        </div>
                        <div class="col-6">
                            <strong>Rp {{ number_format($order['total'], 0, ',', '.') }}</strong>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <strong>Shipping Address:</strong>
                            <p class="mb-0 mt-2">
                                {{ $order['recipient_name'] }}<br>
                                {{ $order['recipient_phone'] }}<br>
                                {{ $order['shipping_address'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('profile.orders') }}" class="btn btn-primary me-2">View My Orders</a>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">Continue Shopping</a>
            </div>
        </div>
    </div>
</div>
@endsection
