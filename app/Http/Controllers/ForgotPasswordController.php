<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('forgot-password');
    }

    // Handle forgot password form submission
    public function sendResetLink(Request $request)
    {
        // Validate email
        $request->validate([
            'email' => 'required|email|exists:customers,email',
        ]);
    
        // Specify the broker for customers
        $status = Password::broker('customers')->sendResetLink(
            $request->only('email')
        );
    
        // Redirect back with appropriate status message
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
    public function showResetPasswordForm(Request $request)
    {
        return view('reset-password', [
            'token' => $request->route('token'),
            'email' => $request->email
        ]);
    }

    public function resetPassword(Request $request)
    {
        try {
            // Validate the form data
            $request->validate([
                'email' => 'required|email|exists:customers,email',
                'password' => 'required|confirmed|min:8',
                'token' => 'required'
            ]);

            // Reset the password
            $status = Password::broker('customers')->reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($customer) use ($request) {
                    $customer->forceFill([
                        'password' => bcrypt($request->password)
                    ])->save();
                }
            );

            // Pass the success message under 'success' key
            return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('success', 'Password reset successfully! You can now log in.')
                : back()->withErrors(['email' => __($status)]);

        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'An unexpected error occurred. Please try again.']);
        }
    }

}