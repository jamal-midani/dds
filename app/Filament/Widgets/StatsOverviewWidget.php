<?php

namespace App\Filament\Widgets;

use App\Models\Applicant;
use App\Models\Position;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalPositions = Position::count();
        $activePositions = Position::active()->count();
        $totalApplicants = Applicant::count();
        $underReview = Applicant::where('status', 'under_review')->count();
        $accepted = Applicant::where('status', 'accepted')->count();
        $rejected = Applicant::where('status', 'rejected')->count();
        $avgScore = Applicant::whereNotNull('score')->avg('score') ?? 0;

        return [
            Stat::make('إجمالي الوظائف', $totalPositions)
                ->description('منها ' . $activePositions . ' نشطة')
                ->descriptionIcon('heroicon-o-briefcase')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 4]),

            Stat::make('إجمالي المتقدمين', $totalApplicants)
                ->description('متقدم جديد')
                ->descriptionIcon('heroicon-o-users')
                ->color('info')
                ->chart([2, 10, 3, 12, 1, 14, 7]),

            Stat::make('قيد المراجعة', $underReview)
                ->description($accepted . ' مقبول • ' . $rejected . ' مرفوض')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning')
                ->chart([1, 2, 3, 4, 5, 6, 7]),

            Stat::make('متوسط النقاط', number_format($avgScore, 2))
                ->description('لجميع المتقدمين')
                ->descriptionIcon('heroicon-o-star')
                ->color('success')
                ->chart([65, 70, 75, 80, 85, 90, 95]),
        ];
    }
}
