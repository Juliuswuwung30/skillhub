@extends('layouts.aplikasi')

@section('konten')
<div class="container">
  <h3>Daftarkan Peserta ke Kelas</h3>

  {{-- Alert sukses / error --}}
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

  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card mt-3">
    <div class="card-header">
      Form Pendaftaran Kelas
    </div>

    <div class="card-body">
      <form action="{{ route('pendaftaran-kelas.store') }}" method="POST">
        @csrf

        {{-- Pilih Peserta --}}
        <div class="mb-3">
          <label for="peserta_id" class="form-label">Peserta</label>
          <select name="peserta_id" id="peserta_id" class="form-select" required>
            <option value="">-- Pilih Peserta --</option>
            @foreach($daftarPeserta as $peserta)
              <option value="{{ $peserta->id }}"
                @if(old('peserta_id') == $peserta->id)
                  selected
                @elseif(isset($pesertaTerpilih) && $pesertaTerpilih && $pesertaTerpilih->id == $peserta->id && !old('peserta_id'))
                  selected
                @endif
              >
                {{ $peserta->nama }} ({{ $peserta->email }})
              </option>
            @endforeach
          </select>
        </div>

        {{-- Pilih Kelas --}}
        <div class="mb-3">
          <label for="kelas_id" class="form-label">Kelas</label>
          <select name="kelas_id" id="kelas_id" class="form-select" required>
            <option value="">-- Pilih Kelas --</option>
            @foreach($daftarKelas as $kelas)
              <option value="{{ $kelas->id }}"
                @if(old('kelas_id') == $kelas->id)
                  selected
                @endif
              >
                {{ $kelas->judul }} ({{ $kelas->kode }})
              </option>
            @endforeach
          </select>
        </div>

        {{-- Catatan (opsional) --}}
        <div class="mb-3">
          <label for="catatan" class="form-label">Catatan (opsional)</label>
          <textarea name="catatan" id="catatan" rows="3" class="form-control">{{ old('catatan') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">
          Simpan Pendaftaran
        </button>

        <a href="{{ url()->previous() }}" class="btn btn-secondary ms-2">
          Batal
        </a>
      </form>
    </div>
  </div>
</div>
@endsection
