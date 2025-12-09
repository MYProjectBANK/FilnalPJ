<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// profile
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user/update', [AuthController::class, 'updateProfile']);
});

/*
|--------------------------------------------------------------------------
| Public Dorm Routes (User Homepage)
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\DormController;
use App\Http\Controllers\PublicDormController;

Route::get('/dorms', [DormController::class, 'index']);
Route::get('/dorms/{id}', [DormController::class, 'show']);

Route::prefix('dorms')->group(function () {
    Route::get('/recommend', [PublicDormController::class, 'recommend']);
    Route::get('/nearby', [PublicDormController::class, 'nearby']);
    Route::get('/by-category/{id}', [PublicDormController::class, 'byCategory']);
});


/*
|--------------------------------------------------------------------------
| Favorites (User)
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\FavoriteController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/favorites/add/{dorm_id}', [FavoriteController::class, 'add']);
    Route::delete('/favorites/remove/{dorm_id}', [FavoriteController::class, 'remove']);
    Route::get('/favorites', [FavoriteController::class, 'list']);
});

/*
|--------------------------------------------------------------------------
| Reviews (User)
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\ReviewController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{id}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);
});

Route::get('/reviews/{dorm_id}', [ReviewController::class, 'list']);

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected)
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\AdminReviewController;
use App\Http\Controllers\AdminDormController;
use App\Http\Controllers\AdminAmenityController;
use App\Http\Controllers\AdminZoneController;
use App\Http\Controllers\AdminBusRouteController;
use App\Http\Controllers\AdminTrainLineController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminDormImageController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminCategoryController;


Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard/stats', [AdminDashboardController::class, 'stats']);

    // Dorm CRUD
    Route::get('/dorms', [AdminDormController::class,'index']);
    Route::post('/dorms', [AdminDormController::class,'store']);
    Route::get('/dorms/{id}', [AdminDormController::class,'show']);
    Route::put('/dorms/{id}', [AdminDormController::class,'update']);
    Route::delete('/dorms/{id}', [AdminDormController::class,'destroy']);

    // Categories
    Route::get('/categories', [AdminCategoryController::class,'index']);
    Route::post('/categories', [AdminCategoryController::class,'store']);
    Route::get('/categories/{id}', [AdminCategoryController::class,'show']);
    Route::put('/categories/{id}', [AdminCategoryController::class,'update']);
    Route::delete('/categories/{id}', [AdminCategoryController::class,'destroy']);

    // Amenities
    Route::get('/amenities', [AdminAmenityController::class,'index']);
    Route::post('/amenities', [AdminAmenityController::class,'store']);
    Route::get('/amenities/{id}', [AdminAmenityController::class,'show']);
    Route::put('/amenities/{id}', [AdminAmenityController::class,'update']);
    Route::delete('/amenities/{id}', [AdminAmenityController::class,'destroy']);

    // Zones
    Route::get('/zones', [AdminZoneController::class,'index']);
    Route::post('/zones', [AdminZoneController::class,'store']);
    Route::get('/zones/{id}', [AdminZoneController::class,'show']);
    Route::put('/zones/{id}', [AdminZoneController::class,'update']);
    Route::delete('/zones/{id}', [AdminZoneController::class,'destroy']);

    // Bus Routes
    Route::get('/bus-routes', [AdminBusRouteController::class,'index']);
    Route::post('/bus-routes', [AdminBusRouteController::class,'store']);
    Route::get('/bus-routes/{id}', [AdminBusRouteController::class,'show']);
    Route::put('/bus-routes/{id}', [AdminBusRouteController::class,'update']);
    Route::delete('/bus-routes/{id}', [AdminBusRouteController::class,'destroy']);

    // Train Lines
    Route::get('/train-lines', [AdminTrainLineController::class,'index']);
    Route::post('/train-lines', [AdminTrainLineController::class,'store']);
    Route::get('/train-lines/{id}', [AdminTrainLineController::class,'show']);
    Route::put('/train-lines/{id}', [AdminTrainLineController::class,'update']);
    Route::delete('/train-lines/{id}', [AdminTrainLineController::class,'destroy']);

    // Reviews Moderation
    Route::get('/reviews/pending', [AdminReviewController::class, 'pending']);
    Route::put('/reviews/{id}/approve', [AdminReviewController::class, 'approve']);
    Route::put('/reviews/{id}/reject', [AdminReviewController::class, 'reject']);

    // Users
    Route::get('/users', [AdminUserController::class,'index']);
    Route::post('/users', [AdminUserController::class,'store']);
    Route::get('/users/{id}', [AdminUserController::class,'show']);
    Route::put('/users/{id}', [AdminUserController::class,'update']);
    Route::delete('/users/{id}', [AdminUserController::class,'destroy']);
});

/*
|--------------------------------------------------------------------------
| Misc
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\MetadataController;

Route::get('/metadata/faculties', [MetadataController::class, 'faculties']);
Route::get('/metadata/year-levels', [MetadataController::class, 'yearLevels']);

use App\Http\Controllers\PublicCategoryController;

Route::get('/categories', [PublicCategoryController::class, 'index']);

Route::prefix('dorms')->group(function () {
    Route::get('/recommend', [PublicDormController::class, 'recommend']);
    Route::get('/nearby', [PublicDormController::class, 'nearby']);
    Route::get('/by-category/{id}', [PublicDormController::class, 'byCategory']);
});
