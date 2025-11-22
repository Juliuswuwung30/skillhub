<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PesertaController extends Controller
{
    /**
     * Tampilkan daftar semua peserta.
     */
    public function index()
    {
        $daftarPeserta = Peserta::orderBy('id')->paginate(10);

        return view('peserta.index', [
            'daftarPeserta' => $daftarPeserta,
        ]);
    }

    /**
     * Tampilkan form tambah peserta.
     */
    public function create()
    {
        return view('peserta.create');
    }

    /**
     * Simpan data peserta baru.
     */
    public function store(Request $request)
    {
        $dataValid = $request->validate([
            'nama'    => 'required|string|max:255',
            'email'   => 'required|email|unique:peserta,email',
            // hanya angka, panjang 8–15 digit
            'telepon' => 'nullable|string|min:8|max:15|regex:/^[0-9]+$/',
            'catatan' => 'nullable|string',
        ]);

        Peserta::create($dataValid);

        return redirect()
            ->route('peserta.index')
            ->with('berhasil', 'Peserta berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail satu peserta + kelas yang diikuti.
     */
    public function show(Peserta $peserta)
    {
        $peserta->load('kelas');
        $daftarKelas = Kelas::withCount('peserta')->orderBy('judul')->get();

        return view('peserta.show', [
            'peserta' => $peserta,
            'kelasDiikuti' => $peserta->kelas,
            'daftarKelas' => $daftarKelas,
        ]);
    }

    /**
     * Tampilkan form edit peserta.
     */
    public function edit(Peserta $peserta)
    {
        return view('peserta.edit', [
            'peserta' => $peserta,
        ]);
    }

    /**
     * Update data peserta.
     */
    public function update(Request $request, Peserta $peserta)
    {
        $dataValid = $request->validate([
            'nama'    => 'required|string|max:255',
            'email'   => 'required|email|unique:peserta,email,' . $peserta->id,
            // hanya angka, panjang 8–15 digit
            'telepon' => 'nullable|string|min:8|max:15|regex:/^[0-9]+$/',
            'catatan' => 'nullable|string',
        ]);

        $peserta->update($dataValid);

        return redirect()
            ->route('peserta.show', $peserta)
            ->with('berhasil', 'Data peserta berhasil diperbarui.');
    }

    /**
     * Hapus satu peserta.
     * (Pendaftaran akan ikut terhapus karena ON DELETE CASCADE di DB)
     */
    public function destroy(Peserta $peserta)
    {
        $peserta->delete();

        return redirect()
            ->route('peserta.index')
            ->with('berhasil', 'Peserta berhasil dihapus.');
    }
}
