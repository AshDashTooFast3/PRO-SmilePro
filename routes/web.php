<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PraktijkmanagementController;
use App\Http\Controllers\patientenController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/praktijkmanagement/index', [PraktijkmanagementController::class, 'index'])
    ->name('praktijkmanagement.index')
    ->middleware(['auth', 'role:praktijkmanagement']);


Route::get('/praktijkmanagement/berichten', [PraktijkmanagementController::class, 'berichten'])
    ->name('praktijkmanagement.berichten')
    ->middleware(['auth', 'role:praktijkmanagement']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/overzicht-patienten', [patientenController::class, 'index'])
    ->name('overzicht-patienten.index')
    ->middleware(['auth', 'role:tandarts,praktijkmanagment,assistent,mondhygienist']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
