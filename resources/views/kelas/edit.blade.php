@extends('layouts.aplikasi')

@section('konten')
  <h1>Ubah Data Kelas</h1>

  <form action="{{ route('kelas.update', $kelas) }}" method="POST" class="mt-3">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label class="form-label">Judul Kelas</label>
      <input type="text" name="judul" class="form-control"
             value="{{ old('judul', $kelas->judul) }}" required>
      @error('judul') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Kode Kelas</label>
      <input type="text" name="kode" class="form-control"
             value="{{ old('kode', $kelas->kode) }}" required>
      @error('kode') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Pengajar</label>
      <input type="text" name="pengajar" class="form-control"
             value="{{ old('pengajar', $kelas->pengajar) }}" required>
      @error('pengajar') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Deskripsi</label>
      <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $kelas->deskripsi) }}</textarea>
      @error('deskripsi') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="row">
      <div class="col-md-4 mb-3">
        <label class="form-label">Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai" class="form-control"
               value="{{ old('tanggal_mulai', optional($kelas->tanggal_mulai)->format('Y-m-d')) }}">
        @error('tanggal_mulai') <small class="text-danger">{{ $message }}</small> @enderror
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label">Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai" class="form-control"
               value="{{ old('tanggal_selesai', optional($kelas->tanggal_selesai)->format('Y-m-d')) }}">
        @error('tanggal_selesai') <small class="text-danger">{{ $message }}</small> @enderror
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label">Kapasitas (opsional)</label>
        <input type="number" name="kapasitas" class="form-control"
               value="{{ old('kapasitas', $kelas->kapasitas) }}">
        @error('kapasitas') <small class="text-danger">{{ $message }}</small> @enderror
      </div>
    </div>

    <button class="btn btn-primary">Simpan Perubahan</button>
    <a href="{{ route('kelas.show', $kelas) }}" class="btn btn-secondary">Batal</a>
  </form>
@endsection
