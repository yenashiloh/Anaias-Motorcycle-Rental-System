<?php

namespace App\Http\Controllers;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\DriverInformation;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Motorcycle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class UsersController extends Controller
{
    public function showUsersPage()
    {
        // Check if the admin is authenticated
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.admin-login');
        }
    
        // Get the authenticated admin user
        $admin = Auth::guard('admin')->user();
    
        // Retrieve all customers
        $customers = Customer::all();
    
        // Pass the data to the view
        return view('admin.user-management.users', compact('admin', 'customers'));
    }
    
}
