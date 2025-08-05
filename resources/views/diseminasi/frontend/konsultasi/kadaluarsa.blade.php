@extends('diseminasi.frontend.layout')
@section('title', 'Konsultasi Statistik Online')
@section('content')
<section class="section-header pb-7 pb-lg-11 bg-soft">
  <div class="container">
      <div class="row justify-content-between align-items-center">
          <div class="col-12 col-md-6 order-2 order-lg-1">
          <img src="{{asset('impact/assets/img/illustrations/hero-illustration.svg')}}" alt="">
          </div>
          <div class="col-12 col-md-5 order-1 order-lg-2">
              <h3>Maaf, Tautan <i>Video Conference</i> Anda Kadaluarsa</h3>
              <p class="lead">
              Anda menjadwalkan konsultasi pada tanggal <b>{{fdate($konsultasi->tgl_konsultasi)}} pukul  {{$konsultasi->waktu_konsultasi}} Wita</b> dan telah melewati waktu lebih dari satu jam dari jadwal yang telah ditetapkan.
              </p>
              <p class="lead">
              Silakan klik tombol di bawah ini untuk mendaftar ulang.
              </p>
              <a class="btn btn-primary" href="{{asset(route('diseminasi.konsultasi.register'))}}">Daftar Konsultasi</a>.
            </div>
      </div>
  </div>
</section>

@endsection