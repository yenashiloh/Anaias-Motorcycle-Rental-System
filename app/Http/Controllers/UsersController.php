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
    //users list
    public function showUsersPage()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.admin-login');
        }
    
        $admin = Auth::guard('admin')->user();
    
        $customers = Customer::all();
    
        return view('admin.user-management.users', compact('admin', 'customers'));
    }
    
}
