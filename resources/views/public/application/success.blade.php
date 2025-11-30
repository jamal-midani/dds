@extends('layouts.app')

@section('title', 'تم إرسال الطلب بنجاح')

@section('content')
<div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <div class="mb-6">
            <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-900 mb-4">تم استلام طلبك بنجاح</h1>
        
        <p class="text-lg text-gray-600 mb-8">
            تم استلام طلبك وسيتم التواصل معك عند الحاجة.
        </p>

        <div class="space-y-4">
            <a href="{{ route('positions.index') }}" 
               class="inline-block px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                العودة إلى الوظائف المتاحة
            </a>
        </div>
    </div>
</div>
@endsection

