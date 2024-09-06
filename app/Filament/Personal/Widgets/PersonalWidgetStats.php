<?php

namespace App\Filament\Personal\Widgets;

use App\Models\Timesheet;
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
            Stat::make('Total Pause', $this->getTotalPause() . ' hours'),
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
        $user = auth()->user();
        $timesheets = Timesheet::where('user_id', $user->id)
        ->where('type','work')->whereDate('created_at', Carbon::today())->get();
        $sumSeconds = 0;
        foreach ($timesheets as $timesheet) {
            # code...
            $startTime = Carbon::parse($timesheet->day_in);
            $finishTime = Carbon::parse($timesheet->day_out);

            $totalDuration = $finishTime->diffInSeconds($startTime);
            $sumSeconds = $sumSeconds + $totalDuration;

        }
        $tiempoFormato = gmdate("H:i:s", $sumSeconds);

        return $tiempoFormato;
    }

    protected function getTotalPause(){
        $user = auth()->user();
        $timesheets = Timesheet::where('user_id', $user->id)
            ->where('type','pause')->whereDate('created_at', Carbon::today())->get();
        $sumSeconds = 0;
        foreach ($timesheets as $timesheet) {
            # code...
            $startTime = Carbon::parse($timesheet->day_in);
            $finishTime = Carbon::parse($timesheet->day_out);

            $totalDuration = $finishTime->diffInSeconds($startTime);
            $sumSeconds = $sumSeconds + $totalDuration;

        }
        $tiempoFormato = gmdate("H:i:s", $sumSeconds);

        return $tiempoFormato;

    }
}
