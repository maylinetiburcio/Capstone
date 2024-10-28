<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu_items_model;
use Illuminate\Support\Facades\Log;

class Menu_items_Controller extends Controller
{  

    public function index()
    {
    $menu = Menu_items_model::all();

    if ($menu->count() > 0) {
        $menu->transform(function ($item) {
            $item->image_url = $item->image 
                ? url('storage/' . $item->image) 
                : url('images/default-image.png'); 
            return $item;
        });

        return response()->json([
            'success' => true,
            'data' => $menu,
        ], 200);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'No menu items found'
        ], 404);
    }
    } 
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('uploads', 'public'); 
            Log::info('Image Path: ' . $imagePath);
        } else {
            Log::info('No image was uploaded or the file was invalid.');
        }

        $menu = Menu_items_model::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
            'price' => $validatedData['price'],
            'category_id' => $validatedData['category_id'],
            'image' => $imagePath, 
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Menu item added successfully',
            'menu_item' => $menu,
            'image_url' => $imagePath ? url('storage/' . $imagePath) : url('images/default-image.png'), // Return full image URL if image exists
        ], 201);
    }         



    public function update(Request $request)
    {
    // Log the incoming data for debugging purposes
    Log::info('Incoming request data:', $request->all());

    // Validate the request data
    $validated = $request->validate([
        'id' => 'required|integer|exists:menu_items,id',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'category_id' => 'required|integer',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
    ]);

    // Find the menu item by id
    $menu = Menu_items_model::findOrFail($validated['id']); // Will throw 404 if not found

    // Update the fields with validated data
    $menu->name = $validated['name'];
    $menu->description = $validated['description'] ?? $menu->description; // Preserve existing description if none provided
    $menu->price = $validated['price'];
    $menu->category_id = $validated['category_id'];

    // Handle image upload if provided
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('uploads', 'public');
        $menu->image = $imagePath; // Update image path
    }

    // Save the updated menu item
    $menu->save();

    // Return a success response
    return response()->json(['success' => true, 'message' => 'Menu item updated successfully'], 200);
    }
   

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:menu_items,id'
        ]);

        try {
            $menuItem = Menu_items_model::findOrFail($request->id);
            $menuItem->delete();

            return response()->json(['success' => true, 'message' => 'Menu item deleted successfully'], 200);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
    
    
}
