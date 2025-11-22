@extends('layouts.aplikasi')

@section('konten')
  <h1>Tambah Peserta</h1>

  <form action="{{ route('peserta.store') }}" method="POST" class="mt-3">
    @csrf

    <div class="mb-3">
      <label class="form-label">Nama</label>
      <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
      @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
      @error('email') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Telepon</label>
      <input type="text" name="telepon" class="form-control" value="{{ old('telepon') }}">
      @error('telepon') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Catatan</label>
      <textarea name="catatan" class="form-control" rows="3">{{ old('catatan') }}</textarea>
      @error('catatan') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('peserta.index') }}" class="btn btn-secondary">Kembali</a>
  </form>
@endsection
