<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Cerpen;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CerpenResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CerpenResource\RelationManagers;

class CerpenResource extends Resource
{
    protected static ?string $model = Cerpen::class;
    protected static ?string $breadcrumb = 'Cerpen';
    protected static ?string $navigationLabel = 'Cerpen';
    protected static ?string $navigationGroup = 'Buku & Cerpen';
    protected static ?string $navigationIcon = 'heroicon-o-paper-clip';
    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return 'Cerpen';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Cerpen';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul')->label('Judul'),
                TextColumn::make('penulis')->label('Penulis'),
                TextColumn::make('status')->badge()->colors([
                    'warning' => 'Pending',
                    'success' => 'Approved',
                    'danger' => 'Rejected'
                ]),
                ImageColumn::make('poster')
                    ->label('Cover Cerpen')
                    ->width(60)
                    ->height(80)
                    ->getStateUsing(function ($record) {
                        $path = public_path('storage/Cerpen/' . $record->poster);
                        if (!empty($record->poster) && file_exists($path)) {
                            return asset('storage/Cerpen/' . $record->poster);
                        } else {
                            return asset('images/default.png');
                        }
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('approved')->label('Approved')->color('success')->icon('heroicon-o-check-badge')->visible(fn($record) => $record->status === 'Pending')
                    ->action(function ($record) {
                        $record->update(['status' => 'approved']);
                    }),
                Action::make('rejected')->label('Rejected')->color('danger')->icon('heroicon-o-x-circle')->visible(fn($record) => $record->status === 'Pending')
                    ->action(function ($record) {
                        $record->update(['status' => 'rejected']);
                    }),
                Action::make('lihatIsi')
                    ->label('Lihat Isi ')
                    ->icon('heroicon-o-eye')
                    ->modalHeading(fn($record) => 'Isi Cerpen : ' . $record->judul)
                    ->modalDescription(fn($record) => strip_tags($record->isi))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),
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
            'index' => Pages\ListCerpens::route('/'),
            'create' => Pages\CreateCerpen::route('/create'),
            'edit' => Pages\EditCerpen::route('/{record}/edit'),
        ];
    }
}
