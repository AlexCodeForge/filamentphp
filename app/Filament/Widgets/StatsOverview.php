<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalEmployes = \App\Models\User::count();
        $pendingHolydays = \App\Models\Holiday::where('type', 'pending')->count();
        $totalTimesheets = \App\Models\Timesheet::count();

        return [
            Stat::make('Employees', $totalEmployes)
                ->description('All employees')
                ->descriptionIcon('heroicon-o-users')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Pending Holydays', $pendingHolydays),
            Stat::make('Timesheets', $totalTimesheets),
        ];
    }
}
