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
        $patient = Patient::find($request->input('Patient'));

        if (empty($patient)) {
            Log::warning('Probeer bericht aan te maken voor niet-bestaande patiënt', ['PatientId' => $request->input('Patient')]);

            return redirect()->route('praktijkmanagement.createBericht')->with('error', 'De geselecteerde patiënt bestaat niet.');
        }

        // Kijkt of de patient niet actief is
        if ($patient->Isactief == 0) {
            Log::warning('Probeer bericht aan te maken voor inactieve patiënt', ['PatientId' => $patient->Id]);

            return redirect()->route('praktijkmanagement.createBericht')->with('error', 'De geselecteerde patiënt is al volledig behandeld en heeft geen actieve status meer bij ons bedrijf.');
        } else {
            // Validatie van de input gegevens voor het bericht
            $validated = $request->validate([
                'Patient' => 'required|string|max:255',
                'Medewerker' => 'required|string|max:255',
                'Bericht' => 'required|string',
            ]);
            // Maakt een nieuw bericht aan in de database met behulp van de gevalideerde gegevens
            $this->communicatie->create([
                'PatientId' => $validated['Patient'],
                'MedewerkerId' => $validated['Medewerker'],
                'Bericht' => $validated['Bericht'],
                'VerzondenDatum' => now(),
                'Isactief' => 0,

            ]);

            // Logt het aanmaken van een nieuw bericht
            Log::info('Nieuw bericht aangemaakt', ['PatientId' => $validated['Patient'], 'MedewerkerId' => $validated['Medewerker'], 'Bericht' => $validated['Bericht']]);

            // Stuurt je terug naar de OverzichtBerichten pagina met een succesmelding
            return redirect()->route('praktijkmanagement.berichten')->with('success', 'Bericht succesvol aangemaakt.');
        }
    }

    public function createBericht()
    {
        // Haalt alle patienten en medewerkers op voor de dropdowns
        $patienten = Patient::all();
        $medewerkers = Medewerker::all();

        return view('praktijkmanagement.createBericht', [
            'title' => 'Nieuw Bericht Aanmaken',
            'patienten' => $patienten,
            'medewerkers' => $medewerkers,
        ]);
    }

    public function OverzichtBerichten()
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
