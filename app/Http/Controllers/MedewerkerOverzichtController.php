<?php

namespace App\Http\Controllers;

use App\Models\MedewerkerOverzichtModel;
use Illuminate\Support\Facades\Log;


class MedewerkerOverzichtController extends Controller
{
    public function index()
    {
        $medewerkers = MedewerkerOverzichtModel::with('persoon')->get();

        if ($medewerkers->isEmpty()) {
            Log::info('Geen medewerkers beschikbaar.');
        }

        return view('Medewerker.MedewerkerOverzicht', ['medewerkers' => $medewerkers, 'title' => 'Medewerker Overzicht']);
    }
}
