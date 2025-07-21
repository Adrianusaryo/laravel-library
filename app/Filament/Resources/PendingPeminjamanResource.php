<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Peminjaman;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\PendingPeminjaman;
use Illuminate\Support\HtmlString;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PendingPeminjamanResource\Pages;
use App\Filament\Resources\PendingPeminjamanResource\RelationManagers;

class PendingPeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('status', 'Menunggu Konfirmasi');
    }

    protected static ?string $breadcrumb = 'Peminjaman Masuk';
    protected static ?string $navigationLabel = 'Peminjaman Masuk';
    protected static ?string $navigationGroup = 'Peminjaman';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    public static function getNavigationBadge(): ?string
    {
        return (string) \App\Models\Peminjaman::where('status', '!=', 'Selesai')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function getModelLabel(): string
    {
        return 'Peminjaman Masuk';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Peminjaman Masuk';
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
                Action::make('lihat_buku')
                    ->label('Lihat Buku')
                    ->icon('heroicon-o-book-open')
                    ->color('info')
                    ->modalHeading('Daftar Buku yang Dipinjam')
                    ->modalSubheading(fn($record) => 'Kode Peminjaman: ' . $record->kode_peminjaman)
                    ->modalContent(function ($record) {
                        $html = '<ul class="list-disc list-inside text-sm text-gray-200 dark:text-gray-300 space-y-1">';

                        foreach ($record->buku as $buku) {
                            $html .= "<li>{$buku->judul} (Penulis: {$buku->penulis}, Penerbit : {$buku->penerbit})</li>";
                        }
                        $html .= '</ul>';
                        return new HtmlString($html);
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),
                Action::make('borrowed')->label('Status Dipinjam')->color('success')->icon('heroicon-o-check')->action(function ($record) {
                    $record->update(['status' => 'Dipinjam']);

                    foreach ($record->buku as $buku) {
                        $buku->update(['status' => 'Tidak Tersedia']);
                    }
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
            'index' => Pages\ListPendingPeminjamen::route('/'),
            'create' => Pages\CreatePendingPeminjaman::route('/create'),
            'edit' => Pages\EditPendingPeminjaman::route('/{record}/edit'),
        ];
    }
}
