<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Afspraken;

class AfspraakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Afspraken::factory()->count(1)->create();
    }
}
