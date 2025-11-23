<?php

namespace Tests\Unit;

use App\Models\Kelas;
use App\Models\Peserta;
use App\Models\PendaftaranKelas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ModelsRelationshipTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function kelas_bisa_memiliki_banyak_peserta()
    {
        $kelas = Kelas::factory()->create();
        $peserta = Peserta::factory()->count(3)->create();

        $kelas->peserta()->attach($peserta->pluck('id')->toArray());

        $this->assertCount(3, $kelas->fresh()->peserta);
    }

    #[Test]
    public function peserta_bisa_mengikuti_banyak_kelas()
    {
        $peserta = Peserta::factory()->create();
        $kelas = Kelas::factory()->count(2)->create();

        $peserta->kelas()->attach($kelas->pluck('id')->toArray());

        $this->assertCount(2, $peserta->fresh()->kelas);
    }

    #[Test]
    public function pendaftaran_relasi_kelas_ke_peserta_berfungsi()
    {
        $peserta = Peserta::factory()->create();
        $kelas = Kelas::factory()->create();

        $pivot = PendaftaranKelas::create([
            'peserta_id' => $peserta->id,
            'kelas_id' => $kelas->id,
        ]);

        $this->assertEquals($kelas->id, $pivot->kelas->id);
        $this->assertEquals($peserta->id, $pivot->peserta->id);
    }
}
