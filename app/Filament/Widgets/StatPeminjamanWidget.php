<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Peminjaman;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatPeminjamanWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Peminjaman Masuk', Peminjaman::where('status', 'Menunggu Konfirmasi')->count())
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->description('Peminjaman Masuk')
                ->icon('heroicon-o-inbox-arrow-down')
                ->color('success'),
            Stat::make('Total Member Perpustakaan', User::count())
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->description('Member Perpustakaan')
                ->icon('heroicon-o-user-group')
                ->color('success'),
            Stat::make('Total Peminjaman Selesai', Peminjaman::where('status', 'Selesai')->count())
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->description('Peminjaman Selesai')
                ->icon('heroicon-o-document-check')
                ->color('success')
        ];
    }
}
