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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user/update', [AuthController::class, 'updateProfile']);
});


/*
|--------------------------------------------------------------------------
| PUBLIC — Homepage API
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\DormController;
use App\Http\Controllers\PublicDormController;
use App\Http\Controllers\PublicCategoryController;

// Public categories
Route::get('/categories', [PublicCategoryController::class, 'index']);

Route::prefix('dorms')->group(function () {

    // ✅ แก้เป็น /suggest (ไม่ต้องมี /dorms ซ้ำ)
    Route::get('/suggest', [DormController::class, 'suggest']);

    // ⭐ ฟิลเตอร์ต้องมาก่อน
    Route::get('/filter', [PublicDormController::class, 'filter']);

    // ⭐ ต้องอยู่ก่อนแบบนี้เท่านั้น!!
    Route::get('/recommend', [PublicDormController::class, 'recommend']);
    Route::get('/nearby', [PublicDormController::class, 'nearby']);
    Route::get('/by-category/{id}', [PublicDormController::class, 'byCategory']);

    // ⭐ ต้องอยู่ล่างสุด
    Route::get('/', [PublicDormController::class, 'index']);

    // ✅ แนะนำเพิ่ม constraint กัน suggest ชนอีกชั้น
    Route::get('/{id}', [PublicDormController::class, 'show'])->whereNumber('id');
});


use App\Http\Controllers\PublicAmenityController;
use App\Http\Controllers\PublicBusRouteController;

Route::get('/amenities', [PublicAmenityController::class, 'index']);
Route::get('/bus-routes', [PublicBusRouteController::class, 'index']);



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
| ADMIN Routes (Protected)
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

    // Dashboard stats
    Route::get('/dashboard/stats', [AdminDashboardController::class, 'stats']);

    // Dorm CRUD
    Route::apiResource('dorms', AdminDormController::class);

    // Categories
    Route::apiResource('categories', AdminCategoryController::class);

    // Amenities
    Route::apiResource('amenities', AdminAmenityController::class);

    // Zones
    Route::apiResource('zones', AdminZoneController::class);

    // Bus Routes
    Route::apiResource('bus-routes', AdminBusRouteController::class);

    // Train Lines
    Route::apiResource('train-lines', AdminTrainLineController::class);

    // Review Moderation
    Route::get('/reviews/pending', [AdminReviewController::class, 'pending']);
    Route::put('/reviews/{id}/approve', [AdminReviewController::class, 'approve']);
    Route::put('/reviews/{id}/reject', [AdminReviewController::class, 'reject']);

    // Users
    Route::apiResource('users', AdminUserController::class);

    Route::delete('/dorm-images/{id}', [AdminDormController::class, 'deleteImage']);

});


/*
|--------------------------------------------------------------------------
| Misc
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\MetadataController;

Route::get('/metadata/faculties', [MetadataController::class, 'faculties']);
Route::get('/metadata/year-levels', [MetadataController::class, 'yearLevels']);
