<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\AdminController;

// Public routes
   Route::post('/admissions', [AdmissionController::class, 'store']);
Route::post('/enquiries', [EnquiryController::class, 'store']);

Route::post('/admin/login', [AuthController::class, 'login']);

// Admin protected routes
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Stats
    Route::get('/stats', [AdminController::class, 'stats']);

    // Admissions CRUD
 
    Route::get('/admissions', [AdmissionController::class, 'index']);
    Route::get('/admissions/{id}', [AdmissionController::class, 'show']);
    Route::put('/admissions/{id}', [AdmissionController::class, 'update']);
    Route::delete('/admissions/{id}', [AdmissionController::class, 'destroy']);

    // Enquiries CRUD
    Route::get('/enquiries', [EnquiryController::class, 'index']);
    Route::get('/enquiries/{id}', [EnquiryController::class, 'show']);
    Route::delete('/enquiries/{id}', [EnquiryController::class, 'destroy']);
});
