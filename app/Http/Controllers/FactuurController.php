<?php

namespace App\Http\Controllers;

use App\Models\Behandeling;
use App\Models\Factuur;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FactuurController extends Controller
{
    
    public function index()
    {
        $facturen = Factuur::getAllFacturen();

        return view('factuur.index', [
            'title' => 'Facturen Overzicht',
            'facturen' => $facturen,
        ]);
    }
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

    public function create(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|integer',
        ]);

        $behandelingen = Behandeling::all();

        $prijzen = [
            'Controles' => 50.00,
            'Vullingen' => 150.00,
            'Gebitsreiniging' => 75.00,
            'Orthodontie' => 500.00,
            'Wortelkanaalbehandelingen' => 350.00,
        ];

        return view('factuur.create', [
            'patient_id' => $request->patient_id, 'title' => 'Factuur Maken',
            'behandelingen' => $behandelingen,
            'prijzen' => $prijzen,
        ]);

    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|integer',
            'behandeling_id' => 'required|integer',
            'behandeling' => 'required|string',
            'omschrijving' => 'required|string',
            'datum' => 'required|date',
            'tijd' => [
                'required',
                'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/',
            ],
        ]);

        $prijzen = [
            'Controles' => 50.00,
            'Vullingen' => 150.00,
            'Gebitsreiniging' => 75.00,
            'Orthodontie' => 500.00,
            'Wortelkanaalbehandelingen' => 350.00,
        ];

        $patient = Patient::find($request->patient_id);
        if ($patient->Isactief === 0) {
            return redirect()
                ->back()
                ->with('error', 'Kan geen factuur aanmaken voor een niet-actieve patiënt.');
        }

        Factuur::create([
            'PatientId' => $request->patient_id,
            'BehandelingId' => $request->behandeling_id,
            'Behandeling' => $request->behandeling,
            'Omschrijving' => $request->omschrijving,
            'Bedrag' => $prijzen[$request->behandeling],
            'Datum' => $request->datum,
            'Tijd' => $request->tijd,
            'Nummer' => 'FAC'.str_pad(Factuur::max('Id') + 1, 6, '0', STR_PAD_LEFT),
            'Isactief' => false,
        ]);

        return redirect()
            ->route('overzicht-patienten.index')
            ->with('success', 'Factuur succesvol aangemaakt, zie de factuur overzicht bij de Factuur pagina.');
    }
}
