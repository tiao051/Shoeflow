<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role_id', '!=', 2)
                    ->withCount('orders')
                    ->latest();

        if ($search = $request->search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->paginate(10)->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = User::with(['orders' => function($q) {
            $q->latest(); 
        }, 'addresses'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'customer' => $customer
        ]);
    }

    public function update(Request $request, $id)
    {
        $customer = User::findOrFail($id);
        
        if ($customer->role_id == 2) {
            return response()->json(['success' => false, 'message' => 'Cannot block admin!'], 403);
        }

        $customer->is_active = !$customer->is_active;
        $customer->save();

        $status = $customer->is_active ? 'activated' : 'blocked';

        return response()->json([
            'success' => true,
            'message' => "Customer has been $status!",
            'is_active' => $customer->is_active
        ]);
    }
}