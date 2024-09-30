<?php

use App\Livewire\Auth\Login;
use App\Livewire\SearchDesa;
use App\Livewire\SearchKota;
use App\Livewire\SearchProvinsi;
use App\Livewire\SearchKecamatan;
use App\Http\Middleware\AuthCheck;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::middleware(['auth'])->group(function(){

// });

Route::get('/login', Login::class)->name('login')->middleware('guest');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout')->middleware('auth');

Route::middleware(['auth', AuthCheck::class])->group(function () {
    Route::get('/', SearchProvinsi::class)->name('provinsi');
    Route::get('/kota/{kode}', SearchKota::class)->name('kota');
    Route::get('/kecamatan/{kode}', SearchKecamatan::class)->name('kecamatan');
    Route::get('/desa/{kode}', SearchDesa::class)->name('desa');
});