<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsiaResource\Pages;
use App\Filament\Resources\UsiaResource\RelationManagers;
use App\Models\Usia;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UsiaResource extends Resource
{
    protected static ?string $model = Usia::class;
    protected static ?string $breadcrumb = 'Usia';
    protected static ?string $navigationLabel = 'Usia';
    protected static ?string $navigationGroup = 'Master';
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-rocket-launch';


    public static function getModelLabel(): string
    {
        return 'Usia';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Usia';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')->label('Kategori Usia')->required()->columnSpan(4),
                TextInput::make('usia_min')->label('Usia Bawah')->required()->numeric()->columnSpan(4),
                TextInput::make('usia_max')->label('Usia Atas')->required()->numeric()->columnSpan(4),
            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->label('Kategori Usia'),
                TextColumn::make('usia_min')->label('Usia Bawah')->alignCenter(),
                TextColumn::make('usia_max')->label('Usia Atas')->alignCenter(),
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
            'index' => Pages\ListUsias::route('/'),
            'create' => Pages\CreateUsia::route('/create'),
            'edit' => Pages\EditUsia::route('/{record}/edit'),
        ];
    }
}
