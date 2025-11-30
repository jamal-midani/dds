# التصميم

## نمط التصميم (Design Patterns)

### Service Layer Pattern
يتم فصل منطق العمل في Services منفصلة:
- `PositionService`: إدارة الوظائف
- `ApplicantService`: إدارة المتقدمين
- `ScoringService`: حساب النقاط التلقائية
- `GeminiService`: تكامل Gemini AI

### Repository Pattern (اختياري)
يمكن إضافة Repositories لاحقاً لتحسين قابلية الاختبار.

## بنية المشروع

```
app/
├── Filament/
│   └── Resources/          # Filament Admin Resources
├── Http/
│   └── Controllers/        # Controllers
├── Models/                 # Eloquent Models
└── Services/               # Business Logic Layer
    ├── ApplicantService.php
    ├── GeminiService.php
    ├── PositionService.php
    └── ScoringService.php

resources/
├── views/
│   ├── layouts/           # Layout Templates
│   └── public/            # Public Views
└── views/filament/        # Filament Admin Views

database/
└── migrations/            # Database Migrations
```

## الأمان

- CSRF Protection
- Laravel Validation
- File Upload Validation (PDF only, max 5MB)
- Admin Authentication via Filament
- Protected Admin Routes

## الأداء

- Database Indexing
- Eager Loading للعلاقات
- Caching (يمكن إضافته لاحقاً)

