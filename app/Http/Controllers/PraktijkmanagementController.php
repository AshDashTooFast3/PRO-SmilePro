<?php

namespace App\Http\Controllers;

use App\Models\Afspraken;
use App\Models\Communicatie;
use App\Models\Factuur;
use App\Models\Medewerker;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PraktijkmanagementController extends Controller
{
    private $communicatie;

    private $factuur;

    public function __construct()
    {
        $this->communicatie = new Communicatie;
        $this->factuur = new Factuur;
    }

    public function index()
    {

        // haalt het aantal afspraken op
        $aantalAfspraken = Afspraken::getAfsprakenCount();

        // haalt het geld bedrag op van de facuturen
        $omzet = $this->factuur->BerekenOmzet();

        // log voor het aantal afspraken
        if ($aantalAfspraken > 0) {
            Log::info('Aantal afspraken opgehaald: '.$aantalAfspraken);
        } else {
            Log::info('Geen afspraken gevonden');
        }

        // log voor het bedrag van de omzet
        if ($omzet > 0) {
            Log::info('Omzet opgehaald', ['Totaal omzet bedrag opgehaald:', $omzet]);
        } else {
            Log::info('er is nog geen omzet gemaakt');
        }

        return view('praktijkmanagement.index', [
            'title' => 'Praktijkmanagement Dashboard',
            'aantalAfspraken' => $aantalAfspraken,
            'omzet' => $omzet,
        ]);
    }

    public function storeBericht(Request $request)
    {
        $validated = $request->validate([
            'Patient' => 'required|string|max:255',
            'Medewerker' => 'required|string|max:255',
            'Bericht' => 'required|string',
        ]);

        $this->communicatie->create([
            'PatientId' => $validated['Patient'],
            'MedewerkerId' => $validated['Medewerker'],
            'Bericht' => $validated['Bericht'],
            'VerzondenDatum' => now(),
            'Isactief' => 0,

        ]);

        return redirect()->route('praktijkmanagement.berichten')->with('success', 'Bericht succesvol aangemaakt.');
    }

    public function createBericht()
    {
        $patienten = Patient::all();
        $medewerkers = Medewerker::all();

        return view('praktijkmanagement.createBericht', [
            'title' => 'Nieuw Bericht Aanmaken',
            'patienten' => $patienten,
            'medewerkers' => $medewerkers,
        ]);
    }

    public function berichten()
    {

        // haalt alle berichten op
        $berichten = $this->communicatie->getAllCommunicatie();

        // log voor het aantal berichten
        if ($berichten > 0) {
            Log::info('Berichten opgehaald', ['Aantal berichten:' => count($berichten)]);
        } else {
            Log::info('Geen berichten opgehaald');
        }

        return view('praktijkmanagement.berichten', [
            'title' => 'Berichten Overzicht',
            'berichten' => $berichten,
        ]);
    }
}
