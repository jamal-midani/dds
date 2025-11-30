@extends('layouts.app')

@section('title', 'تقديم طلب توظيف - ' . $position->name)

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold mb-3">تقديم طلب توظيف</h1>
            <div class="flex items-center justify-center gap-2 text-blue-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <span class="text-lg font-semibold">{{ $position->name }}</span>
            </div>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 transition-colors duration-200">
        <!-- Form Header -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 px-6 md:px-8 py-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="bg-blue-600 dark:bg-blue-500 rounded-lg p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">معلومات المتقدم</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">يرجى ملء جميع الحقول المطلوبة</p>
                </div>
            </div>
        </div>

        <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8">
            @csrf
            <input type="hidden" name="position_id" value="{{ $position->id }}">

            <!-- Personal Information Section -->
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-6 pb-3 border-b border-gray-200 dark:border-gray-700">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">المعلومات الشخصية</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>الاسم الكامل</span>
                            <span class="text-red-500 dark:text-red-400">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               required
                               placeholder="أدخل اسمك الكامل"
                               class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-400 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-200 @error('name') border-red-500 dark:border-red-400 @enderror">
                        @error('name')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>البريد الإلكتروني</span>
                            <span class="text-red-500 dark:text-red-400">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               required
                               placeholder="example@email.com"
                               class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-400 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-200 @error('email') border-red-500 dark:border-red-400 @enderror">
                        @error('email')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="space-y-2">
                        <label for="phone" class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>رقم الهاتف</span>
                            <span class="text-red-500 dark:text-red-400">*</span>
                        </label>
                        <input type="text" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}"
                               required
                               placeholder="05XXXXXXXX"
                               class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-400 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-200 @error('phone') border-red-500 dark:border-red-400 @enderror">
                        @error('phone')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Age -->
                    <div class="space-y-2">
                        <label for="age" class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>العمر</span>
                            <span class="text-red-500 dark:text-red-400">*</span>
                        </label>
                        <input type="number" 
                               id="age" 
                               name="age" 
                               value="{{ old('age') }}"
                               min="18" 
                               max="100"
                               required
                               placeholder="25"
                               class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-400 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-200 @error('age') border-red-500 dark:border-red-400 @enderror">
                        @error('age')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Education & Experience Section -->
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-6 pb-3 border-b border-gray-200 dark:border-gray-700">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">المؤهلات والخبرات</h3>
                </div>

                <!-- Education -->
                <div class="mb-6 space-y-2">
                    <label for="education" class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span>المؤهل العلمي</span>
                        <span class="text-red-500 dark:text-red-400">*</span>
                    </label>
                    <input type="text" 
                           id="education" 
                           name="education" 
                           value="{{ old('education') }}"
                           placeholder="مثال: بكالوريوس في إدارة الأعمال"
                           required
                           class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-400 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-200 @error('education') border-red-500 dark:border-red-400 @enderror">
                    @error('education')
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Experience -->
                <div class="mb-6 space-y-2">
                    <label for="experience" class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>الخبرات السابقة</span>
                    </label>
                    <textarea id="experience" 
                              name="experience" 
                              rows="5"
                              placeholder="اذكر خبراتك السابقة بالتفصيل، مثل: المسمى الوظيفي، المدة، المهام الرئيسية..."
                              class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-400 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-200 resize-none @error('experience') border-red-500 dark:border-red-400 @enderror">{{ old('experience') }}</textarea>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">يرجى ذكر خبراتك بشكل مفصل لزيادة فرصتك في القبول</p>
                    @error('experience')
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Skills -->
                <div class="mb-6 space-y-2">
                    <label for="skills" class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        <span>المهارات</span>
                    </label>
                    <textarea id="skills" 
                              name="skills" 
                              rows="4"
                              placeholder="اذكر مهاراتك (مفصولة بفواصل أو أسطر جديدة)، مثال: إدارة الفرق، التخطيط الاستراتيجي، التفاوض..."
                              class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-400 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-200 resize-none @error('skills') border-red-500 dark:border-red-400 @enderror">{{ old('skills') }}</textarea>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">اذكر جميع المهارات ذات الصلة بالمنصب</p>
                    @error('skills')
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- CV Upload Section -->
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-6 pb-3 border-b border-gray-200 dark:border-gray-700">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">السيرة الذاتية</h3>
                </div>

                <div class="space-y-2">
                    <label for="cv_file" class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>رفع السيرة الذاتية (PDF)</span>
                    </label>
                    <div class="relative">
                        <input type="file" 
                               id="cv_file" 
                               name="cv_file" 
                               accept=".pdf"
                               class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-200 hover:border-blue-400 dark:hover:border-blue-500 text-gray-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900/30 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/50 @error('cv_file') border-red-500 dark:border-red-400 @enderror">
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto text-gray-400 dark:text-gray-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="text-xs text-gray-500 dark:text-gray-400">انقر لاختيار ملف PDF</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start gap-2 mt-2 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-gray-700 dark:text-gray-300">
                            <p class="font-semibold text-gray-900 dark:text-white mb-1">ملاحظات مهمة:</p>
                            <ul class="list-disc list-inside space-y-1 text-gray-600 dark:text-gray-400">
                                <li>الحد الأقصى لحجم الملف: 5 ميجابايت</li>
                                <li>يجب أن يكون الملف بصيغة PDF فقط</li>
                                <li>تأكد من وضوح وجودة الملف</li>
                            </ul>
                        </div>
                    </div>
                    @error('cv_file')
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('positions.index') }}" 
                   class="flex items-center gap-2 px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 w-full sm:w-auto justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>إلغاء</span>
                </a>
                <button type="submit" 
                        class="group flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 dark:from-blue-700 dark:to-indigo-700 dark:hover:from-blue-800 dark:hover:to-indigo-800 text-white font-bold rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl w-full sm:w-auto justify-center">
                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>إرسال الطلب</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

