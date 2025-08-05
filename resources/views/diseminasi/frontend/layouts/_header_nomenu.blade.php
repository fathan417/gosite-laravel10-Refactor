<header class="header-global">
    <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg headroom py-lg-3 px-lg-6 navbar-light navbar-theme-primary">
        <div class="container">
            <a class="navbar-brand @@logo_classes" href="{{asset(route('diseminasi.konsultasi.index', [], false))}}">
                <img class="navbar-brand-dark common" src="{{asset('img/bps7500-white.png')}}" style="height:64px" alt="Logo BPS">
                <img class="navbar-brand-light common" src="{{asset('img/bps7500.png')}}" style="height:64px" alt="Logo BPS">
            </a>
            <div class="navbar-collapse collapse" id="navbar_global">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="{{asset(route('diseminasi.konsultasi.index', [], false))}}">
                            <img class="navbar-brand-dark common" src="{{asset('img/bps7500-white.png')}}" style="height:64px" alt="Logo BPS">
                            </a>
                        </div>
                        <div class="col-6 collapse-close">
                            <a href="#navbar_global" role="button" class="fas fa-times" data-toggle="collapse"
                                data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false"
                                aria-label="Toggle navigation"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex d-lg-none align-items-center">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global"
                    aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation"><span
                        class="navbar-toggler-icon"></span></button>
            </div>
        </div>
    </nav>
</header>