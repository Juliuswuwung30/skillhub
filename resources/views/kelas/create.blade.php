@extends('layouts.aplikasi')

@section('konten')
<div class="container">
    <h3 class="mb-4">Tambah Kelas Baru</h3>

    {{-- Alert error / success --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong> Periksa kembali masukan Anda.
        </div>
    @endif

    <form action="{{ route('kelas.store') }}" method="POST">
        @csrf

        {{-- Judul Kelas --}}
        <div class="mb-3">
            <label for="judul" class="form-label">Judul Kelas</label>
            <input type="text" id="judul" name="judul"
                   class="form-control @error('judul') is-invalid @enderror"
                   value="{{ old('judul') }}" required>

            @error('judul')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Kode Kelas --}}
        <div class="mb-3">
            <label for="kode" class="form-label">Kode Kelas</label>
            <input type="text" id="kode" name="kode"
                   class="form-control @error('kode') is-invalid @enderror"
                   value="{{ old('kode') }}" required>

            @error('kode')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Pengajar --}}
        <div class="mb-3">
            <label for="pengajar" class="form-label">Pengajar</label>
            <input type="text" id="pengajar" name="pengajar"
                   class="form-control @error('pengajar') is-invalid @enderror"
                   value="{{ old('pengajar') }}" required>

            @error('pengajar')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Tanggal Mulai --}}
        <div class="mb-3">
            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                   class="form-control @error('tanggal_mulai') is-invalid @enderror"
                   value="{{ old('tanggal_mulai') }}" required>

            @error('tanggal_mulai')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Tanggal Selesai --}}
        <div class="mb-3">
            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
            <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                   class="form-control @error('tanggal_selesai') is-invalid @enderror"
                   value="{{ old('tanggal_selesai') }}" required>

            @error('tanggal_selesai')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Kapasitas --}}
        <div class="mb-3">
            <label for="kapasitas" class="form-label">Kapasitas Peserta</label>
            <input type="number" id="kapasitas" name="kapasitas" min="1"
                   class="form-control @error('kapasitas') is-invalid @enderror"
                   value="{{ old('kapasitas') }}">

            @error('kapasitas')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
            <small class="text-muted">Kosongkan jika kapasitas tidak dibatasi.</small>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
