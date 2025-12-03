<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class patientenController extends Controller
{
    public function overzicht()
    {
        $patienten = Patient::getVolledigeNaamPatienten();

        return view('patienten.overzicht-patienten',
            [
                'patienten' => $patienten,
                'title' => 'Patienten Overzicht',
            ]);
    }

    public function facturenPatient()
{
    $gebruiker = Auth::user();

    // Haal de patient via de relaties
    $patient = $gebruiker->patient;

    if (! $patient->factuur) {
        Log::info('Geen facturen beschikbaar.');
        return view('patienten.factuurPatient', ['facturen' => [], 'title' => 'Mijn Facturen']);
    }

    $patientId = $patient->Id;

    $facturen = Patient::getPatientFactuur($patientId);

    return view('patienten.factuurPatient', ['facturen' => $facturen, 'title' => 'Mijn Facturen']);
}
}
