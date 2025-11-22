@extends('layouts.aplikasi')

@section('konten')
  <h1>Tambah Kelas</h1>

  <form action="{{ route('kelas.store') }}" method="POST" class="mt-3">
    @csrf

    <div class="mb-3">
      <label class="form-label">Judul Kelas</label>
      <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
      @error('judul') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Kode Kelas</label>
      <input type="text" name="kode" class="form-control" value="{{ old('kode') }}" required>
      @error('kode') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Pengajar</label>
      <input type="text" name="pengajar" class="form-control" value="{{ old('pengajar') }}" required>
      @error('pengajar') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Deskripsi</label>
      <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
      @error('deskripsi') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="row">
      <div class="col-md-4 mb-3">
        <label class="form-label">Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai') }}">
        @error('tanggal_mulai') <small class="text-danger">{{ $message }}</small> @enderror
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label">Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai') }}">
        @error('tanggal_selesai') <small class="text-danger">{{ $message }}</small> @enderror
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label">Kapasitas (opsional)</label>
        <input type="number" name="kapasitas" class="form-control" value="{{ old('kapasitas') }}">
        @error('kapasitas') <small class="text-danger">{{ $message }}</small> @enderror
      </div>
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Kembali</a>
  </form>
@endsection
