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
        // Check if customer is logged in
        $isCustomerLoggedIn = Auth::guard('customer')->check();
        
        // Initialize variables
        $customerEmail = null;
        $reservations = collect(); // Empty collection by default
        
        // If customer is logged in
        if ($isCustomerLoggedIn) {
            $customer = Auth::guard('customer')->user();
            $customerEmail = $customer->email;
            
            // Retrieve reservations for the logged-in customer
            $reservations = Reservation::where('customer_id', $customer->customer_id)
                ->with(['motorcycle', 'driverInformation']) // Eager load related models
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        // Pass both customer info and reservations to the view
        return view('customer.customer-dashboard', compact('isCustomerLoggedIn', 'customerEmail', 'reservations'));
    }
    
}
