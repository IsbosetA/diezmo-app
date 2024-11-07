<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

//Models
use App\Models\Envelope;
use App\Models\Member;
use App\Models\Offering;
use App\Models\Tithe;
use App\Models\OfferingType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Envelope>
 */
class EnvelopeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Envelope::class;

    private static $currentDateIndex = 0; // Contador de fecha

    public function definition(): array
    {
        $firstDayOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $lastDayOfCurrentMonth = Carbon::now()->endOfMonth();

        $dates = [];
        $currentDate = $firstDayOfLastMonth->copy();

        while ($currentDate->lte($lastDayOfCurrentMonth)) {
            $dates[] = $currentDate->copy();
            $currentDate->addDay();
        }

        if (self::$currentDateIndex >= count($dates)) {
            self::$currentDateIndex = 0; // Reiniciar si se alcanzó el final
        }

        $randomDate = $dates[self::$currentDateIndex++]->format('Y-m-d');

        // Obtener el número de sobre de manera segura
        $envelopeNumber = DB::transaction(function () use ($randomDate) {
            return Envelope::getNextEnvelopeNumber($randomDate);
        });

        $member = Member::inRandomOrder()->first();

        return [
            'id_member' => $member->id,
            'envelope_number' => $envelopeNumber,
            'date' => $randomDate,
            'description' => $this->faker->sentence(),
            'total' => 0  // Actualizado después de calcular el total de ofrendas y diezmo
        ];
    }




    public function configure()
    {
        return $this->afterCreating(function (Envelope $envelope) {
            $total = 0;

            // Obtén todos los tipos de ofrendas existentes
            $offeringTypes = OfferingType::all();

            // Genera entre 1 y 4 ofrendas aleatorias por sobre
            $offeringCount = rand(1, 4);
            for ($i = 0; $i < $offeringCount; $i++) {
                $offeringType = $offeringTypes->random();
                $amount = $this->faker->randomFloat(2, 1, 100);

                Offering::create([
                    'id_envelope' => $envelope->id,
                    'id_offering_type' => $offeringType->id,
                    'amount' => $amount
                ]);

                $total += $amount;
            }

            // Crear el diezmo
            $titheAmount = $this->faker->randomFloat(2, 1, 100);
            Tithe::create([
                'id_envelope' => $envelope->id,
                'amount' => $titheAmount
            ]);

            $envelope->total = $total + $titheAmount;
            $envelope->save();
        });
    }
}
