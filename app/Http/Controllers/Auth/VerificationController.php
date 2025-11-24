<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Mail\VerificationCodeMail; 
use App\Http\Controllers\Controller;

class VerificationController extends Controller
{
    /**
     * Receive email from form, generate a 6-digit code, and send it via email.
     */
    public function sendCode(Request $request)
    {
        // 1. Validate
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');
        $code = random_int(100000, 999999);

        Cache::put('verification_code_' . $email, $code, now()->addMinutes(5));

        try {
            // 2. Send Email
            Mail::to($email)->send(new VerificationCodeMail($code));

            // AJAX success response
            if ($request->expectsJson()) {
                return response()->json([
                    'status'  => 200,
                    'message' => 'The verification code has been sent. Please check your email.'
                ], 200);
            }

            return back()->with('success', 'The verification code has been sent to: ' . $email);

        } catch (\Exception $e) {

            // AJAX error response
            if ($request->expectsJson()) {
                return response()->json([
                    'status'  => 500,
                    'message' => 'Unable to send email. Please try again later. Error: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error: Unable to send email.');
        }
    }

    /**
     * Verify the code submitted by the user.
     */
    public function verifyCode(Request $request)
    {
        // 1. Validate Email + Code
        $request->validate([
            'email' => 'required|email|max:255',
            'code'  => 'required|digits:6',
        ]);

        $email = $request->input('email');
        $submittedCode = $request->input('code');

        // 2. Get code from cache
        $cachedCode = Cache::get('verification_code_' . $email);

        // 3. Compare
        if ($cachedCode && $submittedCode == $cachedCode) {

            Cache::forget('verification_code_' . $email);

            // --- SUCCESS LOGIC HERE ---
            // Example: Save user subscription, create record, etc.

            return redirect()->route('home')
                ->with('success', 'Verification successful! Thank you for signing up.');

        } else {
            return back()
                ->withErrors(['code' => 'Invalid or expired verification code.'])
                ->withInput();
        }
    }
}
