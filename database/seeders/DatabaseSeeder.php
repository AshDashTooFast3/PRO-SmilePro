<?php

namespace Database\Seeders;

use App\Models\Gebruiker;
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

        Gebruiker::factory()->create([
            'Gebruikersnaam' => 'Praktijkmanagement',
            'Email' => 'praktijkmanagement@smilepro.nl',
            'Wachtwoord'=> bcrypt('achraf123'),
            'RolNaam' => 'Praktijkmanagement',
        ]);
       $this->call(AfspraakSeeder::class);
       $this->call(PersoonSeeder::class);
       $this->call(PatientSeeder::class);
       $this->call(MedewerkerSeeder::class);
       $this->call(CommunicatieSeeder::class);

    }
}
