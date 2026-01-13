<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Communicatie;
use \App\Models\Patient;
use \App\Models\Medewerker;
use Illuminate\Support\Facades\Log;

class BerichtController extends Controller
{
    private $communicatie;
    public function __construct()
    {
        $this->communicatie = new Communicatie();
    }   

    public function index()
    {
        // haalt alle berichten op
        $berichten = $this->communicatie->getAllCommunicatie();

        // verwijderd een bericht
        $berichtenId = request()->query('verwijder');
        $berichtverwijderen = $this->communicatie->DeleteBericht($berichtenId ?? 0);

        // log voor het aantal berichten
        if ($berichten > 0) {
            Log::info('Berichten opgehaald', ['Aantal berichten:' => count($berichten)]);
        } else {
            Log::info('Geen berichten opgehaald');
        }

        return view('berichten.index', [
            'title' => 'Berichten Overzicht',
            'berichten' => $berichten,
            'berichtverwijderen' => $berichtverwijderen,
        ]);
    }

    public function create()
    {
        // Haalt alle patienten en medewerkers op voor de dropdowns
        $patienten = Patient::all();
        $medewerkers = Medewerker::all();

        return view('berichten.create', [
            'title' => 'Nieuw Bericht Aanmaken',
            'patienten' => $patienten,
            'medewerkers' => $medewerkers,
        ]);
    }

    public function store(Request $request)
    {
        $patient = Patient::find($request->input('Patient'));

        if (empty($patient)) {
            Log::warning('Probeer bericht aan te maken voor niet-bestaande patiënt', ['PatientId' => $request->input('Patient')]);

            return redirect()->route('berichten.create')->with('error', 'De geselecteerde patiënt bestaat niet.');
        }

        // Kijkt of de patient niet actief is
        if ($patient->Isactief == 0) {
            Log::warning('Probeer bericht aan te maken voor inactieve patiënt', ['PatientId' => $patient->Id]);

            return redirect()->route('berichten.create')->with('error', 'De geselecteerde patiënt is al volledig behandeld en heeft geen actieve status meer bij ons bedrijf.');
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
            return redirect()->route('berichten.index')->with('success', 'Bericht succesvol aangemaakt.');
        }
    }
}
