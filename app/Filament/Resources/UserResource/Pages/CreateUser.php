<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    protected static ?string $title = 'Tambah User';
    protected static ?string $breadcrumb = 'Tambah User';

    protected function afterCreate(): void
    {
        $this->record->assignRole($this->data['role']);
    }
}
