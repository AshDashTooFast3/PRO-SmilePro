<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Communicatie>
 */
class CommunicatieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'PatientId' => \App\Models\Patient::factory(),
            'MedewerkerId' => \App\Models\Medewerker::factory(),
            'Bericht' => $this->faker->sentence(),
            'VerzondenDatum' => $this->faker->dateTime(),
            'Isactief' => true,
            'Opmerking' => $this->faker->optional()->sentence(),
            'Datumaangemaakt' => now(),
            'Datumgewijzigd' => now(),
        ];
    }
}
