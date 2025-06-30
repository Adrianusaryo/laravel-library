<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\UsulBuku;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function LihatKoleksiBuku(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Default 10 item per halaman
        $bukuPaginated = Buku::with('kategori.usia')->paginate($perPage);

        $data = $bukuPaginated->getCollection()->map(function ($buku) {
            return [
                'id' => $buku->id,
                'judul' => $buku->judul,
                'penerbit' => $buku->penerbit,
                'penulis' => $buku->penulis,
                'edisi' => $buku->edisi,
                'isbn' => $buku->isbn,
                'bahasa' => $buku->bahasa,
                'deskripsi_fisik' => $buku->deskripsi_fisik,
                'deskripsi' => $buku->deskripsi,
                'cover_buku' => $buku->cover_buku,
                'status' => $buku->status,
                'kategori' => $buku->kategori->map(function ($kategori) {
                    return [
                        'id' => $kategori->id,
                        'kategori' => $kategori->kategori,
                        'usia' => $kategori->usia->map(function ($usia) {
                            return [
                                'id' => $usia->id,
                                'nama' => $usia->nama,
                            ];
                        }),
                    ];
                })
            ];
        });

        return response([
            'data' => $data,
            'current_page' => $bukuPaginated->currentPage(),
            'last_page' => $bukuPaginated->lastPage(),
            'per_page' => $bukuPaginated->perPage(),
            'total' => $bukuPaginated->total(),
            'status' => '200',
            'message' => 'Data Buku Berhasil Ditampilkan'
        ]);
    }

    public function DaftarKategori()
    {
        $kategori = Kategori::with('usia')->get();

        $data = $kategori->map(function ($kategori) {
            return [
                'id' => $kategori->id,
                'kategori' => $kategori->kategori,
                'usia' => $kategori->usia->map(function ($usia) {
                    return [
                        'id' => $usia->id,
                        'nama' => $usia->nama
                    ];
                })
            ];
        });


        return response(['data' => $data, 'status' => '200', 'message' => 'Kategori Buku Berhasil Ditampilkan']);
    }

    public function UsulBuku(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'judul' => 'required',
            'penerbit' => 'required',
            'pengarang' => 'required',
        ]);

        $usulBuku = UsulBuku::create([
            'judul' => $validated['judul'],
            'penerbit' => $validated['penerbit'],
            'pengarang' => $validated['pengarang'],
            'status' => 'Proses',
            'user_id'   => $user->id
        ]);

        return response(['status' => '200', 'message' => 'Buku Berhasil Diusulkan']);
    }

    public function LihatUsulBuku()
    {
        $user = auth()->user();

        $data = UsulBuku::where('user_id', $user->id)->get();

        return response(['data' => $data, 'status' => '200', 'message' => 'Buku Berhasil Diusulkan']);
    }
}
