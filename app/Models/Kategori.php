<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $fillable = ['kategori'];

    public function usia(): BelongsToMany
    {
        return $this->belongsToMany(Usia::class);
    }

    public function buku(): BelongsToMany
    {
        return $this->belongsToMany(Buku::class);
    }
}
