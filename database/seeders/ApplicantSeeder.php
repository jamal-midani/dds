<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\Position;
use App\Services\ScoringService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $scoringService = app(ScoringService::class);

        // الحصول على الوظائف
        $positions = Position::all();

        if ($positions->isEmpty()) {
            $this->command->warn('لا توجد وظائف متاحة. يرجى تشغيل PositionSeeder أولاً.');
            return;
        }

        // الحصول على IDs للوظائف
        $generalManagerId = $positions->where('name', 'مدير عام')->first()->id ?? $positions->first()->id;
        $hrManagerId = $positions->where('name', 'مدير الموارد البشرية')->first()->id ?? $positions->first()->id;
        $salesManagerId = $positions->where('name', 'مدير المبيعات')->first()->id ?? $positions->first()->id;
        $itManagerId = $positions->where('name', 'مدير تقنية المعلومات')->first()->id ?? $positions->first()->id;
        $financeManagerId = $positions->where('name', 'مدير المالية')->first()->id ?? $positions->first()->id;

        $applicants = [
            // ========== متقدمون لمنصب مدير عام (7 متقدمين) ==========
            [
                'name' => 'أحمد محمد العلي',
                'email' => 'ahmed.ali@example.com',
                'phone' => '0501234567',
                'age' => 45,
                'education' => 'دكتوراه في إدارة الأعمال',
                'experience' => 'خبرة 15 سنة في الإدارة العليا. عملت كمدير عام لشركة تقنية لمدة 8 سنوات، ومدير تنفيذي لشركة استشارات لمدة 7 سنوات. قمت بقيادة فرق كبيرة وتحقيق نمو سنوي بنسبة 25%.',
                'skills' => 'القيادة الاستراتيجية، إدارة الفرق، التخطيط الاستراتيجي، إدارة التغيير، التفاوض، اتخاذ القرارات، إدارة الأزمات',
                'position_id' => $generalManagerId,
                'status' => 'accepted',
                'rating' => 5,
            ],
            [
                'name' => 'فاطمة عبدالله السالم',
                'email' => 'fatima.salem@example.com',
                'phone' => '0502345678',
                'age' => 42,
                'education' => 'ماجستير في إدارة الأعمال',
                'experience' => 'خبرة 12 سنة في الإدارة. عملت كمديرة تنفيذية لشركة خدمات لمدة 6 سنوات، ونائبة مدير عام لشركة صناعية لمدة 6 سنوات. خبرة في إدارة المشاريع الكبيرة.',
                'skills' => 'الإدارة التنفيذية، إدارة المشاريع، التخطيط، القيادة، التواصل، إدارة الموارد',
                'position_id' => $generalManagerId,
                'status' => 'under_review',
                'rating' => 4,
            ],
            [
                'name' => 'خالد سعد الدوسري',
                'email' => 'khalid.dosari@example.com',
                'phone' => '0503456789',
                'age' => 38,
                'education' => 'ماجستير في إدارة الأعمال',
                'experience' => 'خبرة 10 سنوات في الإدارة. عملت كمدير عام لشركة تجارية لمدة 5 سنوات، ومدير إقليمي لشركة متعددة الجنسيات لمدة 5 سنوات.',
                'skills' => 'الإدارة الاستراتيجية، القيادة، إدارة الفرق، التسويق، المبيعات',
                'position_id' => $generalManagerId,
                'status' => 'under_review',
                'rating' => 4,
            ],
            [
                'name' => 'سعد عبدالرحمن العتيبي',
                'email' => 'saad.otaibi@example.com',
                'phone' => '0504567890',
                'age' => 48,
                'education' => 'دكتوراه في إدارة الأعمال',
                'experience' => 'خبرة 18 سنة في الإدارة العليا. عملت كمدير عام لشركة صناعية لمدة 10 سنوات، ومدير تنفيذي لشركة استثمارية لمدة 8 سنوات. خبرة في إدارة الشركات الكبيرة.',
                'skills' => 'القيادة الاستراتيجية، إدارة الشركات، التخطيط طويل المدى، إدارة الاستثمارات، العلاقات العامة',
                'position_id' => $generalManagerId,
                'status' => 'under_review',
                'rating' => 5,
            ],
            [
                'name' => 'مريم حسن القحطاني',
                'email' => 'mariam.qhtani@example.com',
                'phone' => '0505678901',
                'age' => 35,
                'education' => 'ماجستير في إدارة الأعمال',
                'experience' => 'خبرة 8 سنوات في الإدارة. عملت كنائبة مدير عام لشركة تقنية لمدة 4 سنوات، ومديرة إدارية لشركة خدمات لمدة 4 سنوات.',
                'skills' => 'الإدارة، التخطيط، القيادة، إدارة الفرق، التواصل',
                'position_id' => $generalManagerId,
                'status' => 'under_review',
                'rating' => 3,
            ],
            [
                'name' => 'عمر يوسف الشمري',
                'email' => 'omar.shamri@example.com',
                'phone' => '0506789012',
                'age' => 52,
                'education' => 'بكالوريوس في إدارة الأعمال',
                'experience' => 'خبرة 20 سنة في الإدارة. عملت كمدير عام لشركة تجارية لمدة 12 سنة، ومدير إقليمي لمدة 8 سنوات.',
                'skills' => 'الإدارة، القيادة، إدارة الفرق، المبيعات، التسويق',
                'position_id' => $generalManagerId,
                'status' => 'rejected',
                'rating' => 3,
            ],
            [
                'name' => 'هند عبدالعزيز الحربي',
                'email' => 'hind.harbi@example.com',
                'phone' => '0507890123',
                'age' => 29,
                'education' => 'بكالوريوس في إدارة الأعمال',
                'experience' => 'خبرة 5 سنوات في الإدارة. عملت كمديرة إدارية لشركة صغيرة لمدة 3 سنوات، ومديرة مشاريع لمدة سنتين.',
                'skills' => 'الإدارة، إدارة المشاريع، التخطيط، التواصل',
                'position_id' => $generalManagerId,
                'status' => 'rejected',
                'rating' => 2,
            ],

            // ========== متقدمون لمنصب مدير الموارد البشرية (6 متقدمين) ==========
            [
                'name' => 'سارة علي القحطاني',
                'email' => 'sara.qhtani@example.com',
                'phone' => '0508901234',
                'age' => 35,
                'education' => 'بكالوريوس في إدارة الأعمال - تخصص موارد بشرية',
                'experience' => 'خبرة 8 سنوات في الموارد البشرية. عملت كمديرة موارد بشرية لشركة تقنية لمدة 5 سنوات، ومديرة توظيف لشركة خدمات لمدة 3 سنوات.',
                'skills' => 'إدارة الموارد البشرية، التوظيف، التدريب والتطوير، إدارة الأداء، قوانين العمل',
                'position_id' => $hrManagerId,
                'status' => 'accepted',
                'rating' => 5,
            ],
            [
                'name' => 'محمد حسن الشمري',
                'email' => 'mohammed.shamri@example.com',
                'phone' => '0509012345',
                'age' => 32,
                'education' => 'بكالوريوس في الموارد البشرية',
                'experience' => 'خبرة 7 سنوات في الموارد البشرية. عملت كمدير موارد بشرية لشركة تجارية لمدة 4 سنوات، ومدير توظيف لشركة صناعية لمدة 3 سنوات.',
                'skills' => 'الموارد البشرية، التوظيف، التدريب، إدارة الأداء، التواصل',
                'position_id' => $hrManagerId,
                'status' => 'under_review',
                'rating' => 4,
            ],
            [
                'name' => 'نورا خالد المطيري',
                'email' => 'nora.mutairi@example.com',
                'phone' => '0510123456',
                'age' => 38,
                'education' => 'ماجستير في الموارد البشرية',
                'experience' => 'خبرة 10 سنوات في الموارد البشرية. عملت كمديرة موارد بشرية لشركة كبيرة لمدة 6 سنوات، ومديرة تطوير موظفين لمدة 4 سنوات.',
                'skills' => 'الموارد البشرية، التوظيف، التدريب والتطوير، إدارة الأداء، التخطيط الاستراتيجي للموارد البشرية',
                'position_id' => $hrManagerId,
                'status' => 'under_review',
                'rating' => 5,
            ],
            [
                'name' => 'عبدالله فهد العتيبي',
                'email' => 'abdullah.otaibi@example.com',
                'phone' => '0511234567',
                'age' => 30,
                'education' => 'بكالوريوس في الموارد البشرية',
                'experience' => 'خبرة 6 سنوات في الموارد البشرية. عملت كمدير توظيف لشركة تقنية لمدة 3 سنوات، ومدير موارد بشرية لشركة صغيرة لمدة 3 سنوات.',
                'skills' => 'الموارد البشرية، التوظيف، التدريب، التواصل',
                'position_id' => $hrManagerId,
                'status' => 'under_review',
                'rating' => 3,
            ],
            [
                'name' => 'لينا صالح الغامدي',
                'email' => 'lina.ghamdi@example.com',
                'phone' => '0512345678',
                'age' => 28,
                'education' => 'بكالوريوس في إدارة الأعمال',
                'experience' => 'خبرة 4 سنوات في الموارد البشرية. عملت كأخصائية موارد بشرية لشركة تجارية لمدة 4 سنوات.',
                'skills' => 'الموارد البشرية، التوظيف، التواصل',
                'position_id' => $hrManagerId,
                'status' => 'rejected',
                'rating' => 2,
            ],
            [
                'name' => 'يوسف أحمد الدوسري',
                'email' => 'youssef.dosari@example.com',
                'phone' => '0513456789',
                'age' => 40,
                'education' => 'دبلوم في الموارد البشرية',
                'experience' => 'خبرة 12 سنة في الموارد البشرية. عملت كمدير موارد بشرية لشركة صناعية لمدة 8 سنوات، ومدير توظيف لمدة 4 سنوات.',
                'skills' => 'الموارد البشرية، التوظيف، التدريب، إدارة الأداء',
                'position_id' => $hrManagerId,
                'status' => 'under_review',
                'rating' => 3,
            ],

            // ========== متقدمون لمنصب مدير المبيعات (7 متقدمين) ==========
            [
                'name' => 'عبدالرحمن يوسف الحربي',
                'email' => 'abdulrahman.harbi@example.com',
                'phone' => '0514567890',
                'age' => 40,
                'education' => 'بكالوريوس في التسويق',
                'experience' => 'خبرة 12 سنة في المبيعات. عملت كمدير مبيعات إقليمي لشركة تقنية لمدة 7 سنوات، ومدير مبيعات لشركة تجارية لمدة 5 سنوات. حققت نمو في المبيعات بنسبة 40% سنوياً.',
                'skills' => 'المبيعات، التسويق، إدارة الفرق، التفاوض، بناء العلاقات، إدارة الحسابات الكبيرة',
                'position_id' => $salesManagerId,
                'status' => 'accepted',
                'rating' => 5,
            ],
            [
                'name' => 'نورا عبدالعزيز الزهراني',
                'email' => 'nora.zahrani@example.com',
                'phone' => '0515678901',
                'age' => 36,
                'education' => 'ماجستير في التسويق',
                'experience' => 'خبرة 9 سنوات في المبيعات والتسويق. عملت كمديرة مبيعات لشركة خدمات لمدة 5 سنوات، ومديرة تسويق لشركة تجارية لمدة 4 سنوات.',
                'skills' => 'المبيعات، التسويق الرقمي، إدارة الفرق، التخطيط الاستراتيجي، تحليل السوق',
                'position_id' => $salesManagerId,
                'status' => 'under_review',
                'rating' => 4,
            ],
            [
                'name' => 'ماجد سعد القحطاني',
                'email' => 'majed.qhtani@example.com',
                'phone' => '0516789012',
                'age' => 43,
                'education' => 'بكالوريوس في التسويق',
                'experience' => 'خبرة 14 سنة في المبيعات. عملت كمدير مبيعات لشركة صناعية لمدة 9 سنوات، ومدير مبيعات إقليمي لمدة 5 سنوات. حققت أهداف مبيعات بنسبة 120% سنوياً.',
                'skills' => 'المبيعات، إدارة الفرق، التفاوض، بناء العلاقات، إدارة الحسابات، التخطيط الاستراتيجي',
                'position_id' => $salesManagerId,
                'status' => 'under_review',
                'rating' => 5,
            ],
            [
                'name' => 'ريم خالد الشمري',
                'email' => 'reem.shamri@example.com',
                'phone' => '0517890123',
                'age' => 34,
                'education' => 'بكالوريوس في إدارة الأعمال',
                'experience' => 'خبرة 7 سنوات في المبيعات. عملت كمديرة مبيعات لشركة تجارية لمدة 4 سنوات، ومديرة مبيعات لشركة صغيرة لمدة 3 سنوات.',
                'skills' => 'المبيعات، التسويق، إدارة الفرق، التواصل',
                'position_id' => $salesManagerId,
                'status' => 'under_review',
                'rating' => 3,
            ],
            [
                'name' => 'فهد عبدالله المطيري',
                'email' => 'fahad.mutairi@example.com',
                'phone' => '0518901234',
                'age' => 31,
                'education' => 'بكالوريوس في التسويق',
                'experience' => 'خبرة 6 سنوات في المبيعات. عملت كمدير مبيعات لشركة تقنية لمدة 3 سنوات، ومدير مبيعات لشركة خدمات لمدة 3 سنوات.',
                'skills' => 'المبيعات، التسويق، التواصل، بناء العلاقات',
                'position_id' => $salesManagerId,
                'status' => 'under_review',
                'rating' => 3,
            ],
            [
                'name' => 'هند يوسف العتيبي',
                'email' => 'hind.otaibi@example.com',
                'phone' => '0519012345',
                'age' => 27,
                'education' => 'بكالوريوس في التسويق',
                'experience' => 'خبرة 3 سنوات في المبيعات. عملت كمديرة مبيعات لشركة صغيرة لمدة 3 سنوات.',
                'skills' => 'المبيعات، التسويق، التواصل',
                'position_id' => $salesManagerId,
                'status' => 'rejected',
                'rating' => 2,
            ],
            [
                'name' => 'سالم صالح الغامدي',
                'email' => 'salem.ghamdi@example.com',
                'phone' => '0520123456',
                'age' => 46,
                'education' => 'دبلوم في التجارة',
                'experience' => 'خبرة 16 سنة في المبيعات. عملت كمدير مبيعات لشركة تجارية لمدة 10 سنوات، ومدير مبيعات إقليمي لمدة 6 سنوات.',
                'skills' => 'المبيعات، إدارة الفرق، التفاوض، بناء العلاقات',
                'position_id' => $salesManagerId,
                'status' => 'under_review',
                'rating' => 3,
            ],

            // ========== متقدمون لمنصب مدير تقنية المعلومات (7 متقدمين) ==========
            [
                'name' => 'يوسف أحمد المطيري',
                'email' => 'youssef.mutairi@example.com',
                'phone' => '0521234567',
                'age' => 38,
                'education' => 'بكالوريوس في علوم الحاسب',
                'experience' => 'خبرة 11 سنة في تقنية المعلومات. عملت كمدير تقنية معلومات لشركة تقنية لمدة 6 سنوات، ومدير أنظمة لشركة خدمات لمدة 5 سنوات. خبرة في الأنظمة السحابية والأمن السيبراني.',
                'skills' => 'إدارة البنية التحتية، الأنظمة السحابية، الأمن السيبراني، إدارة المشاريع التقنية، Linux، AWS، Azure',
                'position_id' => $itManagerId,
                'status' => 'accepted',
                'rating' => 5,
            ],
            [
                'name' => 'ريم خالد العتيبي',
                'email' => 'reem.otaibi@example.com',
                'phone' => '0522345678',
                'age' => 34,
                'education' => 'ماجستير في علوم الحاسب',
                'experience' => 'خبرة 8 سنوات في تقنية المعلومات. عملت كمديرة تقنية معلومات لشركة تجارية لمدة 4 سنوات، ومديرة أنظمة لشركة صناعية لمدة 4 سنوات.',
                'skills' => 'إدارة الأنظمة، الأمن السيبراني، إدارة المشاريع، قواعد البيانات، الشبكات',
                'position_id' => $itManagerId,
                'status' => 'under_review',
                'rating' => 4,
            ],
            [
                'name' => 'خالد فهد الدوسري',
                'email' => 'khalid.dosari@example.com',
                'phone' => '0523456789',
                'age' => 41,
                'education' => 'بكالوريوس في علوم الحاسب',
                'experience' => 'خبرة 13 سنة في تقنية المعلومات. عملت كمدير تقنية معلومات لشركة كبيرة لمدة 8 سنوات، ومدير أنظمة لشركة تقنية لمدة 5 سنوات. خبرة في DevOps والأنظمة السحابية.',
                'skills' => 'إدارة البنية التحتية، DevOps، الأنظمة السحابية، الأمن السيبراني، Kubernetes، Docker، AWS',
                'position_id' => $itManagerId,
                'status' => 'under_review',
                'rating' => 5,
            ],
            [
                'name' => 'سارة عبدالرحمن القحطاني',
                'email' => 'sara.qhtani2@example.com',
                'phone' => '0524567890',
                'age' => 32,
                'education' => 'بكالوريوس في علوم الحاسب',
                'experience' => 'خبرة 7 سنوات في تقنية المعلومات. عملت كمديرة أنظمة لشركة تجارية لمدة 4 سنوات، ومديرة تقنية معلومات لشركة صغيرة لمدة 3 سنوات.',
                'skills' => 'إدارة الأنظمة، الشبكات، قواعد البيانات، الأمن السيبراني',
                'position_id' => $itManagerId,
                'status' => 'under_review',
                'rating' => 3,
            ],
            [
                'name' => 'محمد يوسف الشمري',
                'email' => 'mohammed.shamri2@example.com',
                'phone' => '0525678901',
                'age' => 29,
                'education' => 'بكالوريوس في علوم الحاسب',
                'experience' => 'خبرة 5 سنوات في تقنية المعلومات. عملت كمدير أنظمة لشركة تقنية لمدة 3 سنوات، وأخصائي أنظمة لمدة سنتين.',
                'skills' => 'إدارة الأنظمة، الشبكات، قواعد البيانات',
                'position_id' => $itManagerId,
                'status' => 'rejected',
                'rating' => 2,
            ],
            [
                'name' => 'نورا خالد الحربي',
                'email' => 'nora.harbi@example.com',
                'phone' => '0526789012',
                'age' => 36,
                'education' => 'ماجستير في علوم الحاسب - تخصص أمن سيبراني',
                'experience' => 'خبرة 9 سنوات في تقنية المعلومات. عملت كمديرة أمن سيبراني لشركة كبيرة لمدة 5 سنوات، ومديرة أنظمة لشركة تقنية لمدة 4 سنوات.',
                'skills' => 'الأمن السيبراني، إدارة الأنظمة، الشبكات، التحقيق في الحوادث، إدارة المخاطر',
                'position_id' => $itManagerId,
                'status' => 'under_review',
                'rating' => 4,
            ],
            [
                'name' => 'عبدالله سعد المطيري',
                'email' => 'abdullah.mutairi@example.com',
                'phone' => '0527890123',
                'age' => 44,
                'education' => 'دبلوم في تقنية المعلومات',
                'experience' => 'خبرة 15 سنة في تقنية المعلومات. عملت كمدير تقنية معلومات لشركة صناعية لمدة 10 سنوات، ومدير أنظمة لمدة 5 سنوات.',
                'skills' => 'إدارة الأنظمة، الشبكات، قواعد البيانات، إدارة المشاريع',
                'position_id' => $itManagerId,
                'status' => 'under_review',
                'rating' => 3,
            ],

            // ========== متقدمون لمنصب مدير المالية (7 متقدمين) ==========
            [
                'name' => 'عبدالله صالح الغامدي',
                'email' => 'abdullah.ghamdi@example.com',
                'phone' => '0528901234',
                'age' => 41,
                'education' => 'بكالوريوس في المحاسبة - شهادة محاسب قانوني (CPA)',
                'experience' => 'خبرة 13 سنة في المالية والمحاسبة. عملت كمدير مالي لشركة صناعية لمدة 7 سنوات، ومدير محاسبة لشركة خدمات لمدة 6 سنوات. خبرة في إعداد التقارير المالية والتدقيق.',
                'skills' => 'المحاسبة المالية، إعداد التقارير، التدقيق، إدارة الميزانيات، التحليل المالي، ERP Systems',
                'position_id' => $financeManagerId,
                'status' => 'accepted',
                'rating' => 5,
            ],
            [
                'name' => 'لينا فهد الدوسري',
                'email' => 'lina.dosari@example.com',
                'phone' => '0529012345',
                'age' => 33,
                'education' => 'بكالوريوس في المالية',
                'experience' => 'خبرة 8 سنوات في المالية. عملت كمديرة مالية لشركة تجارية لمدة 4 سنوات، ومديرة محاسبة لشركة تقنية لمدة 4 سنوات.',
                'skills' => 'المحاسبة، المالية، إعداد التقارير، التحليل المالي، إدارة الميزانيات',
                'position_id' => $financeManagerId,
                'status' => 'under_review',
                'rating' => 4,
            ],
            [
                'name' => 'فهد عبدالعزيز القحطاني',
                'email' => 'fahad.qhtani@example.com',
                'phone' => '0530123456',
                'age' => 39,
                'education' => 'ماجستير في المالية - شهادة محاسب قانوني (CPA)',
                'experience' => 'خبرة 11 سنة في المالية. عملت كمدير مالي لشركة كبيرة لمدة 6 سنوات، ومدير محاسبة لشركة صناعية لمدة 5 سنوات. خبرة في التحليل المالي والاستثمار.',
                'skills' => 'المحاسبة المالية، التحليل المالي، إعداد التقارير، التدقيق، إدارة الاستثمارات، ERP Systems',
                'position_id' => $financeManagerId,
                'status' => 'under_review',
                'rating' => 5,
            ],
            [
                'name' => 'مريم حسن الشمري',
                'email' => 'mariam.shamri@example.com',
                'phone' => '0531234567',
                'age' => 31,
                'education' => 'بكالوريوس في المحاسبة',
                'experience' => 'خبرة 7 سنوات في المالية. عملت كمديرة محاسبة لشركة تجارية لمدة 4 سنوات، ومديرة مالية لشركة صغيرة لمدة 3 سنوات.',
                'skills' => 'المحاسبة، المالية، إعداد التقارير، التحليل المالي',
                'position_id' => $financeManagerId,
                'status' => 'under_review',
                'rating' => 3,
            ],
            [
                'name' => 'يوسف خالد المطيري',
                'email' => 'youssef.mutairi2@example.com',
                'phone' => '0532345678',
                'age' => 28,
                'education' => 'بكالوريوس في المالية',
                'experience' => 'خبرة 4 سنوات في المالية. عملت كمدير محاسبة لشركة صغيرة لمدة 4 سنوات.',
                'skills' => 'المحاسبة، المالية، إعداد التقارير',
                'position_id' => $financeManagerId,
                'status' => 'rejected',
                'rating' => 2,
            ],
            [
                'name' => 'سارة يوسف العتيبي',
                'email' => 'sara.otaibi@example.com',
                'phone' => '0533456789',
                'age' => 37,
                'education' => 'بكالوريوس في المحاسبة - شهادة محاسب قانوني (CPA)',
                'experience' => 'خبرة 10 سنوات في المالية. عملت كمديرة مالية لشركة تقنية لمدة 5 سنوات، ومديرة محاسبة لشركة خدمات لمدة 5 سنوات.',
                'skills' => 'المحاسبة المالية، إعداد التقارير، التدقيق، إدارة الميزانيات، التحليل المالي',
                'position_id' => $financeManagerId,
                'status' => 'under_review',
                'rating' => 4,
            ],
            [
                'name' => 'عمر صالح الغامدي',
                'email' => 'omar.ghamdi@example.com',
                'phone' => '0534567890',
                'age' => 46,
                'education' => 'دبلوم في المحاسبة',
                'experience' => 'خبرة 17 سنة في المالية. عملت كمدير مالي لشركة صناعية لمدة 11 سنة، ومدير محاسبة لمدة 6 سنوات.',
                'skills' => 'المحاسبة، المالية، إعداد التقارير، إدارة الميزانيات',
                'position_id' => $financeManagerId,
                'status' => 'under_review',
                'rating' => 3,
            ],
        ];

        $created = 0;
        foreach ($applicants as $applicantData) {
            $applicant = Applicant::create($applicantData);

            // حساب النقاط التلقائية
            $score = $scoringService->calculateScore($applicant);
            $applicant->update(['score' => $score]);

            $created++;
        }

        $this->command->info('تم إنشاء ' . $created . ' متقدم بنجاح!');
        $this->command->info('تم حساب النقاط التلقائية لجميع المتقدمين.');
    }
}
