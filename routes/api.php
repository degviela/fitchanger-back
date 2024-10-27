<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClothingItemController;
use App\Http\Controllers\OutfitController;

Route::prefix('authenticated')->group(function(){

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// ClothingItem routes
Route::post('/clothing-items', [ClothingItemController::class, 'store']);

Route::get('/clothingitems', [ClothingItemController::class, 'index']);

Route::get('/clothingitems/{id}', [ClothingItemController::class, 'show']);

Route::put('/clothingitems/{id}', [ClothingItemController::class, 'update']);

Route::delete('/clothingitems/{id}', [ClothingItemController::class, 'destroy']);


// Outfit routessss
Route::post('/outfits', [OutfitController::class, 'store']);

Route::get('/outfits', [OutfitController::class, 'index']);

Route::get('/outfits/{id}', [OutfitController::class, 'show']);

Route::put('/outfits/{id}', [OutfitController::class, 'update']);

Route::delete('/outfits/{id}', [OutfitController::class, 'destroy']);

})->middleware('auth:sanctum');
