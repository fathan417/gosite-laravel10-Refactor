@extends('diseminasi.frontend.layout')
@section('title', 'Konsultasi Statistik Online')
@section('content')
<section class="section-header bg-soft">
  <div class="container">
      <div class="row justify-content-between align-items-center">
          <div class="col-12 col-md-6 order-2 order-lg-1">
          <img src="{{asset('img/layanan-new.png')}}" alt="Konsultasi Statistik">
          </div>
          <div class="col-12 col-md-5 order-1 order-lg-2">
                <h1 class="display-2 mb-3">Layanan Konsultasi Statistik</h1>
                <p class="lead">BPS Provinsi Gorontalo menyediakan layanan konsultasi statistik secara tatap muka atau <i>online</i> sesuai dengan pilihan pengguna layanan. 
                Cukup melalui perangkat <i>smart phone</i>, Anda dapat berinteraksi langsung dengan petugas kami.</p>
                <a class="btn btn-primary" href="#layanan-all">Info Lebih Lanjut</a>
                <a class="btn btn-success" href="https://ppid.bps.go.id/app/konten/7500/Standar-Layanan-Informasi-Publik.html" target="_blank">Standar Pelayanan</a>
            </div>
      </div>
  </div>
  <div class="pattern bottom"></div>
</section>
<section id="layanan-all" class="section section-lg pt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
                <h2 class="h1 font-weight-bolder mb-4">Layanan Konsultasi Statistik</h2>
                <p class="lead">
                    Kami menyediakan empat kanal layanan konsultasi statistik yang dapat Anda pilih sesuai kebutuhan Anda.
                </p>
            </div>
            <div class="row">
                <a href="#layanan-vicon" class="col">
                    <div class="col konsul-card hvr-float-shadow" >
                        <div class = image>
                            <img src="{{asset('/img/konsultasi-vicon.png')}}" alt=""/>
                        </div>
                        <div class = content>
                            <h4>Video <br> Conference</h4>
                        </div>
                    </div>
                </a>
                <a href="#layanan-wa" class="col">
                    <div class="col konsul-card hvr-float-shadow">
                        <div class = image>
                            <img src="{{asset('/img/new-wa.png')}}" alt=""/> 
                        </div>
                        <div class = content>
                            <h4>Whatsapp <br> Chat</h4>
                        </div>
                    </div>
                </a>
                <a href="#layanan-email" class="col">
                    <div class="col konsul-card hvr-float-shadow">
                        <div class = image>
                            <img src="{{asset('/img/new-email.png')}}" alt=""/> 
                        </div>
                        <div class = content>
                            <h4>Kontak <br> Email</h4>
                        </div>
                    </div>
                </a>
                <a href="#layanan-konsul" class="col">
                    <div class="col konsul-card hvr-float-shadow">
                        <div class = image>
                            <img src="{{asset('/img/new-ksl.png')}}" alt=""/> 
                        </div>
                        <div class = content>
                            <h4>Konsultasi Langsung</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- <section id="pengantar">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
                <h2 class="h1 font-weight-bolder mb-4">Layanan Konsultasi Statistik</h2>
                <p class="lead">
                    Kami menyediakan empat kanal layanan konsultasi statistik yang dapat Anda pilih sesuai kebutuhan Anda.
                </p>
            </div>
        </div>
    </div>
</section> -->

<section id="layanan-vicon">
    <div class="container">
        <div class="row row-grid align-items-center">
            <!-- <div class="col-12 col-md-8 text-center">
                <h2 class="h1 font-weight-bolder mb-4">Akses Layanan Kami</h2>
                <p class="lead">
                    Kami menyediakan empat kanal layanan konsultasi statistik yang dapat Anda pilih sesuai kebutuhan Anda.
                </p>
            </div> -->
            <div class="col-12 col-md-5">
                <h2 class="font-weight-bolder mb-4">Video Conference</h2>
                <p class="lead">
                Ingin berkonsultasi langsung dengan kami tanpa harus datang ke kantor? </p>
                <p class="lead">Manfaatkan video confererence via ZOOM.</p>
                <a href="{{asset(route('diseminasi.konsultasi.register',[],false))}}" target="_blank" class="btn btn-primary mt-3 animate-up-2">Daftar Sekarang</a>
            </div>
            <div class="col-12 col-md-6 ml-md-auto">
                <img src="{{asset('img/konsultasi-vicon.png')}}" alt="">
            </div>
        </div>
    </div>
</section>

<section id="layanan-wa">
    <div class="container">
        <div class="row row-grid align-items-center">
            <div class="col-12 col-md-5 order-md-2">
                <h2 class="font-weight-bolder mb-4">Whatsapp Chat</h2>
                <p class="lead">
                Butuh data untuk melengkapi tugas/pekerjaan/lainnya? </p>
                <p class="lead">
                Lebih cepat dan mudah, hubungi petugas kami via whatsapp.</p>
                <a target="_blank" href="https://api.whatsapp.com/send?phone=628114310075&text=Halo BPS,%20saya%20mau%20konsultasi%20statistik.&source=&data=&app_absent=" class="btn btn-primary mt-3 animate-up-2">WA Sekarang <span class="icon icon-xs ml-2"><i class="fas fa-external-link-alt"></i></span></a>
            </div>
            <div class="col-12 col-md-6 mr-lg-auto">
                <img src="{{asset('img/new-wa.png')}}" alt="">
            </div>
        </div>
    </div>
</section>

<section id="layanan-email">
    <div class="container">
        <div class="row row-grid align-items-center">
            <div class="col-12 col-md-5">
                <h2 class="font-weight-bolder mb-4">Email</h2>
                <p class="lead">
                Bingung, data/informasi yang ingin Anda cari tidak ditemukan di website?</p>
                <p class="lead">Langsung saja tanya ke petugas kami via email.</p>
                <button id="emailbutton" onclick="copyemail()" value="pst7500@bps.go.id" class="btn btn-primary mt-3 animate-up-2">Simpan Email Kami <span class="icon icon-xs ml-2"><i class="fas fa-external-link-alt"></i></span></button>
            </div>
            <div class="col-12 col-md-6 ml-md-auto">
                <img src="{{asset('img/new-email.png')}}" alt="">
            </div>
        </div>
    </div>
</section>

<section id="layanan-konsul">
    <div class="container">
        <div class="row row-grid align-items-center">
            <div class="col-12 col-md-5 order-md-2">
                <h2 class="font-weight-bolder mb-4">Konsultasi Langsung</h2>
                <p class="lead">
                Ingin berkonsultasi langsung dengan kami secara langsung?</p>
                <p class="lead">
                Buat janji dengan kami di sini.</p>
                <a target="_blank" href="{{asset(route('diseminasi.konsultasi.registerKSL',[],false))}}" class="btn btn-primary mt-3 animate-up-2">Buat Janji Sekarang <span class="icon icon-xs ml-2"><i class="fas fa-external-link-alt"></i></span></a>
            </div>
            <div class="col-12 col-md-6 mr-lg-auto">
                <img src="{{asset('img/new-ksl.png')}}" alt="">
            </div>
        </div>
    </div>
</section>


<section class="section section-lg pb-5 bg-soft">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="mb-4">Maklumat Pelayanan</h2>
                <p class="lead mb-5">
                "Dengan ini kami menyatakan sanggup menyelenggarakan pelayanan sesuai standar pelayanan yang telah ditetapkan dan melakukan perbaikan secara terus menerus. Apabila kami tidak menepati, kami siap menerima sanksi dan/atau memberi kompensasi sesuai peraturan yang berlaku."
                </p>
            </div>
            <div class="col-12 text-center">
                <img src="{{asset('/img/Melayani-dengan-PIA2.png')}}" alt="Melayani dengan Profesional, Integritas, dan Amanah"/>
            </div>
        </div>
    </div>
</section>
@endsection

<script type="text/javascript">

    function copyemail() {

        // Get the text field
        var copyText = document.getElementById("emailbutton");

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);

        // Alert the copied text
        alert("Email telah dicopy: " + copyText.value);
        }

</script>