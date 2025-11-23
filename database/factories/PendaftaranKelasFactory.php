<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PendaftaranKelas;
use App\Models\Peserta;
use App\Models\Kelas;

class PendaftaranKelasFactory extends Factory
{
    protected $model = PendaftaranKelas::class;

    public function definition(): array
    {
        return [
            'peserta_id' => Peserta::factory(),
            'kelas_id'   => Kelas::factory(),
        ];
    }
}
