<?php

namespace App\Filament\Resources\BorrowedPeminjamanResource\Pages;

use App\Filament\Resources\BorrowedPeminjamanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBorrowedPeminjaman extends EditRecord
{
    protected static string $resource = BorrowedPeminjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
