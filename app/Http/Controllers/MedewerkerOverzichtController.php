<?php

namespace App\Http\Controllers;

use App\Models\MedewerkerOverzichtModel;

class MedewerkerOverzichtController extends Controller
{
    public function index()
    {
        $medewerkers = MedewerkerOverzichtModel::with('persoon')->get();

        return view('Medewerker.MedewerkerOverzicht', compact('medewerkers'));
    }
}
