<?php

namespace App\Http\Controllers;

use App\Models\Cerpen;
use Illuminate\Http\Request;

class CerpenController extends Controller
{

    public function LihatCerpen()
    {
        $cerpen = Cerpen::where('status', 'Approved')->get();

        return response(['data' => $cerpen, 'status' => '200', 'messages' => 'Koleksi Cerpen Berhasil Ditampilkan']);
    }

    public function KirimCerpen(Request $request)
    {
        $namaPoster = null;

        if ($request->hasFile('poster')) {
            $poster = $request->file('poster');

            $namaPoster = time() . '_' . $poster->getClientOriginalName();

            $poster->move(storage_path('app/public/Cerpen'), $namaPoster);
        }

        $cerpen = Cerpen::create([
            'judul' => $request->input('judul'),
            'penulis' => $request->input('penulis'),
            'isi' => $request->input('isi'),
            'poster' => $namaPoster,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'status' => 200,
            'messages' => 'Cerpen Berhasil Dikirim',
            'data' => $cerpen,
        ]);
    }

    public function LihatKirimanCerpen()
    {
        $user = auth()->user();

        $data = Cerpen::where('user_id', $user->id)->get();

        return response(['data' => $data, 'status' => '200', 'message' => 'Riwayat Pengiriman Berhasil Ditampilkan']);
    }
}
