<?php

namespace App\Filament\Resources\BorrowedPeminjamanResource\Pages;

use App\Filament\Resources\BorrowedPeminjamanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBorrowedPeminjamen extends ListRecords
{
    protected static string $resource = BorrowedPeminjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
