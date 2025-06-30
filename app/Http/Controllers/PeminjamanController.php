<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function PinjamBuku(Request $request)
    {
        $user = auth()->user();
        $kodeUnik = 'PMJ-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));

        $peminjaman = Peminjaman::create([
            'user_id' => $user->id,
            'status' => 'Menunggu Konfirmasi',
            'tanggal_pinjam' => now(),
            'kode_peminjaman' => $kodeUnik
        ]);

        foreach ($request->buku_id as $id_buku) {
            $peminjaman->buku()->attach($id_buku);
        }

        return response()->json([
            'message' => 'Peminjaman Berhasil Dilakukan',
            'data' => $peminjaman->load('buku')
        ], 200);
    }

    public function lihatPeminjaman()
    {
        $user = auth()->user();

        $peminjaman = Peminjaman::with('buku')->where('user_id', $user->id)->get();

        return response()->json([
            'data' => $peminjaman,
            'status' => '200',
            'message' => 'Berhasil tampilkan daftar buku yang dipinjam'
        ]);
    }
}
