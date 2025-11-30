<?php

namespace App\Filament\Widgets;

use App\Models\Applicant;
use Filament\Widgets\ChartWidget;

class ApplicantsByStatusChartWidget extends ChartWidget
{
    protected static ?string $heading = 'المتقدمين حسب الحالة';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $underReview = Applicant::where('status', 'under_review')->count();
        $accepted = Applicant::where('status', 'accepted')->count();
        $rejected = Applicant::where('status', 'rejected')->count();

        return [
            'datasets' => [
                [
                    'label' => 'المتقدمين',
                    'data' => [$underReview, $accepted, $rejected],
                    'backgroundColor' => [
                        'rgb(59, 130, 246)',   // blue for under_review
                        'rgb(34, 197, 94)',   // green for accepted
                        'rgb(239, 68, 68)',   // red for rejected
                    ],
                ],
            ],
            'labels' => ['قيد المراجعة', 'مقبول', 'مرفوض'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}

