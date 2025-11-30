<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ApplicationController;

// Public routes
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/positions', [PublicController::class, 'index'])->name('positions.index');
Route::get('/positions/{id}/apply', [PublicController::class, 'showApplicationForm'])->name('positions.apply');

// Application routes
Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');
Route::get('/application/success', [ApplicationController::class, 'success'])->name('application.success');
