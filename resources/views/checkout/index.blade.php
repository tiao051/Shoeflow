@extends('layouts.app')

@section('title', 'Checkout - Shoeler')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Checkout</h2>

    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf

                <!-- Shipping Information -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Shipping Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Recipient Name *</label>
                            <input type="text" name="recipient_name" class="form-control @error('recipient_name') is-invalid @enderror" 
                                   value="{{ old('recipient_name', auth()->user()->name) }}" required>
                            @error('recipient_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone Number *</label>
                            <input type="tel" name="recipient_phone" class="form-control @error('recipient_phone') is-invalid @enderror" 
                                   value="{{ old('recipient_phone', auth()->user()->phone) }}" required>
                            @error('recipient_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Shipping Address *</label>
                            <textarea name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" 
                                      rows="3" required>{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Payment Method *</label>
                            <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
                                <option value="cod" {{ old('payment_method') == 'cod' ? 'selected' : '' }}>Cash on Delivery (COD)</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                <option value="e_wallet" {{ old('payment_method') == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Order Notes (Optional)</label>
                            <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100">Place Order</button>
            </form>
        </div>

        <div class="col-md-4">
            <!-- Order Summary -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    @foreach($cart as $item)
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $item['shoe_name'] }} ({{ $item['size'] }}) x{{ $item['quantity'] }}</span>
                        <span>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>Rp {{ number_format($orderCalculation['subtotal'], 0, ',', '.') }}</span>
                    </div>
                    @if($orderCalculation['discount'] > 0)
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>Discount:</span>
                        <span>-Rp {{ number_format($orderCalculation['discount'], 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax (11%):</span>
                        <span>Rp {{ number_format($orderCalculation['tax'], 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping:</span>
                        <span>Rp {{ number_format($orderCalculation['shipping_fee'], 0, ',', '.') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong>Rp {{ number_format($orderCalculation['total'], 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>

            <!-- Promo Code -->
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('checkout.apply-promotion') }}" method="POST">
                        @csrf
                        <label class="form-label">Have a promo code?</label>
                        <div class="input-group">
                            <input type="text" name="promo_code" class="form-control" placeholder="Enter code">
                            <button type="submit" class="btn btn-outline-primary">Apply</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
