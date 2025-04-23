<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClothingItemController;
use App\Http\Controllers\OutfitController;
use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json([
        'user' => $request->user(),
    ]);
});
//User needed routes

Route::get('/users/search', [UserController::class, 'search']);

Route::get('/users/{id}', [UserController::class, 'show']);


// ClothingItem routes
Route::post('/clothingitems', [ClothingItemController::class, 'store']);

Route::get('/clothingitems', [ClothingItemController::class, 'index']);

Route::get('/clothingitems/{id}', [ClothingItemController::class, 'getClothingItemById']);

Route::put('/clothingitems/{id}', [ClothingItemController::class, 'update']);

Route::delete('/clothingitems/{id}', [ClothingItemController::class, 'destroy']);


// Outfit routes
Route::post('/outfits', [OutfitController::class, 'store']);

Route::get('/outfits', [OutfitController::class, 'index']);

Route::get('/outfits/user/{userId}', [OutfitController::class, 'getByUserId']);

Route::put('/outfits/{id}', [OutfitController::class, 'update']);

Route::delete('/outfits/{id}', [OutfitController::class, 'destroy']);

        Route::post('clothing-items/validate', [ClothingItemController::class, 'validateClothingItem']);

        Route::post('clothing-items', [ClothingItemController::class, 'store']);

