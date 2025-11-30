# كيفية تسجيل الدخول إلى لوحة التحكم (Admin Panel)

## الطريقة 1: استخدام المستخدم الموجود (من Seeder)

إذا قمت بتشغيل `php artisan db:seed`، تم إنشاء مستخدم Admin تلقائياً:

**بيانات الدخول:**
- **البريد الإلكتروني**: `admin@example.com`
- **كلمة المرور**: `password`

**خطوات الدخول:**
1. افتح المتصفح واذهب إلى: `http://localhost:8000/admin`
2. أدخل البريد الإلكتروني: `admin@example.com`
3. أدخل كلمة المرور: `password`
4. اضغط على "تسجيل الدخول"

## الطريقة 2: إنشاء مستخدم جديد باستخدام Filament Command

يمكنك إنشاء مستخدم Admin جديد باستخدام الأمر التالي:

```bash
php artisan make:filament-user
```

سيطلب منك:
- الاسم (Name)
- البريد الإلكتروني (Email)
- كلمة المرور (Password)

## الطريقة 3: إنشاء مستخدم يدوياً

يمكنك إنشاء مستخدم يدوياً باستخدام Tinker:

```bash
php artisan tinker
```

ثم:

```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'name' => 'Your Name',
    'email' => 'your-email@example.com',
    'password' => Hash::make('your-password'),
    'email_verified_at' => now(),
]);
```

## الطريقة 4: تحديث كلمة مرور مستخدم موجود

إذا نسيت كلمة المرور، يمكنك تحديثها:

```bash
php artisan tinker
```

ثم:

```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::where('email', 'admin@example.com')->first();
$user->password = Hash::make('new-password');
$user->save();
```

## ملاحظات أمنية

⚠️ **مهم**: في بيئة الإنتاج:
1. قم بتغيير كلمة المرور الافتراضية فوراً
2. استخدم كلمة مرور قوية
3. لا تشارك بيانات الدخول
4. قم بتفعيل المصادقة الثنائية (2FA) إذا كان متاحاً

## استكشاف الأخطاء

### لا يمكن تسجيل الدخول
1. تأكد من تشغيل `php artisan migrate` و `php artisan db:seed`
2. تأكد من وجود المستخدم في قاعدة البيانات:
   ```bash
   php artisan tinker
   User::where('email', 'admin@example.com')->first();
   ```
3. تأكد من أن كلمة المرور صحيحة

### صفحة تسجيل الدخول لا تظهر
1. تأكد من أن Filament مثبت بشكل صحيح
2. تأكد من أن المسار `/admin` متاح
3. امسح الكاش:
   ```bash
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```



