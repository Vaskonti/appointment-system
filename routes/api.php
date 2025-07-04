<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Middleware\EnsureHeaders;
use Illuminate\Support\Facades\Route;

Route::middleware(EnsureHeaders::class)->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
});
