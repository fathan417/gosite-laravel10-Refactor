<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>GoSite</title>
      <link id="themeStylesheet" rel="stylesheet" href="{{ asset('css/gosite_style_planet.css') }}">
      <link id="themeStylesheet" rel="stylesheet" href="{{ asset('css/theme.css') }}">
      <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Sora:wght@100..800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <!-- Bootstrap 4.5 -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <!-- SweetAlert2 CSS & JS -->
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

        <style>
          .Gear {
            position: absolute !important;
            top: -30px;
            left: -110px;
            width: 400px;
            pointer-events: none;
            z-index: 0;
            animation: rotateGear 64s linear infinite;
          }
        
          @keyframes rotateGear {
            0%   { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
          }
        </style>
  </head>

  <body id="main-body" class="d-flex flex-column w-100 min-vh-100 text-light theme-light">
    <div id="vanta-dots" class="position-fixed w-100 h-100" style="z-index: -1; top: 0; left: 0;"></div>
    <!-- Navbar -->
      <nav class="Main-nav navbar navbar-expand-sm navbar-dark px-4 py-2 shadow-sm position-fixed w-100">
        <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">

        <!-- Logo + Divider -->
          <div class="LogDiv d-flex flex-sm-row align-items-center justify-content-center mb-3 mb-md-0">
            <span class="h5 font-weight-bold text-white mb-1 mb-sm-0">GoSite</span>
            <div class="mx-2 divider"></div>
            <img id="logo-gosite" src="{{ $logoDark }}" alt="Logo Provinsi Gorontalo" style="max-width: 120px;"/>
          </div>

        <!-- Search + Filter + Setting -->
          <div class="SeacTons d-flex flex-wrap justify-content-end align-items-center w-100 w-md-auto">

          <!-- Search input -->
            <div class="input-group rounded-pill Search my-2 mr-2">     
              <div class="input-group-append">
                <span class="input-group-text bg-transparent border-0">
                  <i class="fas fa-search text-dark"></i>
                </span>
              </div>
          
              <input id="search" name="search" type="text" class="form-control border-0 bg-transparent" placeholder="Cari Kegiatan...." value="{{ request('search') }}"/>
            </div>

          <!-- Filter Dropdown -->
            <div class="dropdown d-inline-block">
              <button class="Filter dropdown-toggle d-flex justify-content-center align-items-center mx-1 my-1" type="button" id="filterDropdown" aria-haspopup="true">
                <i class="fa-solid fa-filter text-dark"></i>
              </button>
              <div class="Dropdown dropdown-menu dropdown-menu-right p-3 dropdown-responsive" aria-labelledby="filterDropdown" style="width: 700px;">

                <div class="row">
                  <!-- Jenis -->
                  <div class="col-md-4 mb-2">
                    <h6 class="dropdown-header p-0 mb-1 text-light">Jenis</h6>
                    <div id="filter-jenis" class="btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                      @foreach($allJenis as $jenis)
                        <label class="btn btn-sm Kategori m-1 rounded-pill">
                          <input type="checkbox" class="filter-checkbox" data-type="jenis" value="{{ $jenis }}"> {{ $jenis }}
                        </label>
                      @endforeach
                    </div>
                  </div>

                  <!-- Tahun -->
                  <div class="col-md-4 mb-2">
                    <h6 class="dropdown-header p-0 mb-1 text-light">Tahun</h6>
                    <div id="filter-tahun" class="btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                      @foreach($allTahun as $tahun)
                        <label class="btn btn-sm Kategori m-1 rounded-pill">
                          <input type="checkbox" class="filter-checkbox" data-type="tahun" value="{{ $tahun }}"> {{ $tahun }}
                        </label>
                      @endforeach
                    </div>
                  </div>

                  <!-- Bulan -->
                  <div class="col-md-4 mb-2">
                    <h6 class="dropdown-header p-0 mb-1 text-light">Bulan</h6>
                    <div id="filter-bulan" class="btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                      @foreach($allBulan as $bulan)
                        <label class="btn btn-sm Kategori m-1 rounded-pill">
                          <input type="checkbox" class="filter-checkbox" data-type="bulan" value="{{ $bulan }}"> {{ $bulan }}
                        </label>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </div>

          <!-- Setting Modal Trigger -->
            <button type="button" class="btn Primary d-flex justify-content-center align-items-center mx-1 my-1 Settings" data-toggle="modal" data-target="#modal_setting">
              <i class="fas fa-gear fa-lg text-white"></i>
            </button>

            <button id="theme-toggle" class="theme-toggle-btn" title="Ganti Tema">
              <span id="theme-icon" class="theme-icon d-flex justify-content-center align-items-center"><i class="fa-solid fa-sun"></i></span>
            </button>


          </div>
        </div>
      </nav>

    <!-- Modal Settings -->
      <div class="modal fade" id="modal_setting" tabindex="-1" role="dialog" aria-labelledby="modal_setting_label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="myModal modal-content p-0 border-0 rounded-4 overflow-hidden position-relative">
      
          <!-- Background Gear -->
            <img src="{{ asset('images/icon-gear.png') }}" alt="Gear" class="Gear">
      
            <!-- Modal Body -->
            <div class="modal-body px-5 py-4 position-relative text-light" style="z-index:1;">
              <div class="row d-flex flex-column align-items-end">
      
                <div class="col-md-7 offset-md-5 modalWrap p-3 d-flex flex-column">
                  @foreach ([
                    'Nama' => $profil->nama,
                    'Email' => $profil->email,
                    'Asal Instansi' => $profil->instansi,
                    'Pekerjaan' => $profil->pekerjaan,
                    'Jenis Kelamin' => $profil->jk,
                    'Nomor Telepon' => $profil->nohp,
                    'Alamat' => $profil->alamat
                  ] as $label => $value)
                    <div class="d-flex justify-content-between small">
                      <span class="text-light">{{ $value ?: '-' }}</span>
                      <span class="text-light font-weight-bold">{{ $label }}</span>
                    </div>
                  @endforeach
                </div>

                  <div class="mt-4 col-md-7 offset-md-5 w-50 d-flex flex-column align-items-end">
                    <label for="token" class="form-label text-light font-weight-bold small">Token Kegiatan</label>

                    <div class="position-relative w-100">
                      <input type="text" id="token" name="token"
                             class="form-control ps-5 pe-4 py-2 rounded-pill border-0 shadow-sm text-light"
                             placeholder="Masukkan token kegiatan"
                             style="background-color: rgba(255, 255, 255, 0.07); backdrop-filter: blur(4px);">

                      <span class="position-absolute typing d-flex justify-content-center align-items-center">
                        <i class="fa-solid fa-keyboard"></i>
                      </span>
                    </div>
                  </div>      
              </div>
                  
            </div>
                  
            <!-- Modal Footer -->
            <div class="modal-footer border-0 px-5 pb-4 pt-0 justify-content-end" style="z-index:1;">
              <button id="btn-simpan" type="button" class="btn rounded-pill px-4 py-2 Simpan">
                <i class="fa-solid fa-check"></i>
              </button>
              <button type="button" class="btn rounded-pill px-4 py-2 btn-outline-light text-light" data-dismiss="modal">
                <i class="fa-solid fa-xmark"></i>
              </button>
            </div>
          </div>
        </div>
      </div>


    
    <!-- Main Content -->
      <main class="d-flex flex-column flex-grow-1 mt-5 main-content">

        <div id="card-wrapper" class="position-relative w-100">

          <!-- Card Content & Pagination -->
          <div id="card-container">
            @include('partials.cards', ['paginated' => $paginated])
          </div>

          <!-- Skeleton Loading Content -->
          <div id="card-skeleton" class="d-none p-5">
            <div class="row">
              @for ($i = 0; $i < 6; $i++)
                <div class="col-12 col-sm-6 col-md-4 mb-3">
                  <div class="card skeleton-card p-4 d-flex flex-column justify-content-between
                  Cards h-100 shadow border-0 card-content">
                    <div class="skeleton-title mb-1"></div>
                    <div class="skeleton-text mb-4"></div>
                    <div class="skeleton-badge mb-3"></div>
                    <div class="skeleton-footer d-flex justify-content-around align-items-center mt-2">
                      <div class="skeleton-date"></div>
                      <div class="d-flex">
                        <div class="skeleton-button mr-2"></div>
                        <div class="skeleton-button"></div>
                      </div>
                    </div>
                  </div>
                </div>
              @endfor
            </div>
          </div>

        </div>

      </main>

      

    <!-- Footer -->
      <footer class="text-light text-center">
        <div class="container">
          <div class="d-flex justify-content-center flex-wrap SosMed">
            <a href="https://www.facebook.com/bpsgorontalo/?locale=id_ID" target="_blank">
              <img src="{{ asset('images/gosite/facebook.png') }}" alt="Facebook" style="height: 25px;">
            </a>
            <a href="https://www.instagram.com/bps_gorontalo/" target="_blank">
              <img src="{{ asset('images/gosite/instagram.png') }}" alt="Instagram" style="height: 25px;">
            </a>
            <a href="https://www.youtube.com/@bpsprovgorontalo" target="_blank">
              <img src="{{ asset('images/gosite/youtube.png') }}" alt="YouTube" style="height: 25px;">
            </a>
          </div>
          <strong class="text-muted small">bps7500</strong>
        </div>
      </footer>

    
    <!-- Script -->
      <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script src="{{ asset('js/three.min.js') }}"></script>
      <script src="{{ asset('js/vanta.globe.min.js') }}"></script>

    
    <script type="text/javascript">
        $(document).ready(function(){
          const $body = $("#main-body");
          const $themeIcon = $("#theme-icon");
          let vantaEffect;

          const vantaConfigDark = {
            el: "#vanta-dots",
            mouseControls: true,
            touchControls: true,
            gyroControls: false,
            minHeight: 200.0,
            minWidth: 200.0,
            size: 0.7,
            scale: 1.5,
            scaleMobile: 1.5,
            points: 13.0,
            spacing: 15.0,
            color: 0xd12600,
            backgroundColor: 0xa051a,
          };
        
          const vantaConfigLight = {
            el: "#vanta-dots",
            mouseControls: true,
            touchControls: true,
            gyroControls: false,
            minHeight: 200.0,
            minWidth: 200.0,
            size: 0.7,
            scale: 1.1,
            scaleMobile: 1.1,
            points: 13.0,
            spacing: 15.0,
            color: 0xd12600,
            color2: 0x1c1a1a,
            backgroundColor: 0xd4d4d4,
          };
        
          function initVanta(theme) {
            if (vantaEffect) {
              vantaEffect.destroy();
            }
            vantaEffect = VANTA.GLOBE(
              theme === "dark" ? vantaConfigDark : vantaConfigLight
            );
          }
        
          const savedTheme = localStorage.getItem("theme") || "light";
          $body.removeClass("theme-dark theme-light").addClass("theme-" + savedTheme);
          $themeIcon.html(
            savedTheme === "dark"
              ? '<i class="fa-solid fa-moon fa-sm"></i>'
              : '<i class="fa-solid fa-sun fa-sm"></i>'
          );
          initVanta(savedTheme);
        
          $("#theme-toggle").on("click", function () {
            const isDark = $body.hasClass("theme-dark");
            const newTheme = isDark ? "light" : "dark";
          
            $body.toggleClass("theme-dark", !isDark);
            $body.toggleClass("theme-light", isDark);
            localStorage.setItem("theme", newTheme);
          
            $themeIcon.html(
              newTheme === "dark"
                ? '<i class="fa-solid fa-moon fa-sm"></i>'
                : '<i class="fa-solid fa-sun fa-sm"></i>'
            );
          
            initVanta(newTheme);
          });
         
          var token = '';

          function showSkeleton() {
            $('#card-container').hide();
            $('#card-skeleton').removeClass('d-none').show();
          }

          function hideSkeleton() {
            $('#card-skeleton').hide();
            $('#card-container').show();
          }


          $("#modal-btn").click(function(){
              $("#modal-setting").show()
          })
          $('.close').click(function(){
              $("#modal-setting").hide()
          })
          $('#btn-tutup').click(function(){
              $("#modal-setting").hide()
          })
          $('#btn-simpan').click(function() {
          let token = $('#token').val();
              $.get("{{ route('addNewToken') }}", { 'token': token }, function(data, status) {
                  if (data.trim().toLowerCase() === 'token yang anda masukkan salah') {
                      
                      Swal.fire({
                          title: 'Gagal',
                          text: data,
                          icon: 'error',
                          confirmButtonText: 'OK',
                          customClass: {
                              popup: 'custom-alert'
                          }
                      });
                  } else {
                      
                      Swal.fire({
                          title: 'Berhasil!',
                          text: data,
                          icon: 'success',
                          confirmButtonText: 'OK',
                          customClass: {
                              popup: 'custom-alert' 
                          }
                      });
                  }
              });
          });
          
          const toggleBtn = document.getElementById('filterDropdown');
          const dropdown = toggleBtn.closest('.dropdown');

          toggleBtn.addEventListener('click', function (e) {
            e.stopPropagation();
          
            if (dropdown.classList.contains('show')) {
              closeDropdown();
            } else {
              dropdown.classList.add('show');
            }
          });
        
          function closeDropdown() {
            dropdown.classList.add('animating-out');
          
            setTimeout(() => {
              dropdown.classList.remove('show');
            }, 300);
          }
        
          document.addEventListener('click', function (e) {
            if (!dropdown.contains(e.target) && dropdown.classList.contains('show')) {
              closeDropdown();
            }
          });

          function getActiveFilters() {
            let tahun = [];
            let bulan = [];
            let kategori = [];

            $(".filter-checkbox:checked").each(function () {
              const tipe = $(this).data("type");
              const val = $(this).val();
            
              if (tipe === "tahun") {
                tahun.push(val);
              } else if (tipe === "bulan") {
                bulan.push(val);
              } else if (tipe === "jenis") {
                kategori.push(val);
              }
            });
          
            return { tahun, bulan, kategori };
          }


          function fetchData(query = '', page = 1) {
            const filters = getActiveFilters();
            showSkeleton();

            $.ajax({
              url: "/search-cards",
              method: "GET",
              data: {
                search: query,
                page: page,
                tahun: filters.tahun,
                bulan: filters.bulan,
                kategori: filters.kategori
              },
              success: function (response) {
                $("#card-container").html(response.html);
                highlightKeyword($("#search").val());
                hideSkeleton();
              },
              error: function (xhr) {
                console.error("Gagal fetch data:", xhr.responseText);
                hideSkeleton();
              }
            });
          }




          function highlightKeyword(keyword) {
            if (!keyword) return;

            const elements = document.querySelectorAll(".card-title-content");
            const regex = new RegExp(`(${keyword})`, "gi");

            elements.forEach(el => {
              const original = el.getAttribute("data-original") || el.textContent;
              el.innerHTML = original.replace(regex, `<span class="highlighted">$1</span>`);
            });
          }

        
          let typingTimer;
          let lastQuery = "";

          $("#search").on("input", function () {
            clearTimeout(typingTimer);
            const query = $(this).val();
          
            typingTimer = setTimeout(function () {
              if (query !== lastQuery) {
                fetchData(query);
                lastQuery = query;
              }
            }, 650);
          });

        
          $(document).on("click", ".pagination a", function (e) {
            e.preventDefault();

            const urlParams = new URLSearchParams($(this).attr("href").split('?')[1]);
            const page = urlParams.get('page') || 1;
            const query = $("#search").val();

            fetchData(query, page);
          });

          
          const dropdownMenu = document.querySelector('.dropdown-menu');
          if (dropdownMenu) {
            dropdownMenu.addEventListener('click', function (e) {
              e.stopPropagation(); 
            });
          }
          
          $(".filter-checkbox").on("change", function () {
            const label = $(this).closest("label");
          
            if ($(this).is(":checked")) {
              label.removeClass("Kategori").addClass("Kategori-Fill");
            } else {
              label.removeClass("Kategori-Fill").addClass("Kategori");
            }
          
            fetchData($("#search").val());
          });  
          
        })
        function copyToClipboard(eventId) {
          const input = document.getElementById(`presensiLinkInput_${eventId}`);
          input.select();
          input.setSelectionRange(0, 99999);
          document.execCommand("copy");
          alert("Link berhasil disalin!");
        }
        
        </script>
  </body>
</html>