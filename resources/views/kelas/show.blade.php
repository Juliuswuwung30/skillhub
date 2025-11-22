@extends('layouts.aplikasi')

@section('konten')
<div class="container">
  <div class="row">

    {{-- DETAIL KELAS --}}
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header">
          Detail Kelas
        </div>
        <div class="card-body">

          <p><strong>Judul Kelas</strong><br>
          {{ $kelas->judul ?? '-' }}</p>

          <p><strong>Kode</strong><br>
          {{ $kelas->kode ?? '-' }}</p>

          <p><strong>Pengajar</strong><br>
          {{ $kelas->pengajar ?? '-' }}</p>

          <p><strong>Tanggal Mulai</strong><br>
          {{ $kelas->tanggal_mulai ? \Carbon\Carbon::parse($kelas->tanggal_mulai)->format('d M Y') : '-' }}</p>

          <p><strong>Tanggal Selesai</strong><br>
          {{ $kelas->tanggal_selesai ? \Carbon\Carbon::parse($kelas->tanggal_selesai)->format('d M Y') : '-' }}</p>

          <p><strong>Kapasitas</strong><br>
          {{ $kelas->kapasitas ?? '-' }} peserta</p>

          <p><strong>Catatan</strong><br>
          {{ $kelas->catatan ?? '-' }}</p>

          <a href="{{ route('kelas.index') }}" class="btn btn-secondary mt-3">
            &laquo; Kembali ke Daftar Kelas
          </a>

        </div>
      </div>
    </div>

    {{-- DAFTAR PESERTA KELAS --}}
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header">
          Daftar Peserta di Kelas Ini
        </div>
        <div class="card-body">

          @if(session('success'))
            <div class="alert alert-success">
              {{ session('success') }}
            </div>
          @endif

          @if($daftarPeserta->isEmpty())
            <p>Belum ada peserta yang terdaftar di kelas ini.</p>
          @else
            <table class="table table-bordered table-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Telepon</th>
                  <th style="width: 90px;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($daftarPeserta as $index => $peserta)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $peserta->nama }}</td>
                  <td>{{ $peserta->email }}</td>
                  <td>{{ $peserta->telepon ?? '-' }}</td>
                  <td>
                    <form action="{{ route('kelas.peserta.hapus', ['kelas' => $kelas->id, 'peserta' => $peserta->id]) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus peserta ini dari kelas?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger">
                        Hapus
                      </button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          @endif

        </div>
      </div>
    </div>

  </div>
</div>
@endsection
