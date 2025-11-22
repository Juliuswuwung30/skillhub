<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'judul',
        'kode',
        'pengajar',
        'tanggal_mulai',
        'tanggal_selesai',
        'kapasitas',
        'catatan',
    ];

        protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function peserta()
    {
        return $this->belongsToMany(Peserta::class, 'pendaftaran_kelas', 'kelas_id', 'peserta_id')
                    ->withTimestamps();
    }
}
