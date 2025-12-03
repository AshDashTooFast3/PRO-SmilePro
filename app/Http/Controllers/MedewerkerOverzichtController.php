<?php

namespace App\Http\Controllers;

use App\Models\MedewerkerOverzichtModel;

class MedewerkerOverzichtController extends Controller
{
    public function index()
    {
        // Toggle hier: zet op true of false om scenario te simuleren
        $toonMedewerkers = true;

        $medewerkers = $toonMedewerkers
            ? MedewerkerOverzichtModel::with('persoon')->get()
            : collect(); // lege collectie → unhappy scenario

        return view('Medewerker.MedewerkerOverzicht', ['medewerkers' => $medewerkers, 'title' => 'Medewerker Overzicht']);
    }
}
