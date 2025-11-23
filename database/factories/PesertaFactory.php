<?php

namespace Database\Factories;

use App\Models\Peserta;
use Illuminate\Database\Eloquent\Factories\Factory;

class PesertaFactory extends Factory
{
    protected $model = Peserta::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'telepon' => $this->faker->numerify('08##########'),
        ];
    }
}
