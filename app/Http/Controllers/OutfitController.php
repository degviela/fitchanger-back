<?php

namespace App\Http\Controllers;

use App\Models\Outfit;
use Illuminate\Http\Request;

class OutfitController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'head_id' => 'required|exists:clothing_items,id',
            'top_id' => 'required|exists:clothing_items,id',
            'bottom_id' => 'required|exists:clothing_items,id',
            'footwear_id' => 'required|exists:clothing_items,id',
        ]);

        try {
            $outfit = Outfit::create($validatedData);
            return response()->json($outfit, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'head_id' => 'required|exists:clothing_items,id',
            'top_id' => 'required|exists:clothing_items,id',
            'bottom_id' => 'required|exists:clothing_items,id',
            'footwear_id' => 'required|exists:clothing_items,id',
        ]);

        try {
            $outfit = Outfit::findOrFail($id);
            $outfit->update($validatedData);
            return response()->json($outfit, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error'], 500);
        }
    }

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
