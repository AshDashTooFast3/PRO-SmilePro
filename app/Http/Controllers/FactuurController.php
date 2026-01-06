<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Factuur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FactuurController extends Controller
{
    public function facturenPatient()
    {
        $gebruiker = Auth::user();

        // Haal de patient via de relaties
        $patient = $gebruiker->patient;

        if (empty($patient)) {
            Log::info('gebruiker is niet gekoppeld aan Patient.');

            return view('factuur.factuurPatient', ['facturen' => [], 'title' => 'Mijn Facturen']);
        }

        $patientId = $patient->Id;

        $facturen = Patient::getPatientFactuur($patientId);

        if (empty($facturen)) {
            Log::info('Geen facturen beschikbaar.');

            return view('factuur.factuurPatient', ['facturen' => [], 'title' => 'Mijn Facturen']);
        }

        return view('factuur.factuurPatient', ['facturen' => $facturen, 'title' => 'Mijn Facturen']);
    }

    public function factuurmaken(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|integer',
        ]);

        
        $behandelingen = [
            'Controles' => 50.00,
            'Vullingen' => 150.00,
            'Gebitsreiniging' => 75.00,
            'Orthodontie' => 500.00,
            'Wortelkanaalbehandelingen' => 350.00,
        ];

        return view('factuur.factuurMaken', [
            'patient_id' => $request->patient_id, 'title' => 'Factuur Maken',
            'behandelingen' => $behandelingen,
        ]);

    }

public function create(Request $request)
{
    $request->validate([
        'Patient_id'   => 'required|integer',
        'behandeling'  => 'required|string',
        'omschrijving' => 'required|string',
        'datum'        => 'required|date',
        'tijd'         => 'required',
    ]);

    $prijzen = [
        'Controles' => 50.00,
        'Vullingen' => 150.00,
        'Gebitsreiniging' => 75.00,
        'Orthodontie' => 500.00,
        'Wortelkanaalbehandelingen' => 350.00,
    ];

    if (!array_key_exists($request->behandeling, $prijzen)) {
        abort(400, 'Onbekende behandeling');
    }

    Factuur::create([
        'patientId'  => $request->patient_id,
        'behandeling' => $request->behandeling,
        'omschrijving'=> $request->omschrijving,
        'prijs'       => $prijzen[$request->behandeling],
        'datum'       => $request->datum,
        'tijd'        => $request->tijd,
        'status'      => 'concept',
    ]);

    return redirect()
        ->route('overzicht-patienten.index')
        ->with('success', 'Factuur succesvol aangemaakt');
}

}
