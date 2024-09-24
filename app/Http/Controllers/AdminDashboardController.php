<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Motorcycle;

class AdminDashboardController extends Controller
{
    //show dashboard
    public function showAdminDashboard()
    {
        $admin = Auth::guard('admin')->user(); 
        $customerCount = Customer::count(); 
        $motorcycleCount = Motorcycle::count();
        return view('admin.admin-dashboard', compact('admin', 'customerCount', 'motorcycleCount'));
    }

}
