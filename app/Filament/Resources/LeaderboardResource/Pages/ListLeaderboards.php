<?php

namespace App\Filament\Resources\LeaderboardResource\Pages;

use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\LeaderboardWidget;
use App\Filament\Resources\LeaderboardResource;

class ListLeaderboards extends ListRecords
{
    protected static string $resource = LeaderboardResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            LeaderboardWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('resetPoints')
                ->label('Reset Leaderboard')
                ->color('danger')
                ->icon('heroicon-o-arrow-path')
                ->requiresConfirmation()
                ->action(function () {
                    User::query()->role('member')->update(['poin' => 0]);

                    \Filament\Notifications\Notification::make()
                        ->title('Semua poin member berhasil di-reset.')
                        ->success()
                        ->send();
                }),
        ];
    }
}
