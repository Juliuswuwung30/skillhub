@extends('layouts.aplikasi')

@section('konten')
  <h1>Ubah Data Peserta</h1>

  <form action="{{ route('peserta.update', $peserta) }}" method="POST" class="mt-3">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label class="form-label">Nama</label>
      <input type="text" name="nama" class="form-control" value="{{ old('nama', $peserta->nama) }}" required>
      @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" value="{{ old('email', $peserta->email) }}" required>
      @error('email') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Telepon</label>
      <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $peserta->telepon) }}">
      @error('telepon') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Catatan</label>
      <textarea name="catatan" class="form-control" rows="3">{{ old('catatan', $peserta->catatan) }}</textarea>
      @error('catatan') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <button class="btn btn-primary">Simpan Perubahan</button>
    <a href="{{ route('peserta.show', $peserta) }}" class="btn btn-secondary">Batal</a>
  </form>
@endsection
