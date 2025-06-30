<?php

namespace App\Filament\Resources\BukuResource\Pages;

use App\Filament\Resources\BukuResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBuku extends CreateRecord
{
    protected static string $resource = BukuResource::class;
    protected static ?string $title = 'Tambah Buku';
    protected static ?string $breadcrumb = 'Tambah Buku';
}
