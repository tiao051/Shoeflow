<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'    => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'address_line' => 'required|string|max:255',
            'city'         => 'required|string|max:100',
            'district'     => 'required|string|max:100',
            'ward'         => 'nullable|string|max:100',
            'is_default'   => 'sometimes|boolean',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_default'] = $request->has('is_default');

        $address = Address::create($validated);

        // If this is an AJAX request, return JSON for JS to handle
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Address added successfully!',
                'address' => $address
            ]);
        }

        return redirect()->route('profile.index', ['tab' => 'addresses'])
                         ->with('success', 'Address added successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $address = Address::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($address->is_default) {
            $msg = 'You cannot delete your default address.';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return back()->withErrors(['msg' => $msg]);
        }

        $address->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Address deleted successfully.']);
        }

        return redirect()->route('profile.index', ['tab' => 'addresses'])
                         ->with('success', 'Address removed successfully.');
    }

    public function setDefault(Request $request, $id)
    {
        $address = Address::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $address->update(['is_default' => true]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Default address updated.']);
        }

        return redirect()->route('profile.index', ['tab' => 'addresses'])
                         ->with('success', 'Default shipping address updated.');
    }

    public function update(Request $request, $id)
    {
        $address = Address::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'full_name'    => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'address_line' => 'required|string|max:255',
            'city'         => 'required|string|max:100',
            'district'     => 'required|string|max:100',
            'ward'         => 'nullable|string|max:100',
            'is_default'   => 'sometimes|boolean',
        ]);

        $validated['is_default'] = $request->has('is_default');

        $address->update($validated); 

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Address updated!']);
        }

        return back()->with('success', 'Address updated successfully!');
    }
}