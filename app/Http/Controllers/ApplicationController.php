<?php

namespace App\Http\Controllers;

use App\Services\ApplicantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    protected ApplicantService $applicantService;

    public function __construct(ApplicantService $applicantService)
    {
        $this->applicantService = $applicantService;
    }

    /**
     * Store a new application
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'age' => 'required|integer|min:18|max:100',
            'education' => 'required|string|max:255',
            'experience' => 'nullable|string',
            'skills' => 'nullable|string',
            'position_id' => 'required|exists:positions,id',
            'cv_file' => 'nullable|file|mimes:pdf|max:5120', // 5MB max
        ], [
            'name.required' => 'الاسم مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'phone.required' => 'رقم الهاتف مطلوب',
            'age.required' => 'العمر مطلوب',
            'age.min' => 'العمر يجب أن يكون 18 سنة على الأقل',
            'age.max' => 'العمر يجب أن يكون 100 سنة على الأكثر',
            'education.required' => 'المؤهل العلمي مطلوب',
            'position_id.required' => 'المنصب مطلوب',
            'position_id.exists' => 'المنصب المحدد غير موجود',
            'cv_file.mimes' => 'يجب أن يكون الملف بصيغة PDF',
            'cv_file.max' => 'حجم الملف يجب أن يكون أقل من 5 ميجابايت',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->only([
                'name',
                'email',
                'phone',
                'age',
                'education',
                'experience',
                'skills',
                'position_id'
            ]);

            $cvFile = $request->hasFile('cv_file') ? $request->file('cv_file') : null;

            $this->applicantService->createApplicant($data, $cvFile);

            return redirect()->route('application.success')
                ->with('success', 'تم استلام طلبك وسيتم التواصل معك عند الحاجة.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء إرسال الطلب. يرجى المحاولة مرة أخرى.')
                ->withInput();
        }
    }

    /**
     * Show success page
     */
    public function success()
    {
        return view('public.application.success');
    }
}
