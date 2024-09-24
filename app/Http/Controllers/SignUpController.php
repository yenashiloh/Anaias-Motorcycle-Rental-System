<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class SignUpController extends Controller
{
    //show registration page
    public function showSignUpForm()
    {
        return view('sign-up'); 
    }

    //store data in registration
    // public function storeRegistration(Request $request)
    // {    
    //     $validator = Validator::make($request->all(), [
    //         'first_name' => 'required|string|max:255',
    //         'last_name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:customers,email',
    //         'address' => 'required|string',
    //         'birthdate' => 'required|date',
    //         'gender' => 'required|in:male,female',
    //         'contact_number' => 'required|string|max:11',
    //         'driver_license' => 'required|file|mimes:jpeg,png,pdf|max:2048',
    //         'password' => 'required|string|min:8|confirmed',
    //         'password_confirmation' => 'required|string|min:8|same:password',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     $filePath = $request->file('driver_license')->store('public/driver_licenses');

    //     $customer = Customer::create([
    //         'first_name' => $request->input('first_name'),
    //         'last_name' => $request->input('last_name'),
    //         'email' => $request->input('email'),
    //         'address' => $request->input('address'),
    //         'birthdate' => $request->input('birthdate'),
    //         'gender' => $request->input('gender'),
    //         'contact_number' => $request->input('contact_number'),
    //         'driver_license' => $filePath,
    //         'password' => Hash::make($request->input('password')),
    //         'otp' => $this->generateOTP(),
    //     ]);

    //     $this->sendOTPEmail($customer);

    //     return redirect()->route('email.otp')->with('email', $customer->email);
    // }

    public function storeRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $customer = Customer::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'otp' => $this->generateOTP(),
        ]);

        $this->sendOTPEmail($customer);

        return redirect()->route('email.otp')->with('email', $customer->email);
    }


    //show otp page
    public function showOtp(Request $request)
    {
        $email = $request->session()->get('email');
        if (!$email) {
            return redirect()->route('sign-up')->withErrors(['email' => 'Email not found. Please register again.']);
        }
        return view('email.otp', ['email' => $email]);
    }

    //generate otp
    private function generateOTP()
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    //verify otp
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return redirect()->route('email.otp')
                ->withErrors($validator)
                ->withInput()
                ->with('email', $request->email);
        }

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer || $customer->otp !== $request->otp) {
            return redirect()->route('email.otp')
                ->withErrors(['otp' => 'Invalid OTP'])
                ->with('email', $request->email);
        }

        $customer->email_verified_at = now();
        $customer->otp = null;
        $customer->save();

        return redirect()->route('success-verification')->with('success', 'Email verified successfully. You can now log in.');
    }

    //resend otp email
    public function resendOtp(Request $request)
    {
        $customer = Customer::where('email', $request->email)->first();

        if ($customer) {
            $customer->otp = $this->generateOTP();
            $customer->save();
            $this->sendOTPEmail($customer);
        }

        return redirect()->route('email.otp')
            ->with('success', 'OTP resent successfully.')
            ->with('email', $request->email);
    }

    //send otp email
    private function sendOTPEmail($customer)
    {
        Mail::send('email.otp-email-send', [
            'otp' => $customer->otp,
            'first_name' => $customer->first_name
        ], function ($message) use ($customer) {
            $message->to($customer->email)->subject('OTP for Registration');
        });
    }

    //check success verification
    public function successVerification()
    {
        return view('success-verification'); 
    }

    //show login page
    public function showLoginCustomer()
    {
        return view('login');
    }

    public function loginCustomer(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
    
        if (Auth::guard('customer')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
    
            return redirect()->intended('/');
        }
    
        return back()->with('error', 'Email and password do not match. Please try again.');
    }

    public function logoutCustomer(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
