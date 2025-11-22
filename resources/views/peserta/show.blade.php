@extends('layouts.aplikasi')

@section('konten')
<div class="container">
  <h3>Detail Peserta</h3>

  {{-- Alert --}}
  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
  @endif

  {{-- DETAIL PESERTA --}}
  <div class="card mb-4">
    <div class="card-body">
      <p><strong>Nama:</strong> {{ $peserta->nama }}</p>
      <p><strong>Email:</strong> {{ $peserta->email }}</p>
      <p><strong>Telepon:</strong> {{ $peserta->telepon ?? '-' }}</p>

      <a href="{{ route('peserta.index') }}" class="btn btn-secondary mt-2">
        &laquo; Kembali ke Daftar Peserta
      </a>
    </div>
  </div>

  {{-- KELAS YANG DIAMBIL PESERTA --}}
  <div class="card mb-4">
    <div class="card-header">
      Kelas yang Diambil Peserta Ini
    </div>
    <div class="card-body">
      @if($kelasDiikuti->isEmpty())
        <p>Peserta ini belum mengambil kelas apapun.</p>
      @else
        <table class="table table-sm table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Judul Kelas</th>
              <th>Pengajar</th>
              <th>Tanggal Mulai</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($kelasDiikuti as $index => $kelas)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $kelas->judul }}</td>
                <td>{{ $kelas->pengajar }}</td>
                <td>
                  {{ $kelas->tanggal_mulai
                        ? \Carbon\Carbon::parse($kelas->tanggal_mulai)->format('d M Y')
                        : '-' }}
                </td>
                <td>
                  {{-- Hapus hubungan peserta-kelas (keluar dari kelas) --}}
                  <form action="{{ route('kelas.peserta.hapus', ['kelas' => $kelas->id, 'peserta' => $peserta->id]) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus peserta ini dari kelas tersebut?');">
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

  {{-- FORM: PESERTA AMBIL KELAS --}}
<div class="card">
  <div class="card-header">
    Ambil Kelas
  </div>
  <div class="card-body">

    <form action="{{ route('pendaftaran-kelas.store-multi') }}" method="POST">
      @csrf

      <input type="hidden" name="peserta_id" value="{{ $peserta->id }}">

      <table class="table table-bordered table-sm">
        <thead>
          <tr>
            <th>Pilih</th>
            <th>Kelas</th>
            <th>Status</th>
            <th>Kuota</th>
          </tr>
        </thead>
        <tbody>
        @foreach($daftarKelas as $kelas)

          @php
            $totalPeserta = $kelas->peserta_count;
            $hariIni = now();
            if ($kelas->tanggal_mulai > $hariIni) {
                $status = 'Belum Dibuka';
                $bisa = false;
            } elseif ($kelas->tanggal_selesai < $hariIni) {
                $status = 'Ditutup';
                $bisa = false;
            } elseif ($totalPeserta >= $kelas->kapasitas) {
                $status = 'Penuh';
                $bisa = false;
            } else {
                $status = 'Terbuka';
                $bisa = true;
            }
          @endphp

          {{-- Lewati kelas yang sudah diambil peserta --}}
          @if($kelasDiikuti->contains($kelas->id))
            @continue
          @endif

          <tr>
            <td>
              <input type="checkbox"
                     name="kelas_id[]"
                     value="{{ $kelas->id }}"
                     @if(!$bisa) disabled @endif>
            </td>
            <td>
              {{ $kelas->judul }}
              <br><small>{{ $kelas->kode }}</small>
            </td>
            <td>
              <span class="badge 
                @if($status == 'Terbuka') bg-success
                @elseif($status == 'Penuh') bg-danger
                @elseif($status == 'Belum Dibuka') bg-warning text-dark
                @else bg-secondary
                @endif
              ">
                {{ $status }}
              </span>
            </td>
            <td>
              {{ $totalPeserta }} / {{ $kelas->kapasitas }}
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>

      <button type="submit" class="btn btn-primary">
        Simpan Kelas yang Dipilih
      </button>

    </form>
  </div>
</div>
@endsection
