<?php

namespace App\Http\Controllers;

use App\Models\ClothingItem;
use App\Models\Outfit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
    }
}
