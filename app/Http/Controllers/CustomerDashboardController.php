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
use Illuminate\Support\Facades\Log;

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


    public function cancelReservation(Request $request, $reservationId)
{
    // Get the logged-in customer
    $customer = Auth::guard('customer')->user();
    if (!$customer) {
        return redirect()->back()->with('error', 'Please log in to cancel a reservation.');
    }

    // Find the reservation
    $reservation = Reservation::where('customer_id', $customer->customer_id)
        ->where('reservation_id', $reservationId)
        ->first();

    // Validate reservation
    if (!$reservation) {
        return redirect()->back()->with('error', 'Reservation not found.');
    }

    // Check if cancellable
    if (!in_array($reservation->status, ['Pending', 'Confirmed'])) {
        return redirect()->back()->with('error', 'This reservation cannot be cancelled.');
    }

    // Get cancellation reason
    $cancelReason = $request->input('cancel_reason');
    if (empty($cancelReason)) {
        return redirect()->back()->with('error', 'Cancellation reason is required.');
    }

    // Update reservation
    $reservation->update([
        'status' => 'Cancelled',
        'cancel_reason' => $cancelReason
    ]);

    // Return to dashboard
    return redirect()->route('customer.dashboard')
        ->with('success', 'Reservation successfully cancelled.');
}
}
