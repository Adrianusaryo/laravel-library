<?php

namespace App\Filament\Resources\UsulBukuResource\Pages;

use App\Filament\Resources\UsulBukuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsulBukus extends ListRecords
{
    protected static string $resource = UsulBukuResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }
}
