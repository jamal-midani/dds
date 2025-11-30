<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApplicantResource\Pages;
use App\Filament\Resources\ApplicantResource\RelationManagers;
use App\Models\Applicant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApplicantResource extends Resource
{
    protected static ?string $model = Applicant::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'المتقدمين';
    protected static ?string $modelLabel = 'متقدم';
    protected static ?string $pluralModelLabel = 'المتقدمين';
    protected static ?string $navigationGroup = 'إدارة المتقدمين';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('position_id')
                    ->label('المنصب')
                    ->relationship('position', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('name')
                    ->label('الاسم الكامل')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('البريد الإلكتروني')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label('رقم الهاتف')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('age')
                    ->label('العمر')
                    ->numeric()
                    ->required()
                    ->minValue(18)
                    ->maxValue(100),
                Forms\Components\TextInput::make('education')
                    ->label('المؤهل العلمي')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('experience')
                    ->label('الخبرات السابقة')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('skills')
                    ->label('المهارات')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('cv_file')
                    ->label('السيرة الذاتية')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(5120)
                    ->directory('cvs')
                    ->visibility('private')
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->label('حالة الطلب')
                    ->options([
                        'under_review' => 'قيد المراجعة',
                        'accepted' => 'مقبول',
                        'rejected' => 'مرفوض',
                    ])
                    ->default('under_review')
                    ->required(),
                Forms\Components\Select::make('rating')
                    ->label('التقييم')
                    ->options([
                        1 => '⭐',
                        2 => '⭐⭐',
                        3 => '⭐⭐⭐',
                        4 => '⭐⭐⭐⭐',
                        5 => '⭐⭐⭐⭐⭐',
                    ])
                    // ->numeric(),
                    ->default(0),
                Forms\Components\TextInput::make('score')
                    ->label('النقاط التلقائية')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\Textarea::make('gemini_summary')
                    ->label('ملخص Gemini AI')
                    ->rows(3)
                    ->columnSpanFull()
                    ->disabled()
                    ->dehydrated(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position.name')
                    ->label('المنصب')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('age')
                    ->label('العمر')
                    ->sortable(),
                Tables\Columns\TextColumn::make('education')
                    ->label('المؤهل')
                    ->searchable()
                    ->limit(20),
                Tables\Columns\TextColumn::make('score')
                    ->label('النقاط')
                    ->numeric(
                        decimalPlaces: 2,
                    )
                    ->sortable()
                    ->color(fn($state) => match (true) {
                        $state >= 80 => 'success',
                        $state >= 60 => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\SelectColumn::make('status')
                    ->label('الحالة')
                    ->options([
                        'under_review' => 'قيد المراجعة',
                        'accepted' => 'مقبول',
                        'rejected' => 'مرفوض',
                    ])
                    ->selectablePlaceholder(false),
                Tables\Columns\TextColumn::make('rating')
                    ->label('التقييم')
                    ->formatStateUsing(fn($state) => $state ? str_repeat('⭐', $state) : '-')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ التقديم')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('position_id')
                    ->label('المنصب')
                    ->relationship('position', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'under_review' => 'قيد المراجعة',
                        'accepted' => 'مقبول',
                        'rejected' => 'مرفوض',
                    ]),
                Tables\Filters\Filter::make('score')
                    ->form([
                        Forms\Components\TextInput::make('min_score')
                            ->label('الحد الأدنى للنقاط')
                            // ->numeric()
                            ->default(0),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['min_score'],
                                fn(Builder $query, $score): Builder => $query->where('score', '>=', $score),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('view_cv')
                    ->label('عرض السيرة الذاتية')
                    ->icon('heroicon-o-document')
                    ->url(fn(Applicant $record): string => $record->cv_file ? asset('storage/' . $record->cv_file) : '#')
                    ->openUrlInNewTab()
                    ->visible(fn(Applicant $record): bool => !empty($record->cv_file)),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                return $query
                    ->orderByRaw("CASE 
                        WHEN status = 'under_review' THEN 1 
                        WHEN status = 'accepted' THEN 2 
                        WHEN status = 'rejected' THEN 3 
                        ELSE 4 
                    END")
                    ->orderBy('created_at', 'asc');
            });
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApplicants::route('/'),
            'create' => Pages\CreateApplicant::route('/create'),
            'edit' => Pages\EditApplicant::route('/{record}/edit'),
            'decision-support' => Pages\DecisionSupport::route('/decision-support'),
        ];
    }
}
