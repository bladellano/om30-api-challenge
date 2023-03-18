<?php

namespace Database\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'street' => $this->faker->streetName,
            'number' => $this->faker->numberBetween(1, 100),
            'zip_code' => $this->faker->numerify('########'),
            'complement' => $this->faker->secondaryAddress,
            'district' => $this->faker->text(10),
            'city' => $this->faker->city,
            'state' => mb_strtoupper($this->faker->lexify('??')),
            'patient_id' => \App\Models\Patient::factory()
        ];
    }
}
