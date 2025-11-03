@extends('layouts.app')

@section('title', 'My Orders - Shoeler')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">My Orders</h2>

    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="{{ route('profile.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-person"></i> Profile
                </a>
                <a href="{{ route('profile.orders') }}" class="list-group-item list-group-item-action active">
                    <i class="bi bi-receipt"></i> Orders
                </a>
                <a href="{{ route('profile.addresses') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-geo-alt"></i> Addresses
                </a>
                <a href="{{ route('profile.reviews') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-star"></i> Reviews
                </a>
            </div>
        </div>

        <div class="col-md-9">
            @forelse($orders['data'] as $order)
            <div class="card mb-3">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <strong>Order #{{ $order->order_number }}</strong>
                        </div>
                        <div class="col-md-6 text-end">
                            <span class="badge bg-{{ $order->status_badge }}">{{ ucfirst($order->status) }}</span>
                            <span class="badge bg-{{ $order->payment_status_badge }}">{{ ucfirst($order->payment_status) }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <p class="mb-1"><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                            <p class="mb-1"><strong>Total:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                            <p class="mb-1"><strong>Items:</strong> {{ $order->items->count() }} item(s)</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('profile.order-detail', $order->order_number) }}" class="btn btn-outline-primary">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-receipt display-1 text-muted"></i>
                    <h5 class="mt-3">No orders yet</h5>
                    <p class="text-muted">Start shopping to see your orders here!</p>
                    <a href="{{ route('shoes.index') }}" class="btn btn-primary mt-2">Shop Now</a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
