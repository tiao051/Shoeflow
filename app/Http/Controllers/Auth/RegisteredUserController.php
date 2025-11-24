<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validate dữ liệu đầu vào
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['nullable', 'string', 'max:15'], // Thêm validate số điện thoại
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Tạo User mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone ?? null, // Lưu số điện thoại (nếu có)
            'password' => Hash::make($request->password),
            
            // LƯU Ý QUAN TRỌNG: 
            // role_id = 1 thường là Admin. 
            // Nếu đây là khách hàng mua giày, bạn nên để role_id = 2 (hoặc ID tương ứng với role Customer trong DB của bạn)
            'role_id' => 2, 
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Chuyển hướng về trang Dashboard hoặc Trang chủ sau khi đăng ký
        return redirect(route('dashboard', absolute: false));
    }
}