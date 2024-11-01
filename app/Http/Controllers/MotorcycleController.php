<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Motorcycle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


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
        $validationRules = [
            'name' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'cc' => 'required',
            'year' => 'required|integer',
            'gas' => 'required',
            'color' => 'required',
            'body_number' => 'required',
            'plate_number' => 'required|unique:motorcycles,plate_number',
            'price' => 'required|numeric',
            'description' => 'required',
        ];

        if ($request->hasFile('images')) {
            $validationRules['images.*'] = 'required|image|mimes:jpeg,png,jpg,gif,webp';
        } elseif (!$request->has('image_data')) {
            $validationRules['images'] = 'required';
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

        if ($request->has('image_data')) {
            foreach ($request->image_data as $base64Image) {
                if (Str::startsWith($base64Image, 'motorcycle_images/')) {
                    $imagePaths[] = $base64Image;
                    continue;
                }

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
            'body_number' => 'required',
            'plate_number' => 'required',
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
    
        // Process existing images
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
        return view('admin.motorcycles.view-motorcycle', compact('admin', 'motorcycle'));
    }

    public function updateStatus(Request $request, $motor_id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.admin-login');
        }

        $motorcycle = Motorcycle::findOrFail($motor_id);
        $motorcycle->status = $request->input('status');
        $motorcycle->save();

        return redirect()->route('admin.motorcycles.manage-motorcycles')->with('success', 'Motorcycle Status Updated Successfully!');
    }
}
