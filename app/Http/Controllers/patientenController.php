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
            Log::info('Geen patienten beschikbaar.'); }

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
            Log::error('Fout bij ophalen gebruikers: ' . $e->getMessage());

            return view('patienten.Create-Patient', [
                'title' => 'Patient Toevoegen',
                'gebruikers' => [],
            ]);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'gebruiker_id' => 'required|integer',
            'medischdossier' => 'nullable|string',
        ]);

        $patient = new Patient;
        $patient->Nummer = fake()->unique()->randomNumber(8);
        $patient->persoonId = $request->gebruiker_id;
        $patient->MedischDossier = $request->medischdossier;
        $patient->Isactief = 1;
        $patient->Opmerking = null;
        $patient->save();

        $patienten = Patient::getVolledigeNaamPatienten();

        return view('patienten.overzicht-patienten',
            [
                'patienten' => $patienten,
                'title' => 'Patienten Overzicht',
            ]);
    }
}
