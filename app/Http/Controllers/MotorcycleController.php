<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Motorcycle;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;


class MotorcycleController extends Controller
{
    //show manage motorcycles admin page
    public function showManageMotorcycles(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.admin-login');
        }
    
        $admin = Auth::guard('admin')->user();
        
        $motorcycles = Motorcycle::where('is_archived', false)
            ->whereIn('status', ['Available', 'Not Available'])
            ->get();
    
        return view('admin.motorcycles.manage-motorcycles', compact('admin', 'motorcycles'));
    }

    //show motorcycle maintenance page
    public function showMotorcycleMaintenance(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.admin-login');
        }
    
        $admin = Auth::guard('admin')->user();
        $motorcycles = Motorcycle::whereIn('status', ['Maintenance'])->get();
        return view('admin.motorcycles.maintenance-motorcycles', compact('admin', 'motorcycles'));
    }

    //show add motorcycle page
    public function showaddMotorcycles()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.motorcycles.add-motorcycle', compact('admin'));
    }

    //show archived motorcycles page
    public function showArchivedMotorcycles(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.admin-login');
        }
    
        $admin = Auth::guard('admin')->user();
        
        $motorcycles = Motorcycle::where('is_archived', true)
            ->orderBy('created_at', 'desc')  
            ->get();
    
        return view('admin.motorcycles.archived-motorcycles', compact('admin', 'motorcycles'));
    }

    //store motorcycle
    public function store(Request $request)
    {
        $validationRules = [
            'name' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'cc' => 'required',
            'year' => 'required|integer',
            'gas' => 'required',
            'color' => 'required',
            'body_number' => 'nullable',
            'plate_number' => 'nullable|unique:motorcycles,plate_number',
            'price' => 'required|numeric',
            'description' => 'required',
        ];

        if (!$request->hasFile('images') && !$request->has('image_data')) {
            $validationRules['images'] = 'required';
        }

        if ($request->hasFile('images')) {
            $validationRules['images.*'] = 'image|mimes:jpeg,png,jpg,gif,webp';
        }

        $validated = $request->validate($validationRules, [
            'plate_number.unique' => 'The plate number has already been taken.',
            'images.required' => 'At least one image is required.',
        ]);

        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('motorcycle_images', 'public');
                $imagePaths[] = $path;
            }
        }

        if (empty($imagePaths) && $request->has('image_data')) {
            foreach ($request->image_data as $base64Image) {
                if (Str::startsWith($base64Image, 'motorcycle_images/')) {
                    $imagePaths[] = $base64Image;
                    continue;
                }

                if (Str::startsWith($base64Image, 'data:image')) {
                    try {
                        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
                        $filename = 'motorcycle_images/' . uniqid() . '.png';
                        Storage::disk('public')->put($filename, $imageData);
                        $imagePaths[] = $filename;
                    } catch (\Exception $e) {
                        \Log::error('Failed to process base64 image: ' . $e->getMessage());
                        continue;
                    }
                }
            }
        }

        if (empty($imagePaths)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['images' => 'At least one image is required.']);
        }

        $motorcycleData = array_merge(
            $request->except(['images', 'image_data']),
            ['images' => json_encode($imagePaths)]
        );

        try {
            Motorcycle::create($motorcycleData);
            return redirect()
                ->route('admin.motorcycles.manage-motorcycles')
                ->with('success', 'Motorcycle created successfully!');
        } catch (\Exception $e) {
            foreach ($imagePaths as $path) {
                Storage::disk('public')->delete($path);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create motorcycle. Please try again.']);
        }
    }

    //delete 
    public function destroy($id)
    {
        $motorcycle = Motorcycle::findOrFail($id);

        if ($motorcycle->delete()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 500);
    }
    
    //view edit
    public function edit($motor_id)
    {
        $admin = Auth::guard('admin')->user();
        $motorcycle = Motorcycle::findOrFail($motor_id);
        return view('admin.motorcycles.edit-motorcycle', compact('admin','motorcycle'));
    }

    //update motorcycle
    public function update(Request $request, $id)
    {
        $motorcycle = Motorcycle::findOrFail($id);
    
        $validatedData = $request->validate([
            'name' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'cc' => 'required',
            'year' => 'required|integer',
            'gas' => 'required',
            'color' => 'required',
            'body_number' => 'nullable',
            'plate_number' => 'nullable',
            'price' => 'required|numeric',
            'description' => 'required',
            'new_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5048',
            'replaced_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'removed_images' => 'nullable|array',
            'removed_images.*' => 'integer',
            'existing_images' => 'required|array',
            'existing_images.*' => 'string',
        ], [
            'new_images.*.image' => 'The file must be an image',
            'new_images.*.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp',
            'new_images.*.max' => 'The image may not be greater than 5MB',
            'replaced_images.*.image' => 'The replacement file must be an image',
            'replaced_images.*.mimes' => 'The replacement image must be a file of type: jpeg, png, jpg, gif, webp',
            'replaced_images.*.max' => 'The replacement image may not be greater than 5MB',
        ]);
    
        $hasNewImages = $request->hasFile('new_images');
        $existingImagesCount = count($request->input('existing_images', []));
        $removedImagesCount = count($request->input('removed_images', []));
        
        if ($existingImagesCount - $removedImagesCount === 0 && !$hasNewImages) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['images' => 'At least one image is required for the motorcycle.']);
        }
    
        $existingImages = json_decode($motorcycle->images) ?? [];
        $updatedImages = [];
        $errors = [];
    
        foreach ($existingImages as $index => $image) {
            try {
                if (in_array($index, $request->input('removed_images', []))) {
                    if (Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                    }
                } elseif ($request->hasFile("replaced_images.$index")) {
                    if (Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                    }
                    $path = $request->file("replaced_images.$index")->store('motorcycle_images', 'public');
                    $updatedImages[] = $path;
                } else {
                    $updatedImages[] = $image;
                }
            } catch (\Exception $e) {
                $errors[] = "Error processing image at index $index: " . $e->getMessage();
            }
        }
    
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $index => $image) {
                try {
                    $path = $image->store('motorcycle_images', 'public');
                    $updatedImages[] = $path;
                } catch (\Exception $e) {
                    $errors[] = "Error uploading new image $index: " . $e->getMessage();
                }
            }
        }
    
        if (!empty($errors)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['image_processing' => $errors]);
        }
        $motorcycle->update($validatedData);
        $motorcycle->images = json_encode(array_values($updatedImages));
        $motorcycle->save();
    
        return redirect()->route('admin.motorcycles.edit-motorcycle', $motorcycle->motor_id)
            ->with('success', 'Motorcycle updated successfully');
    }

    //view motorcycle
    public function viewMotorcycle($motor_id)
    {
        $admin = Auth::guard('admin')->user();
        $motorcycle = Motorcycle::findOrFail($motor_id);
    
        $bookings = Reservation::with(['motorcycle', 'driverInformation', 'payment'])
            ->where('motor_id', $motor_id) 
            ->whereIn('status', ['To Review', 'Approved', 'Declined', 'Completed', 'Ongoing'])
            ->get()
            ->map(function ($reservation) {
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
            });
    
        return view('admin.motorcycles.view-motorcycle', compact('admin', 'motorcycle', 'bookings'));
    }

    //update the status of motorcycle
    public function updateStatus(Request $request, $motor_id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.admin-login');
        }
    
        $motorcycle = Motorcycle::findOrFail($motor_id);
        $oldStatus = $motorcycle->status; 
    
        if ($oldStatus === 'Maintenance' && $request->input('status') === 'Available') {
            $fields = [
                'engine_status', 
                'brake_status', 
                'tire_condition', 
                'oil_status', 
                'lights_status', 
                'overall_condition'
            ];
    
            foreach ($fields as $field) {
                if ($motorcycle->$field !== 1) {
                    return redirect()->back()->withErrors([
                        'status' => 'All the checkboxes need to be checked to set them to be available.'
                    ]);
                }
            }
    
            $motorcycle->engine_status = 0;
            $motorcycle->brake_status = 0;
            $motorcycle->tire_condition = 0;
            $motorcycle->oil_status = 0;
            $motorcycle->lights_status = 0;
            $motorcycle->overall_condition = 0;
        }
    
        $motorcycle->status = $request->input('status');
        $motorcycle->save();
    
        $referrer = $request->headers->get('referer');
    
        if (strpos($referrer, 'maintenance') !== false) {
            return redirect()->route('admin.motorcycles.maintenance-motorcycles')->with('success', 'Motorcycle Status Updated Successfully!');
        }
    
        return redirect()->route('admin.motorcycles.manage-motorcycles')->with('success', 'Motorcycle Status Updated Successfully!');
    }
    
    //update the motorcycle maintenance
    public function updateMotorcycleMaintenance(Request $request, $motorcycleId)
    {
        try {
            $motorcycle = Motorcycle::findOrFail($motorcycleId);
            $field = $request->input('field');
            $status = $request->input($field);
    
            $allowedFields = [
                'engine_status',
                'brake_status',
                'tire_condition',
                'oil_status',
                'lights_status',
                'overall_condition'
            ];

            if (in_array($field, $allowedFields)) {
                $motorcycle->$field = $status;
                $motorcycle->save();
    
                return response()->json([
                    'success' => true,
                    'message' => 'Maintenance status updated successfully'
                ]);
            }
    
            return response()->json([
                'success' => false,
                'message' => 'Invalid field'
            ], 400);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating maintenance status'
            ], 500);
        }
    }
    
    //archive motorcycle
    public function archive(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        try {
            $motorcycle = Motorcycle::findOrFail($id);
            
            if ($motorcycle->status !== 'Not Available') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only motorcycles with "Not Available" status can be archived.'
                ], 400);
            }

            $motorcycle->is_archived = true;
            $motorcycle->archive_reason = $request->input('reason'); 

            if ($motorcycle->save()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Motorcycle archived successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to archive motorcycle'
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while archiving the motorcycle',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    //restore archive motorcycle
    public function restore($id)
    {
        try {
            $motorcycle = Motorcycle::findOrFail($id);
            $motorcycle->is_archived = false;
            
            if ($motorcycle->save()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Motorcycle restored successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to restore motorcycle'
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while restoring the motorcycle',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //view motorcycle in archive page
    public function viewArchiveMotorcycle($motor_id)
    {
        $admin = Auth::guard('admin')->user();
        $motorcycle = Motorcycle::findOrFail($motor_id);
    
        $bookings = Reservation::with(['motorcycle', 'driverInformation', 'payment'])
            ->where('motor_id', $motor_id) 
            ->whereIn('status', ['To Review', 'Approved', 'Declined', 'Completed', 'Ongoing'])
            ->get()
            ->map(function ($reservation) {
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
            });
    
        return view('admin.motorcycles.view-archive-motorcycle', compact('admin', 'motorcycle', 'bookings'));
    }

}
