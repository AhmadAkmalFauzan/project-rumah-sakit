<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DokterController; 
use App\Http\Controllers\OtpController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\RuanganController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::resource('dokter', DokterController::class);
Route::resource('ruangan', RuanganController::class);

Route::get('/reset-password-otp', [OtpController::class, 'showResetForm'])->name('password.reset.otp.form');
Route::get('/forgot-password', [OtpController::class, 'showRequestForm'])->name('otp.form.request');
Route::post('/forgot-password', [OtpController::class, 'sendOtp'])->name('otp.send');
Route::get('/verify-otp', [OtpController::class, 'showVerifyForm'])->name('otp.form.verify');
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('otp.form.verify.submit');
Route::get('/reset-password-otp', [OtpController::class, 'showResetForm'])->name('password.reset.otp.form');
Route::post('/reset-password', [OtpController::class, 'resetPassword'])->name('otp.reset');

Route::get('/login',[LoginController::class,'login'])->name('login');
Route::post('actionlogin',[LoginController::class,'actionlogin'])->name('actionlogin');
Route::get('home',[DokterControllers::class,'index'])->name('dokter')->middleware('auth');
Route::get('actionlogout',[LoginController::class,'actionlogout'])->name('actionlogout')->middleware('auth');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register', [LoginController::class, 'actionregister'])->name('actionregister');

Route::post('/upload-foto', [LoginController::class, 'uploadFoto'])->name('upload.foto')->middleware('auth');

Route::get('/api/dokter-by-penyakit/{spesialisasi}', function($spesialisasi){
    return \App\Models\Dokter::where('spesialisasi',$spesialisasi)->get();
});

Route::resource('pasien', PasienController::class);
