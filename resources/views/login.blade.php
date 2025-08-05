<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

 @include('partials.backend-head')
    <body class="d-flex w-100 h-100" style="min-height: 100vh;">
      <div class="left-panel d-flex flex-column justify-content-between p-4 m-3" style="background: url('{{ asset('images/mountain-bg-2.svg') }}') right center/cover no-repeat;">
        <div class="d-flex justify-content-between align-items-center">
          <img src="{{ asset('images/logo-prov-gto.png') }}" alt="" class="bps p-2 rounded-pill" style="width: 150px; background-color: #FCFAEE;">
          <div>
            <a href="{{ route('google.login') }}" class="btn btn-sm btn-danger rounded-pill mr-2 login-btn">Login Google</a>
            <a href="#" class="btn btn-sm btn-outline-dark rounded-pill login-btn">Login SSO</a>
          </div>
        </div>
      </div>

      <div class="right-panel d-flex flex-column justify-content-center align-items-center p-5 position-relative">
        <div class="d-flex flex-row align-items-center position-absolute logo-header" style="top: 50px; left: 10px;">
          <img src="{{ asset('images/shape.png') }}" alt="" class="logo mr-3 p-2" style="width: 30px; background-color: #252a33ff; border-radius: 50%;">
          <h6 class="text-dark font-weight-bold title">GoSite Master</h6>
        </div>
        
        <div class="position-relative text-center mb-4 mt-5 border-0 d-flex flex-column justify-content-center align-items-center bg-transparent Header">
            <h1 class="font-weight-bold mb-3">Login</h1>
            <p>Selamat Datang di <span class="font-weight-bold">Gosite Master</span></p>
        </div>

        <form action="./manualLogin" class="d-flex flex-column justify-content-center align-items-center w-100">
          <input class="text-dark" type="email" id="email" name="email" placeholder="Email">
          <input class="text-dark" type="password" id="password" name="password" placeholder="Password">
          <button type="submit" class="submit-btn d-flex align-items-center text-center justify-content-center submit-login-btn">Login</button>
        </form>

        @if(session('error'))
          <div class="alert alert-danger">
            {{ session('error') }}
          </div>
        @endif
        
        <a href="{{ route('newRegist') }}" class="submit-btn d-flex align-items-center text-center justify-content-center">Daftar Baru</a>
        
      </div>
    </body>
</html>
 