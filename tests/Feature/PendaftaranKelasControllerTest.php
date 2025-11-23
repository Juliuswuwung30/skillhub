<?php

namespace Tests\Feature;

use App\Models\Peserta;
use App\Models\Kelas;
use App\Models\PendaftaranKelas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PendaftaranKelasControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function daftar_peserta_dalam_kelas_bisa_diakses()
    {
        $kelas = Kelas::factory()->create();
        $peserta = Peserta::factory()->create();

        $kelas->peserta()->attach($peserta->id);

        $response = $this->get(route('kelas.daftar-peserta', $kelas->id));
        $response->assertStatus(200);
        $response->assertSee($kelas->judul);
    }

    #[Test]
    public function daftar_kelas_yang_diikuti_peserta_bisa_diakses()
    {
        $peserta = Peserta::factory()->create();
        $kelas = Kelas::factory()->create();

        $peserta->kelas()->attach($kelas->id);

        $response = $this->get(route('peserta.daftar-kelas', $peserta->id));
        $response->assertStatus(200);
        $response->assertSee($peserta->nama);
    }

    #[Test]
    public function bisa_menambahkan_banyak_kelas_sekaligus()
    {
        $peserta = Peserta::factory()->create();
        $kelas1 = Kelas::factory()->create();
        $kelas2 = Kelas::factory()->create();

        $response = $this->post(route('pendaftaran-kelas.store-multi'), [
            'peserta_id' => $peserta->id,
            'kelas_id' => [$kelas1->id, $kelas2->id]
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('pendaftaran_kelas', [
            'peserta_id' => $peserta->id,
            'kelas_id' => $kelas1->id,
        ]);
        $this->assertDatabaseHas('pendaftaran_kelas', [
            'peserta_id' => $peserta->id,
            'kelas_id' => $kelas2->id,
        ]);
    }

    #[Test]
    public function tidak_boleh_duplikat_pendaftaran()
    {
        $peserta = Peserta::factory()->create();
        $kelas = Kelas::factory()->create();

        PendaftaranKelas::create([
            'peserta_id' => $peserta->id,
            'kelas_id' => $kelas->id
        ]);

        // Submit form lagi dengan kelas yang sama
        $response = $this->post(route('pendaftaran-kelas.store-multi'), [
            'peserta_id' => $peserta->id,
            'kelas_id' => [$kelas->id]
        ]);

        $response->assertRedirect();

        // Masih harus hanya ada 1 data
        $this->assertEquals(1, PendaftaranKelas::count());
    }

    #[Test]
    public function tidak_bisa_mendaftar_ke_kelas_yang_penuh()
    {
        $kelas = Kelas::factory()->create([
            'kapasitas' => 1,
            'tanggal_mulai' => now()->subDay(),
            'tanggal_selesai' => now()->addDay(),
        ]);

        $peserta1 = Peserta::factory()->create();
        $peserta2 = Peserta::factory()->create();

        // Penuhi kelas
        $kelas->peserta()->attach($peserta1->id);

        // Coba daftar lagi → harus gagal
        $response = $this->post(route('pendaftaran-kelas.store', [
            'peserta_id' => $peserta2->id,
            'kelas_id' => $kelas->id,
        ]));

        $response->assertStatus(302);
        $response->assertSessionHas('error', 'Kelas sudah penuh!');
    }


    #[Test]
    public function tidak_bisa_mendaftar_kelas_belum_dibuka()
    {
        $kelas = Kelas::factory()->create([
            'tanggal_mulai' => now()->addDays(3),
            'tanggal_selesai' => now()->addDays(10)
        ]);

        $peserta = Peserta::factory()->create();

        $response = $this->post(route('pendaftaran-kelas.store', [
            'peserta_id' => $peserta->id,
            'kelas_id' => $kelas->id,
        ]));

        $response->assertSessionHas('error');
    }

    #[Test]
    public function tidak_bisa_mendaftar_kelas_sudah_ditutup()
    {
        $kelas = Kelas::factory()->create([
            'tanggal_mulai' => now()->subDays(10),
            'tanggal_selesai' => now()->subDays(1)
        ]);

        $peserta = Peserta::factory()->create();

        $response = $this->post(route('pendaftaran-kelas.store', [
            'peserta_id' => $peserta->id,
            'kelas_id' => $kelas->id,
        ]));

        $response->assertSessionHas('error');
    }

    #[Test]
    public function validasi_gagal_jika_data_tidak_lengkap()
    {
        $response = $this->post(route('pendaftaran-kelas.store'));

        $response->assertSessionHasErrors(['peserta_id', 'kelas_id']);
    }

    public function test_update_gagal_validasi()
    {
        $pendaftaran = PendaftaranKelas::factory()->create();

        $response = $this->put(route('pendaftaran-kelas.update', $pendaftaran->id), [
            'kelas_id' => '', // invalid
            'peserta_id' => '',
        ]);

        $response->assertSessionHasErrors(['kelas_id', 'peserta_id']);
    }
}
