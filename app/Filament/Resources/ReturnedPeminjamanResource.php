<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Peminjaman;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\ReturnedPeminjaman;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ReturnedPeminjamanResource\Pages;
use App\Filament\Resources\ReturnedPeminjamanResource\RelationManagers;

class ReturnedPeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('status', 'Selesai');
    }

    protected static ?string $breadcrumb = 'Riwayat Peminjaman';
    protected static ?string $navigationLabel = 'Riwayat Peminjaman';
    protected static ?string $navigationGroup = 'Peminjaman';
    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?int $navigationSort = 3;
    public static function getModelLabel(): string
    {
        return 'Riwayat Peminjaman';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Riwayat Peminjaman';
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
                TextColumn::make('user.name')->label('Nama')->alignCenter(),
                TextColumn::make('kode_peminjaman')->label('Kode Peminjaman')->alignCenter(),
                TextColumn::make('tanggal_pinjam')->label('Tanggal Peminjaman')->alignCenter(),
                TextColumn::make('tanggal_kembali')->label('Tanggal Kembali')->alignCenter()->placeholder('No Information'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Selesai' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn($state) => ucwords($state)),
            ])
            ->filters([
                //
            ])
            ->actions([])
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
            'index' => Pages\ListReturnedPeminjamen::route('/'),
            'create' => Pages\CreateReturnedPeminjaman::route('/create'),
            'edit' => Pages\EditReturnedPeminjaman::route('/{record}/edit'),
        ];
    }
}
