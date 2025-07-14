<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CerpenController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Leaderboard;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UlasanController;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('Auth')->group(function () {
    Route::post('/Register', [AuthController::class, 'register']);
    Route::post('/Login', [AuthController::class, 'login']);
    Route::get('/Profile', [AuthController::class, 'profile'])->middleware(['auth:sanctum']);
    Route::put('/ProfileUpdate', [AuthController::class, 'profileUpdate'])->middleware(['auth:sanctum']);
    Route::get('/Logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
});

Route::middleware('auth:sanctum')->prefix('Buku')->group(function () {
    Route::get('/KoleksiBukuHome', [BookController::class, 'HomeKoleksiBuku']);
    Route::get('/KoleksiBuku', [BookController::class, 'LihatKoleksiBuku']);
    Route::get('/DaftarKategori', [BookController::class, 'DaftarKategori']);
    Route::post('/UsulBuku', [BookController::class, 'UsulBuku']);
    Route::get('/LihatUsulBuku', [BookController::class, 'LihatUsulBuku']);
    Route::post('/UlasanBuku', [UlasanController::class, 'UlasanBuku']);
    Route::get('/LihatUlasanBuku/{buku_id}', [UlasanController::class, 'LihatUlasanBuku']);
});

Route::middleware('auth:sanctum')->prefix('Leaderboard')->group(function () {
    Route::get('/LihatLeaderboardDewasa', [Leaderboard::class, 'showLeaderboardDewasa']);
});

Route::middleware('auth:sanctum')->prefix('Acara')->group(function () {
    Route::get('/ListAcaraHome', [EventController::class, 'HomeAcara']);
    Route::get('/ListAcara', [EventController::class, 'LihatAcara']);
});

Route::middleware('auth:sanctum')->prefix('Cerpen')->group(function () {
    Route::get('/LihatCerpen', [CerpenController::class, 'LihatCerpen']);
    Route::get('/LihatRiwayatPengiriman', [CerpenController::class, 'LihatKirimanCerpen']);
    Route::post('/KirimCerpen', [CerpenController::class, 'KirimCerpen']);
    Route::post('/UlasanCerpen', [UlasanController::class, 'UlasanCerpen']);
    Route::get('/LihatUlasanCerpen/{cerpen_id}', [UlasanController::class, 'LihatUlasanCerpen']);
});

Route::middleware('auth:sanctum')->prefix('/Peminjaman')->group(function () {
    Route::post('/PinjamBuku', [PeminjamanController::class, 'PinjamBuku']);
    Route::get('/LihatPeminjamanBuku', [PeminjamanController::class, 'lihatPeminjaman']);
});

Route::middleware('auth:sanctum')->get('/User', function (Request $request) {
    return $request->user();
});
