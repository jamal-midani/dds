# بنية قاعدة البيانات

## الجداول

### positions
جدول الوظائف المتاحة

| الحقل | النوع | الوصف |
|------|------|-------|
| id | bigint | المعرف الفريد |
| name | string | اسم الوظيفة |
| description | text | الوصف |
| requirements | text | الشروط |
| status | boolean | الحالة (نشط/غير نشط) |
| created_at | timestamp | تاريخ الإنشاء |
| updated_at | timestamp | تاريخ التحديث |

### applicants
جدول المتقدمين

| الحقل | النوع | الوصف |
|------|------|-------|
| id | bigint | المعرف الفريد |
| name | string | الاسم الكامل |
| email | string | البريد الإلكتروني |
| phone | string | رقم الهاتف |
| age | integer | العمر |
| education | string | المؤهل العلمي |
| experience | text | الخبرات السابقة |
| skills | text | المهارات |
| position_id | foreignId | معرف الوظيفة |
| cv_file | string | مسار ملف السيرة الذاتية |
| status | enum | حالة الطلب (under_review, accepted, rejected) |
| rating | integer | التقييم (1-5) |
| score | decimal | النقاط التلقائية (0-100) |
| gemini_summary | text | ملخص من Gemini AI |
| created_at | timestamp | تاريخ الإنشاء |
| updated_at | timestamp | تاريخ التحديث |

## العلاقات

- `Position` hasMany `Applicant`
- `Applicant` belongsTo `Position`

## الفهارس

- `position_id` على جدول `applicants` (Foreign Key)
- `status` على جدول `positions` (Index)
- `status` على جدول `applicants` (Index)
- `score` على جدول `applicants` (Index)

