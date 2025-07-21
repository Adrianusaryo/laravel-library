<?php

namespace App\Http\Controllers;

use App\Models\Acara;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function HomeAcara()
    {
        $acara = Acara::with('usia')->inRandomOrder()->limit(5)->get();
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

        return response(['data' => $data, 'status' => 200, 'message' => 'data berhasil ditampilkan']);
    }

    public function LihatAcara(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $usia = $request->input('usia'); // contoh: remaja

        $query = Acara::with('usia');

        if ($usia) {
            $query->whereHas('usia', function ($q) use ($usia) {
                $q->where('nama', $usia);
            });
        }

        $acara = $query->paginate($perPage);

        $data = $acara->getCollection()->map(function ($acara) {
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

        return response([
            'data' => $data,
            'current_page' => $acara->currentPage(),
            'last_page' => $acara->lastPage(),
            'per_page' => $acara->perPage(),
            'total' => $acara->total(),
            'status' => '200',
            'message' => 'Data Acara Berhasil Ditampilkan'
        ]);
    }
}
