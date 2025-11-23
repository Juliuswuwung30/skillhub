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
        $validated = $request->validate([
            'peserta_id' => 'required|exists:peserta,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $kelas = Kelas::findOrFail($validated['kelas_id']);
        $peserta = Peserta::findOrFail($validated['peserta_id']);

        $today = now();

        // ❌ Jika kelas belum dibuka
        if ($kelas->tanggal_mulai && $today->lt($kelas->tanggal_mulai)) {
            return back()->with('error', 'Kelas belum dibuka!');
        }

        // ❌ Jika kelas sudah ditutup
        if ($kelas->tanggal_selesai && $today->gt($kelas->tanggal_selesai)) {
            return back()->with('error', 'Kelas sudah ditutup!');
        }

        // ❌ Jika kelas penuh
        if (!is_null($kelas->kapasitas) && $kelas->peserta()->count() >= $kelas->kapasitas) {
            return back()->with('error', 'Kelas sudah penuh!');
        }

        // ❌ Jika sudah terdaftar
        if ($kelas->peserta()->where('peserta_id', $peserta->id)->exists()) {
            return back()->with('error', 'Peserta sudah terdaftar di kelas ini.');
        }

        // 💾 Simpan pendaftaran
        $kelas->peserta()->attach($peserta->id);

        return back()->with('success', 'Berhasil mendaftar kelas.');
    }


    /**
     * (Opsional) Detail satu pendaftaran.
     */
    public function show(Kelas $kelas)
    {
        $kelas->load('peserta'); // eager load relasi

        return view('pendaftaran-kelas.show', [
            'kelas' => $kelas,
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
    public function destroy($id)
    {
        $pendaftaran = PendaftaranKelas::find($id);

        // Jika tidak ditemukan → test expect 404
        if (!$pendaftaran) {
            abort(404);
        }

        // Simpan dulu kelas_id sebelum dihapus
        $kelasId = $pendaftaran->kelas_id;

        $pendaftaran->delete();

        return redirect()->route('kelas.show', $kelasId)
            ->with('success', 'Pendaftaran berhasil dihapus.');
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

    public function daftarPesertaKelas(Kelas $kelas)
    {
        $kelas->load('peserta');

        return view('kelas.show', [
            'kelas'         => $kelas,
            'daftarPeserta' => $kelas->peserta,
        ]);
    }

    public function daftarKelasPeserta(Peserta $peserta)
    {
        $peserta->load('kelas');

        $daftarKelas = Kelas::withCount('peserta')
            ->orderBy('tanggal_mulai')
            ->get();

        return view('peserta.show', [
            'peserta'      => $peserta,
            'kelasDiikuti' => $peserta->kelas,
            'daftarKelas'  => $daftarKelas,
        ]);
    }
}
