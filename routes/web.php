<?php

use App\Http\Controllers\FactuurController;
use App\Http\Controllers\MedewerkerOverzichtController;
use App\Http\Controllers\patientenController;
use App\Http\Controllers\PraktijkmanagementController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/praktijkmanagement/berichten', [PraktijkmanagementController::class, 'OverzichtBerichten'])
    ->name('praktijkmanagement.berichten')
    ->middleware(['auth', 'role:praktijkmanagement']);

Route::get('/praktijkmanagement/createBericht', [PraktijkmanagementController::class, 'createBericht'])
    ->name('praktijkmanagement.createBericht')
    ->middleware(['auth', 'role:praktijkmanagement']);
    
Route::post('/praktijkmanagement/storeBericht', [PraktijkmanagementController::class, 'storeBericht'])
    ->name('praktijkmanagement.storeBericht')
    ->middleware(['auth', 'role:praktijkmanagement']);


Route::get('/praktijkmanagement/index', [PraktijkmanagementController::class, 'index'])
    ->name('praktijkmanagement.index')
    ->middleware(['auth', 'role:praktijkmanagement']);

Route::get('/factuur', [FactuurController::class, 'index'])
    ->name('factuur.index')
    ->middleware(['auth', 'role:tandarts,praktijkmanagement,assistent,mondhygienist']);

Route::get('/facturenOverzichtPatient', [FactuurController::class, 'facturenPatient'])
    ->name('facturenOverzichtPatient.index')
    ->middleware(['auth', 'role:patient']);

Route::get('/factuur/create', [FactuurController::class, 'create'])
    ->middleware(['auth', 'role:tandarts,praktijkmanagement,assistent,mondhygienist'])
    ->name('factuur.create');

Route::post('/factuur/store', [FactuurController::class, 'store'])
    ->middleware(['auth', 'role:tandarts,praktijkmanagement,assistent,mondhygienist'])
    ->name('factuur.store');

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
