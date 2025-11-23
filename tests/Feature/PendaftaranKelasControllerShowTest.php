<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Kelas;
use App\Models\Peserta;
use App\Models\PendaftaranKelas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class PendaftaranKelasControllerShowTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function halaman_detail_kelas_menampilkan_daftar_peserta()
    {
        $kelas = Kelas::factory()->create();
        $peserta = Peserta::factory()->count(3)->create();

        foreach ($peserta as $p) {
            PendaftaranKelas::factory()->create([
                'kelas_id' => $kelas->id,
                'peserta_id' => $p->id,
            ]);
        }

        $response = $this->get(route('pendaftaran-kelas.show', $kelas->id));

        $response->assertStatus(200);
        $response->assertSee($kelas->judul);

        foreach ($peserta as $p) {
            $response->assertSee($p->nama);
        }
    }

    public function test_show_kelas_tanpa_peserta()
    {
        $kelas = Kelas::factory()->create();

        $response = $this->get(route('pendaftaran-kelas.show', $kelas->id));

        $response->assertStatus(200);
        $response->assertSee($kelas->judul);
        $response->assertSee('Belum ada peserta');
    }
}
