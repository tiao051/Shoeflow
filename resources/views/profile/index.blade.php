@extends('layouts.app')

@section('title', 'My Profile - Shoeler')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">My Profile</h2>

    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="{{ route('profile.index') }}" class="list-group-item list-group-item-action active">
                    <i class="bi bi-person"></i> Profile
                </a>
                <a href="{{ route('profile.orders') }}" class="list-group-item list-group-item-action">
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
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Profile Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
