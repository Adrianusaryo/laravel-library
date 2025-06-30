<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cerpen extends Model
{
    protected $fillable = ['judul', 'penulis', 'isi', 'status', 'user_id', 'poster'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
