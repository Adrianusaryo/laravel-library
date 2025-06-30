<?php

namespace App\Http\Controllers;

use App\Models\Acara;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function LihatAcara()
    {
        $acara = Acara::with('usia')->get();

        $data = $acara->map(function ($acara) {
            return [
                'id' => $acara->id,
                'narasumber' => $acara->narasumber,
                'nama_acara' => $acara->nama_acara,
                'tanggal' => $acara->tanggal,
                'jam_mulai' => $acara->jam_mulai,
                'jam_selesai' => $acara->jam_selesai,
                'lokasi' => $acara->lokasi,
                'alamat' => $acara->alamat,
                'deskripsi' => $acara->deskripsi,
                'kategori' => $acara->kategori,
                'poster' => $acara->poster,
                'usia' => $acara->usia->map(function ($usia) {
                    return [
                        'id' => $usia->id,
                        'nama' => $usia->nama
                    ];
                })
            ];
        });

        return response()->json($data);
    }
}
