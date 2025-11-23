<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Kelas;
use App\Models\Peserta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class PendaftaranKelasControllerAdditionalTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function index_halaman_pendaftaran_kelas_bisa_diakses()
    {
        $response = $this->get('/pendaftaran-kelas');
        $response->assertStatus(200);
    }

    #[Test]
    public function store_multi_gagal_jika_tidak_ada_kelas_dipilih()
    {
        $peserta = Peserta::factory()->create();

        $response = $this->post('/pendaftaran-kelas/store-multi', [
            'peserta_id' => $peserta->id,
            'kelas_id'   => [] // kosong → harus gagal
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['kelas_id']);
    }

    #[Test]
    public function destroy_menghapus_pendaftaran_dari_kelas()
    {
        $kelas = Kelas::factory()->create();
        $peserta = Peserta::factory()->create();

        $kelas->peserta()->attach($peserta->id);

        $response = $this->delete("/kelas/{$kelas->id}/peserta/{$peserta->id}");

        $response->assertStatus(302);

        $this->assertDatabaseMissing('pendaftaran_kelas', [
            'peserta_id' => $peserta->id,
            'kelas_id' => $kelas->id,
        ]);
    }

    #[Test]
    public function hapus_pendaftaran_invalid_id_mengembalikan_404()
    {
        $response = $this->delete(route('pendaftaran-kelas.destroy', 999));
        $response->assertStatus(404);
    }
}
