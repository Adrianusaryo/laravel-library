<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Peminjaman extends Model
{

    protected $fillable = ['user_id', 'tanggal_pinjam', 'tanggal_kembali', 'status', 'kode_peminjaman'];

    public function buku(): BelongsToMany
    {
        return $this->belongsToMany(Buku::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
