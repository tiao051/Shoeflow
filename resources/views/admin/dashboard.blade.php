@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<h2 class="mb-4">Dashboard</h2>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Orders</h5>
                <h2 class="mb-0">{{ $statistics['total_orders'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Total Revenue</h5>
                <h2 class="mb-0">Rp {{ number_format($statistics['total_revenue'], 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Pending Orders</h5>
                <h2 class="mb-0">{{ $statistics['pending_orders'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <h2 class="mb-0">{{ $totalUsers }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Recent Orders</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders['data'] as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td><span class="badge bg-{{ $order->status_badge }}">{{ ucfirst($order->status) }}</span></td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No orders yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
