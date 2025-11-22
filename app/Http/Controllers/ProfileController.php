<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Display the user profile
    public function show()
    {
        $user = Auth::user();
        $orders = $user->orders()->limit(5)->get();

        return view('profile.profile', compact('user', 'orders'));
    }

    // Update the user profile details
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

        return redirect()->back()->with('success', 'Profile has been updated.');
    }

    // Update the user's password
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Auth::user()->update([
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->back()->with('success', 'Password has been changed successfully.');
    }

    // Upload and update the user's avatar
    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        // 1. Validate the uploaded file
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);

        // 2. Delete the old avatar (if one exists)
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // 3. Store the new file in the 'avatars' directory on the 'public' disk
        $path = $request->file('avatar')->store('avatars', 'public');

        // 4. Update the new avatar path in the database
        $user->avatar = $path;
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Your profile picture has been updated successfully!');
    }
}