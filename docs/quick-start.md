# البدء السريع - نظام دعم اتخاذ القرار للتوظيف

## ⚡ تثبيت سريع (5 دقائق)

### 1. تثبيت التبعيات
```bash
composer install
```

### 2. إعداد البيئة
```bash
cp .env.example .env
php artisan key:generate
```

### 3. تعديل ملف `.env`
```env
DB_DATABASE=dss_database
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. إنشاء قاعدة البيانات
```bash
mysql -u root -p -e "CREATE DATABASE dss_database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 5. تشغيل Migrations والبيانات التجريبية
```bash
php artisan migrate --seed
php artisan storage:link
```

### 6. تشغيل الخادم
```bash
php artisan serve
```

### ✅ جاهز!

- **الموقع**: http://localhost:8000
- **لوحة التحكم**: http://localhost:8000/admin
- **الدخول**: 
  - البريد: `admin@gmail.com`
  - كلمة المرور: `password`

---

## 📖 للمزيد من التفاصيل

- [دليل التثبيت الكامل](installation-guide.md)
- [دليل المستخدم](user-guide.md)

