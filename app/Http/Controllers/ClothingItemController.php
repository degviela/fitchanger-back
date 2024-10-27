<?php

namespace App\Http\Controllers;

use App\Models\ClothingItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClothingItemController extends Controller
{
    /**
     * Store a newly created clothing item in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:head,top,bottom,footwear',
            'name' => 'required|string|max:255',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'outfit_ids' => 'required|array',
            'outfit_ids.*' => 'exists:outfits,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            // Store the image
            $imagePath = $request->file('image')->store('clothing_items', 'public');

            // Create the clothing item
            $clothingItem = ClothingItem::create([
                'type' => $request->type,
                'name' => $request->name,
                'image_path' => $imagePath,
            ]);

            // Attach the clothing item to the outfits
            $clothingItem->outfits()->attach($request->outfit_ids);

            return response()->json([
                'message' => 'Clothing item created successfully!',
                'clothingItem' => $clothingItem
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    /**
     * Update the specified clothing item in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image',
        ]);

        try {
            $clothingItem = ClothingItem::findOrFail($id);
            $clothingItem->update($validatedData);

            return response()->json($clothingItem, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    /**
     * Remove the specified clothing item from storage.
     */
    public function destroy($id)
    {
        try {
            $clothingItem = ClothingItem::findOrFail($id);
            $clothingItem->delete();

            return response()->json(null, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error'], 500);
        }
    }
}
