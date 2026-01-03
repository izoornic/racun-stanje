<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Stanje;
use App\Livewire\Profil;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/stanje', Stanje::class)->name('stanje');
Route::get('/profil', Profil::class)->name('profil');
