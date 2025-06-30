<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Acara;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MultiSelect;
use App\Filament\Resources\AcaraResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AcaraResource\RelationManagers;

class AcaraResource extends Resource
{
    protected static ?string $model = Acara::class;
    protected static ?string $breadcrumb = 'Acara';
    protected static ?string $navigationLabel = 'Acara';
    protected static ?string $navigationGroup = 'Acara & Aktivitas';
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    public static function getModelLabel(): string
    {
        return 'Acara';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Acara';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_acara')->label('Acara'),
                TextInput::make('narasumber')->label('Narasumber'),
                TextInput::make('lokasi')->label('Lokasi'),
                DatePicker::make('tanggal')->label('Tanggal Acara'),
                TimePicker::make('jam_mulai')->label('Jam Mulai')->seconds(false)->format('H:i'),
                TimePicker::make('jam_selesai')->label('Jam Selesai')->seconds(false)->format('H:i'),
                TextInput::make('alamat')->label('Alamat'),
                Textarea::make('deskripsi')->label('Deskripsi Acara'),
                MultiSelect::make('usia')->relationship('usia', 'nama')->required()->preload(),
                TextInput::make('kategori')->label('Kategori Acara'),
                FileUpload::make('poster')->label('Poster Acara')
                    ->directory('Acara')
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
                TextColumn::make('nama_acara')->label('Nama Acara'),
                TextColumn::make('narasumber')->label('Narasumber'),
                TextColumn::make('tanggal')->label('Tanggal Acara'),
                TextColumn::make('jam_mulai')->label('Jam Mulai'),
                TextColumn::make('jam_selesai')->label('Jam Selesai'),
                TextColumn::make('lokasi')->label('Lokasi'),
                TextColumn::make('alamat')->label('Alamat'),
                TextColumn::make('deskripsi')->label('Deskripsi'),
                TextColumn::make('usia')
                    ->label('Kategori Usia')
                    ->formatStateUsing(
                        fn($record) =>
                        $record->usia?->pluck('nama')->join(', ') ?? '-'
                    ),
                ImageColumn::make('poster')
                    ->label('Poster')
                    ->disk('public')
                    ->width(60)

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        if ($record->poster) {
                            Storage::disk('public')->delete('Acara/' . $record->poster);
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
            'index' => Pages\ListAcaras::route('/'),
            'create' => Pages\CreateAcara::route('/create'),
            'edit' => Pages\EditAcara::route('/{record}/edit'),
        ];
    }
}
