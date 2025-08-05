@extends('diseminasi.frontend.layout')
@section('title', 'Konsultasi Statistik Online')
@section('content')
<section class="section-header pb-7 pb-lg-11 bg-soft">
  <div class="container">
      <div class="row justify-content-between align-items-center">
          <div class="col-12 col-md-6 order-2 order-lg-1">
          <img src="{{asset('img/new-ksl.png')}}" alt="">
          </div>
          <div class="col-12 col-md-5 order-1 order-lg-2">
                <h1 class="display-2 mb-3">Konsultasi Statistik Langsung</h1>
                <p class="lead">BPS Provinsi Gorontalo menyediakan layanan konsultasi statistik secara <i>offline</i> bertempat di Kantor BPS Provinsi Gorontalo.</p> 
                <p class="lead">Silakan daftar melalui form berikut ini.</p>
                <div class="mt-4">
                  <form action="{{asset(route('diseminasi.konsultasi.registerKSL.save',[],false))}}" class="d-flex flex-column mb-5 mb-lg-0" method="POST">
                      @csrf
                        <div class="form-group">
                          <label for="nama">Sapaan:<sup>*</sup></label>
                          <select name="sapaan" id="sapaan" class="form-control" required>
                            <option></option>
                            <option {{old('sapaan')=='Bapak'?'selected':''}} value="Bapak">Bapak</option>
                            <option {{old('sapaan')=='Ibu'?'selected':''}} value="Ibu">Ibu</option>
                            <option {{old('sapaan')=='Sdr.'?'selected':''}} value="Sdr.">Sdr.</option>
                            <option {{old('sapaan')=='Sdri.'?'selected':''}} value="Sdri.">Sdri.</option>
                          </select>
                          @error('sapaan') <small class="text-danger"> {!! $message!!}</small> @enderror
                        </div>  
                      <div class="form-group">
                        <label for="nama">Nama Lengkap:<sup>*</sup></label>
                        <input id="nama" for="nama" value="{{old('nama')}}" class="form-control" type="text" name="nama" placeholder="Nama Lengkap" required>
                        @error('nama') <small class="text-danger"> {!! $message!!}</small> @enderror
                      </div> 
                      <div class="form-group">
                      <label for="email">E-mail:<sup>*</sup></label>
                      <input id="email" class="form-control" value="{{old('email')}}" type="email" name="email" placeholder="Alamat Email" required>
                      @error('email') <small class="text-danger"> {!! $message!!}</small> @enderror
                      </div>
                      <div class="form-group">
                      <label for="nohp">Nomor HP:<sup>*</sup></label>
                      <input id="nohp" class="form-control" value="{{old('nohp')}}" type="text" name="nohp" placeholder="Nomor HP" required>
                      <small class="form-text text-muted">Masukkan nomor HP Anda seperti contoh berikut: 082185386589</small>
                      
                      @error('nohp') <small class="text-danger"> {!! $message!!}</small> @enderror
                      </div>
                      <div class="form-group">
                      <label for="tgl_konsultasi">Waktu Konsultasi:<sup>*</sup></label>
                      
                          <div class="input-group">
                          <input id="tgl_konsultasi"  value="{{fdate(old('tgl_konsultasi'))}}" class="form-control datepicker" type="text" name="tgl_konsultasi" placeholder="Tanggal Konsultasi" required>
                          <div class="input-group-prepend">
                              <span class="input-group-text" id="inputGroup-sizing-default">Pukul</span>
                            </div>
                            <select name="waktu_konsultasi" id="waktu_konsultasi" class="form-control" aria-describedby="inputGroup-sizing-default" >
                              <option {{old('waktu_konsultasi')=='09:00'?'selected':''}} value="09:00">09:00</option>
                              <option {{old('waktu_konsultasi')=='10:00'?'selected':''}} value="10:00">10:00</option>
                              <option {{old('waktu_konsultasi')=='11:00'?'selected':''}} value="11:00">11:00</option>
                              <option {{old('waktu_konsultasi')=='13:00'?'selected':''}} value="13:00">13:00</option>
                              <option {{old('waktu_konsultasi')=='14:00'?'selected':''}} value="14:00">14:00</option>
                              <option {{old('waktu_konsultasi')=='15:00'?'selected':''}} value="15:00">15:00</option>
                            </select>
                            <div class="input-group-append">
                              <span class="input-group-text" id="inputGroup-sizing-default">Wita</span>
                            </div>
                            @error('waktu_konsultasi') <small class="text-danger"> {!! $message!!}</small> @enderror
                          @error('tgl_konsultasi') <small class="text-danger"> {!! $message!!}</small> @enderror
                          
                      </div>
                      <small class="form-text text-muted">Tentukan waktu kapan Anda ingin berkonsultasi. Konsultasi hanya akan dilayani pada <a href="#pst">hari dan jam kerja</a>.</small>
                      </div>
                      <div class="form-group">
                      <label for="uraian">Uraian Konsultasi:<sup>*</sup></label>
                      <textarea id="uraian" required row=2 class="form-control" name="uraian" placeholder="Tuliskan secara singkat apa yang ingin Anda konsultasikan">{{old('uraian')}}</textarea>
                      @error('uraian') <small class="text-danger"> {!! $message!!}</small> @enderror
                      </div>
                      <div class="form-group row">
                      <div class="col">
                        {!! captcha_img('flat') !!}
                      </div>
                      <div class="col">
                        <input type="text" class="form-control" name="captcha" placeholder="Masukkan Captcha" required>
                        @error('captcha') <small class="text-danger"> {!! $message!!}</small> @enderror
                      </div>
                      </div>
                      
                      <button class="btn btn-primary" type="submit">Daftar </button>
                  </form>
                </div>
            </div>
      </div>
  </div>
</section>

@endsection

@push('css')
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
@endpush

@push('js')
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<script type="text/javascript">
$(function () {
  var now = moment()
  if(now.hour()>15){
    now = now.add(1, 'days');
  }
  $('.datepicker').daterangepicker({
      timePicker: false,
      singleDatePicker:true,
      minDate: now,
      maxDate: moment().add(30, 'days'),
      locale: {
        format: 'DD-MM-YYYY'
      }
    });
});
</script>
@endpush