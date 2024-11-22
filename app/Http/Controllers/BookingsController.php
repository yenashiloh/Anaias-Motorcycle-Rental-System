<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\DriverInformation;
use App\Models\Admin;
use App\Models\Motorcycle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use PDF;


class BookingsController extends Controller
{
    //show bookings management
    public function showBookings()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.admin-login');
        }
    
        $admin = Auth::guard('admin')->user();
    
        try {
            $allBookings = Reservation::with(['motorcycle', 'driverInformation', 'payment'])
                ->whereIn('status', ['To Review', 'Approved'])
                ->orderByRaw("CASE WHEN payment_method = 'gcash' THEN 1 ELSE 2 END")
                ->get();
    
            $toReviewBookings = $allBookings->where('status', 'To Review')
                ->map(function ($reservation) {
                    return $this->formatBookingData($reservation);
                });
    
            $approvedBookings = $allBookings->where('status', 'Approved')
                ->map(function ($reservation) {
                    return $this->formatBookingData($reservation);
                });
    
            return view('admin.reservation.bookings', compact('admin', 'toReviewBookings', 'approvedBookings'));
        } catch (\Exception $e) {
            \Log::error('Booking Error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the bookings.');
        }
    }
    
    // format booking data
    private function formatBookingData($reservation)
    {
        $startDate = Carbon::parse($reservation->rental_start_date);
        $endDate = Carbon::parse($reservation->rental_end_date);
        $duration = $startDate->diffInDays($endDate) ?: 1;
        
        $images = json_decode($reservation->motorcycle->images, true);
        $firstImage = $images[0] ?? 'images/placeholder.jpg';
        
        $paymentStatus = $reservation->payment->status ?? 'Pending';
        
        $driverName = $reservation->driverInformation 
            ? $reservation->driverInformation->first_name . ' ' . $reservation->driverInformation->last_name
            : 'N/A';
    
        return [
            'reservation_id' => $reservation->reservation_id,
            'created_at' => $reservation->created_at,
            'driver_name' => $driverName,
            'rental_start_date' => $reservation->rental_start_date,
            'duration' => $duration . ' ' . ((int)$duration === 1 ? 'day' : 'days'),
            'total' => $reservation->total,
            'motorcycle_image' => $firstImage,
            'status' => $reservation->status ?? 'To Review',
            'payment_status' => $paymentStatus,
        ];
    }
    
    //update payment status
    public function updatePaymentStatus(Request $request, $reservation_id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Paid,Unpaid,Pending', 
        ]);

        $reservation = Reservation::findOrFail($reservation_id);
        
        $payment = $reservation->payment; 

        if ($payment) {
            $payment->status = $validated['status']; 
            $payment->save(); 
        } else {
            return redirect()->back()->with('error', 'Payment record not found for this reservation.');
        }

        return redirect()->back()->with('success', 'Payment Status Updated Successfully!');
    }

    //approve the bookings reservation
    public function approve($id)
{
    try {
        $reservation = Reservation::findOrFail($id);

        // Check if the payment exists and is 'Paid'
        $payment = Payment::where('reservation_id', $reservation->reservation_id)->first();

        // If no payment record or payment is not 'Paid'
        if (!$payment || $payment->status !== 'Paid') {
            // Return an error message if the payment is not 'Paid'
            return back()->with('error', 'The reservation needs to be paid before it can be approved.');
        }

        // Proceed to approve the reservation
        $reservation->status = 'Approved';
        $reservation->save();

        return back()->with('success', 'Reservation Approved Successfully!');
    } catch (\Exception $e) {
        \Log::error('Approval Error: ' . $e->getMessage());
        return back()->with('error', 'An error occurred while approving the reservation.');
    }
}

    
    
    //decline the bookings reservation
    public function decline($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->status = 'Declined';
            $reservation->save();
    
            return back()->with('success', 'Reservation Declined Successfully!');
        } catch (\Exception $e) {
            \Log::error('Decline Error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while declining the reservation.');
        }
    }
    
    //cancel the bookings reservation
    public function cancel(Request $request, $reservation_id)
    {
        $reservation = Reservation::findOrFail($reservation_id);
        
        $reservation->status = 'Cancelled'; 
        $reservation->cancel_reason = $request->cancel_reason; 
        $reservation->save();
    
        return redirect()->back()->with('success', 'Reservation has been cancelled.');
    }
    

    //ongoing the bookings reservation
    public function markOngoing($reservation_id)
    {
        $reservation = Reservation::findOrFail($reservation_id);
        $reservation->status = 'Ongoing'; 
        $reservation->save();

        return redirect()->back()->with('success', 'Reservation has been marked as ongoing.');
    }

    //change completed reservation
    public function completed($reservation_id)
    {
        try {
            $reservation = Reservation::findOrFail($reservation_id);
            $reservation->status = 'Completed';
            $reservation->save();

            $motorcycle = $reservation->motorcycle;
            if ($motorcycle) {
                $motorcycle->status = 'Maintenance';
                $motorcycle->save();
            }

            return redirect()->back()->with('success', 'Reservation has been completed, and the motorcycle is now under Maintenance!');
        } catch (\Exception $e) {
            \Log::error('Error completing reservation: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while completing the reservation.');
        }
    }

    //view bookings 
    public function viewBookings($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.admin-login');
        }
    
        $admin = Auth::guard('admin')->user();
    
        try {
            if (!$id) {
                return back()->with('error', 'Invalid reservation ID');
            }
    
            $reservation = Reservation::with([
                'motorcycle',
                'customer',
                'driverInformation', 
                'payment'
            ])->findOrFail($id);
    
            $driverLicensePath = optional($reservation->driverInformation)->driver_license;
    
            \Log::info('Driver License Path: ' . $driverLicensePath);
    
            $startDate = Carbon::parse($reservation->rental_start_date);
            $endDate = Carbon::parse($reservation->rental_end_date);
            $duration = $startDate->diffInDays($endDate) ?: 1;
    
            $images = json_decode($reservation->motorcycle->images, true) ?: [];
            $firstImage = !empty($images) ? $images[0] : 'images/placeholder.jpg';
    
            return view('admin.reservation.view-bookings', compact(
                'admin',
                'reservation',
                'duration',
                'firstImage',
                'driverLicensePath'
            ));
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Reservation not found.');
        } catch (\Exception $e) {
            \Log::error('Error loading booking details: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the booking details.');
        }
    }
    
    //show all bookings
    public function showAllBookings()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.admin-login');
        }
        
        $admin = Auth::guard('admin')->user();
        
        try {
            $bookings = Reservation::with(['motorcycle', 'driverInformation'])
                ->whereIn('status', ['Completed', 'Declined']) 
                ->get()
                ->map(function ($reservation) {
                    $startDate = Carbon::parse($reservation->rental_start_date);
                    $endDate = Carbon::parse($reservation->rental_end_date);
                    
                    $duration = $startDate->diffInDays($endDate) ?: 1;
                    
                    $images = json_decode($reservation->motorcycle->images, true);
                    $firstImage = $images[0] ?? 'images/placeholder.jpg';
                    
                    $driverName = $reservation->driverInformation 
                        ? $reservation->driverInformation->first_name . ' ' . $reservation->driverInformation->last_name
                        : 'N/A';
                    
                    $driverId = $reservation->driverInformation 
                        ? $reservation->driverInformation->driver_id 
                        : null;
                    
                    return [
                        'reservation_id' => $reservation->reservation_id,
                        'customer_id' => $reservation->customer_id,
                        'driver_id' => $driverId,
                        'driver_name' => $driverName,
                        'rental_start_date' => $reservation->rental_start_date,
                        'created_at' => $reservation->created_at,
                        'duration' => $duration . ' ' . ((int)$duration === 1 ? 'day' : 'days'),
                        'total' => $reservation->total,
                        'motorcycle_image' => $firstImage,
                        'status' => $reservation->status,
                        'violation_status' => $reservation->violation_status
                    ];
                });
                
            return view('admin.reservation.all-bookings-record', compact('admin', 'bookings'));
        } catch (\Exception $e) {
            \Log::error('Booking Error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the bookings.');
        }
    }

    //view all booking records
    public function viewAllBookingsRecord($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.admin-login');
        }
    
        $admin = Auth::guard('admin')->user();
    
        try {
            if (!$id) {
                return back()->with('error', 'Invalid reservation ID');
            }
    
            $reservation = Reservation::with([
                'motorcycle',
                'customer',
                'driverInformation',
                'payment',
                'penalty' 
            ])->findOrFail($id);
    
            $driverLicensePath = optional($reservation->driverInformation)->driver_license;
    
            \Log::info('Driver License Path: ' . $driverLicensePath);
    
            $startDate = Carbon::parse($reservation->rental_start_date);
            $endDate = Carbon::parse($reservation->rental_end_date);
            $duration = $startDate->diffInDays($endDate) ?: 1;
    
            $images = json_decode($reservation->motorcycle->images, true) ?: [];
            $firstImage = !empty($images) ? $images[0] : 'images/placeholder.jpg';
    
            return view('admin.reservation.view-all-bookings', compact(
                'admin',
                'reservation',
                'duration',
                'firstImage',
                'driverLicensePath'
            ));
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Reservation not found.');
        } catch (\Exception $e) {
            \Log::error('Error loading booking details: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the booking details.');
        }
    }
    
    //show ongoing bookings 
    public function showOngoingBookings()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.admin-login');
        }
    
        $admin = Auth::guard('admin')->user();
    
        try {
            $bookings = Reservation::with(['motorcycle', 'driverInformation'])
                ->whereIn('status', ['Ongoing']) 
                ->get()
                ->map(function ($reservation) {
                    $startDate = Carbon::parse($reservation->rental_start_date);
                    $endDate = Carbon::parse($reservation->rental_end_date);
    
                    $duration = $startDate->diffInDays($endDate) ?: 1;
    
                    $images = json_decode($reservation->motorcycle->images, true);
                    $firstImage = $images[0] ?? 'images/placeholder.jpg';
    
                    $driverName = $reservation->driverInformation 
                        ? $reservation->driverInformation->first_name . ' ' . $reservation->driverInformation->last_name
                        : 'N/A';
    
                    return [
                        'reservation_id' => $reservation->reservation_id,
                        'driver_name' => $driverName, 
                        'rental_start_date' => $reservation->rental_start_date,
                        'created_at' => $reservation->created_at, 
                        'duration' => $duration . ' ' . ((int)$duration === 1 ? 'day' : 'days'),
                        'total' => $reservation->total,
                        'motorcycle_image' => $firstImage,
                        'status' => $reservation->status, 
                    ];
                });
                
            return view('admin.reservation.ongoing-bookings', compact('admin', 'bookings'));
        } catch (\Exception $e) {
            \Log::error('Booking Error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the bookings.');
        }
    }

    //view ongoing bookings
    public function viewOngoingBookings($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.admin-login');
        }
    
        $admin = Auth::guard('admin')->user();
    
        try {
            if (!$id) {
                return back()->with('error', 'Invalid reservation ID');
            }
    
            $reservation = Reservation::with([
                'motorcycle',
                'customer',
                'driverInformation', 
                'payment'
            ])->findOrFail($id);
    
            $driverLicensePath = optional($reservation->driverInformation)->driver_license;
    
            \Log::info('Driver License Path: ' . $driverLicensePath);
    
            $startDate = Carbon::parse($reservation->rental_start_date);
            $endDate = Carbon::parse($reservation->rental_end_date);
            $duration = $startDate->diffInDays($endDate) ?: 1;
    
            $images = json_decode($reservation->motorcycle->images, true) ?: [];
            $firstImage = !empty($images) ? $images[0] : 'images/placeholder.jpg';
    
            return view('admin.reservation.view-ongoing-bookings', compact(
                'admin',
                'reservation',
                'duration',
                'firstImage',
                'driverLicensePath'
            ));
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Reservation not found.');
        } catch (\Exception $e) {
            \Log::error('Error loading booking details: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the booking details.');
        }
    }

    public function showCancelledBookings()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.admin-login');
        }
        
        $admin = Auth::guard('admin')->user();
        
        try {
            $bookings = Reservation::with(['motorcycle', 'driverInformation'])
                ->whereIn('status', ['Cancelled']) 
                ->get()
                ->map(function ($reservation) {
                    $startDate = Carbon::parse($reservation->rental_start_date);
                    $endDate = Carbon::parse($reservation->rental_end_date);
                    
                    $duration = $startDate->diffInDays($endDate) ?: 1;
                    
                    $images = json_decode($reservation->motorcycle->images, true);
                    $firstImage = $images[0] ?? 'images/placeholder.jpg';
                    
                    $driverName = $reservation->driverInformation 
                        ? $reservation->driverInformation->first_name . ' ' . $reservation->driverInformation->last_name
                        : 'N/A';
                    
                    $driverId = $reservation->driverInformation 
                        ? $reservation->driverInformation->driver_id 
                        : null;
                    
                    return [
                        'reservation_id' => $reservation->reservation_id,
                        'customer_id' => $reservation->customer_id,
                        'driver_id' => $driverId,
                        'driver_name' => $driverName,
                        'rental_start_date' => $reservation->rental_start_date,
                        'created_at' => $reservation->created_at,
                        'duration' => $duration . ' ' . ((int)$duration === 1 ? 'day' : 'days'),
                        'total' => $reservation->total,
                        'motorcycle_image' => $firstImage,
                        'status' => $reservation->status,
                        'cancel_reason' => $reservation->cancel_reason
                    ];
                });
                
            return view('admin.reservation.cancelled-bookings', compact('admin', 'bookings'));
        } catch (\Exception $e) {
            \Log::error('Booking Error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the bookings.');
        }
    }

    //generate invoice in admin
    public function generateInvoice($reservationId)
    {
        $reservation = Reservation::with(['driverInformation', 'payment', 'motorcycle'])->findOrFail($reservationId);
    
        $startDate = Carbon::parse($reservation->rental_start_date);
        $endDate = Carbon::parse($reservation->rental_end_date);
        $createdAt = Carbon::parse($reservation->created_at);
        
        $duration = $startDate->diffInDays($endDate);
        $durationText = $duration === 1 ? '1 day' : $duration . ' days';
    
        $paymentMethod = strtolower(trim($reservation->payment_method ?? 'N/A'));
    
        $data = [
            'bookingDate' => $createdAt->format('F j, Y, h:i A'),
            'motorcycleName' => $reservation->motorcycle->name,
            'dailyPrice' => number_format($reservation->motorcycle->price, 2, '.', ','),
            'plateNumber' => $reservation->motorcycle->plate_number,
            'bookingReference' => $reservation->reference_id,
            'driverName' => $reservation->driverInformation->first_name . ' ' . $reservation->driverInformation->last_name,
            'email' => $reservation->driverInformation->email,
            'address' => $reservation->driverInformation->address,
            'birthdate' => $startDate->format('F j, Y'),
            'contactNumber' => $reservation->driverInformation->contact_number,
            'gender' => ucfirst($reservation->driverInformation->gender),
            'rentalStartDate' => $startDate->format('F j, Y'),
            'pickUp' => $startDate->format('h:i A'),
            'rentalEndDate' => $endDate->format('F j, Y'),
            'dropOff' => $endDate->format('h:i A'),
            'duration' => $durationText,
            'paymentMethod' => ucfirst($paymentMethod),
            'gcashNumber' => $reservation->payment->number ?? 'N/A',
            'gcashReceipt' => $reservation->payment->receipt ?? 'N/A',
            'totalAmount' => number_format($reservation->total, 2, '.', ','),
        ];
    
        $pdf = PDF::loadView('invoices.booking', $data);
    
        return $pdf->download('invoice_' . $reservation->reference_id . '.pdf');
    }
    
    public function viewBookingSpecific($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.admin-login');
        }
    
        $admin = Auth::guard('admin')->user();
    
        try {
            if (!$id) {
                return back()->with('error', 'Invalid reservation ID');
            }
    
            $reservation = Reservation::with([
                'motorcycle',
                'customer',
                'driverInformation',
                'payment',
                'penalty'
            ])->findOrFail($id);
    
            $motorcycle = $reservation->motorcycle;
    
            $driverLicensePath = optional($reservation->driverInformation)->driver_license;
    
            \Log::info('Driver License Path: ' . $driverLicensePath);
    
            $startDate = Carbon::parse($reservation->rental_start_date);
            $endDate = Carbon::parse($reservation->rental_end_date);
            $duration = $startDate->diffInDays($endDate) ?: 1;
    
            $images = json_decode(optional($motorcycle)->images, true) ?: [];
            $firstImage = !empty($images) ? $images[0] : 'images/placeholder.jpg';
    
            return view('admin.reservation.view-bookings-specific', compact(
                'admin',
                'reservation',
                'motorcycle',
                'duration',
                'firstImage',
                'driverLicensePath'
            ));
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Reservation not found.');
        } catch (\Exception $e) {
            \Log::error('Error loading booking details: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the booking details.');
        }
    }

    //view cancelled bookings
    public function viewCancelledBookingsRecord($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.admin-login');
        }
    
        $admin = Auth::guard('admin')->user();
    
        try {
            if (!$id) {
                return back()->with('error', 'Invalid reservation ID');
            }
    
            $reservation = Reservation::with([
                'motorcycle',
                'customer',
                'driverInformation',
                'payment',
                'penalty' 
            ])->findOrFail($id);
    
            $driverLicensePath = optional($reservation->driverInformation)->driver_license;
    
            \Log::info('Driver License Path: ' . $driverLicensePath);
    
            $startDate = Carbon::parse($reservation->rental_start_date);
            $endDate = Carbon::parse($reservation->rental_end_date);
            $duration = $startDate->diffInDays($endDate) ?: 1;
    
            $images = json_decode($reservation->motorcycle->images, true) ?: [];
            $firstImage = !empty($images) ? $images[0] : 'images/placeholder.jpg';
    
            return view('admin.reservation.view-cancelled-bookings', compact(
                'admin',
                'reservation',
                'duration',
                'firstImage',
                'driverLicensePath'
            ));
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Reservation not found.');
        } catch (\Exception $e) {
            \Log::error('Error loading booking details: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the booking details.');
        }
    }
}
