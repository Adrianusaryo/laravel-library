<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Buku extends Model
{
    protected $fillable = ['judul', 'penulis', 'penerbit', 'edisi', 'deskripsi_fisik', 'isbn', 'cover_buku', 'sinopsis', 'status', 'bahasa', 'deskripsi'];

    public function kategori(): BelongsToMany
    {
        return $this->belongsToMany(Kategori::class);
    }

    public function peminjaman(): BelongsToMany
    {
        return $this->belongsToMany(Peminjaman::class);
    }
}
