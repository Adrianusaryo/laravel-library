<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function UlasanBuku(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'comment' => 'required|string',
        ]);

        Ulasan::create([
            'user_id' => $user->id,
            'buku_id' => $request->buku_id,
            'comment' => $request->comment,
        ]);

        return response(['status' => '200', 'message' => 'Ulasan berhasil ditambahkan']);
    }

    public function LihatUlasanBuku($buku_id)
    {
        $ulasans = Ulasan::where('buku_id', $buku_id)
            ->with('user:id,name')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status'   => 200,
            'buku_id'  => $buku_id,
            'ulasans'  => $ulasans
        ]);
    }

    public function UlasanCerpen(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'comment' => 'required|string',
        ]);

        Ulasan::create([
            'user_id' => $user->id,
            'cerpen_id' => $request->cerpen_id,
            'comment' => $request->comment,
        ]);

        return response(['status' => '200', 'message' => 'Ulasan berhasil ditambahkan']);
    }

    public function LihatUlasanCerpen($cerpen_id)
    {
        $ulasans = Ulasan::where('cerpen_id', $cerpen_id)
            ->with('user:id,name')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status'   => 200,
            'cerpen_id'  => $cerpen_id,
            'ulasans'  => $ulasans
        ]);
    }
}
