<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class UserChart extends ChartWidget
{
    protected static ?string $heading = 'User Chart';
    public ?string $filter = 'today';



    protected function getData(): array
    {
        $activeFilter = $this->filter;
        // dd($activeFilter);

        if ($activeFilter === 'today') {
            return [
                'datasets' => [
                    [
                        'label' => 'Users',
                        'data' => [0, 99, 15],
                    ],
                ],
                'labels' => ['Jan', 'Feb', 'Mar'],
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Users',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
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

    protected function getType(): string
    {
        return 'line';
    }
}
