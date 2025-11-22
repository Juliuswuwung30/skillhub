<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>SkillHub – Manajemen Peserta & Kelas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="{{ route('peserta.index') }}">SkillHub</a>
    <div class="navbar-nav">
      <a class="nav-link" href="{{ route('peserta.index') }}">Peserta</a>
      <a class="nav-link" href="{{ route('kelas.index') }}">Kelas</a>
    </div>
  </div>
</nav>

<div class="container mb-4">

  {{-- pesan sukses --}}
  @if(session('berhasil'))
    <div class="alert alert-success">
      {{ session('berhasil') }}
    </div>
  @endif

  {{-- error validasi global --}}
  @if($errors->any())
    <div class="alert alert-danger">
      <strong>Terjadi kesalahan:</strong>
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @yield('konten')

</div>

</body>
</html>
