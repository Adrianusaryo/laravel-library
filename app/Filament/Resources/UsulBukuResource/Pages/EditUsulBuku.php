<?php

namespace App\Filament\Resources\UsulBukuResource\Pages;

use App\Filament\Resources\UsulBukuResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUsulBuku extends EditRecord
{
    protected static string $resource = UsulBukuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
