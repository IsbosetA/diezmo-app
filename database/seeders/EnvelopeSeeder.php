<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//Model
use App\Models\Envelope;

class EnvelopeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Genera un mínimo de 20 sobres diarios
        for ($i = 0; $i < 30; $i++) {
            Envelope::factory()->count(rand(20, 30))->create();
        }
    }
}
