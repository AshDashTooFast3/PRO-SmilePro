<?php

use App\Http\Controllers\MedewerkerOverzichtController;
use App\Http\Controllers\patientenController;
use App\Http\Controllers\PraktijkmanagementController;
use App\Http\Controllers\ProfileController;
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

Route::get('/facturenOverzichtPatient', [patientenController::class, 'facturenPatient'])
    ->name('facturenOverzichtPatient.index')
    ->middleware(['auth', 'role:patient']);

Route::get('/medewerkers', [MedewerkerOverzichtController::class, 'index'])
        ->middleware(['auth', 'role:praktijkmanagement'])
        ->name('medewerkers.overzicht');

Route::get('/Patient-toevoegen', [patientenController::class, 'create'])
    ->name('patienten.toevoegen')
    ->middleware(['auth', 'role:tandarts,praktijkmanagement,assistent,mondhygienist']);

Route::post('/Patient-toevoegen-update', [patientenController::class, 'update'])
    ->name('patienten.toevoegen-update')
    ->middleware(['auth', 'role:tandarts,praktijkmanagement,assistent,mondhygienist']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/overzicht-patienten', [patientenController::class, 'overzicht'])
    ->name('overzicht-patienten.index')
    ->middleware(['auth', 'role:tandarts,praktijkmanagement,assistent,mondhygienist']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
