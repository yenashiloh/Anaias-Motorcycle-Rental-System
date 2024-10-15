<?php

namespace App\Http\Controllers;

use App\Models\Motorcycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\DriverInformation;
use App\Models\Reservation;
use App\Models\Payment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class HomeController extends Controller
{
    //show landing page
    public function home()
    {
        $motorcycles = Motorcycle::all();
        $isCustomerLoggedIn = Auth::guard('customer')->check();
    
        return view('welcome', compact('motorcycles', 'isCustomerLoggedIn'));
    }

    //view list motorcycle
    public function viewMotorcycleCategories()
    {
       $motorcycles = Motorcycle::all();
       $isCustomerLoggedIn = Auth::guard('customer')->check();

       return view('motorcycles', compact('motorcycles', 'isCustomerLoggedIn'));
    }

    //view details motorcycle
    public function viewDetailsMotorcycle($id)
    {
       $motorcycle = Motorcycle::findOrFail($id);
       $isCustomerLoggedIn = Auth::guard('customer')->check();
   
       return view('motorcycle.details-motorcycle', compact('motorcycle', 'isCustomerLoggedIn'));
    }
   
    //view reservation details
    public function viewReservationDetails(Request $request)
    {
        $motorcycle = Motorcycle::findOrFail($request->motorcycle_id);
        $reservationData = $request->only(['rental_dates', 'pick_up', 'drop_off', 'riding']);
        $isCustomerLoggedIn = Auth::guard('customer')->check();

        $dates = explode(' - ', $reservationData['rental_dates']);
        $start = Carbon::createFromFormat('d/m/Y', $dates[0]);
        $end = Carbon::createFromFormat('d/m/Y', $dates[1]);
        
        $days = $end->diffInDays($start); 
        
        $total = $days * $motorcycle->price;

        return view('motorcycle.reservation-details', compact(
            'motorcycle', 
            'reservationData', 
            'isCustomerLoggedIn', 
            'total', 
            'days'
        ));
    }

    //process reservation
    public function process(Request $request)
    {
        $validatedData = $request->validate([
            'motorcycle_id' => 'required|exists:motorcycles,motor_id',
            'rental_dates' => 'required',
            'pick_up' => 'required',
            'drop_off' => 'required',
            'riding' => 'required',
            'total' => 'required|numeric',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'contact_number' => 'required',
            'address' => 'required',
            'birthdate' => 'required|date',
            'gender' => 'required',
            'driver_license' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $rentalDates = explode(' - ', $validatedData['rental_dates']);
        $startDate = Carbon::createFromFormat('d/m/Y', trim($rentalDates[0]));
        $endDate = Carbon::createFromFormat('d/m/Y', trim($rentalDates[1]));
    
        $days = $endDate->diffInDays($startDate) + 1; 
        $motorcycle = Motorcycle::findOrFail($validatedData['motorcycle_id']);
        $total = abs($days * $motorcycle->price); 
    
        $driverInfo = new DriverInformation();
        $driverInfo->customer_id = Auth::guard('customer')->id();
        $driverInfo->first_name = $validatedData['first_name'];
        $driverInfo->last_name = $validatedData['last_name'];
        $driverInfo->email = $validatedData['email'];
        $driverInfo->contact_number = $validatedData['contact_number'];
        $driverInfo->address = $validatedData['address'];
        $driverInfo->birthdate = $validatedData['birthdate'];
        $driverInfo->gender = $validatedData['gender'];
    
        if ($request->hasFile('driver_license')) {
            $path = $request->file('driver_license')->store('driver_licenses', 'public');
            $driverInfo->driver_license = $path;
        }
    
        $driverInfo->save();
    
        $pickUpTime = Carbon::createFromFormat('h:i A', trim($validatedData['pick_up']));
        $dropOffTime = Carbon::createFromFormat('h:i A', trim($validatedData['drop_off']));
    
        $pickUpDateTime = $startDate->copy()->setTime($pickUpTime->hour, $pickUpTime->minute);
        $dropOffDateTime = $endDate->copy()->setTime($dropOffTime->hour, $dropOffTime->minute);
    
        $reservation = new Reservation();
        $reservation->customer_id = Auth::guard('customer')->id();
        $reservation->motor_id = $validatedData['motorcycle_id'];
        $reservation->rental_start_date = $startDate->toDateString();
        $reservation->rental_end_date = $endDate->toDateString();
        $reservation->pick_up = $pickUpDateTime;
        $reservation->drop_off = $dropOffDateTime;
        $reservation->riding = $validatedData['riding'];
        $reservation->total = $total; 
        $reservation->save();
    
        return redirect()->route('motorcycle.payment', ['reservation_id' => $reservation->reservation_id]);
    }
    
    //show payment page
    public function showPayment($reservation_id)
    {
        $reservation = Reservation::with(['motorcycle', 'customer'])->findOrFail($reservation_id);
        $motorcycle = $reservation->motorcycle;
        $isCustomerLoggedIn = Auth::guard('customer')->check();
    
        $driverInformation = null;
        if ($isCustomerLoggedIn) {
            $driverInformation = DriverInformation::where('customer_id', $reservation->customer_id)
                                                  ->latest()
                                                  ->first();
        }
    
        $pickupDate = \Carbon\Carbon::parse($reservation->rental_start_date);
        $dropoffDate = \Carbon\Carbon::parse($reservation->rental_end_date);
        $days = $dropoffDate->diffInDays($pickupDate) + 1;
        $total = $days * $motorcycle->price;
    
        $bookingId = 'BK' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
    
        $reservationData = [
            'booking_id' => $bookingId,
            'rental_dates' => $pickupDate->format('d/m/Y') . ' - ' . $dropoffDate->format('d/m/Y'),
            'pick_up' => $reservation->pick_up,
            'drop_off' => $reservation->drop_off,
            'riding' => $reservation->riding,
        ];
    
        return view('motorcycle.payment', compact('reservation', 'motorcycle', 'isCustomerLoggedIn', 'driverInformation', 'reservationData', 'days', 'total'));
    }
    
    //get payment info
    public function getPaymentInfo($reservationId)
    {
        $payment = Payment::where('reservation_id', $reservationId)
                        ->select('customer_id', 'reservation_id', 'motor_id', 'name', 'number', 'receipt', 'amount', 'image')
                        ->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        return response()->json($payment);
    }

    //process payment
    public function processPayment(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'number' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'amount' => 'required|numeric|min:0.01',
            'reservation_id' => 'required|exists:reservations,reservation_id',
            'receipt' => 'required|string|max:255',
        ]);
    
        $reservation = Reservation::findOrFail($validatedData['reservation_id']);
    
        $payment = new Payment();
        $payment->reservation_id = $reservation->reservation_id;
        $payment->customer_id = $reservation->customer_id;
        $payment->motor_id = $reservation->motor_id;
        $payment->amount = $validatedData['amount'];
        $payment->name = $validatedData['name'];
        $payment->number = $validatedData['number'];
        $payment->receipt = $validatedData['receipt'];

        $payment->booking_id = Str::random(10);  
    
        if ($request->hasFile('image')) {
            $payment->image = $request->file('image')->store('receipts', 'public');
        }
    
        $payment->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your rental motorcycle was successfully processed.',
            'booking_id' => $payment->booking_id, 
            'payment_image' => $payment->image, 
        ]);
    }
    

}
