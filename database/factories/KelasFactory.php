<?php

namespace Database\Factories;

use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelasFactory extends Factory
{
    protected $model = Kelas::class;

    public function definition()
    {
        return [
            'judul' => $this->faker->sentence(3),
            'kode' => strtoupper($this->faker->bothify('??###')),
            'pengajar' => $this->faker->name(),
            'tanggal_mulai' => $this->faker->date(),
            'tanggal_selesai' => $this->faker->date(),
            'kapasitas' => $this->faker->numberBetween(10, 40),
        ];
    }
}
