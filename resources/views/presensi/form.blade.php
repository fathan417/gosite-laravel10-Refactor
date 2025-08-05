<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Form Presensi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .form-container {
      width: 750px;
      margin: 50px auto;
    }

    .glass-card {
      background: rgba(0, 0, 0, 0.38);
      backdrop-filter: blur(15px);
      border: 1px solid rgba(255, 255, 255, 0.66);
      border-radius: 1.25rem;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
      color: #fff;
    }

    .form-control, input:focus {
      background-color: #cdcdcd !important;
      color: #202020 !important;
      border-radius: 0.5rem !important;
    }

    .form-control::placeholder {
      color: #202020;
      font-weight: 400;
    }

    input:focus, select:focus, button:focus, a:focus, .btn:focus, .btn.focus {
      box-shadow: none !important;
      outline: none !important;
    }

    label {
      font-weight: 500;
      text-shadow: 1px 1px 3px rgba(30, 30, 30, 0.47);
    }

    select.form-control {
      background-color: rgba(255, 255, 255, 0.1);
      color: #fff;
    }

    select.form-control option {
      color: #000;
      background-color: #fff;
    }

    canvas#signature {
      background-color: rgba(255, 255, 255, 0.14);
      border: 1px solid rgba(255, 255, 255, 0.81);
      border-radius: 0.5rem;
    }

    button.btn {
      border-radius: 0.5rem;
    }

    .modern-btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 0.5rem 1.2rem;
      font-size: 0.95rem;
      font-weight: 500;
      border: none;
      border-radius: 999px;
      background-color: #ffffff10;
      color: #fff;
      backdrop-filter: blur(6px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: all 0.2s ease;
    }

    .modern-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    }

    .modern-btn.primary {
      background-color: #2e51f0;
    }

    .modern-btn.primary:hover {
      background-color: #2444c8;
    }

    .modern-btn.danger {
      background-color: #e74c3c;
    }

    .modern-btn.warning {
      background-color: #f39c12;
    }

    .modern-btn.outline {
      border: 1px solid #fff;
      background-color: transparent;
    }

    .modern-btn.outline:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }

  </style>
</head>
<body style="background: url('{{ asset('images/mountain-bg.jpg') }}') no-repeat center center fixed; background-size: cover;">
  <div class="container form-container d-flex justify-content-center align-items-center flex-column min-vh-100">
    <div class="glass-card w-100 px-4 py-5 text-light" style="max-width: 720px;">
      <div class="text-center mb-4" style="text-shadow: 1px 1px 3px rgba(30, 30, 30, 0.47);">
        <h3 class="mb-1">{{ $rapat->judul }}</h3>
        <h4 class="mb-3">{{ $rapat->tempat }}</h4>
        @php
          $start = \Carbon\Carbon::parse($rapat->waktu_mulai);
          $end = \Carbon\Carbon::parse($rapat->waktu_selesai);
          $startDate = $start->translatedFormat('d M Y');
          $startTime = $start->format('H:i');
          $endDate = $end->translatedFormat('d M Y');
          $endTime = $end->format('H:i');
          if ($start->toDateString() === $end->toDateString()) {
              $display = "$startDate, $startTime – $endTime";
          } else {
              $display = "$startDate, $startTime – $endDate, $endTime";
          }
        @endphp

        <div style="min-width: 0; max-width: 100%;" title="{{ $display }}">
          <i class="fa fa-calendar mr-2"></i> {{ $display }}
        </div>
      </div>

      <form action="{{ route('presensi.submit', ['id' => $rapat->id]) }}" method="POST">
      @csrf
        <div class="form-group">
          <h6><label for="nip" class="text-light">NIP/NIK</label></h6>
          <input type="text" id="nip" name="nip" class="form-control" maxlength="20" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Masukkan NIP atau NIK">
        </div>

        <div class="form-group">
          <h6><label for="nama" class="text-light">Nama Lengkap</label></h6>
          <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap">
        </div>

        <div class="form-group">
            <h6><label for="instansi" class="text-light">Instansi</label></h6>
            <input type="text" class="form-control" id="instansi" name="instansi" placeholder="Masukkan nama instansi">
        </div>

          <div class="form-group">
            <h6 style="text-shadow: 1px 1px 3px rgba(30, 30, 30, 0.47);">Wilayah Satuan Kerja</h6>

            <div class="form-group">
              <label for="provinsi" class="text-light">Provinsi</label>
              <select class="form-control" id="provinsi" name="province_id">
                <option value="">-- Pilih Provinsi --</option>
                @foreach ($provinsi as $prov)
                  <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="kabupaten" class="text-light">Kabupaten/Kota</label>
              <select class="form-control" id="kabupaten" name="regency_id">
                <option value="">-- Pilih Kabupaten/Kota --</option>
              </select>
            </div>
          </div>

        <div class="form-group">
          <h6><label class="text-light">Tanda Tangan Digital</label></h6>
          <canvas id="signature" width="660" height="300" style="border:1px solid #ccc; display: block;"></canvas>
          
          <div class="d-flex mt-2">
            <button type="button" class="modern-btn danger mr-3" onclick="clearSignature()"><i class="fa-solid fa-eraser"></i></button>
            <button type="button" class="modern-btn warning" onclick="undoSignature()"><i class="fa-solid fa-arrow-rotate-left"></i></button>
          </div>
        </div>

        <div class="d-flex justify-content-between w-100 mt-4">
          <button type="submit" class="modern-btn primary"><i class="fa-regular fa-paper-plane"></i></button>
          <button type="reset" class="modern-btn outline"><i class="fa-regular fa-trash-can"></i></button>
        </div>

        <input type="hidden" name="event_id" value="{{ $rapat->id }}">
        <input type="hidden" name="signature" id="signature-input">

      </form>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>


  <script>
    const canvas = document.getElementById('signature');
    const signaturePad = new SignaturePad(canvas);   
   
    function clearSignature() {
      signaturePad.clear();
    }

    function undoSignature() {
      const data = signaturePad.toData();
      if (data.length) {
        data.pop();
        signaturePad.fromData(data);
      }
    }

    document.querySelector('form').addEventListener('submit', function (e) {
      if (!signaturePad.isEmpty()) {
        const signatureData = signaturePad.toDataURL();
        document.getElementById('signature-input').value = signatureData;
      }
    });

    document.querySelector('form').addEventListener('reset', function () {
      clearSignature();
    });

    document.getElementById('provinsi').addEventListener('change', function () {
      const provinceId = this.value;
      fetch(`/api/kabupaten/${provinceId}`)
        .then(res => res.json())
        .then(data => {
          const kabupatenSelect = document.getElementById('kabupaten');
          kabupatenSelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
          data.forEach(kab => {
            kabupatenSelect.innerHTML += `<option value="${kab.id}">${kab.name}</option>`;
          });
        });
    });
  </script>

</body>
</html>
