@extends('layouts.aplikasi')

@section('konten')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Daftar Kelas</h1>
        <a href="{{ route('kelas.create') }}" class="btn btn-primary">Tambah Kelas</a>
    </div>

    @if ($daftarKelas->isEmpty())
        <p>Belum ada kelas terdaftar.</p>
    @else
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Judul Kelas</th>
                    <th>Kode</th>
                    <th>Pengajar</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Status</th>
                    <th style="width: 220px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($daftarKelas as $kelas)
                    @php
                        $today = \Carbon\Carbon::today();
                        $kapasitas = $kelas->kapasitas ?? '∞';
                        $jumlahPeserta = $kelas->peserta_count;
                        $sisaSlot = $kelas->kapasitas ? $kelas->kapasitas - $kelas->peserta_count : null;

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
                        <td>
                            <span class="badge bg-{{ $status[1] }}">{{ $status[0] }}</span>
                            <br>
                            @if (!is_null($kelas->kapasitas))
                                <small class="text-muted">{{ $jumlahPeserta }} / {{ $kapasitas }} peserta</small>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('kelas.show', $kelas) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('kelas.edit', $kelas) }}" class="btn btn-sm btn-warning">Ubah</a>
                            <form action="{{ route('kelas.destroy', $kelas) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $daftarKelas->links() }}
    @endif
@endsection
