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
use App\Models\Notification;

class HomeController extends Controller
{
    //show landing page
    public function home()
    {
        $motorcycles = Motorcycle::all();
        $isCustomerLoggedIn = Auth::guard('customer')->check();
    
        if ($isCustomerLoggedIn) {
            $user = Auth::guard('customer')->user();
            $notifications = Notification::where('customer_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get(['id', 'type', 'message', 'read', 'created_at', 'updated_at']);
        } else {
            $notifications = [];
        }
    
        return view('welcome', compact('motorcycles', 'isCustomerLoggedIn', 'notifications'));
    }
    
    //view list motorcycle
    public function viewMotorcycleCategories(Request $request) 
    {
        $searchQuery = $request->input('search', '');
    
        $motorcycles = Motorcycle::where(function($query) use ($searchQuery) {
            $query->where('name', 'like', '%' . $searchQuery . '%')
                  ->orWhere('brand', 'like', '%' . $searchQuery . '%')
                  ->orWhere('model', 'like', '%' . $searchQuery . '%')
                  ->orWhere('cc', 'like', '%' . $searchQuery . '%')
                  ->orWhere('year', 'like', '%' . $searchQuery . '%')
                  ->orWhere('gas', 'like', '%' . $searchQuery . '%')
                  ->orWhere('color', 'like', '%' . $searchQuery . '%')
                  ->orWhere('body_number', 'like', '%' . $searchQuery . '%')
                  ->orWhere('price', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%')
                  ->orWhere('status', 'like', '%' . $searchQuery . '%');
        })->get();
    
        $isCustomerLoggedIn = Auth::guard('customer')->check();
    
        if ($isCustomerLoggedIn) {
            $user = Auth::guard('customer')->user();
            $notifications = Notification::where('customer_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get(['id', 'type', 'message', 'read', 'created_at', 'updated_at']);
        } else {
            $notifications = [];
        }

        return view('motorcycles', compact('motorcycles', 'isCustomerLoggedIn', 'searchQuery', 'notifications'));
    }

    //filter and search
    public function search(Request $request)
    {
        $searchQuery = $request->input('search', '');
        $priceRange = $request->input('price', '');
        $status = $request->input('status', '');
    
        $motorcycles = Motorcycle::where(function($query) use ($searchQuery) {
                $query->where('name', 'like', '%' . $searchQuery . '%')
                      ->orWhere('brand', 'like', '%' . $searchQuery . '%')
                      ->orWhere('model', 'like', '%' . $searchQuery . '%')
                      ->orWhere('cc', 'like', '%' . $searchQuery . '%')
                      ->orWhere('year', 'like', '%' . $searchQuery . '%')
                      ->orWhere('gas', 'like', '%' . $searchQuery . '%')
                      ->orWhere('color', 'like', '%' . $searchQuery . '%')
                      ->orWhere('body_number', 'like', '%' . $searchQuery . '%')
                      ->orWhere('description', 'like', '%' . $searchQuery . '%')
                      ->orWhere('status', 'like', '%' . $searchQuery . '%');
            });
    
        if ($priceRange) {
            [$minPrice, $maxPrice] = explode('-', $priceRange);
            $motorcycles->whereBetween('price', [(float)$minPrice, (float)$maxPrice]);
        }
    
        if ($status) {
            $motorcycles->where('status', $status);
        }
    
        $motorcycles = $motorcycles->get();
    
        return view('motorcycle.motorcycle_list', compact('motorcycles'))->render();
    }
    
    //view details motorcycle
    public function viewDetailsMotorcycle($id)
    {
        $motorcycle = Motorcycle::findOrFail($id);
        $isCustomerLoggedIn = Auth::guard('customer')->check();
        $status = $motorcycle->status;
        
        $reservedDates = Reservation::where('motor_id', $id)
            ->whereIn('status', ['Approved', 'Ongoing'])
            ->select('rental_start_date', 'rental_end_date')
            ->get()
            ->map(function($reservation) {
                return [
                    'start' => $reservation->rental_start_date,
                    'end' => $reservation->rental_end_date
                ];
            });
    
         if ($isCustomerLoggedIn) {
            $user = Auth::guard('customer')->user();
            $notifications = Notification::where('customer_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get(['id', 'type', 'message', 'read', 'created_at', 'updated_at']);
        } else {
            $notifications = [];
        }

        return view('motorcycle.details-motorcycle', compact(
            'motorcycle', 
            'status', 
            'isCustomerLoggedIn',
            'reservedDates',
            'notifications'
        ));
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

        if ($isCustomerLoggedIn) {
            $user = Auth::guard('customer')->user();
            $notifications = Notification::where('customer_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get(['id', 'type', 'message', 'read', 'created_at', 'updated_at']);
        } else {
            $notifications = [];
        }

        return view('motorcycle.reservation-details', compact(
            'motorcycle', 
            'reservationData', 
            'isCustomerLoggedIn', 
            'total', 
            'days',
            'notifications'
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
            'payment_method' => 'required|in:gcash,cash',
        ]);

        $rentalDates = explode(' - ', $validatedData['rental_dates']);
        $startDate = Carbon::createFromFormat('d/m/Y', trim($rentalDates[0]));
        $endDate = Carbon::createFromFormat('d/m/Y', trim($rentalDates[1]));

        $days = $startDate->diffInDays($endDate);

        $motorcycle = Motorcycle::findOrFail($validatedData['motorcycle_id']);
        $total = $days * $motorcycle->price;

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
        $reservation->driver_id = $driverInfo->driver_id;
        $reservation->motor_id = $validatedData['motorcycle_id'];
        $reservation->rental_start_date = $startDate->toDateString();
        $reservation->rental_end_date = $endDate->toDateString();
        $reservation->pick_up = $pickUpDateTime;
        $reservation->drop_off = $dropOffDateTime;
        $reservation->riding = $validatedData['riding'];
        $reservation->total = $total;
        $reservation->payment_method = $validatedData['payment_method']; 
        $reservation->reference_id = $this->generateUniqueReferenceId();
        $reservation->violation_status = 'No Violation';
        $reservation->save();

        $payment = new Payment();
        $payment->reservation_id = $reservation->reservation_id;
        $payment->amount = $total;
        $payment->customer_id = Auth::guard('customer')->id(); 
        $payment->motor_id = $validatedData['motorcycle_id']; 

        if ($validatedData['payment_method'] === 'cash') {
            $payment->status = 'Unpaid'; 
        } elseif ($validatedData['payment_method'] === 'gcash') {
            $payment->status = 'Pending';
            return redirect()->route('motorcycle.payment', ['reservation_id' => $reservation->reservation_id]);
        }
        $payment->save(); 
        return redirect()->route('motorcycle.success', ['reservation_id' => $reservation->reservation_id]);
    }

    
    private function generateUniqueReferenceId()
    {
        do {
           
            $referenceId = Str::random(10); 
        } while (Reservation::where('reference_id', $referenceId)->exists());

        return $referenceId;
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
    
        $reservationData = [
            'rental_dates' => $pickupDate->format('d/m/Y') . ' - ' . $dropoffDate->format('d/m/Y'),
            'pick_up' => $reservation->pick_up,
            'drop_off' => $reservation->drop_off,
            'riding' => $reservation->riding,
        ];
    
        if ($isCustomerLoggedIn) {
            $user = Auth::guard('customer')->user();
            $notifications = Notification::where('customer_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get(['id', 'type', 'message', 'read', 'created_at', 'updated_at']);
        } else {
            $notifications = [];
        }

        return view('motorcycle.payment', compact('reservation', 'motorcycle', 'isCustomerLoggedIn', 'driverInformation', 'reservationData', 'days', 'total', 'notifications'));
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
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
    
        if ($request->hasFile('image')) {
            $payment->image = $request->file('image')->store('receipts', 'public');
        }
    
        $payment->status = 'Pending';
    
        $payment->save();
    
        $motorcycle = Motorcycle::findOrFail($payment->motor_id);
        $motorcycle->status = 'Not Available';
        $motorcycle->save();
    
        return response()->json([
            'success' => true,
            'redirectUrl' => route('motorcycle.success', ['reservation_id' => $payment->reservation_id])
        ]);
    }
    
    //show success reservation page
    public function showSuccessPage($reservation_id)
    {
        $isCustomerLoggedIn = Auth::guard('customer')->check();
    
        $reservation = Reservation::with(['customer', 'motorcycle', 'payment', 'driverInformation'])
            ->where('reservation_id', $reservation_id)
            ->first();
    
        if (!$reservation) {
            return redirect()->route('reservations.index')->with('error', 'Reservation not found.');
        }

        if ($isCustomerLoggedIn) {
            $user = Auth::guard('customer')->user();
            $notifications = Notification::where('customer_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get(['id', 'type', 'message', 'read', 'created_at', 'updated_at']);
        } else {
            $notifications = [];
        }
        
        $startDate = Carbon::parse($reservation->rental_start_date);
        $endDate = Carbon::parse($reservation->rental_end_date);
        $duration = $startDate->diffInDays($endDate) ?: 1;

        $images = json_decode($reservation->motorcycle->images, true) ?: [];
        $firstImage = !empty($images) ? $images[0] : 'images/placeholder.jpg';

        $driverLicensePath = optional($reservation->driverInformation)->driver_license;
    
        
        return view('motorcycle.success', compact('reservation', 'isCustomerLoggedIn',  'driverLicensePath',  'duration', 'firstImage', 'notifications'));
    }
    
    //view history bookings
    public function viewHistory($reservation_id)
    {
        $isCustomerLoggedIn = Auth::guard('customer')->check();
    
        $reservation = Reservation::with(['customer', 'motorcycle', 'payment', 'driverInformation'])
            ->where('reservation_id', $reservation_id)
            ->first();
    
        if (!$reservation) {
            return redirect()->route('reservations.index')->with('error', 'Reservation not found.');
        }
    
        $startDate = Carbon::parse($reservation->rental_start_date);
        $endDate = Carbon::parse($reservation->rental_end_date);
        $duration = $startDate->diffInDays($endDate) ?: 1;
    
        $images = json_decode($reservation->motorcycle->images, true) ?: [];
        $firstImage = !empty($images) ? $images[0] : 'images/placeholder.jpg';
    
        $driverLicensePath = optional($reservation->driverInformation)->driver_license;
    
        if ($isCustomerLoggedIn) {
            $user = Auth::guard('customer')->user();
            $notifications = Notification::where('customer_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get(['id', 'type', 'message', 'read', 'created_at', 'updated_at']);
        } else {
            $notifications = [];
        }

        return view('customer.view-history', compact(
            'reservation',
            'isCustomerLoggedIn',
            'driverLicensePath',
            'duration',
            'firstImage',
            'notifications'
        ));
    }
    
    
}
