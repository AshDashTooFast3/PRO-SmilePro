<?php

namespace Database\Seeders;

use App\Models\Communicatie;
use App\Models\Gebruiker;
use App\Models\Persoon;
use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Maak een praktijkmanagement gebruiker aan
        Gebruiker::factory()->create([
            'Gebruikersnaam' => 'Praktijkmanagement',
            'Email' => 'praktijkmanagement@smilepro.nl',
            'Wachtwoord' => bcrypt('achraf123'),
            'RolNaam' => 'Praktijkmanagement',
        ]);

        $gebruiker = Gebruiker::factory()->create([
            'Gebruikersnaam' => 'Patient',
            'Email' => 'patient@smilepro.nl',
            'Wachtwoord' => bcrypt('achraf123'),
            'RolNaam' => 'Patient',
        ]);

        Persoon::factory()->create([
            'GebruikerId' => $gebruiker->Id,
            'Voornaam' => 'Wesley',
            'Tussenvoegsel' => '',
            'Achternaam' => 'Borgman',
            'Geboortedatum' => '2003-01-01',
        ]);

        Patient::factory()->create([
            'PersoonId' => Persoon::where('Voornaam', 'Wesley')
            ->where('Achternaam', 'Borgman')
            ->first()->Id,
        ]);
         
        // Unhappy scenarios testen met deze inactieve gebruiker
        Gebruiker::factory()->create([
            'Gebruikersnaam' => 'Achraf El Arrasi',
            'Email' => 'achraf@smilepro.nl',
            'Wachtwoord' => bcrypt('password123'),
            'RolNaam' => 'Patient',
            'Isactief' => 0,
        ]);
        
        Persoon::factory()->create([
            'Voornaam' => 'Achraf',
            'Tussenvoegsel' => 'El',
            'Achternaam' => 'Arrasi',
            'Geboortedatum' => '2003-01-01',
        ]);

        Patient::factory()->create([
            'PersoonId' => Persoon::where('Voornaam', 'Achraf')
            ->where('Achternaam', 'Arrasi')
            ->first()->Id,
            'Isactief' => 0,
        ]);

        $this->call(AfspraakSeeder::class);
        $this->call(PersoonSeeder::class);
        $this->call(PatientSeeder::class);
        $this->call(MedewerkerSeeder::class);
        $this->call(CommunicatieSeeder::class);
        $this->call(BehandelingSeeder::class);
        $this->call(FactuurSeeder::class);

        //test bericht voor patient Wesley Borgman
        Communicatie::factory(2)->create([
            'PatientId' => Patient::where('PersoonId', 
            Persoon::where('Voornaam', 'Wesley')
            ->where('Achternaam', 'Borgman')
            ->first()->Id
            )->first()->Id,
            'MedewerkerId' => 1,
            'Bericht' => 'Dit is een testbericht voor Wesley Borgman.',
            'VerzondenDatum' => now(),
            'Status' => 'Verzonden',
            'Isactief' => 1,
            'Opmerking' => null,
        ]);
    }
}
