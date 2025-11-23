@extends('layouts.aplikasi')

@section('konten')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Daftar Kelas</h1>
    <a href="{{ route('kelas.create') }}" class="btn btn-primary">Tambah Kelas</a>
</div>

@if ($daftarKelas->isEmpty())
    <p class="text-muted">Belum ada kelas terdaftar.</p>
@else
    <table class="table table-bordered table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Judul Kelas</th>
                <th>Kode</th>
                <th>Pengajar</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
                <th style="width: 200px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($daftarKelas as $kelas)
                @php
                    $today = \Carbon\Carbon::today();

                    // Pastikan jumlah peserta tidak null
                    $jumlahPeserta = $kelas->peserta_count ?? $kelas->peserta->count() ?? 0;

                    // Kapasitas bisa null → unlimited
                    $kapasitas = $kelas->kapasitas ?? '∞';

                    // Tentukan status kelas
                    if ($kelas->tanggal_mulai && $today->lt($kelas->tanggal_mulai)) {
                        $status = ['Belum Dibuka', 'warning'];
                    } elseif ($kelas->tanggal_selesai && $today->gt($kelas->tanggal_selesai)) {
                        $status = ['Ditutup', 'secondary'];
                    } elseif (!is_null($kelas->kapasitas) && $jumlahPeserta >= $kelas->kapasitas) {
                        $status = ['Penuh', 'danger'];
                    } else {
                        $status = ['Dibuka', 'success'];
                    }

                    $nomor = $loop->iteration + ($daftarKelas->currentPage() - 1) * $daftarKelas->perPage();
                @endphp

                <tr>
                    <td>{{ $nomor }}</td>
                    <td>{{ $kelas->judul }}</td>
                    <td>{{ $kelas->kode }}</td>
                    <td>{{ $kelas->pengajar }}</td>
                    <td>{{ $kelas->tanggal_mulai?->format('d-m-Y') }}</td>
                    <td>{{ $kelas->tanggal_selesai?->format('d-m-Y') }}</td>

                    {{-- Status --}}
                    <td>
                        <span class="badge bg-{{ $status[1] }}">
                            {{ $status[0] }}
                        </span><br>
                        @if($kapasitas !== '∞')
                            <small class="text-muted">
                                {{ $jumlahPeserta }} / {{ $kapasitas }} peserta
                            </small>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td>
                        <a href="{{ route('kelas.show', $kelas->id) }}"
                           class="btn btn-sm btn-info">Detail</a>

                        <a href="{{ route('kelas.edit', $kelas->id) }}"
                           class="btn btn-sm btn-warning">Ubah</a>

                        <form action="{{ route('kelas.destroy', $kelas->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus kelas ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $daftarKelas->links() }}
    </div>
@endif
@endsection
