<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

 @include('partials.dash-head')
 
    <body class="container">
        @include('partials.sidebar')
        <div class="main-content">
            <header class="dash-header">
                @include('partials.buttons')
                <h1>{{ $sidebar }}</h1>
            </header>
            <div class="wrapper">
                
                <div class="dash-main">
                    <div class="my-items">
                        <h1>My Events</h1>
                        <button class="btn-add">
                            <a href="./addEvent">
                                <i class="fa-solid fa-plus" style="color: #ffffff;"></i>
                                Tambah Event
                            </a>
                        </button>
                    </div>
                    
                    @foreach ($rapat as $e)
                    <div class="content-list">
                        <div class="icon">
                            AB
                        </div>
                        <div class="list-title">
                            <a href=""><h1>{{$e->judul}}</h1></a>
                            <p>{{$e->tempat}}, {{$e->waktu_mulai}} - {{$e->waktu_selesai}}</p>
                        </div>
                        <div class="list-details" style="">
                            <button class="btn-mini">
                                <i class="fa-solid fa-pen-to-square fa-sm" style="color: #545454;"></i>Edit
                            </button>
                            <button class="btn-mini">
                                <i class="fa-solid fa-trash-can fa-sm" style="color: #545454;"></i>Delete
                            </button>
                            <div class="date-mini">
                                <i class="fa-solid fa-clock fa-sm" style="color: #b3b3b3;"></i>
                                <a>2 Bulan lalu</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                </div>
                <!-- <aside class="aside aside1">
                    <h1>Aside1</h1>
                </aside> -->
                <aside class="aside aside2">
                    <!-- <h1>Aside2</h1> -->
                </aside>
                <footer class="footer">
                    <h1>Footer</h1>
                </footer>
            </div>
        </div>
        
    </body>
</html>