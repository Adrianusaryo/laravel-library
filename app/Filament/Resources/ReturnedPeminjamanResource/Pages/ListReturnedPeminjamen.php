<?php

namespace App\Filament\Resources\ReturnedPeminjamanResource\Pages;

use App\Filament\Resources\ReturnedPeminjamanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReturnedPeminjamen extends ListRecords
{
    protected static string $resource = ReturnedPeminjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
