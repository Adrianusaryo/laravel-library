<?php

namespace App\Filament\Resources\PendingPeminjamanResource\Pages;

use App\Filament\Resources\PendingPeminjamanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendingPeminjamen extends ListRecords
{
    protected static string $resource = PendingPeminjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
