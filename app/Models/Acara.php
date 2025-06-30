<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Acara extends Model
{
    protected $fillable = ['narasumber', 'nama_acara', 'tanggal', 'jam_mulai', 'jam_selesai', 'lokasi', 'alamat', 'deskripsi', 'poster', 'kategori'];

    public function usia(): BelongsToMany
    {
        return $this->belongsToMany(Usia::class);
    }
}
