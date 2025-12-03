<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Behandeling>
 */
class BehandelingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'MedewerkerId' => \App\Models\Medewerker::factory(),
            'PatientId' => \App\Models\Patient::factory(),
            'Datum' => $this->faker->date(),
            'Tijd' => $this->faker->time(),
            'Behandelingtype' => $this->faker->randomElement(['Controles', 'Vullingen', 'Gebitsreiniging', 'Orthodontie', 'Wortelkanaalbehandelingen']),
            'Omschrijving' => $this->faker->optional()->sentence(),
            'Kosten' => $this->faker->randomFloat(2, 50, 1000),
            'Status' => $this->faker->randomElement(['Behandeld', 'Onbehandeld', 'Uitgesteld']),
            'Isactief' => $this->faker->boolean(),
            'Opmerking' => $this->faker->optional()->sentence(),
            'Datumaangemaakt' => $this->faker->dateTime(),
            'Datumgewijzigd' => $this->faker->optional()->dateTime(),
        ];
    }
}
