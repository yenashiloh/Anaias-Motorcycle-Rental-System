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
use App\Models\NotificationAdmin;
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
                ->get()
                ->map(function ($reservation) {
                    $reservation->displayStatus = $this->normalizeReservationStatus($reservation);
                    return $reservation;
                });
    
            $notifications = Notification::where('customer_id', $customer->id)
                ->orderBy('created_at', 'desc')
                ->get(['id', 'type', 'message', 'read', 'created_at', 'updated_at']);
        }
    
        return view('customer.customer-dashboard', compact('isCustomerLoggedIn', 'customerEmail', 'reservations', 'notifications'));
    }
    
    //normalize status
    public function normalizeReservationStatus($reservation)
    {
        $statusMap = [
            'to_review' => 'To Review', 
            'approved' => 'Approved',
            'declined' => 'Declined',
            'ongoing' => 'Ongoing',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];

        return $statusMap[strtolower($reservation->status)] ?? 'Unknown Status'; 
    }

    //cancel reservation
    public function cancelReservation(Request $request, $reservation_id)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:500'
        ]);

        try {
            $reservation = Reservation::findOrFail($reservation_id);

            $customer = Auth::guard('customer')->user();
            if ($reservation->customer_id !== $customer->customer_id) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Unauthorized to cancel this reservation.'
                ], 403);
            }

            if (in_array($reservation->status, ['Cancelled', 'Completed'])) {
                return response()->json([
                    'success' => false, 
                    'message' => 'This reservation cannot be cancelled.'
                ], 400);
            }

            $reservation->cancelReservation($request->cancel_reason);

            $driver = $reservation->driverInformation;

            $driverName = $driver ? $driver->first_name . ' ' . $driver->last_name : 'Unknown Driver';

            NotificationAdmin::create([
                'customer_id' => $customer->customer_id,
                'reservation_id' => $reservation->reservation_id,
                'type' => 'Reservation Cancelled',
                'message' => $driverName . ' cancelled the reservation.',
                'read' => false,  
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reservation Cancelled Successfully!'
            ]);            

        } catch (\Exception $e) {
            Log::error('Reservation Cancellation Error: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'An error occurred while cancelling the reservation.'
            ], 500);
        }
    }
}
