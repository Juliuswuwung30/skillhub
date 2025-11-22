@extends('layouts.aplikasi')

@section('konten')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Daftar Peserta</h1>
    <a href="{{ route('peserta.create') }}" class="btn btn-primary">Tambah Peserta</a>
  </div>

  @if($daftarPeserta->isEmpty())
    <p>Belum ada peserta terdaftar.</p>
  @else
    <table class="table table-bordered table-striped align-middle">
      <thead>
      <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Telepon</th>
        <th style="width: 220px;">Aksi</th>
      </tr>
      </thead>
      <tbody>
      @foreach($daftarPeserta as $peserta)
        <tr>
          <td>{{ $peserta->id }}</td>
          <td>{{ $peserta->nama }}</td>
          <td>{{ $peserta->email }}</td>
          <td>{{ $peserta->telepon }}</td>
          <td>
            <a href="{{ route('peserta.show', $peserta) }}" class="btn btn-sm btn-info">Detail</a>
            <a href="{{ route('peserta.edit', $peserta) }}" class="btn btn-sm btn-warning">Ubah</a>
            <form action="{{ route('peserta.destroy', $peserta) }}"
                  method="POST"
                  class="d-inline"
                  onsubmit="return confirm('Yakin ingin menghapus peserta ini?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-danger">Hapus</button>
            </form>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>

    {{ $daftarPeserta->links() }}
  @endif
@endsection
