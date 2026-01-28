<?php

namespace App\Http\Controllers;

use App\Models\Behandeling;
use App\Models\Factuur;
use App\Models\Patient;
use App\Models\Persoon;
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
    public function factuurPatient()
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

    //form pagina
    public function create(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|integer',
        ]);

        $behandelingen = Behandeling::all();

        // Prijzen voor behandelingen
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
        //validatie
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
        // Prijzen voor behandelingen
        $prijzen = [
            'Controles' => 50.00,
            'Vullingen' => 150.00,
            'Gebitsreiniging' => 75.00,
            'Orthodontie' => 500.00,
            'Wortelkanaalbehandelingen' => 350.00,
        ];

        //Unhappy scenario: check of patient actief is
        $patient = Patient::find($request->patient_id);
        if ($patient->Isactief === 0) {
            Log::warning('Probeer factuur aan te maken voor niet-actieve patiënt Id: '.$request->patient_id);
            return redirect()
                ->back()
                ->with('error', 'Kan geen factuur aanmaken voor een niet-actieve patiënt.');
        }
        //maakt een factuur aan

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
        Log::info('Factuur aangemaakt voor PatientId: '.$request->patient_id);

        return redirect()
            ->route('overzicht-patienten.index')
            ->with('success', 'Factuur succesvol aangemaakt, zie de factuur overzicht bij de Factuur pagina.');
    }

    public function delete(Request $request)
    {
        $factuur = Factuur::find($request->id);
        if (!$factuur) {
            Log::warning('Factuur niet gevonden voor verwijdering. Id: ' . $request->id);
            return redirect()->back();
        }
        $factuur->delete();
        Log::info('Factuur verwijderd. Id: ' . $request->id);
        return redirect()->back()->with('success', 'Factuur succesvol verwijderd.');
    }

    public function edit($Id) {
        $gebruikerid = auth()->id();
        $persoon = Persoon::where('GebruikerId', $gebruikerid)->first();
        $factuur = Factuur::find($Id);
        $behandeling = Behandeling::find($Id);
       

        return view('factuur.edit', [
            'title' => 'Mijn Facturen',
            'factuur' => $factuur,
            'behandeling' => $behandeling,
        ]);
    }

    public function update(Request $request) {
        // validatie
        $request->validate([
            'Nummer' => 'required|string',
            'Omschrijving' => 'required|string',
            'Datum' => 'required|date',
            'Tijd' => [
                'required',
                'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/',
            ],
            'Status' => 'required|string',
            'Bedrag' => 'required|numeric',
        ]);

        $factuur = Factuur::find($request->Id);
        if (!$factuur) {
            Log::warning('Factuur niet gevonden voor update. Id: ' . $request->Id);
            return redirect()->back()->with('error', 'Factuur niet gevonden.');
        }
        $factuur->Nummer = $request->Nummer;
        $factuur->Omschrijving = $request->Omschrijving;
        $factuur->Datum = $request->Datum;
        $factuur->Tijd = $request->Tijd;
        $factuur->Status = $request->Status;
        $factuur->Bedrag = $request->Bedrag;
        $factuur->save();

        Log::info('Factuur bijgewerkt. Id: ' . $factuur->Id);
        return redirect()->route('factuur.index')->with('success', 'Factuur succesvol bijgewerkt.');
        
    }
}
