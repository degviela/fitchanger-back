<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClothingItemController;
use App\Http\Controllers\OutfitController;
use App\Http\Controllers\UserController;

Route::get('/setup', function () {

    Artisan::call('migrate');

    Artisan::call('storage:link');

    return 'Migrations executed and storage link created successfully!';
});

Route::get('/prep-for-cors-edit', function () {
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    // Artisan::call('cache:clear');
    Artisan::call('optimize:clear');
    Artisan::call('config:cache');
    return "✔️ Prepped for CORS edit. All caches cleared. You can now safely update config/cors.php.";
});

Route::get('/finalize-after-cors-edit', function () {
    Artisan::call('config:cache');
    Artisan::call('route:cache');

    return "✅ CORS config finalized. Configuration and routes cached.";
});

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

