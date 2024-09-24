<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Motorcycle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class MotorcycleController extends Controller
{
    //show manage motorcycles admin
    public function showManageMotorcycles(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.admin-login');
        }
    
        $admin = Auth::guard('admin')->user();
        $motorcycles = Motorcycle::all();
        return view('admin.motorcycles.manage-motorcycles', compact('admin', 'motorcycles'));
    }
    

    public function showaddMotorcycles()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.motorcycles.add-motorcycle', compact('admin'));
    }

    //store motorcycle
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'cc' => 'required',
            'year' => 'required|integer',
            'gas' => 'required',
            'color' => 'required',
            'body_number' => 'required',
            'plate_number' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp', 
        ]);
    
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('motorcycle_images', 'public'); 
                $imagePaths[] = $path; 
            }
        }

        Motorcycle::create(array_merge($request->all(), ['images' => json_encode($imagePaths)]));
    
        return redirect()->route('admin.motorcycles.manage-motorcycles')->with('success', 'Motorcycle created successfully!');
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
    
    public function edit($motor_id)
    {
        $admin = Auth::guard('admin')->user();
        $motorcycle = Motorcycle::findOrFail($motor_id);
        return view('admin.motorcycles.edit-motorcycle', compact('admin','motorcycle'));
    }

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
            'body_number' => 'required',
            'plate_number' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'new_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'replaced_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'removed_images' => 'nullable|array',
            'removed_images.*' => 'integer',
        ]);
    
        // Decode existing images
        $existingImages = json_decode($motorcycle->images) ?? [];
        $updatedImages = [];
    
        // Process existing images
        foreach ($existingImages as $index => $image) {
            if (in_array($index, $request->input('removed_images', []))) {
                // Delete the image from storage
                Storage::disk('public')->delete($image);
            } elseif ($request->hasFile("replaced_images.$index")) {
                // Delete the old image and store the new one
                Storage::disk('public')->delete($image);
                $path = $request->file("replaced_images.$index")->store('motorcycle_images', 'public');
                $updatedImages[] = $path;
            } else {
                // Keep the existing image
                $updatedImages[] = $image;
            }
        }
    
        // Handle new images
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $image) {
                $path = $image->store('motorcycle_images', 'public');
                $updatedImages[] = $path;
            }
        }
    
        // Update the motorcycle with validated data
        $motorcycle->update($validatedData);
    
        // Update the images attribute
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
        return view('admin.motorcycles.view-motorcycle', compact('admin', 'motorcycle'));
    }

}
