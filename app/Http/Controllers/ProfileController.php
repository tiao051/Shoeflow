<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Xem profile
    public function show()
    {
        $user = Auth::user();
        $orders = $user->orders()->limit(5)->get();

        return view('profile.profile', compact('user', 'orders'));
    }

    // Cập nhật profile
    public function update(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string',
            'bio' => 'nullable|string',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? $user->phone,
            'bio' => $validated['bio'] ?? $user->bio,
        ]);

        return redirect()->back()->with('success', 'Hồ sơ đã được cập nhật');
    }

    // Thay đổi mật khẩu
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Auth::user()->update([
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->back()->with('success', 'Mật khẩu đã được thay đổi');
    }

    // Tải ảnh đại diện
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            Auth::user()->update(['avatar' => $path]);
            return redirect()->back()->with('success', 'Ảnh đã được cập nhật');
        }

        return redirect()->back();
    }
}