<?php

namespace App\Filament\Pages;

use App\Models\Position;
use App\Services\ApplicantService;
use App\Services\GeminiService;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class DecisionSupportStandalone extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'دعم اتخاذ القرار';
    protected static ?string $title = 'دعم اتخاذ القرار';
    protected static ?string $navigationGroup = 'إدارة المتقدمين';
    protected static ?int $navigationSort = 3;
    protected static bool $shouldRegisterNavigation = true;

    protected static string $view = 'filament.pages.decision-support-standalone';

    public ?array $data = [];
    public $positionId = null;
    public $sortBy = 'score';
    public $sortOrder = 'desc';

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getApplicantService(): ApplicantService
    {
        return app(ApplicantService::class);
    }

    protected function getGeminiService(): GeminiService
    {
        return app(GeminiService::class);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('positionId')
                    ->label('اختر المنصب')
                    ->options(Position::active()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(fn() => $this->loadApplicants()),
                Select::make('sortBy')
                    ->label('ترتيب حسب')
                    ->options([
                        'score' => 'النقاط',
                        'experience' => 'الخبرة',
                        'education' => 'المؤهل العلمي',
                        'age' => 'العمر',
                        'rating' => 'التقييم',
                    ])
                    ->default('score')
                    ->live()
                    ->afterStateUpdated(fn() => $this->loadApplicants()),
                Select::make('sortOrder')
                    ->label('الاتجاه')
                    ->options([
                        'desc' => 'تنازلي',
                        'asc' => 'تصاعدي',
                    ])
                    ->default('desc')
                    ->live()
                    ->afterStateUpdated(fn() => $this->loadApplicants()),
            ])
            ->statePath('data');
    }

    public function loadApplicants()
    {
        $this->positionId = $this->data['positionId'] ?? null;
        $this->sortBy = $this->data['sortBy'] ?? 'score';
        $this->sortOrder = $this->data['sortOrder'] ?? 'desc';
    }

    public function getApplicants()
    {
        if (!$this->positionId) {
            return collect();
        }

        $filters = [
            'sort_by' => $this->sortBy,
            'sort_order' => $this->sortOrder,
        ];

        return $this->getApplicantService()->getApplicantsForPosition($this->positionId, $filters);
    }

    public function getTopRecommendations()
    {
        if (!$this->positionId) {
            return [];
        }

        $applicants = $this->getApplicants()->toArray();

        if (count($applicants) < 3) {
            return array_slice($applicants, 0, 3);
        }

        try {
            $topIds = $this->getGeminiService()->getTopRecommendations($applicants, $this->positionId);
            return array_filter($applicants, fn($app) => in_array($app['id'], $topIds));
        } catch (\Exception $e) {
            Notification::make()
                ->title('خطأ')
                ->body('فشل في الحصول على التوصيات من Gemini AI')
                ->danger()
                ->send();

            // Fallback: return top 3 by score
            return array_slice($applicants, 0, 3);
        }
    }

    protected function getViewData(): array
    {
        return [
            'applicants' => $this->getApplicants(),
            'topRecommendations' => $this->getTopRecommendations(),
        ];
    }
}
