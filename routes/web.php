<?php

use App\Http\Controllers\FactuurController;
use App\Http\Controllers\MedewerkerOverzichtController;
<<<<<<< HEAD
use App\Http\Controllers\patientenController;
use App\Http\Controllers\PraktijkmanagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BerichtController;
use Illuminate\Support\Facades\Route;
=======
use App\Http\Controllers\AfspraakController;
>>>>>>> 095a80e (afspraak overzicht voor alle rollen patient rol heeft zijn eigen unieke pagina)

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/berichten', [BerichtController::class, 'index'])
    ->name('berichten.index')
    ->middleware(['auth', 'role:praktijkmanagement']);

Route::get('/berichten/create', [BerichtController::class, 'create'])
    ->name('berichten.create')
    ->middleware(['auth', 'role:praktijkmanagement']);
    
Route::post('/berichten', [BerichtController::class, 'store'])
    ->name('berichten.store')
    ->middleware(['auth', 'role:praktijkmanagement']);


Route::get('/praktijkmanagement/index', [PraktijkmanagementController::class, 'index'])
    ->name('praktijkmanagement.index')
    ->middleware(['auth', 'role:praktijkmanagement']);

Route::get('/factuur', [FactuurController::class, 'index'])
    ->name('factuur.index')
    ->middleware(['auth', 'role:tandarts,praktijkmanagement,assistent,mondhygienist']);

Route::get('/factuur/factuurPatient', [FactuurController::class, 'factuurPatient'])
    ->name('factuur.factuurPatient')
    ->middleware(['auth', 'role:patient']);

<<<<<<< HEAD
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
=======
    Route::get('/afspraken', [AfspraakController::class, 'index'])
        ->name('afspraken.index')
        ->middleware(['auth', 'role:tandarts,praktijkmanagement,assistent,mondhygienist,patient']);
>>>>>>> 095a80e (afspraak overzicht voor alle rollen patient rol heeft zijn eigen unieke pagina)

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
