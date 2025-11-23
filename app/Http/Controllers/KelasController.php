<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Models\Peserta;
use Illuminate\Validation\Rule;

class KelasController extends Controller
{
    /**
     * Tampilkan daftar kelas.
     */
    public function index()
    {
        $daftarKelas = \App\Models\Kelas::withCount('peserta')   // <- PENTING
            ->orderBy('tanggal_mulai')
            ->paginate(10);

        return view('kelas.index', [
            'daftarKelas' => $daftarKelas,
        ]);
    }


    /**
     * Tampilkan form tambah kelas.
     */
    public function create()
    {
        return view('kelas.create');
    }

    /**
     * Simpan kelas baru.
     */
    public function store(Request $request)
    {
        $dataValid = $request->validate([
            'judul'           => 'required|string|max:255',
            'kode'            => 'required|string|max:50|unique:kelas,kode',
            'pengajar'        => 'required|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'kapasitas'       => 'nullable|integer|min:1',
        ]);

        Kelas::create($dataValid);

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Kelas berhasil dibuat.');
    }

    /**
     * Tampilkan detail satu kelas.
     */
    public function show(Kelas $kelas)
    {
        // load peserta yang terdaftar di kelas ini
        $kelas->load('peserta');

        return view('kelas.show', [
            'kelas'         => $kelas,
            'daftarPeserta' => $kelas->peserta,
        ]);
    }

    /**
     * Tampilkan form edit kelas.
     */
    public function edit(Kelas $kelas)
    {
        return view('kelas.edit', [
            'kelas' => $kelas,
        ]);
    }

    /**
     * Update data kelas.
     */

    public function update(Request $request, Kelas $kelas)
    {
        $dataValid = $request->validate([
            'judul'           => 'required|string|max:255',
            'kode'            => [
                'required',
                'string',
                'max:50',
                Rule::unique('kelas', 'kode')->ignore($kelas->id),
            ],
            'pengajar'        => 'required|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'kapasitas'       => 'nullable|integer|min:1',
        ]);

        $kelas->update($dataValid);

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Data kelas berhasil diperbarui.');
    }


    /**
     * Hapus kelas.
     */
    public function destroy(Kelas $kelas)
    {
        $kelas->delete();

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }

    public function hapusPeserta(Kelas $kelas, Peserta $peserta)
    {
        // detach hubungan many-to-many di tabel pendaftaran_kelas
        $kelas->peserta()->detach($peserta->id);

        return redirect()
            ->route('kelas.show', $kelas)
            ->with('success', 'Peserta berhasil dihapus dari kelas.');
    }
}
