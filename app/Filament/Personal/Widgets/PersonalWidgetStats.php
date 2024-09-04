<?php

namespace App\Filament\Personal\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class PersonalWidgetStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pending holidays', $this->getPendingHolidays()),
            Stat::make('Approved holidays', $this->getApprovedHolidays()),
            Stat::make('Total work', $this->getTotalHours() . ' hours'),
        ];
    }

    protected function getPendingHolidays()
    {
        return auth()->user()->holidays()->where('type' , 'pending')->count();
    }
    protected function getApprovedHolidays()
    {
        return auth()->user()->holidays()->where('type' , 'approve')->count();
    }

    protected function getTotalHours()
    {
        $totalHours = auth()->user()->timesheets()->where('type' , 'work')->get()
            ->sum(function ($timesheet) {
                $dayIn = Carbon::parse($timesheet->day_in);
                $dayOut = Carbon::parse($timesheet->day_out);

                $diffInHours = $dayOut->diffInHours($dayIn);
                return $diffInHours;
            });

        return $totalHours;
    }
}
