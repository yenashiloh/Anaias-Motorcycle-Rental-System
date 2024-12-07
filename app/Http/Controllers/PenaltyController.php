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
use App\Events\PenaltyAdded;
use App\Models\Notification;
use Illuminate\Validation\ValidationException;


class PenaltyController extends Controller
{
    //store penalty
    public function storePenalty(Request $request)
    {
        try {
            $validated = $request->validate([
                'reservation_id' => 'required|integer|exists:reservations,reservation_id',
                'customer_id' => 'required|integer|exists:customers,customer_id',
                'driver_id' => 'required|integer|exists:driver_information,driver_id',
                'penalty_type' => 'required|string',
                'description' => 'required|string',
                'additional_payment' => 'required|numeric',
                'penalty_image' => 'nullable|array',
                'penalty_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            ]);
    
            $imagePaths = [];
            if ($request->hasFile('penalty_image')) {
                foreach ($request->file('penalty_image') as $image) {
                    try {
                        if (!$image->isValid()) {
                            continue;
                        }
    
                        $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                        $path = $image->storeAs('penalty_images', $filename);
                        $webPath = str_replace('public/', 'storage/', $path);
                        $imagePaths[] = $webPath;
                    } catch (\Exception $imageException) {
                    }
                }
            }
    
            $penaltyData = $validated;
            $penaltyData['penalty_image'] = count($imagePaths) > 0 ? json_encode($imagePaths) : null;
    
            $penalty = Penalty::create($penaltyData);
    
            $reservationUpdate = Reservation::where('reservation_id', $validated['reservation_id'])
                ->update(['violation_status' => 'Violator']);
    
            $notification = Notification::create([
                'customer_id' => $validated['customer_id'],
                'reservation_id' => $validated['reservation_id'],
                'type' => 'penalty',
                'message' => "You have a violation due to {$validated['penalty_type']}.",
                'read' => false
            ]);
    
            return redirect()->back()->with('success', 'Penalty Added Successfully!');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add penalty. Please try again.');
        }
    }
    
    //show penalty page
    public function showPenaltiesPage()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.admin-login');
        }
    
        $admin = Auth::guard('admin')->user();

        $penalties = Penalty::with('driver')->get();
    
        return view('admin.reservation.penalties', compact('admin', 'penalties'));
    }
    
    //update the status of penalty
    public function updateStatusPenalty(Request $request, $penalty_id)
    {
        $penalty = Penalty::find($penalty_id);

        if ($penalty) {
            $penalty->status = $request->input('status');
            $penalty->save();

            return redirect()->back()->with('success', 'Status updated successfully!');
        }

        return redirect()->back()->with('error', 'Penalty not found!');
    }
}
