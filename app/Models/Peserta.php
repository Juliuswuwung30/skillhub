<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        // kolom lain kalau ada
    ];

    /**
     * Relasi ke tabel pivot pendaftaran_kelas (hasMany).
     * Ini yang dimaksud 'pendaftaranKelas' di error tadi.
     */
    public function pendaftaranKelas()
    {
        return $this->hasMany(PendaftaranKelas::class, 'peserta_id');
    }

    /**
     * Relasi langsung ke kelas-kelas yang diikuti peserta (many-to-many).
     * Ini enak dipakai kalau mau langsung ambil list kelas dari peserta.
     */
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'pendaftaran_kelas', 'peserta_id', 'kelas_id')
                    ->withTimestamps();
    }
}
