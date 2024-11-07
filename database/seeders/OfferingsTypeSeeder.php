<?php

namespace Database\Seeders;

use App\Models\OfferingType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfferingsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offerings_types = [
            0 => [
                'name' => 'Ofrenda de Amor',
                'description' => 'Tu Ofrenda de amor para la iglesia'
            ],
            1 => [
                'name' => 'Construccion del Templo',
                'description' => 'Tu Ofrenda para la contruccion del Templo'
            ],
            2 => [
                'name' => 'Ofrenda Proyecto del Terreno del Club',
                'description' => 'Tu Ofrenda para apoyar el mantenimiento y mejora del club'
            ],
            3 => [
                'name' => 'Ofrenda de Proyectos audiovisuales',
                'description' => 'Tu Ofrenda para el proyecto de produccion audivisual de la iglesia'
            ]

        ];

        foreach($offerings_types as $types){
            $offering_type = OfferingType::create([
                'name' => $types['name'],
                'description' => $types['description']
            ]);
        }

    }
}
