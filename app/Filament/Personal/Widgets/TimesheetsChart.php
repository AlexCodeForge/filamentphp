<?php

namespace App\Filament\Personal\Widgets;

use App\Models\Timesheet;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class TimesheetsChart extends ChartWidget

{
    public ?string $filter = 'year';

    protected static ?string $heading = 'Timesheets Chart';

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        switch ($activeFilter) {
            case 'year':
                $data = Trend::query(Timesheet::Where('user_id', auth()->user()->id)->where('type','work')->distinct('day_in'))
                ->dateColumn('day_in')
                ->between(
                        start: now()->startOfYear(),
                        end: now()->endOfYear(),
                    )
                    ->perMonth()
                    ->count();
                break;

            case 'month':
                $data = Trend::query(Timesheet::Where('user_id', auth()->user()->id)->where('type','work')->distinct('day_in'))
                ->dateColumn('day_in')
                ->between(
                        start: now()->startOfMonth(),
                        end: now()->endOfMonth(),
                    )
                    ->perDay()
                    ->count();
                break;

            case 'week':
                $data = Trend::query(Timesheet::Where('user_id', auth()->user()->id)->where('type','work')->distinct('day_in'))
                ->dateColumn('day_in')
                ->between(
                        start: now()->startOfWeek(),
                        end: now()->endOfWeek(),
                    )
                    ->perDay()
                    ->count();
                break;

            case 'today':
                $data = Trend::query(Timesheet::Where('user_id', auth()->user()->id)->where('type','work')->distinct('day_in'))
                ->dateColumn('day_in')
                ->between(
                        start: now()->startOfDay(),
                        end: now()->endOfDay(),
                    )
                    ->perHour()
                    ->count();
                break;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Timesheets created',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }

    public function getDescription(): ?string
    {
        return 'El número de días trabajados';
    }
}
