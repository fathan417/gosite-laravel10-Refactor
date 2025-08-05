<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

 @include('partials.backend-head')
    <body>
        <div class="flex items-center">
            <!-- <h1>Registrasi Baru</h1> -->
            <div class="main-regform">
            
                    @csrf
                    <div class="regform">
                        <label for="fullname">Nama</label>
                        <p>:</p>
                        <input type="text" id="fullname" name="fullname">
                    </div>
                    <div class="regform">
                        <label for="jk">Jenis Kelamin</label>
                        <p>:</p>
                        <select id="jk" name="jk" class="textfill">
                            <option id="1">Laki-Laki</option>
                            <option id="2">Perempuan</option>
                        </select>
                    </div>
                    <div class="regform">
                        <label for="nip">NIP</label>
                        <p>:</p>
                        <input type="text" id="nip" name="nip">
                    </div>
                    <div class="regform">
                        <label for="instansi">Instansi</label>
                        <p>:</p>
                        <select id="instansi" name="instansi" class="textfill">
                            @foreach ($instansi as $instansi)
                            <option id="{{ $instansi->id }}">{{ $instansi->nama }}</option>
                            @endforeach         
                        </select>
                    </div>
                    <div class="regform">
                        <label for="email">Email</label>
                        <p>:</p>
                        <input type="email" id="email" name="email">
                    </div>
                    <div class="regform">
                        <label for="telepon">No HP</label>
                        <p>:</p>
                        <input type="text" id="telepon" name="telepon">
                    </div>
                    <div class="regform">
                        <label for="pekerjaan">Pekerjaan</label>
                        <p>:</p>
                        <input type="text" id="pekerjaan" name="pekerjaan">
                    </div>
                    <div class="regform">
                        <label for="alamat">Alamat</label>
                        <p>:</p>
                        <input type="text" id="alamat" name="alamat">
                    </div>
                    <div style="text-align: center;">
                        <!-- <input type="submit" class="submit-btn" value="Daftar"> -->
                         <button onclick="kirim()">Kirim</button>
                    </div>
          
            </div>
        </div>
        <div>
           
         </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function(){
                
            })
            var mydata = [];

            function kirim(){

                mydata['nama'] = $('#fullname').val();
                mydata['jk'] = $('#jk').children(":selected").attr("id");
                mydata['nip'] = $('#nip').val();
                mydata['instansi'] = $('#instansi').children(":selected").attr("id");
                mydata['email'] = $('#email').val();
                mydata['telp'] = $('#telepon').val();
                mydata['pekerjaan'] = $('#pekerjaan').val();
                mydata['alamat'] = $('#alamat').val();
                
                    // alert(mydata['nama']);
                    // console.log(mydata);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    let sapaan = '';
                    if($('#jk').val() == 'Laki-Laki'){
                        sapaan = 'Bapak'
                    } else {
                        sapaan = 'Ibu'
                    }

                    $.post("{{ route('submitRegist') }}",
                    {
                    'sapaan' : sapaan,
                    'nama' : $('#fullname').val(),
                    'jk' : $('#jk').val(),
                    'nip' : $('#nip').val(),
                    'instansi' : $('#instansi').val(),
                    'instansi_id' : $('#instansi').children(":selected").attr("id"),
                    'email' :  $('#email').val(),
                    'telepon' : $('#telepon').val(),
                    'pekerjaan' : $('#pekerjaan').val(),
                    'alamat' : $('#alamat').val()
                    }, 
                    function(data,status){
                        alert(data)
                    })
                }
            
                
        </script>
    
    </body>
    
</html>
 