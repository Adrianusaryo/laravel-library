<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Buku;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MultiSelect;
use App\Filament\Resources\BukuResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BukuResource\RelationManagers;
use Filament\Tables\Columns\ImageColumn;

class BukuResource extends Resource
{
    protected static ?string $model = Buku::class;
    protected static ?string $breadcrumb = 'Buku';
    protected static ?string $navigationLabel = 'Buku';
    protected static ?string $navigationGroup = 'Buku & Cerpen';
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function getModelLabel(): string
    {
        return 'Buku';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Buku';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('judul')->label('Judul Buku')->required()->placeholder('Contoh : Timun jelita'),
                TextInput::make('penulis')->label('Penulis')->required()->placeholder('Contoh : Raditya Dika'),
                TextInput::make('penerbit')->label('Penerbit')->required()->placeholder('Contoh :Jakarta : Gagas Media, 2024'),
                TextInput::make('edisi')->label('Edisi')->required()->placeholder('Contoh : Cetakan pertama'),
                TextInput::make('deskripsi_fisik')->label('Deskripsi Fisik')->required()->placeholder('Contoh : vi, 174 Halaman : Ilustrasi ; 13 x 19 cm.'),
                TextInput::make('isbn')->label('ISBN')->required()->placeholder('Contoh : 9786234933031'),
                TextInput::make('bahasa')->label('Bahasa')->required()->placeholder('Indonesia'),
                MultiSelect::make('kategori')->relationship('kategori', 'kategori')->preload()->label('Kategori'),
                Textarea::make('deskripsi')->label('Deskripsi')->required(),
                FileUpload::make('cover_buku')->label('Cover Buku')
                    ->directory('Buku')
                    ->image()
                    ->preserveFilenames(false)
                    ->getUploadedFileNameForStorageUsing(function ($file): string {
                        $timestamp = Carbon::now()->timestamp;
                        $originalName = $file->getClientOriginalName();
                        return $timestamp . '-' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                    })
                    ->required()
                    ->imagePreviewHeight('200'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul')->label('Judul'),
                TextColumn::make('penulis')->label('Penulis'),
                TextColumn::make('penerbit')->label('Penerbit'),
                TextColumn::make('edisi')->label('Edisi'),
                TextColumn::make('isbn')->label('ISBN'),
                TextColumn::make('bahasa')->label('Bahasa'),
                TextColumn::make('deskripsi_fisik')->label('Deskripsi Fisik'),
                TextColumn::make('kategori')
                    ->label('Kategori Buku')
                    ->formatStateUsing(
                        fn($record) =>
                        $record->kategori?->pluck('kategori')->join(', ') ?? '-'
                    ),
                TextColumn::make('deskripsi')->label('Deskripsi'),
                ImageColumn::make('cover_buku')->label('Cover Buku')->width(60)->height(80),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Tidak Tersedia' => 'danger',
                        'Tersedia' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn($state) => ucwords($state)),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListBukus::route('/'),
            'create' => Pages\CreateBuku::route('/create'),
            'edit' => Pages\EditBuku::route('/{record}/edit'),
        ];
    }
}
