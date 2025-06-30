<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\UsulBuku;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UsulBukuResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UsulBukuResource\RelationManagers;

class UsulBukuResource extends Resource
{
    protected static ?string $model = UsulBuku::class;

    protected static ?string $navigationGroup = 'Buku & Cerpen';
    protected static ?string $navigationLabel = 'Usul Buku';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 4;

    public static function getModelLabel(): string
    {
        return 'Usul Buku';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Usul Buku';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Nama'),
                TextColumn::make('judul')->label('Judul'),
                TextColumn::make('penerbit')->label('Penerbit'),
                TextColumn::make('pengarang')->label('Pengarang'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Ditolak' => 'danger',
                        'Diterima' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn($state) => ucwords($state)),

            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('Diterima')->label('Diterima')->color('success')->visible(fn($record) => $record->status === 'Proses')->action(function ($record) {
                    $record->update(['status' => 'Diterima']);
                }),
                Action::make('Ditolak')->label('Ditolak')->color('danger')->visible(fn($record) => $record->status === 'Proses')->action(function ($record) {
                    $record->update(['status' => 'Ditolak']);
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsulBukus::route('/'),
            'create' => Pages\CreateUsulBuku::route('/create'),
            'edit' => Pages\EditUsulBuku::route('/{record}/edit'),
        ];
    }
}
