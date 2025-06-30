<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Leaderboard;
use Filament\Resources\Resource;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LeaderboardResource\Pages;
use App\Filament\Resources\LeaderboardResource\RelationManagers;

class LeaderboardResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $breadcrumb = 'Leaderboard';
    protected static ?string $navigationLabel = 'Leaderboard';
    protected static ?string $navigationGroup = 'Acara & Aktivitas';
    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return 'Leaderboard Aktivitas';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Leaderboard Aktivitas';
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
            ->columns([]);
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
            'index' => Pages\ListLeaderboards::route('/'),
            'create' => Pages\CreateLeaderboard::route('/create'),
            'edit' => Pages\EditLeaderboard::route('/{record}/edit'),
        ];
    }
}
