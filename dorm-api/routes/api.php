<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DormController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminReviewController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/dorms', [DormController::class, 'index']);
Route::get('/dorms/{id}', [DormController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Update Profile
    Route::put('/user/update', [AuthController::class, 'updateProfile']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/favorites/add/{dorm_id}', [FavoriteController::class, 'add']);
    Route::delete('/favorites/remove/{dorm_id}', [FavoriteController::class, 'remove']);
    Route::get('/favorites', [FavoriteController::class, 'list']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{id}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);
});

Route::middleware(['auth:sanctum','admin'])->group(function () {
    Route::get('/admin/reviews/pending', [AdminReviewController::class, 'pending']);
    Route::put('/admin/reviews/{id}/approve', [AdminReviewController::class, 'approve']);
    Route::put('/admin/reviews/{id}/reject', [AdminReviewController::class, 'reject']);
});

Route::get('/reviews/{dorm_id}', [ReviewController::class, 'list']);


// ----------------------------------------admin zone---------------------------------------------------

use App\Http\Controllers\AdminDormController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminAmenityController;
use App\Http\Controllers\AdminZoneController;

Route::middleware(['auth:sanctum','admin'])->prefix('admin')->group(function () {
    // Dorm
    Route::get('/dorms', [AdminDormController::class,'index']);
    Route::post('/dorms', [AdminDormController::class,'store']);
    Route::get('/dorms/{id}', [AdminDormController::class,'show']);
    Route::put('/dorms/{id}', [AdminDormController::class,'update']);
    Route::delete('/dorms/{id}', [AdminDormController::class,'destroy']);

    // Category
    Route::get('/categories', [AdminCategoryController::class,'index']);
    Route::post('/categories', [AdminCategoryController::class,'store']);
    Route::get('/categories/{id}', [AdminCategoryController::class,'show']);
    Route::put('/categories/{id}', [AdminCategoryController::class,'update']);
    Route::delete('/categories/{id}', [AdminCategoryController::class,'destroy']);

    // Amenity
    Route::get('/amenities', [AdminAmenityController::class,'index']);
    Route::post('/amenities', [AdminAmenityController::class,'store']);
    Route::get('/amenities/{id}', [AdminAmenityController::class,'show']);
    Route::put('/amenities/{id}', [AdminAmenityController::class,'update']);
    Route::delete('/amenities/{id}', [AdminAmenityController::class,'destroy']);

    // Zone
    Route::get('/zones', [AdminZoneController::class,'index']);
    Route::post('/zones', [AdminZoneController::class,'store']);
    Route::get('/zones/{id}', [AdminZoneController::class,'show']);
    Route::put('/zones/{id}', [AdminZoneController::class,'update']);
    Route::delete('/zones/{id}', [AdminZoneController::class,'destroy']);
});



