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
        $reservations = collect();
        
        if ($isCustomerLoggedIn) {
            $customer = Auth::guard('customer')->user();
            $customerEmail = $customer->email;
            
            $reservations = Reservation::where('customer_id', $customer->customer_id)
                ->with(['motorcycle', 'driverInformation', 'payment']) 
                ->orderBy('created_at', 'desc')
                ->get();
        }
    
        return view('customer.customer-dashboard', compact('isCustomerLoggedIn', 'customerEmail', 'reservations'));
    }
}
