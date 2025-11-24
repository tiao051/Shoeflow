<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use App\Mail\VerificationCodeMail;

class ForgotPasswordController extends Controller
{
    // Bước 1: Gửi Code (AJAX)
    public function sendResetCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['errors' => ['email' => ['We can\'t find a user with that email address.']]], 422);
        }

        $code = random_int(100000, 999999);
        Cache::put('reset_password_code_' . $request->email, $code, now()->addMinutes(10));

        try {
            Mail::to($request->email)->send(new VerificationCodeMail($code));
            return response()->json(['message' => 'Code sent successfully!']);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['email' => ['Unable to send email.']]], 500);
        }
    }

    // Bước 2: Verify Code (AJAX)
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6'
        ]);

        $cachedCode = Cache::get('reset_password_code_' . $request->email);

        if ($cachedCode && $request->code == $cachedCode) {
            // Code đúng -> Xóa cache code cũ, tạo token tạm để cho phép đổi pass
            Cache::forget('reset_password_code_' . $request->email);
            // Tạo một token tạm trong cache để bước 3 check (tránh user nhảy cóc)
            Cache::put('allow_reset_' . $request->email, true, now()->addMinutes(5));

            return response()->json(['message' => 'Code verified!']);
        }

        return response()->json(['errors' => ['code' => ['Invalid or expired verification code.']]], 422);
    }

    // Bước 3: Đổi mật khẩu (AJAX)
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Check xem đã pass bước 2 chưa
        if (!Cache::get('allow_reset_' . $request->email)) {
             return response()->json(['errors' => ['global' => ['Session expired. Please start over.']]], 403);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
            Cache::forget('allow_reset_' . $request->email); // Xóa token

            return response()->json(['message' => 'Password reset successfully!']);
        }

        return response()->json(['errors' => ['email' => ['User not found.']]], 422);
    }
}