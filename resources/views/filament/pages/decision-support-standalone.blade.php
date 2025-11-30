<x-filament-panels::page>
    <div class="space-y-6">
        {{ $this->form }}

        @if($this->positionId)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Top Recommendations -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-6 h-6 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">أفضل 3 متقدمين (Gemini AI)</h2>
                    </div>
                    @if(count($this->getTopRecommendations()) > 0)
                        <div class="space-y-4">
                            @foreach($this->getTopRecommendations() as $index => $applicant)
                                @php
                                    $rankColors = [
                                        0 => ['bg' => 'bg-gradient-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20', 'border' => 'border-yellow-400 dark:border-yellow-500', 'badge' => 'bg-yellow-500 text-white', 'text' => 'text-gray-900 dark:text-white'],
                                        1 => ['bg' => 'bg-gradient-to-r from-gray-50 to-slate-50 dark:from-gray-800 dark:to-slate-800', 'border' => 'border-gray-300 dark:border-gray-600', 'badge' => 'bg-gray-500 text-white', 'text' => 'text-gray-900 dark:text-white'],
                                        2 => ['bg' => 'bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20', 'border' => 'border-orange-300 dark:border-orange-600', 'badge' => 'bg-orange-500 text-white', 'text' => 'text-gray-900 dark:text-white'],
                                    ];
                                    $colors = $rankColors[$index] ?? $rankColors[1];
                                @endphp
                                <div class="border-2 {{ $colors['border'] }} rounded-lg p-4 {{ $colors['bg'] }} shadow-md hover:shadow-lg transition-shadow">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex items-center gap-2">
                                            <span class="flex items-center justify-center w-8 h-8 rounded-full {{ $colors['badge'] }} font-bold text-sm">
                                                {{ $index + 1 }}
                                            </span>
                                            <h3 class="font-bold text-lg {{ $colors['text'] }}">{{ $applicant['name'] }}</h3>
                                        </div>
                                        @if($index === 0)
                                            <span class="px-2 py-1 bg-yellow-500 text-white text-xs font-bold rounded-full">🏆 الأفضل</span>
                                        @endif
                                    </div>
                                    <div class="space-y-2 text-sm {{ $colors['text'] }}">
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold text-gray-700 dark:text-gray-300">النقاط:</span>
                                            <span class="px-2 py-1 rounded {{ $applicant['score'] >= 80 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : ($applicant['score'] >= 60 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300') }} font-bold">
                                                {{ number_format($applicant['score'] ?? 0, 2) }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold text-gray-700 dark:text-gray-300">المؤهل:</span>
                                            <span class="text-gray-800 dark:text-gray-200">{{ $applicant['education'] }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold text-gray-700 dark:text-gray-300">العمر:</span>
                                            <span class="text-gray-800 dark:text-gray-200">{{ $applicant['age'] }} سنة</span>
                                        </div>
                                        @if(isset($applicant['rating']) && $applicant['rating'])
                                            <div class="flex items-center gap-2">
                                                <span class="font-semibold text-gray-700 dark:text-gray-300">التقييم:</span>
                                                <span class="text-yellow-500 text-lg">{{ str_repeat('⭐', $applicant['rating']) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">لا توجد توصيات متاحة</p>
                        </div>
                    @endif
                </div>

                <!-- All Applicants -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">جميع المتقدمين</h2>
                        </div>
                        <span class="px-3 py-1 bg-blue-500 text-white text-sm font-bold rounded-full shadow-sm">
                            {{ $this->getApplicants()->count() }} متقدم
                        </span>
                    </div>
                    @if($this->getApplicants()->count() > 0)
                        <div class="space-y-3 max-h-[500px] overflow-y-auto pr-2">
                            @foreach($this->getApplicants() as $index => $applicant)
                                @php
                                    $statusColors = [
                                        'under_review' => ['bg' => 'bg-blue-50 dark:bg-blue-900/20', 'border' => 'border-blue-200 dark:border-blue-700', 'badge' => 'bg-blue-500 text-white'],
                                        'accepted' => ['bg' => 'bg-green-50 dark:bg-green-900/20', 'border' => 'border-green-200 dark:border-green-700', 'badge' => 'bg-green-500 text-white'],
                                        'rejected' => ['bg' => 'bg-red-50 dark:bg-red-900/20', 'border' => 'border-red-200 dark:border-red-700', 'badge' => 'bg-red-500 text-white'],
                                    ];
                                    $statusInfo = $statusColors[$applicant->status] ?? $statusColors['under_review'];
                                    $statusLabels = [
                                        'under_review' => 'قيد المراجعة',
                                        'accepted' => 'مقبول',
                                        'rejected' => 'مرفوض',
                                    ];
                                @endphp
                                <div class="border-2 {{ $statusInfo['border'] }} rounded-lg p-4 {{ $statusInfo['bg'] }} hover:shadow-md transition-all duration-200">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <h3 class="font-bold text-lg text-gray-900 dark:text-white">{{ $applicant->name }}</h3>
                                                @if($applicant->rating)
                                                    <span class="text-yellow-500 text-sm">{{ str_repeat('⭐', $applicant->rating) }}</span>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-0.5 {{ $statusInfo['badge'] }} text-xs font-semibold rounded">
                                                    {{ $statusLabels[$applicant->status] ?? $applicant->status }}
                                                </span>
                                                <span class="text-xs text-gray-600 dark:text-gray-400">
                                                    {{ $applicant->created_at->format('Y-m-d') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-right ml-4">
                                            <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">النقاط</div>
                                            <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-sm font-bold shadow-sm {{ $applicant->score >= 80 ? 'bg-green-500 text-white' : ($applicant->score >= 60 ? 'bg-yellow-500 text-white' : 'bg-red-500 text-white') }}">
                                                {{ number_format($applicant->score ?? 0, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                        <div class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                            <div>
                                                <span class="text-xs font-semibold text-gray-600 dark:text-gray-400 block">المؤهل العلمي</span>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $applicant->education }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <div>
                                                <span class="text-xs font-semibold text-gray-600 dark:text-gray-400 block">العمر</span>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $applicant->age }} سنة</span>
                                            </div>
                                        </div>
                                        @if($applicant->email)
                                            <div class="flex items-start gap-2">
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                                <div>
                                                    <span class="text-xs font-semibold text-gray-600 dark:text-gray-400 block">البريد الإلكتروني</span>
                                                    <span class="text-sm font-medium text-gray-900 dark:text-white break-all">{{ $applicant->email }}</span>
                                                </div>
                                            </div>
                                        @endif
                                        @if($applicant->phone)
                                            <div class="flex items-start gap-2">
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                </svg>
                                                <div>
                                                    <span class="text-xs font-semibold text-gray-600 dark:text-gray-400 block">رقم الهاتف</span>
                                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $applicant->phone }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">لا يوجد متقدمين لهذا المنصب</p>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500 dark:text-gray-400 text-lg">يرجى اختيار منصب لعرض المتقدمين</p>
            </div>
        @endif
    </div>
</x-filament-panels::page>
