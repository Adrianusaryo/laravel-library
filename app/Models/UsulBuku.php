<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsulBuku extends Model
{
    protected $fillable = ['user_id', 'judul', 'penerbit', 'pengarang', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
