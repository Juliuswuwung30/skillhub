<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Kelas;
use App\Models\Peserta;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KelasTest extends TestCase
{
  use RefreshDatabase;

  public function test_index_halaman_kelas_bisa_diakses()
  {
    $response = $this->get(route('kelas.index'));

    $response->assertStatus(200);
  }

  public function test_bisa_menambah_kelas_baru()
  {
    $data = [
      'judul'           => 'Desain Grafis',
      'kode'            => 'DG-001',
      'deskripsi'       => 'Belajar desain dasar untuk pemula',
      'tanggal_mulai'   => '2025-01-01',
      'tanggal_selesai' => '2025-01-31',
      'kapasitas'       => 30,
      'pengajar'        => 'Bapak Desainer',
    ];

    $response = $this->post(route('kelas.store'), $data);

    $response->assertStatus(302);

    $this->assertDatabaseHas('kelas', [
      'judul'    => 'Desain Grafis',
      'kode'     => 'DG-001',
      'pengajar' => 'Bapak Desainer',
    ]);
  }

  public function test_bisa_mengupdate_data_kelas()
  {
    $kelas = Kelas::create([
      'judul'           => 'Pemrograman Dasar',
      'kode'            => 'PD-001',
      'deskripsi'       => 'Belajar coding dari nol',
      'tanggal_mulai'   => '2025-02-01',
      'tanggal_selesai' => '2025-02-28',
      'kapasitas'       => 25,
      'pengajar'        => 'Bu Nana',
    ]);

    $updateData = [
      'judul'           => 'Pemrograman Dasar Lanjutan',
      'kode'            => 'PD-002',
      'deskripsi'       => 'Sudah tidak nol lagi',
      'tanggal_mulai'   => '2025-03-01',
      'tanggal_selesai' => '2025-03-31',
      'kapasitas'       => 40,
      'pengajar'        => 'Bu Nana Update',
    ];

    $response = $this->put(route('kelas.update', $kelas->id), $updateData);

    $response->assertStatus(302);

    $this->assertDatabaseHas('kelas', [
      'id'       => $kelas->id,
      'judul'    => 'Pemrograman Dasar Lanjutan',
      'kode'     => 'PD-002',
      'pengajar' => 'Bu Nana Update',
    ]);
  }

  public function test_bisa_menghapus_kelas()
  {
    $kelas = Kelas::create([
      'judul'           => 'Kelas Dihapus',
      'kode'            => 'HAPUS-001',
      'deskripsi'       => 'Ini akan dihapus',
      'tanggal_mulai'   => '2025-04-01',
      'tanggal_selesai' => '2025-04-30',
      'kapasitas'       => 10,
      'pengajar'        => 'Pak Hapus',
    ]);

    $response = $this->delete(route('kelas.destroy', $kelas->id));

    $response->assertStatus(302);

    $this->assertDatabaseMissing('kelas', [
      'id' => $kelas->id,
    ]);
  }

  public function test_daftar_peserta_dalam_suatu_kelas_bisa_diakses()
  {
    $kelas = Kelas::create([
      'judul'           => 'Public Speaking',
      'kode'            => 'PS-001',
      'deskripsi'       => 'Latihan ngomong di depan umum',
      'tanggal_mulai'   => '2025-05-01',
      'tanggal_selesai' => '2025-05-31',
      'kapasitas'       => 20,
      'pengajar'        => 'Kak Bicara',
    ]);

    $peserta = Peserta::create([
      'nama'    => 'Budi Peserta',
      'email'   => 'budi@example.com',
      'telepon' => '081234567890',
    ]);

    $kelas->peserta()->attach($peserta->id);

    $response = $this->get(route('kelas.daftar-peserta', $kelas->id));

    $response->assertStatus(200);
    // $response->assertSee('Budi Peserta');
  }
}
