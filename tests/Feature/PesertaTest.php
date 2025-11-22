<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Peserta;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PesertaTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_halaman_peserta_bisa_diakses()
    {
        $response = $this->get(route('peserta.index'));

        $response->assertStatus(200);
    }

    public function test_bisa_menambah_peserta_baru()
    {
        $data = [
            'nama'  => 'Budi',
            'email' => 'budi@example.com',
            'telepon' => '081234567890',
        ];

        $response = $this->post(route('peserta.store'), $data);

        // Harus redirect (biasanya ke index atau show)
        $response->assertStatus(302);

        // Data masuk database
        $this->assertDatabaseHas('peserta', [
            'nama'  => 'Budi',
            'email' => 'budi@example.com',
        ]);
    }

    public function test_bisa_mengupdate_data_peserta()
    {
        $peserta = Peserta::create([
            'nama'  => 'Ani',
            'email' => 'ani@example.com',
            'telepon' => '081111111111',
        ]);

        $updateData = [
            'nama'  => 'Ani Update',
            'email' => 'ani.update@example.com',
            'telepon' => '082222222222',
        ];

        $response = $this->put(route('peserta.update', $peserta->id), $updateData);

        $response->assertStatus(302);

        $this->assertDatabaseHas('peserta', [
            'id'    => $peserta->id,
            'nama'  => 'Ani Update',
            'email' => 'ani.update@example.com',
        ]);
    }

    public function test_bisa_menghapus_peserta()
    {
        $peserta = Peserta::create([
            'nama'  => 'Hapus',
            'email' => 'hapus@example.com',
            'telepon' => '083333333333',
        ]);

        $response = $this->delete(route('peserta.destroy', $peserta->id));

        $response->assertStatus(302);

        $this->assertDatabaseMissing('peserta', [
            'id' => $peserta->id,
        ]);
    }
}
