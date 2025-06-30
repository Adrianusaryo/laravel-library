<?php

namespace App\Filament\Widgets;

use App\Models\Buku;
use App\Models\User;
use Filament\Widgets\BarChartWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class LeaderboardWidget extends BarChartWidget
{
    protected static ?string $heading = 'Top 5 Pengguna Berdasarkan Poin';

    protected function getData(): array
    {
        $users = User::role('Member')->orderByDesc('poin')
            ->limit(5)
            ->get(['name', 'poin']);

        return [
            'datasets' => [
                [
                    'label' => 'Poin',
                    'data' => $users->pluck('poin'),
                ],
            ],
            'labels' => $users->pluck('name'),
        ];
    }

    public static function canView(): bool
    {
        return request()->routeIs('filament.admin.resources.leaderboards.index');
    }

    public function getColumnSpan(): int | string | array
    {
        return 'full';
    }
}
