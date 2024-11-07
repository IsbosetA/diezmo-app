<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

//Model
use App\Models\Member;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Member::class;

    public function definition(): array
    {

        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
