<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usia extends Model
{
    protected $fillable = ['nama', 'usia_min', 'usia_max'];

    public function kategori(): BelongsToMany
    {
        return $this->belongsToMany(Kategori::class);
    }

    public function acara(): BelongsToMany
    {
        return $this->belongsToMany(Acara::class);
    }
}
