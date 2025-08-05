<!--

=========================================================
* Impact Design System - v1.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/impact-design-system
* Copyright 2010 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/impact-design-system/blob/master/LICENSE.md)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

-->
<!DOCTYPE html>
<html lang="en">

<head> 
    <!-- Primary Meta Tags -->
<title>@yield('title') - BPS Provinsi Gorontalo</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="title" content="@yield('title') - BPS Provinsi Gorontalo">

<meta name="keywords" content="konsultasi online, konsultasi statistik, bps, statistik, data, gorontalo, bps gorontalo, bps provinsi gorontalo">
<meta name="description" content="BPS Provinsi Gorontalo menyediakan layanan konsultasi statistik secara online menggunakan aplikasi CloudX.">
<link rel="icon" href="{{asset('img/logo.png')}}" type="image/png">
<link type="text/css" href="{{asset('impact/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<link type="text/css" href="{{asset('impact/vendor/prismjs/themes/prism.css')}}" rel="stylesheet">
<link type="text/css" href="{{asset('impact/css/front.css')}}" rel="stylesheet">
@stack('css')
@stack('jshead')
<!-- Anti-flicker snippet (recommended)
<style>.async-hide { opacity: 0 !important} </style>
<script>(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;h.start=1*new Date;
h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')};
(a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c;
})(window,document.documentElement,'async-hide','dataLayer',4000,
{'GTM-K9BGS8K':true});</script>

<!-- Analytics-Optimize Snippet
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-46172202-22', 'auto', {allowLinker: true});
ga('set', 'anonymizeIp', true);
ga('require', 'GTM-K9BGS8K');
ga('require', 'displayfeatures');
ga('require', 'linker');
ga('linker:autoLink', ["2checkout.com","avangate.com"]);
</script>
<!-- end Analytics-Optimize Snippet -->

<!-- Google Tag Manager
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NKDMSK6');</script>
<!-- End Google Tag Manager -->
</head>

<body>
    <!-- Google Tag Manager (noscript)
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
<main>
@include('diseminasi.frontend.layouts._preloader')
@include('diseminasi.frontend.layouts._header')
@yield('content')        
@include('diseminasi.frontend.layouts._footer')
</main>

<!-- Core -->
<script src="{{asset('impact/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{asset('impact/vendor/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{asset('impact/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{asset('impact/vendor/headroom.js/dist/headroom.min.js') }}"></script>

<!-- Vendor JS -->
<script src="{{asset('impact/vendor/onscreen/dist/on-screen.umd.min.js') }}"></script>
<script src="{{asset('impact/vendor/waypoints/lib/jquery.waypoints.min.js') }}"></script>
<script src="{{asset('impact/vendor/jarallax/dist/jarallax.min.js') }}"></script>
<script src="{{asset('impact/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js') }}"></script>
<!-- Impact JS -->
<script src="{{asset('impact/assets/js/front.js') }}"></script>
@stack('js')
</body>
</html>