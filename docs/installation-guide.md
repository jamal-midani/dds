# دليل التثبيت والتشغيل - نظام دعم اتخاذ القرار للتوظيف

## المتطلبات الأساسية

قبل البدء، تأكد من تثبيت المتطلبات التالية:

- **PHP**: 8.2 أو أحدث
- **Composer**: آخر إصدار
- **MySQL**: 5.7 أو أحدث (أو MariaDB 10.3+)
- **Node.js**: 18.x أو أحدث
- **NPM**: 9.x أو أحدث
- **Git**: (اختياري)

### التحقق من المتطلبات

```bash
# التحقق من إصدار PHP
php -v

# التحقق من Composer
composer --version

# التحقق من MySQL
mysql --version

# التحقق من Node.js
node -v

# التحقق من NPM
npm -v
```

---

## خطوات التثبيت

### 1. استنساخ المشروع

```bash
# إذا كان المشروع على Git
git clone <repository-url>
cd DSS

# أو قم بتحميل المشروع وانتقل إلى المجلد
cd /path/to/DSS
```

### 2. تثبيت تبعيات PHP

```bash
composer install
```

**ملاحظة**: إذا واجهت مشاكل في الذاكرة:
```bash
COMPOSER_MEMORY_LIMIT=-1 composer install
```

### 3. إعداد ملف البيئة (.env)

```bash
# نسخ ملف البيئة
cp .env.example .env
```

#### تعديل ملف `.env`:

افتح ملف `.env` وعدّل الإعدادات التالية:

```env
# إعدادات التطبيق
APP_NAME="نظام دعم اتخاذ القرار للتوظيف"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=Asia/Riyadh
APP_URL=http://localhost:8000

# إعدادات قاعدة البيانات
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dss_database
DB_USERNAME=root
DB_PASSWORD=

# إعدادات Gemini AI (اختياري)
GEMINI_API_KEY=your_gemini_api_key_here
```

**ملاحظات مهمة**:
- استبدل `dss_database` باسم قاعدة البيانات الخاصة بك
- استبدل `root` و `DB_PASSWORD` ببيانات قاعدة البيانات الخاصة بك
- للحصول على مفتاح Gemini API: [Google AI Studio](https://makersuite.google.com/app/apikey)

### 4. إنشاء مفتاح التطبيق

```bash
php artisan key:generate
```

### 5. إنشاء قاعدة البيانات

قم بإنشاء قاعدة بيانات جديدة في MySQL:

```sql
CREATE DATABASE dss_database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

أو باستخدام MySQL Command Line:

```bash
mysql -u root -p
CREATE DATABASE dss_database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 6. تشغيل Migrations

```bash
php artisan migrate
```

هذا الأمر سينشئ الجداول التالية:
- `positions`: جدول الوظائف
- `applicants`: جدول المتقدمين
- `users`: جدول المستخدمين (للوحة التحكم)

### 7. ملء قاعدة البيانات ببيانات تجريبية (اختياري)

```bash
php artisan db:seed
```

هذا الأمر سينشئ:
- 5 وظائف تجريبية
- 34 متقدم تجريبي
- مستخدم Admin:
  - البريد: `admin@gmail.com`
  - كلمة المرور: `password`

### 8. تثبيت تبعيات NPM (اختياري)

```bash
npm install
```

**ملاحظة**: إذا لم تقم بتثبيت NPM، سيستخدم النظام TailwindCSS من CDN تلقائياً.

### 9. بناء Assets (اختياري)

```bash
npm run build
```

**ملاحظة**: هذا الأمر اختياري. النظام يعمل بدون بناء Assets باستخدام CDN.

### 10. إنشاء رابط التخزين

```bash
php artisan storage:link
```

هذا الأمر يربط مجلد `storage/app/public` بـ `public/storage` لرفع ملفات السيرة الذاتية.

---

## تشغيل المشروع

### 1. تشغيل خادم التطوير

```bash
php artisan serve
```

سيتم تشغيل الخادم على: `http://localhost:8000`

### 2. الوصول إلى الموقع

- **الموقع العام**: http://localhost:8000
- **لوحة التحكم**: http://localhost:8000/admin

---

## إعدادات إضافية

### إعدادات Filament (لوحة التحكم)

لوحة التحكم جاهزة للاستخدام. لا حاجة لإعدادات إضافية.

### إعدادات Gemini AI

1. احصل على مفتاح API من [Google AI Studio](https://makersuite.google.com/app/apikey)
2. أضف المفتاح في ملف `.env`:
   ```env
   GEMINI_API_KEY=your_api_key_here
   ```
3. بدون المفتاح، سيعمل النظام لكن بدون ميزات Gemini AI

### إعدادات البريد الإلكتروني (اختياري)

إذا أردت إرسال إشعارات بريدية، أضف في `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

## حل المشاكل الشائعة

### 1. خطأ "Class not found"

```bash
composer dump-autoload
```

### 2. خطأ في قاعدة البيانات

- تأكد من تشغيل MySQL
- تحقق من بيانات الاتصال في `.env`
- تأكد من إنشاء قاعدة البيانات

### 3. خطأ في الصلاحيات

```bash
# على Linux/Mac
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# على Windows (عادة لا حاجة)
```

### 4. خطأ "Vite manifest not found"

هذا طبيعي إذا لم تقم ببناء Assets. النظام يستخدم CDN تلقائياً.

### 5. خطأ في Gemini API

- تأكد من صحة المفتاح في `.env`
- تحقق من اتصالك بالإنترنت
- بدون المفتاح، سيعمل النظام لكن بدون ميزات AI

### 6. مشاكل في الذاكرة

```bash
# زيادة حد الذاكرة في php.ini
memory_limit = 512M

# أو في سطر الأوامر
php -d memory_limit=512M artisan migrate
```

---

## إعادة تعيين قاعدة البيانات

إذا أردت حذف جميع البيانات والبدء من جديد:

```bash
php artisan migrate:fresh --seed
```

**تحذير**: هذا الأمر سيحذف جميع البيانات الموجودة!

---

## التحديثات

### تحديث التبعيات

```bash
composer update
npm update
```

### تحديث قاعدة البيانات

```bash
php artisan migrate
```

---

## الإنتاج (Production)

### 1. تغيير إعدادات `.env`

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

### 2. تحسين الأداء

```bash
# تحسين التلقائي
php artisan optimize

# مسح الكاش
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 3. بناء Assets للإنتاج

```bash
npm run build
```

### 4. إعداد Web Server

استخدم Apache أو Nginx مع PHP-FPM. راجع [Laravel Deployment](https://laravel.com/docs/deployment) للتفاصيل.

---

## الأوامر المفيدة

```bash
# عرض جميع الأوامر المتاحة
php artisan list

# مسح الكاش
php artisan cache:clear

# إعادة تحميل التكوين
php artisan config:clear

# عرض معلومات Laravel
php artisan about

# إنشاء مستخدم Filament جديد
php artisan make:filament-user

# تشغيل الخادم على منفذ محدد
php artisan serve --port=8080
```

---

## البنية الأساسية للمشروع

```
DSS/
├── app/
│   ├── Filament/              # لوحة التحكم Filament
│   │   ├── Pages/             # صفحات مخصصة
│   │   ├── Resources/         # موارد (الوظائف، المتقدمين)
│   │   └── Widgets/           # Widgets للإحصائيات
│   ├── Http/
│   │   └── Controllers/       # Controllers
│   ├── Models/                # Models
│   └── Services/              # Service Layer
├── database/
│   ├── migrations/            # Migrations
│   └── seeders/               # Seeders
├── resources/
│   └── views/                 # Views
├── routes/
│   └── web.php               # Routes
├── .env                      # ملف البيئة
└── composer.json             # تبعيات PHP
```

---

## الدعم والمساعدة

إذا واجهت أي مشاكل:

1. راجع هذا الدليل
2. تحقق من [Laravel Documentation](https://laravel.com/docs)
3. تحقق من [Filament Documentation](https://filamentphp.com/docs)

---

**آخر تحديث**: {{ date('Y-m-d') }}


