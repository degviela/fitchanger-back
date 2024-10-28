<?php

namespace App\Http\Controllers;

use App\Models\Outfit;
use App\Models\ClothingItem;
use Illuminate\Http\Request;

class OutfitController extends Controller
{
    /**
     * Display a listing of the outfits.
     */
    public function index()
    {
        $outfits = Outfit::all();
        return response()->json($outfits);
    }

    /**
     * Store a newly created outfit in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        try {
            // Fetch clothing items by type
            $clothingItems = ClothingItem::whereIn('type', ['head', 'top', 'bottom', 'footwear'])->get();
            $clothingItemIds = [];

            foreach ($clothingItems as $item) {
                $clothingItemIds[$item->type . '_id'] = $item->id;
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

    /**
     * Display the specified outfit.
     */
    public function show($id)
    {
        try {
            $outfit = Outfit::findOrFail($id);
            return response()->json($outfit);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Outfit not found'], 404);
        }
    }

    /**
     * Update the specified outfit in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        try {
            $outfit = Outfit::findOrFail($id);

            // Fetch clothing items by type
            $clothingItems = ClothingItem::whereIn('type', ['head', 'top', 'bottom', 'footwear'])->get();
            $clothingItemIds = [];

            foreach ($clothingItems as $item) {
                $clothingItemIds[$item->type . '_id'] = $item->id;
            }

            // Add clothing item IDs to the validated data
            $validatedData = array_merge($validatedData, $clothingItemIds);

            $outfit->update($validatedData);
            return response()->json($outfit, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    /**
     * Remove the specified outfit from storage.
     */
    public function destroy($id)
    {
        try {
            $outfit = Outfit::findOrFail($id);
            $outfit->delete();
            return response()->json(null, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error'], 500);
        }
    }
}
