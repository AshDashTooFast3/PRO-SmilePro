<?php

namespace App\Http\Controllers;

use App\Models\Communicatie;
use App\Models\Medewerker;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BerichtController extends Controller
{
    private $communicatie;

    public function __construct()
    {
        $this->communicatie = new Communicatie;
    }

    public function index()
    {
        // haalt alle berichten op
        $berichten = $this->communicatie->getAllBerichten();

        // log voor het aantal berichten
        if ($berichten > 0) {
            Log::info('Berichten opgehaald', ['Aantal berichten:' => count($berichten)]);
        } else {
            Log::info('Geen berichten opgehaald');
        }

        return view('berichten.index', [
            'title' => 'Berichten Overzicht',
            'berichten' => $berichten,

        ]);
    }

    public function create()
    {
        // Haalt alle patienten en medewerkers op voor de dropdowns
        $patienten = Patient::all();
        $medewerkers = Medewerker::all();
        $bericht = new Communicatie();


        return view('berichten.create', [
            'title' => 'Nieuw Bericht Aanmaken',
            'patienten' => $patienten,
            'medewerkers' => $medewerkers,
            'bericht' => $bericht,
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
                'Status' => 'required|string',
            ]);
            // Maakt een nieuw bericht aan in de database met behulp van de gevalideerde gegevens
            $this->communicatie->create([
                'PatientId' => $validated['Patient'],
                'MedewerkerId' => $validated['Medewerker'],
                'Bericht' => $validated['Bericht'],
                'VerzondenDatum' => null,
                'Status' => $validated['Status'],
                'Isactief' => 0,

            ]);

            // Logt het aanmaken van een nieuw bericht
            Log::info('Nieuw bericht aangemaakt', ['PatientId' => $validated['Patient'], 'MedewerkerId' => $validated['Medewerker'], 'Bericht' => $validated['Bericht']]);

            // Stuurt je terug naar de OverzichtBerichten pagina met een succesmelding
            return redirect()->route('berichten.index')->with('success', 'Bericht succesvol aangemaakt.');
        }
    }

    public function edit($Id)
    {
        $bericht = Communicatie::find($Id);
        $patienten = Patient::all();
        $medewerkers = Medewerker::all();

        return view('berichten.edit', [
            'title' => 'Bericht bewerken',
            'bericht' => $bericht,
            'patienten' => $patienten,
            'medewerkers' => $medewerkers,
        ]);
    }

    public function update(Request $request, $Id)
    {
        // valideren
        $validated = $request->validate([
            'Id' => 'required|integer|exists:Communicatie,Id',
            'PatientId' => 'required|integer|exists:Patient,Id',
            'MedewerkerId' => 'required|integer|exists:Medewerker,Id',
            'Bericht' => 'required|string',
            'Status' => 'required|string',
        ]);

        // controleert of de patient actief is
        $patient = Patient::find($validated['PatientId']);

        if ($patient && $patient->Isactief == 0) {
            Log::warning('Probeer bericht bij te werken voor inactieve patiënt', ['PatientId' => $validated['PatientId']]);

            return redirect()->route('berichten.index')->with('error', 'Je kunt geen bericht bijwerken met een patiënt die volledig is behandeld 
            en geen actieve status meer heeft bij ons bedrijf. wij raden u aan om het bericht te annuleren i.p.v. bij te werken.');
        }

        // bericht bijwerken met de methode in het model genaamd WijzigBericht
        $result = Communicatie::WijzigBericht(
            (int) $Id,
            (int) $validated['PatientId'],
            (int) $validated['MedewerkerId'],
            $validated['Bericht'],
            $validated['Status']
        );

        // als het gelukt is om het bericht bij te werken, stuur je terug naar de berichten index met een succesmelding.
        if ($result === true) {
            Log::info('Bericht bijgewerkt', ['BerichtId' => $Id]);

            return redirect()->route('berichten.index')
                ->with('success', 'Bericht succesvol bijgewerkt.');
        }
        // als het niet gelukt is, stuur je terug naar de berichten index met een errormelding.
        else {
            Log::error('Fout bij het bijwerken van bericht', ['BerichtId' => $Id]);

            return redirect()->route('berichten.index')
                ->with('error', 'Bericht niet gevonden of kon niet bijgewerkt worden.');
        }
    }

    public function destroy($Id)
    {
        $bericht = Communicatie::find($Id);
        // dd($bericht);
        $patient = Patient::find($bericht->PatientId);

        if ($patient && $patient->Isactief == 1) {
            Log::warning('Probeer bericht te annuleren voor inactieve patiënt', ['PatientId' => $patient->Id]);

            return redirect()->route('berichten.index')->with('error', 'Je kunt geen bericht annuleren voor een patiënt die nog actief is bij ons bedrijf. wij raden u aan om het bericht te wijzigen i.p.v. te annuleren.');
        }

        $result = Communicatie::DeleteBericht((int) $Id);

        if ($result === true) {
            Log::info('Bericht verwijderd', ['BerichtId' => $Id]);

            return redirect()->route('berichten.index')
                ->with('success', 'Bericht succesvol verwijderd.');
        } else {
            Log::error('Fout bij het verwijderen van bericht', ['BerichtId' => $Id]);

            return redirect()->route('berichten.index')
                ->with('error', 'Bericht niet gevonden of kon niet verwijderd worden.');
        }
    }
}
