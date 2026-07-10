<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/profile', fn () => '<h1>Halaman Profil — coming soon</h1>')->name('profile');
Route::get('/visi-misi', fn () => '<h1>Halaman Visi & Misi — coming soon</h1>')->name('vision-mission');
Route::get('/guru-staf', fn () => '<h1>Halaman Guru & Staf — coming soon</h1>')->name('teachers');
Route::get('/berita', [BeritaController::class, 'index'])->name('news');
Route::get('/berita/{post:slug}', [BeritaController::class, 'show'])->name('berita.show');
Route::get('/galeri', [GaleriController::class, 'index'])->name('gallery.index');
Route::get('/galeri/{post:slug}', [GaleriController::class, 'show'])->name('gallery.show');
Route::get('/agenda', fn () => '<h1>Halaman Agenda — coming soon</h1>')->name('agenda');
Route::get('/unduh', fn () => '<h1>Halaman Unduhan — coming soon</h1>')->name('downloads');
Route::get('/faq', fn () => '<h1>Halaman FAQ — coming soon</h1>')->name('faq');
Route::get('/kontak', fn () => '<h1>Halaman Kontak — coming soon</h1>')->name('contact');
