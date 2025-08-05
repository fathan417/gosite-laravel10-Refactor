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
                        <a href="./event" class="btn-back">
                            <span style="display:block;">
                                <i class="fa-solid fa-angles-left"></i>
                                Kembali ke Daftar Event
                            </span>
                        </a>
                    </div>
                    
                    <div class="content-place">
                        
                        <div class="list-title">
                            <h1>Tambah Event Baru</h1>
                            <p>Inputkan Detail Event Baru Anda</p>
                        </div>
                        <div class="input-place">
                            <form action="./sendEvent">
                                <div class="input-bar">
                                    <label for="namakeg">Nama Kegiatan</label>
                                    <span>:</span>
                                    <input type="text" id="namakeg" name="namakeg"><br>
                                </div>
                                <div class="input-bar">
                                    <label for="namaket">Nama Ketua Panitia</label>
                                    <span>:</span>
                                    <input list="namaket" name="namaket">
                                    <datalist id="namaket">
                                        @foreach ($pegawai as $p)
                                            <option value="{{$p->nama}}" id="{{$p->id}}" class="namaketua">
                                        @endforeach
                                    </datalist>
                                </div>
                               
                                <div class="input-bar">
                                    <label for="tgl_mulai">Tanggal Mulai</label>
                                    <span>:</span>
                                    <input type="date" id="tgl_mulai" name="tgl_mulai">
                                </div>
                                <div class="input-bar">
                                    <label for="tgl_selesai">Tanggal Selesai</label>
                                    <span>:</span>
                                    <input type="date" id="tgl_selesai" name="tgl_selesai">
                                </div>
                                <div class="input-bar">
                                    <label for="tempat">Tempat</label>
                                    <span>:</span>
                                    <input type="text" id="tempat" name="tempat"><br>
                                </div>
                                <div class="input-bar">
                                    <label for="kak">Unggah File KAK</label>
                                    <span>:</span>
                                    <input type="file" id="kak" name="kak">
                                </div>
                                
                                <input type="submit" value="Submit" class="btn-submit">
                            </form>
                        </div>
                        
                    </div>

                    
                    
                </div>
                <!-- <aside class="aside aside1">
                    <h1>Aside1</h1>
                </aside> -->
                <aside class="aside aside2">
                    <!-- <h1>Aside2</h1> -->
                </aside>
                <!-- <footer class="footer">
                    <h1>Footer</h1>
                </footer> -->
            </div>
        </div>
        
    </body>
    <script type="text/javascript">
       
    </script>
    @push('js')
        <script src="{{asset('js/addEvent.js')}}"></script>
    @endpush
</html>