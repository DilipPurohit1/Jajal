<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Laravel Sanctum protected endpoints and authentication for Medical Case Management.
|
*/

// Public Authentication Endpoint
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// Protected Routes (Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user(),
            'message' => 'User profile retrieved successfully.',
        ]);
    });

    // Medical Cases API
    Route::get('/cases', [CaseApiController::class, 'index'])->name('api.cases.index');
    Route::post('/cases', [CaseApiController::class, 'store'])->name('api.cases.store');
    Route::get('/cases/{id}', [CaseApiController::class, 'show'])->name('api.cases.show');
    Route::put('/cases/{id}', [CaseApiController::class, 'update'])->name('api.cases.update');
    Route::delete('/cases/{id}', [CaseApiController::class, 'destroy'])->name('api.cases.destroy');
});
