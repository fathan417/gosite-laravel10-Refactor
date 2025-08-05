<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detail Event - {{ $rapat->judul }}</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    .glass-card {
      background: rgba(0, 0, 0, 0.49);
      border: 1px solid rgba(255, 255, 255, 0.66);
      border-radius: 1rem;
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.4);
      padding: 3rem;
      color: white;
    }

    .glass-link, .glass-button {
      display: block;
      padding: 1rem;
      margin-top: 1rem;
      background: rgba(255, 255, 255, 0.47);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 12px;
      color: #202020;
      font-weight: 500;
      text-align: center;
      text-decoration: none;
      transition: 0.3s;
      /* text-shadow: 1px 1px 3px rgba(30, 30, 30, 0.69); */
    }

    .glass-link:hover, .glass-button:hover {
      background: rgba(255, 255, 255, 0.18);
      transform: translateY(-2px);
      text-decoration: none;
      color: #202020;
    }
  </style>

</head>
<body class="bg-light text-light" style="background: url('{{ asset('images/mountain-bg-1.svg') }}') no-repeat center center fixed; background-size: cover;">

  <div class="container my-5 glass-card" style="max-width: 720px;">
    <!-- Header -->
    <div class="text-center mb-4 border-0 d-flex justify-content-center align-items-center bg-transparent">
      <img src="{{ asset('images/details.png') }}" alt="Icon" style="width: 120px; height: 120px; font-weight: 500;">
      <h2 class="text-light">{{ $rapat->judul }}</h2>
    </div>

    <!-- Tombol Presensi -->
    <div class="mb-4 text-center">
      <a href="{{ route('presensi.show', ['id' => $rapat->id]) }}" class="glass-button">Presensi</a>
    </div>

    <!-- Konten File -->
    @forelse($rapat->contents as $c)
      <div class="mb-3">
        <a href="{{ $c->link }}" target="_blank" class="glass-link">
          <i class="fa fa-folder mr-2"></i> {{ $c->name }}
        </a>
      </div>
    @empty
      <p class="text-center">Belum ada konten untuk ditampilkan.</p>
    @endforelse


  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
