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

            // Alleen de rollen die relevant zijn voor een tandartspraktijk
            'Medewerkertype' => $this->faker->randomElement([
                'Tandarts',
                'Mondhygiënist',
                'Assistent',
                'Praktijkmanagement'
            ]),

            // Realistische specialisaties
            'Specialisatie' => $this->faker->optional()->randomElement([
                'Orthodontie',
                'Implantologie',
                'Kinderzorg',
                'Preventie',
                'Chirurgie',
                'Angstbegeleiding',
                'Parodontologie'
            ]),

            'Beschikbaarheid' => $this->faker->randomElement(['Fulltime', 'Parttime']),
            'Isactief' => true,

            // Realistische opmerkingen
            'Opmerking' => $this->faker->optional()->randomElement([
                'Werkt op maandag en woensdag',
                'Gespecialiseerd in angstpatiënten',
                'Fulltime beschikbaar',
                'Ondersteunt bij baliewerk',
                'Sinds 2015 werkzaam in de praktijk',
                'Ervaring met implantaten en kronen',
                'Begeleidt stagiaires en nieuwe medewerkers'
            ]),

            'Datumaangemaakt' => now(),
            'Datumgewijzigd' => now(),
        ];
    }
}
