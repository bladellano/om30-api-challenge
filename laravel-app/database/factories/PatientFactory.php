<?php

namespace Database\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'full_name' => $this->faker->name,
            'mother_full_name' => $this->faker->name('female'),
            'date_of_birth' => $this->faker->date(),
            'cpf' => $this->faker->numerify('###.###.###-##'),
            'cns' => $this->faker->numerify('###############'),
        ];
    }
}
