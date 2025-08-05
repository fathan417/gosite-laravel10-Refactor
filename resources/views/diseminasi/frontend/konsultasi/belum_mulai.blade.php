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
              <h3>Maaf, Konsultasi Statistik Belum Dapat Dimulai</h3>
              <p class="lead">
              Konsultasi statistik akan dibuka sesuai jadwal permintaan Anda pada tanggal <b>{{fdate($konsultasi->tgl_konsultasi)}} pukul  {{$konsultasi->waktu_konsultasi}} Wita</b>
              </p>
              <p class="lead">Silakan klik tombol di bawah ini setelah memasuki waktu tersebut.</p>
              <a class="btn btn-primary" href="{{asset(route('diseminasi.konsultasi.joinmeeting', $konsultasi->token))}}">Mulai Konsultasi</a></p>
              
            </div>
      </div>
  </div>
</section>

@endsection