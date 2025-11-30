<?php

namespace App\Filament\Widgets;

use App\Models\Position;
use Filament\Widgets\ChartWidget;

class ApplicantsByPositionChartWidget extends ChartWidget
{
    protected static ?string $heading = 'المتقدمين حسب المنصب';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $positions = Position::withCount('applicants')->get();
        
        $labels = $positions->pluck('name')->toArray();
        $data = $positions->pluck('applicants_count')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'عدد المتقدمين',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgb(59, 130, 246)',
                        'rgb(34, 197, 94)',
                        'rgb(251, 191, 36)',
                        'rgb(239, 68, 68)',
                        'rgb(168, 85, 247)',
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

