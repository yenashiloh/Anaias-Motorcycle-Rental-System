<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Motorcycle;
use App\Models\Payment;
use App\Models\DriverInformation;

class CustomerDashboardController extends Controller
{
    //view customer dashboard page
    public function viewDashboard()
    {
        $isCustomerLoggedIn = Auth::guard('customer')->check();
        $customerEmail = null;
    
        if ($isCustomerLoggedIn) {
            $customer = Auth::guard('customer')->user();
            $customerEmail = $customer->email; 
        }
    
        return view('customer.customer-dashboard', compact('isCustomerLoggedIn', 'customerEmail'));
    }
    
}
