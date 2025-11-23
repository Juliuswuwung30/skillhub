@extends('layouts.aplikasi')

@section('konten')
<div class="container">
    <h1>Detail Kelas: {{ $kelas->judul }}</h1>

    <p><strong>Kode:</strong> {{ $kelas->kode }}</p>
    <p><strong>Pengajar:</strong> {{ $kelas->pengajar }}</p>
    <p><strong>Tanggal Mulai:</strong> {{ $kelas->tanggal_mulai }}</p>
    <p><strong>Tanggal Selesai:</strong> {{ $kelas->tanggal_selesai }}</p>
    <p><strong>Kapasitas:</strong> {{ $kelas->kapasitas }}</p>

    <h3 class="mt-4">Peserta Terdaftar</h3>

    @if ($kelas->peserta->isEmpty())
        <p>Belum ada peserta</p>
    @else
        <ul>
            @foreach ($kelas->peserta as $peserta)
                <li>{{ $peserta->nama }} ({{ $peserta->email }})</li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('kelas.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
