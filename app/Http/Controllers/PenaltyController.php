<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\DriverInformation;
use App\Models\Admin;
use App\Models\Motorcycle;
use App\Models\Penalty;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class PenaltyController extends Controller
{
    //store penalty
    public function storePenalty(Request $request)
    {
        try {
            $validated = $request->validate([
                'reservation_id' => 'required|integer|exists:reservations,reservation_id',
                'customer_id' => 'required|integer',
                'driver_id' => 'required|integer',
                'penalty_type' => 'required|string|max:255',
                'description' => 'required|string',
            ]);
    
            Penalty::create($validated);
    
            Reservation::where('reservation_id', $validated['reservation_id'])
                ->update(['violation_status' => 'Violator']);
    
            return redirect()->back()->with('success', 'Penalty Added Successfully!');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Failed to add penalty: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add penalty. Please try again.');
        }
    }

    public function showPenaltiesPage()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.admin-login');
        }
    
        $admin = Auth::guard('admin')->user();
    
        // Fetch all penalties with their associated driver information
        $penalties = Penalty::with('driver')->get();
    
        return view('admin.reservation.penalties', compact('admin', 'penalties'));
    }
    


}
