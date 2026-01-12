<?php

namespace Database\Seeders;

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

         Gebruiker::factory()->create([
            'Gebruikersnaam' => 'Patient',
            'Email' => 'patient@smilepro.nl',
            'Wachtwoord' => bcrypt('achraf123'),
            'RolNaam' => 'Patient',
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

    }
}
