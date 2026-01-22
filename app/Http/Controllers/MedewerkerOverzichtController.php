<?php

namespace App\Http\Controllers;

use App\Models\Medewerker;
use Illuminate\Support\Facades\Log;

class MedewerkerOverzichtController extends Controller
{
    public function index()
    {
        $medewerkers = Medewerker::with('persoon')->get();

        if ($medewerkers->isEmpty()) {
            Log::info('Geen medewerkers beschikbaar.');
        }

        return view('Medewerker.MedewerkerOverzicht', ['medewerkers' => $medewerkers, 'title' => 'Medewerker Overzicht']);
    }
}
