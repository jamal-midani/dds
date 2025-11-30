@extends('layouts.app')

@section('title', 'الوظائف المتاحة')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">الوظائف المتاحة</h1>
            <p class="text-xl md:text-2xl text-blue-100 mb-2">اكتشف الفرص الوظيفية المناسبة لك</p>
            <p class="text-lg text-blue-200">انضم إلى فريقنا المتميز وابدأ رحلتك المهنية</p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    @if($positions->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-12 text-center transition-colors duration-200">
            <div class="max-w-md mx-auto">
                <svg class="w-24 h-24 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-2">لا توجد وظائف متاحة حالياً</h3>
                <p class="text-gray-600 dark:text-gray-400">يرجى العودة لاحقاً للاطلاع على الفرص الجديدة</p>
            </div>
        </div>
    @else
        <!-- Stats Bar -->
        <div class="mb-8 bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 transition-colors duration-200 border border-gray-200 dark:border-gray-700">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $positions->count() }} وظيفة متاحة</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>آخر تحديث: {{ now()->format('Y-m-d') }}</span>
                </div>
            </div>
        </div>

        <!-- Jobs Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($positions as $position)
                <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
                    <!-- Card Header with Gradient -->
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-700 dark:to-indigo-700 p-6 text-white">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h2 class="text-xl font-bold mb-2 leading-tight">{{ $position->name }}</h2>
                                <div class="flex items-center gap-2 text-sm text-blue-100 dark:text-blue-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <span>وظيفة بدوام كامل</span>
                                </div>
                            </div>
                            <div class="bg-white/20 dark:bg-white/10 rounded-full p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6">
                        @if($position->description)
                            <div class="mb-4">
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed line-clamp-3">{{ Str::limit($position->description, 150) }}</p>
                            </div>
                        @endif

                        @if($position->requirements)
                            <div class="mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">الشروط الأساسية:</h3>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 leading-relaxed">{{ Str::limit($position->requirements, 100) }}</p>
                            </div>
                        @endif

                        <!-- Applicants Count -->
                        <div class="mb-4 flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>{{ $position->applicants->count() }} متقدم</span>
                        </div>

                        <!-- Apply Button -->
                        <a href="{{ route('positions.apply', $position->id) }}" 
                           class="group/btn block w-full text-center bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 dark:from-blue-700 dark:to-indigo-700 dark:hover:from-blue-800 dark:hover:to-indigo-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg">
                            <span class="flex items-center justify-center gap-2">
                                <span>تقديم الآن</span>
                                <svg class="w-5 h-5 transform group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

