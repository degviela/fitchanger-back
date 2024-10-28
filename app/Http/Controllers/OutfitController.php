<?php

namespace App\Http\Controllers;

use App\Models\Outfit;
use App\Models\ClothingItem;
use Illuminate\Http\Request;

class OutfitController extends Controller
{
    /**
     * Store a newly created outfit in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'clothing_items' => 'required|array',
            'clothing_items.*.type' => 'required|in:head,top,bottom,footwear',
            'clothing_items.*.id' => 'required|exists:clothing_items,id',
        ]);

        try {
            // Initialize clothing item IDs
            $clothingItemIds = [
                'head_id' => null,
                'top_id' => null,
                'bottom_id' => null,
                'footwear_id' => null,
            ];

            // Assign clothing item IDs based on type
            foreach ($request->clothing_items as $item) {
                switch ($item['type']) {
                    case 'head':
                        $clothingItemIds['head_id'] = $item['id'];
                        break;
                    case 'top':
                        $clothingItemIds['top_id'] = $item['id'];
                        break;
                    case 'bottom':
                        $clothingItemIds['bottom_id'] = $item['id'];
                        break;
                    case 'footwear':
                        $clothingItemIds['footwear_id'] = $item['id'];
                        break;
                }
            }

            // Add clothing item IDs to the validated data
            $validatedData = array_merge($validatedData, $clothingItemIds);

            // Create the outfit
            $outfit = Outfit::create($validatedData);
            return response()->json($outfit, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error'], 500);
        }
    }
}
