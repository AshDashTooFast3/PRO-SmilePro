<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Afspraak;
use App\Models\Medewerker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AfspraakController extends Controller
{
    /**
     * PatientId = Gebruiker.Id
     */
private function getRealPatientId($user)
{
    // 1. Persoon ophalen via raw query zodat we zeker weten dat Id klopt
    $persoon = DB::table('Persoon')->where('GebruikerId', $user->Id)->first();

    // 2. Als Persoon niet bestaat → maak hem aan via raw insert
    if (!$persoon) {
        DB::table('Persoon')->insert([
            'GebruikerId' => $user->Id,
            'Voornaam' => $user->Gebruikersnaam,
            'Tussenvoegsel' => null,
            'Achternaam' => $user->Gebruikersnaam,
            'Geboortedatum' => '2000-01-01',
            'Isactief' => 1,
            'Opmerking' => null,
            'Datumaangemaakt' => now(),
        ]);

        // opnieuw ophalen zodat we het echte Id hebben
        $persoon = DB::table('Persoon')->where('GebruikerId', $user->Id)->first();
    }

    // 3. Patient ophalen via raw query
    $patient = DB::table('Patient')->where('PersoonId', $persoon->Id)->first();

    // 4. Als Patient niet bestaat → maak hem aan via raw insert
    if (!$patient) {
        DB::table('Patient')->insert([
            'PersoonId' => $persoon->Id,
            'Nummer' => 'AUTO-' . $persoon->Id,
            'MedischDossier' => '',
            'Isactief' => 1,
            'Datumaangemaakt' => now(),
        ]);

        // opnieuw ophalen zodat we het echte Id hebben
        $patient = DB::table('Patient')->where('PersoonId', $persoon->Id)->first();
    }

    return $patient->Id;
}
    /**
     * INDEX
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->RolNaam === 'Patient') {

            $patientId = $this->getRealPatientId($user);

            $afspraken = Afspraak::where('Isactief', 1)
                ->where('PatientId', $patientId)
                ->orderBy('Datum')
                ->orderBy('Tijd')
                ->get();

        } else {
            // Medewerkers zien ALLE afspraken
            $afspraken = Afspraak::where('Isactief', 1)
                ->orderBy('Datum')
                ->orderBy('Tijd')
                ->get();
        }

        return view('afspraken.index', compact('afspraken', 'user'));
    }

    /**
     * CREATE
     * Alleen patiënten mogen afspraken maken
     */
    public function create()
    {
        $user = Auth::user();

        if ($user->RolNaam !== 'Patient') {
            abort(403);
        }

        return view('afspraken.create', compact('user'));
    }

    /**
     * STORE
     * Patiënt maakt afspraak → random medewerker wordt toegewezen
     */
    public function store(Request $request)
{
    $user = Auth::user();

    if ($user->RolNaam !== 'Patient') {
        abort(403);
    }

    // Ophalen via Persoon → Patient
    $patientId = $this->getRealPatientId($user);

    if (!$patientId) {
        abort(403, 'Geen patiënt gekoppeld aan dit account.');
    }

    $request->validate([
        'Datum' => ['required', 'date'],
        'Tijd'  => ['required'],
        'Opmerking' => ['nullable', 'string', 'max:1000'],
    ]);

    // Random medewerker
    $randomMedewerkerId = Medewerker::inRandomOrder()->value('Id');

    // Dubbele afspraak check
    $bestaatAl = Afspraak::where('Isactief', 1)
        ->where('PatientId', $patientId)
        ->where('Datum', $request->Datum)
        ->where('Tijd', $request->Tijd)
        ->exists();

    if ($bestaatAl) {
        return back()
            ->withErrors(['Datum' => 'Er is al een afspraak ingepland.'])
            ->withInput();
    }

    // Opslaan
    Afspraak::create([
        'PatientId' => $patientId,
        'MedewerkerId' => $randomMedewerkerId,
        'Datum' => $request->Datum,
        'Tijd' => $request->Tijd,
        'Status' => 'Bevestigd',
        'Isactief' => 1,
        'Opmerking' => $request->Opmerking,
        'Datumaangemaakt' => now(),
        'Datumgewijzigd' => now(),
    ]);

    return redirect()->route('afspraken.index')
        ->with('success', 'Afspraak is succesvol aangemaakt.');
}

    /**
     * EDIT
     */
   public function edit(Afspraak $afspraak)
{
    try {
        $user = Auth::user();

        // Patiënt mag alleen zijn eigen afspraak openen
        if ($user->RolNaam === 'Patient') {
            $patientId = $this->getRealPatientId($user);

            if ($afspraak->PatientId !== $patientId || $afspraak->Isactief != 1) {
                abort(403);
            }
        }

        // Medewerkers en praktijkmanagement mogen alles
        return view('afspraken.edit', compact('afspraak', 'user'));

    } catch (\Throwable $e) {
        Log::error('Fout in edit(): ' . $e->getMessage());
        abort(500, 'Er ging iets mis bij het openen van de afspraak.');
    }
}

    /**
     * UPDATE
     */
   public function update(Request $request, Afspraak $afspraak)
{
    try {
        $user = Auth::user();

        // Patiënt mag alleen zijn eigen afspraak wijzigen
        if ($user->RolNaam === 'Patient') {
            $patientId = $this->getRealPatientId($user);

            if ($afspraak->PatientId !== $patientId || $afspraak->Isactief != 1) {
                abort(403);
            }
        }

        // Validatie
        $request->validate([
            'Datum' => ['required', 'date'],
            'Tijd'  => ['required'],
            'Opmerking' => ['nullable', 'string', 'max:1000'],
        ]);

        // Dubbele afspraak check
        $bestaatAl = Afspraak::where('Isactief', 1)
            ->where('PatientId', $afspraak->PatientId)
            ->where('Datum', $request->Datum)
            ->where('Tijd', $request->Tijd)
            ->where('Id', '!=', $afspraak->Id)
            ->exists();

        if ($bestaatAl) {
            return back()
                ->withErrors(['Datum' => 'Er is al een afspraak ingepland.'])
                ->withInput();
        }

        // Opslaan
        $afspraak->Datum = $request->Datum;
        $afspraak->Tijd = $request->Tijd;
        $afspraak->Opmerking = $request->Opmerking;
        $afspraak->Datumgewijzigd = now();
        $afspraak->save();

        return redirect()->route('afspraken.index')
            ->with('success', 'Afspraak is succesvol bijgewerkt.');

    } catch (\Throwable $e) {
        Log::error('Fout in update(): ' . $e->getMessage());
        abort(500, 'Er ging iets mis bij het bijwerken van de afspraak.');
    }
}

    /**
     * DELETE
     */
    public function destroy(Afspraak $afspraak)
{
    try {
        $user = Auth::user();

        // Patiënt mag alleen zijn eigen afspraak verwijderen
        if ($user->RolNaam === 'Patient') {
            $patientId = $this->getRealPatientId($user);

            if ($afspraak->PatientId !== $patientId || $afspraak->Isactief != 1) {
                abort(403);
            }
        }

        // Medewerkers en praktijkmanagement mogen alles
        $afspraak->Isactief = 0;
        $afspraak->Datumgewijzigd = now();
        $afspraak->save();

        return redirect()->route('afspraken.index')
            ->with('success', 'Afspraak is verwijderd.');

    } catch (\Throwable $e) {
        Log::error('Fout in destroy(): ' . $e->getMessage());
        abort(500, 'Er ging iets mis bij het verwijderen van de afspraak.');
    }
}

    /**
     * UPDATE STATUS
     * Alleen medewerkers mogen status wijzigen
     */
    public function updateStatus(Request $request, Afspraak $afspraak)
    {
        $user = Auth::user();

        if (!in_array($user->RolNaam, ['Tandarts', 'Assistent', 'Mondhygienist', 'Praktijkmanagement'])) {
            abort(403);
        }

        $request->validate([
            'Status' => ['required', Rule::in(['Bevestigd', 'Geannuleerd'])],
        ]);

        $afspraak->Status = $request->Status;
        $afspraak->Datumgewijzigd = now();
        $afspraak->save();

        return redirect()->route('afspraken.index')
            ->with('success', 'Status van de afspraak is bijgewerkt.');
    }
}