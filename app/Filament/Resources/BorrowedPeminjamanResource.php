<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Peminjaman;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\BorrowedPeminjaman;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BorrowedPeminjamanResource\Pages;
use App\Filament\Resources\BorrowedPeminjamanResource\RelationManagers;

class BorrowedPeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('status', 'Dipinjam');
    }
    protected static ?string $breadcrumb = 'Peminjaman Aktif';
    protected static ?string $navigationLabel = 'Peminjaman Aktif';
    protected static ?string $navigationGroup = 'Peminjaman';
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return 'Peminjaman Aktif';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Peminjaman Aktif';
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
                TextColumn::make('status')->label('Status')->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('returned')->label('Peminjaman Selesai')->color('success')->icon('heroicon-o-check')->action(function ($record) {
                    $record->update(['status' => 'Selesai', 'tanggal_kembali' =>  now()->toDateString()]);

                    foreach ($record->buku as $buku) {
                        $buku->update(['status' => 'Tersedia']);
                    }

                    $record->user->increment('poin', 10);
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
            'index' => Pages\ListBorrowedPeminjamen::route('/'),
            'create' => Pages\CreateBorrowedPeminjaman::route('/create'),
            'edit' => Pages\EditBorrowedPeminjaman::route('/{record}/edit'),
        ];
    }
}
