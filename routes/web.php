<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());
});

Route::middleware('auth:sanctum')->put('/profile/update', [UserController::class, 'update'])->name('profile.update');
Route::middleware('auth:sanctum')->post('/profile/update-picture', [UserController::class, 'updatePicture'])->name('profile.update.picture');

require __DIR__.'/auth.php';
