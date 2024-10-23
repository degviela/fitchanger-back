<?php

namespace App\Http\Controllers;

use App\Models\Outfit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OutfitController extends Controller
{
    /**
     * Store a newly created outfit in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Create the outfit
        $outfit = Outfit::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Outfit created successfully!',
            'outfit' => $outfit
        ], 201);
    }
}
