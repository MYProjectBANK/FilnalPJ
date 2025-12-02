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

Route::get('/reviews/{dorm_id}', [ReviewController::class, 'list']);


Route::middleware(['auth:sanctum','admin'])->group(function () {
    Route::get('/admin/reviews/pending', [AdminReviewController::class, 'pending']);
    Route::put('/admin/reviews/{id}/approve', [AdminReviewController::class, 'approve']);
    Route::put('/admin/reviews/{id}/reject', [AdminReviewController::class, 'reject']);
});


