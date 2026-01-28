<?php

namespace App\Http\Controllers;

use App\Models\Gebruiker;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class patientenController extends Controller
{
    public function overzicht()
    {
        $patienten = Patient::getVolledigeNaamPatienten();

        if (empty($patienten)) {
            Log::info('Geen patienten beschikbaar.');
        }

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

        if (empty($patient)) {
            Log::info('gebruiker is niet gekoppeld aan Patient.');

            return view('patienten.factuurPatient', ['facturen' => [], 'title' => 'Mijn Facturen']);
        }

        $patientId = $patient->Id;

        $facturen = Patient::getPatientFactuur($patientId);

        if (empty($facturen)) {
            Log::info('Geen facturen beschikbaar.');

            return view('patienten.factuurPatient', ['facturen' => [], 'title' => 'Mijn Facturen']);
        }

        return view('patienten.factuurPatient', ['facturen' => $facturen, 'title' => 'Mijn Facturen']);
    }

    public function create()
    {
        try {
            $gebruikers = Gebruiker::All();

            if (empty($gebruikers)) {
                Log::info('Geen gebruikers beschikbaar.');
            }

            return view('patienten.Create-Patient', [
                'title' => 'Patient Toevoegen',
                'gebruikers' => $gebruikers,
            ]);
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen gebruikers: '.$e->getMessage());

            return view('patienten.Create-Patient', [
                'title' => 'Patient Toevoegen',
                'gebruikers' => [],
            ]);
        }
    }

    public function edit($id)
    {

        $patient = Patient::find($id);

        if (! $patient) {
            Log::info('Patient niet gevonden met id: '.$id);

            return redirect()->route('overzicht-patienten.index')->with('error', 'Patient niet gevonden.'); // <-- Try dash instead of dot
            // If route name is 'patienten-overzicht-patienten', use:
            // return redirect()->route('patienten-overzicht-patienten')->with('error', 'Patient niet gevonden.');
        }

        return view('patienten.edit', [
            'title' => 'Patient wijzigen',
            'patient' => $patient,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string',
            'Nummer' => 'required|string',
            'MedischDossier' => 'nullable|string',
            'Opmerking' => 'nullable|string',
        ]);

        $patient = Patient::find($validated['id']);
        $patient->Nummer = $validated['Nummer'];
        $patient->MedischDossier = $validated['MedischDossier'] ?? null;
        $patient->Opmerking = $validated['Opmerking'] ?? null;
        $patient->save();        

        return redirect()->route('overzicht-patienten.index')->with('success', 'Patient succesvol bijgewerkt.');
    }

    public function delete(Request $request)
    {
        $patient = Patient::find($request->patient_id);
        if (! $patient) {
            Log::warning('Patient niet gevonden voor verwijdering. Id: '.$request->patient_id);

            return redirect()->back();
        }

        // verwijder eerst alle afspraken
        $patient->Afspraken()->delete();

        // verwijder alle facturen indien aanwezig
        if (method_exists($patient, 'Facturen')) {
            $patient->Facturen()->delete();
        }

        // verwijder alle communicatie indien aanwezig
        if (method_exists($patient, 'Communicatie')) {
            $patient->Communicatie()->delete();
        }

        // dan de patient
        $patient->delete();
        Log::info('Patient verwijderd. Id: '.$request->patient_id);

        return redirect()->back()->with('success', 'Patient succesvol verwijderd.');
    }
}
