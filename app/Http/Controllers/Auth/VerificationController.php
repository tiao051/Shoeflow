<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Mail\VerificationCodeMail; 
use App\Http\Controllers\Controller;
use App\Models\User;

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
        $cachedCode = Cache::get('verification_code_' . $email);

        // 2. Compare
        if ($cachedCode && $submittedCode == $cachedCode) {

            Cache::forget('verification_code_' . $email);
            $user = User::where('email', $email)->first();

            // 3. Update user status if found
            if ($user) {
                // Update status
                $user->is_verified = true;
                $user->save();

                // If AJAX, return success JSON
                if ($request->expectsJson()) {
                    return response()->json([
                        'status' => 200, 
                        'message' => $successMessage,
                    ]);
                }

                // If not AJAX, redirect to Dashboard
                return redirect()->route('dashboard')->with('success', $successMessage);
            }
            
            // Case where code is correct but user NOT found
            // If AJAX, return error (e.g., 404 Not Found)
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Verification successful, but user not found. Please log in.'
                ], 404);
            }

            // If not AJAX, redirect to Login
            return redirect()->route('login')->with('error', 'User not found. Please try logging in.');


        } else {
            // Case where code is incorrect or expired
            $errorMessage = 'Invalid or expired verification code.';

            // If AJAX, return error JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 422,
                    'message' => $errorMessage
                ], 422);
            }

            // If not AJAX, redirect back with errors
            return back()
                ->withErrors(['code' => $errorMessage])
                ->withInput();
        }
    }
}
