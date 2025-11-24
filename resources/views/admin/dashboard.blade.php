@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')
    <h1 class="text-2xl font-black text-gray-900 mb-6">Dashboard Overview</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-xs font-semibold text-gray-500 uppercase">Total Users</p>
            <h3 class="text-2xl font-black text-gray-900 mt-1">1 User</h3>
            <p class="text-xs text-green-600 mt-2 font-bold">System Online</p>
        </div>
    </div>
@endsection