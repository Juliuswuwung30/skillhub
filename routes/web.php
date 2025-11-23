<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PendaftaranKelasController;

// Halaman utama → langsung ke daftar peserta (PesertaController@index)
Route::get('/', [PesertaController::class, 'index'])->name('home');

// CRUD Peserta
Route::resource('peserta', PesertaController::class)->parameters([
    'peserta' => 'peserta',
]);

// CRUD Kelas
Route::resource('kelas', KelasController::class)->parameters([
    'kelas' => 'kelas', // optional, tapi biar konsisten
]);


// Pendaftaran peserta ke kelas (buat relasi many-to-many)
Route::resource('pendaftaran-kelas', PendaftaranKelasController::class)
    ->parameters(['pendaftaran-kelas' => 'kelas']);


// Simpan pendaftaran peserta ke kelas
Route::post('pendaftaran-kelas', [PendaftaranKelasController::class, 'store'])
    ->name('pendaftaran-kelas.store');

// Hapus 1 pendaftaran tertentu (misalnya kalau tabel pivot punya id sendiri)
Route::delete('pendaftaran-kelas/{pendaftaranKelas}', [PendaftaranKelasController::class, 'destroy'])
    ->name('pendaftaran-kelas.destroy');

// Daftar kelas yang diikuti oleh peserta tertentu
Route::get('peserta/{peserta}/kelas', [PendaftaranKelasController::class, 'daftarKelasPeserta'])
    ->name('peserta.daftar-kelas');

// Daftar peserta yang mengikuti kelas tertentu
Route::get('kelas/{kelas}/peserta', [PendaftaranKelasController::class, 'daftarPesertaKelas'])
    ->name('kelas.daftar-peserta');

// Hapus peserta dari kelas tertentu
Route::delete('/kelas/{kelas}/peserta/{peserta}', [KelasController::class, 'hapusPeserta'])
    ->name('kelas.peserta.hapus');

Route::post(
    '/pendaftaran-kelas/store-multi',
    [PendaftaranKelasController::class, 'storeMulti']
)
    ->name('pendaftaran-kelas.store-multi');

Route::get('pendaftaran-kelas/kelas/{kelas}', [PendaftaranKelasController::class, 'show'])
    ->name('pendaftaran-kelas.show');
