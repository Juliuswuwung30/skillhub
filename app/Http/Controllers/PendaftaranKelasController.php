<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Kelas;
use App\Models\PendaftaranKelas;
use Illuminate\Http\Request;

class PendaftaranKelasController extends Controller
{
    /**
     * (Opsional) Tampilkan daftar semua pendaftaran kelas.
     * Kalau belum dipakai, boleh dikosongkan dulu atau diisi nanti.
     */
    public function index()
    {
        $daftarPendaftaran = PendaftaranKelas::with(['peserta', 'kelas'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('pendaftaran-kelas.index', [
            'daftarPendaftaran' => $daftarPendaftaran,
        ]);
    }

    /**
     * Tampilkan form pendaftaran peserta ke kelas.
     * Bisa dipanggil pakai route('pendaftaran-kelas.create')
     * dan bisa kirim query ?peserta_id=xxx kalau mau preset 1 peserta.
     */
    public function create(Request $request)
    {
        $daftarPeserta = Peserta::orderBy('nama')->get();
        $daftarKelas   = Kelas::orderBy('judul')->get();

        $pesertaTerpilih = null;
        if ($request->filled('peserta_id')) {
            $pesertaTerpilih = Peserta::find($request->input('peserta_id'));
        }

        return view('pendaftaran-kelas.create', [
            'daftarPeserta'    => $daftarPeserta,
            'daftarKelas'      => $daftarKelas,
            'pesertaTerpilih'  => $pesertaTerpilih,
        ]);
    }

    /**
     * Simpan pendaftaran peserta ke kelas.
     * Biasanya form POST ke /pendaftaran-kelas.
     */
    public function store(Request $request)
    {
        $dataValid = $request->validate([
            'peserta_id' => 'required|exists:peserta,id',
            'kelas_id'   => 'required|exists:kelas,id',
            'catatan'    => 'nullable|string|max:500',
        ]);

        // Cek kalau peserta sudah terdaftar di kelas yang sama
        $sudahAda = PendaftaranKelas::where('peserta_id', $dataValid['peserta_id'])
            ->where('kelas_id', $dataValid['kelas_id'])
            ->exists();

        if ($sudahAda) {
            return back()
                ->withInput()
                ->with('error', 'Peserta sudah terdaftar di kelas ini.');
        }

        PendaftaranKelas::create($dataValid);

        return redirect()
            ->route('kelas.show', $dataValid['kelas_id'])
            ->with('success', 'Peserta berhasil didaftarkan ke kelas.');
    }

    /**
     * (Opsional) Detail satu pendaftaran.
     */
    public function show(PendaftaranKelas $pendaftaranKelas)
    {
        $pendaftaranKelas->load(['peserta', 'kelas']);

        return view('pendaftaran-kelas.show', [
            'pendaftaran' => $pendaftaranKelas,
        ]);
    }

    /**
     * (Opsional) Form edit pendaftaran.
     */
    public function edit(PendaftaranKelas $pendaftaranKelas)
    {
        $daftarPeserta = Peserta::orderBy('nama')->get();
        $daftarKelas   = Kelas::orderBy('judul')->get();

        return view('pendaftaran-kelas.edit', [
            'pendaftaran' => $pendaftaranKelas,
            'daftarPeserta' => $daftarPeserta,
            'daftarKelas' => $daftarKelas,
        ]);
    }

    /**
     * (Opsional) Update pendaftaran.
     */
    public function update(Request $request, PendaftaranKelas $pendaftaranKelas)
    {
        $dataValid = $request->validate([
            'peserta_id' => 'required|exists:peserta,id',
            'kelas_id'   => 'required|exists:kelas,id',
            'catatan'    => 'nullable|string|max:500',
        ]);

        // Cek duplikat (kecuali dirinya sendiri)
        $sudahAda = PendaftaranKelas::where('peserta_id', $dataValid['peserta_id'])
            ->where('kelas_id', $dataValid['kelas_id'])
            ->where('id', '!=', $pendaftaranKelas->id)
            ->exists();

        if ($sudahAda) {
            return back()
                ->withInput()
                ->with('error', 'Peserta sudah terdaftar di kelas ini.');
        }

        $pendaftaranKelas->update($dataValid);

        return redirect()
            ->route('kelas.show', $dataValid['kelas_id'])
            ->with('success', 'Pendaftaran kelas berhasil diperbarui.');
    }

    /**
     * Hapus pendaftaran kelas (batalkan peserta dari kelas).
     * Dipakai kalau hapus dari halaman detail kelas atau dari daftar pendaftaran.
     */
    public function destroy(PendaftaranKelas $pendaftaranKelas)
    {
        $kelasId = $pendaftaranKelas->kelas_id;

        $pendaftaranKelas->delete();

        return redirect()
            ->route('kelas.show', $kelasId)
            ->with('success', 'Peserta berhasil dihapus dari kelas.');
    }

    public function storeMulti(Request $request)
    {
        $request->validate([
            'peserta_id' => 'required|exists:peserta,id',
            'kelas_id' => 'required|array|min:1',
            'kelas_id.*' => 'exists:kelas,id',
        ]);

        foreach ($request->kelas_id as $kelasId) {
            // Hindari duplikat
            PendaftaranKelas::firstOrCreate([
                'peserta_id' => $request->peserta_id,
                'kelas_id' => $kelasId,
            ]);
        }

        return redirect()
            ->route('peserta.show', $request->peserta_id)
            ->with('success', 'Kelas berhasil diambil!');
    }
}
