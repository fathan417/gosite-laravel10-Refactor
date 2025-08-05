<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MicrositeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GositeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\WilayahController;
use App\Models\Rapat;
use App\Models\Regency;
use App\Http\Controllers\DLS\KonsultasiController;
use App\Http\Controllers\DLS\BroadcastController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/logins', [LoginController::class, 'index'])->name('logins');

Route::get('/manualLogin', [LoginController::class, 'manualLogin']);
Route::get('/newRegist', [RegistrationController::class,'index'])->name('newRegist');
Route::post('/submitRegist', [RegistrationController::class,'submitRegist'])->name('submitRegist');
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/microsite', [MicrositeController::class, 'index']);
Route::get('/event', [EventController::class, 'index']);
Route::get('/event/{id}', [EventController::class, 'showEvent'])->name('event.show');

Route::get('/gosite', [GositeController::class, 'index']);
Route::get('/gosite/newToken',[GositeController::class, 'newToken'])->name('addNewToken');
Route::get('/search-cards', [GositeController::class, 'searchPublicEvents'])->name('search.cards');

Route::get('/presensi/{id}', [PresensiController::class, 'show'])->name('presensi.show');
Route::post('/presensi/{id}', [PresensiController::class, 'submit'])->name('presensi.submit');
Route::get('/api/provinsi', function () {
    return \App\Models\Province::orderBy('name')->get();
});
Route::get('/api/kabupaten/{province_id}', function ($province_id) {
    return \App\Models\Regency::where('province_id', $province_id)->orderBy('name')->get();
});

Route::get('/presensi/form/{token}', [PresensiController::class, 'showForm'])->name('presensi.form');

Route::post('/presensi', [PresensiController::class, 'store'])->name('presensi.store');


Route::get('/addEvent', [EventController::class, 'addEvent']);
Route::get('/sendEvent', [EventController::class, 'sendEvent']);


Route::get('auth/google',[App\Http\Controllers\GoogleController::class,'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback',[App\Http\Controllers\GoogleController::class,'handleGoogleCallback'])->name('google.callback');

Route::get('/departure',[App\Http\Controllers\DepartureController::class,'index']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Konsultasi
Route::get('/pst/konsultasi', [KonsultasiController::class, 'index'])->name('diseminasi.konsultasi.index');
Route::get('/pst/konsultasi/daftar', [KonsultasiController::class, 'register'])->name('diseminasi.konsultasi.register');
Route::post('/pst/konsultasi/daftar', [KonsultasiController::class, 'registerSave'])->name('diseminasi.konsultasi.register.save');
Route::get('/pst/konsultasi/respon', [KonsultasiController::class, 'registerResponse'])->name('diseminasi.konsultasi.register.response');
// Route alternatif 
// Route::get('/pst/konsultasi/respon', [KonsultasiController::class, 'registerResponse'])->name('diseminasi.konsultasi.register.respons');
// Route::get('/pst/konsultasi/respon', [KonsultasiController::class, 'registerResponse'])->name('diseminasi.konsultasi.register.new.response');

Route::get('/pst/konsultasi/vc/{token}', [KonsultasiController::class, 'joinMeeting'])->name('diseminasi.konsultasi.joinmeeting');

// Broadcast (WA)
Route::get('/pst/wa/{token}', [BroadcastController::class, 'confirmRegister'])->name('diseminasi.broadcast.confirm_register');

// Broadcast Registrasi
Route::get('/pst/broadcast/registers', [BroadcastController::class, 'register'])->name('diseminasi.broadcast.registers');
Route::post('/pst/broadcast/register', [BroadcastController::class, 'registerSave'])->name('diseminasi.broadcast.register.save');
Route::get('/pst/broadcast/respon', [BroadcastController::class, 'registerResponse'])->name('diseminasi.broadcast.register.response');

 
Route::get('/pst/broadcast/register', [BroadcastController::class, 'registers'])->name('diseminasi.broadcast.register');
// Route::post('/pst/broadcast/register', [BroadcastController::class, 'registerSave'])->name('diseminasi.broadcast.register.save');
// Route::get('/pst/broadcast/respon', [BroadcastController::class, 'registerResponse'])->name('diseminasi.broadcast.register.response');


Route::get('/pst/konsultasi/registerKSL', [KonsultasiController::class, 'registerKSL'])->name('diseminasi.konsultasi.registerKSL');
Route::post('/pst/konsultasi/registerKSL', [KonsultasiController::class, 'registerKSLSave'])->name('diseminasi.konsultasi.registerKSL.save');
Route::get('/pst/konsultasi/kslrespon', [KonsultasiController::class, 'registerKSLResponse'])->name('diseminasi.konsultasi.registerKSL.response');
Route::get('/pst/konsultasi/kslwarespon/{id}', [KonsultasiController::class, 'registerKSLWAResponse'])->name('diseminasi.konsultasi.registerKSL.kslwaresponse');
Route::get('/pst/konsultasi/kslgrupnotif/{id}', [KonsultasiController::class, 'KSLGroupNotif'])->name('diseminasi.konsultasi.registerKSL.kslgrupnotif');