<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peserta;
use Faker\Factory as Faker;

class PesertaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 10; $i++) {
            Peserta::create([
                'nama' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'telepon' => $faker->numerify('08##########'),
                'catatan' => $faker->optional()->sentence(8),
            ]);
        }
    }
}
