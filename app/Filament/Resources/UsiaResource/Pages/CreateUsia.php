<?php

namespace App\Filament\Resources\UsiaResource\Pages;

use Filament\Actions;
use App\Filament\Resources\UsiaResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateUsia extends CreateRecord
{
    protected static string $resource = UsiaResource::class;
    protected static ?string $title = 'Tambah Usia';
    protected static ?string $breadcrumb = 'Tambah Usia';
}
