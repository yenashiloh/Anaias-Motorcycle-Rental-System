<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Motorcycle;
use App\Models\Payment;
use App\Models\DriverInformation;
use App\Models\Notification;

class CustomerDashboardController extends Controller
{
    //view customer dashboard page
    public function viewDashboard()
    {
        $isCustomerLoggedIn = Auth::guard('customer')->check();
        
        $customerEmail = null;
        $reservations = collect();
        $notifications = [];

        if ($isCustomerLoggedIn) {
            $customer = Auth::guard('customer')->user();
            $customerEmail = $customer->email;
            
            $reservations = Reservation::where('customer_id', $customer->customer_id)
                ->with(['motorcycle', 'driverInformation', 'payment']) 
                ->orderBy('created_at', 'desc')
                ->get();

            $notifications = Notification::where('customer_id', $customer->id)
                ->orderBy('created_at', 'desc')
                ->get(['id', 'type', 'message', 'read', 'created_at', 'updated_at']);
        }

        return view('customer.customer-dashboard', compact('isCustomerLoggedIn', 'customerEmail', 'reservations', 'notifications'));
    }
}
