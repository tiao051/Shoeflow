@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>My Addresses</h2>
            
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                + Add New Address
            </button>

            @if($addresses->isEmpty())
                <div class="alert alert-info">
                    No addresses saved yet. <a href="#" data-bs-toggle="modal" data-bs-target="#addAddressModal">Add one now</a>
                </div>
            @else
                <div class="row">
                    @foreach($addresses as $address)
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $address->label }}</h5>
                                <p class="card-text">
                                    <strong>{{ $address->recipient_name }}</strong><br>
                                    {{ $address->address_line }}<br>
                                    {{ $address->city }}, {{ $address->state }}<br>
                                    {{ $address->phone }}
                                </p>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAddressModal{{ $address->id }}">Edit</button>
                                <form action="{{ route('profile.destroyAddress', $address) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this address?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('profile.storeAddress') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Label (e.g., Home, Office)</label>
                        <input type="text" name="label" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Recipient Name</label>
                        <input type="text" name="recipient_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address_line" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">State/Province</label>
                        <input type="text" name="state" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Address</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
