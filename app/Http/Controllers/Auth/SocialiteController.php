<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Http\Request;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                Auth::login($user);
            } else {
                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(), 
                    'password' => \Hash::make(\Str::random(16)), 
                    'role_id' => 2, 
                ]);
                
                Auth::login($newUser);
            }

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['google_error' => 'Could not login with Google: ' . $e->getMessage()]);
        }
    }
}