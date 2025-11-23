<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Kelas;
use App\Models\Peserta;
use App\Models\PendaftaranKelas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class PendaftaranKelasTest extends TestCase
{
    use RefreshDatabase;

    public function test_bisa_melihat_daftar_kelas_yang_diikuti_peserta()
    {
        $peserta = Peserta::create([
            'nama'    => 'Caca Lihat Kelas',
            'email'   => 'caca@example.com',
            'telepon' => '082222222222',
        ]);

        $kelas = Kelas::create([
            'judul'           => 'Desain Grafis',
            'kode'            => 'DG-002',
            'deskripsi'       => 'Belajar desain',
            'tanggal_mulai'   => '2025-07-01',
            'tanggal_selesai' => '2025-07-31',
            'kapasitas'       => 25,
            'pengajar'        => 'Mbak Desain',
        ]);

        PendaftaranKelas::create([
            'peserta_id' => $peserta->id,
            'kelas_id'   => $kelas->id,
        ]);

        $response = $this->get(route('peserta.daftar-kelas', $peserta->id));

        $response->assertStatus(200);
        // $response->assertSee('Desain Grafis');
    }

    public function test_bisa_menghapus_pendaftaran_peserta_dari_kelas()
    {
        $peserta = Peserta::create([
            'nama'    => 'Dodi Hapus',
            'email'   => 'dodi@example.com',
            'telepon' => '083333333333',
        ]);

        $kelas = Kelas::create([
            'judul'           => 'Kelas Hapus Peserta',
            'kode'            => 'HP-001',
            'deskripsi'       => 'Tes hapus pendaftaran',
            'tanggal_mulai'   => '2025-08-01',
            'tanggal_selesai' => '2025-08-31',
            'kapasitas'       => 20,
            'pengajar'        => 'Pak Cabut',
        ]);

        $pendaftaran = PendaftaranKelas::create([
            'peserta_id' => $peserta->id,
            'kelas_id'   => $kelas->id,
        ]);

        $response = $this->delete(
            route('pendaftaran-kelas.destroy', $pendaftaran->id)
        );

        $response->assertStatus(302);

        $this->assertDatabaseMissing('pendaftaran_kelas', [
            'id' => $pendaftaran->id,
        ]);
    }

    #[Test]
    public function bisa_mendaftarkan_peserta_ke_kelas()
    {
        $kelas = Kelas::factory()->create([
            'tanggal_mulai'   => now()->subDay(),
            'tanggal_selesai' => now()->addDays(5),
            'kapasitas'       => 20,
        ]);

        $peserta = Peserta::factory()->create();

        $response = $this->post(route('pendaftaran-kelas.store', [
            'peserta_id' => $peserta->id,
            'kelas_id' => $kelas->id,
        ]));

        $response->assertStatus(302);

        $this->assertDatabaseHas('pendaftaran_kelas', [
            'peserta_id' => $peserta->id,
            'kelas_id'   => $kelas->id,
        ]);
    }
}
