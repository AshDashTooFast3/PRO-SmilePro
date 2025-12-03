<?php

namespace App\Http\Controllers;

use App\Models\MedewerkerOverzichtModel;
use Illuminate\Support\Facades\Log;


class MedewerkerOverzichtController extends Controller
{
    public function index()
    {
        // Toggle hier: zet op true of false om scenario te simuleren
        $toonMedewerkers = false;

        $medewerkers = $toonMedewerkers
            ? MedewerkerOverzichtModel::with('persoon')->get()
            : collect(); // lege collectie → unhappy scenario

        if ($medewerkers->isEmpty()) {
            Log::info('Geen medewerkers beschikbaar.');
        }

        return view('Medewerker.MedewerkerOverzicht', ['medewerkers' => $medewerkers, 'title' => 'Medewerker Overzicht']);
    }
}
