<?php

namespace App\Http\Controllers;
//namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Motorcycle;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminLoginController extends Controller
{
    //show login page
    public function home()
    {
        $motorcycles = Motorcycle::all();

        return view('welcome', compact('motorcycles'));
    }

    public function showLoginForm()
    {
        return view('admin.admin-login');
    }

    //store login
    public function loginDashboard(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('admin-dashboard');
        }

        return back()->withErrors([
            'email' => 'Incorrect Username or password',
        ]);
    }

    //logout
    public function logoutAdmin(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['success' => true]); 
    }
    



}
