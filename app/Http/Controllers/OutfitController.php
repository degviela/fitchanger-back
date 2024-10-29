<?php

namespace App\Http\Controllers;

use App\Models\Outfit;
use App\Models\ClothingItem;
use Illuminate\Http\Request;

class OutfitController extends Controller
{
    /**
     * Fetch all outfits.
     */
    public function index()
    {
        $outfits = Outfit::all();
        return response()->json($outfits);
    }

    /**
     * Fetch outfits by user ID.
     */
    public function getByUserId($userId)
    {
        $outfits = Outfit::where('user_id', $userId)->get();
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
            'clothing_items' => 'required|array',
            'clothing_items.*.type' => 'required|in:head,top,bottom,footwear',
            'clothing_items.*.id' => 'required|exists:clothing_items,id',
        ]);

        try {
            $clothingItemIds = [
                'head_id' => null,
                'top_id' => null,
                'bottom_id' => null,
                'footwear_id' => null,
            ];

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

            $validatedData = array_merge($validatedData, $clothingItemIds);

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
            'clothing_items' => 'required|array',
            'clothing_items.*.type' => 'required|in:head,top,bottom,footwear',
            'clothing_items.*.id' => 'required|exists:clothing_items,id',
        ]);

        try {
            $outfit = Outfit::findOrFail($id);

            $clothingItemIds = [
                'head_id' => null,
                'top_id' => null,
                'bottom_id' => null,
                'footwear_id' => null,
            ];

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
