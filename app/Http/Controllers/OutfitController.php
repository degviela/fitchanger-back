<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outfit;
use App\Models\ClothingItem;

class OutfitController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'clothing_item_ids' => 'required|array',
            'clothing_item_ids.*' => 'exists:clothing_items,id',
        ]);

        $outfit = Outfit::create([
            'user_id' => $validatedData['user_id'],
            'name' => $validatedData['name'],
        ]);

        $clothingItems = ClothingItem::whereIn('id', $validatedData['clothing_item_ids'])->get();
        $outfit->clothingItems()->attach($clothingItems);

        return response()->json($outfit->load('clothingItems'), 201);
    }
}
