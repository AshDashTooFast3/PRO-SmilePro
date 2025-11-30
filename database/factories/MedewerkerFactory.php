<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medewerker>
 */
class MedewerkerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'PersoonId' => \App\Models\Persoon::factory(),
            'Nummer' => $this->faker->unique()->numerify('M####'),
            'Medewerkertype' => $this->faker->randomElement(['Tandarts', 'Assistent', 'Mondhygiënist']),
            'Specialisatie' => $this->faker->optional()->word(),
            'Beschikbaarheid' => $this->faker->randomElement(['Fulltime', 'Parttime']),
            'Isactief' => true,
            'Opmerking' => $this->faker->optional()->sentence(),
            'Datumaangemaakt' => now(),
            'Datumgewijzigd' => now(),
        ];
    }
}
