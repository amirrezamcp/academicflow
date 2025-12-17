## 📥 نصب و اجرا

### 1️⃣ کلون کردن پروژه
```bash
git clone https://github.com/amirrezamcp/academicflow.git
```

### 2️⃣ نصب وابستگی‌ها
```bash
composer install
npm install
```

### 3️⃣ ساخت فایل env.
```bash
cp .env.example .env
```

### 4️⃣ تنظیمات دیتابیس  
داخل فایل `.env` این بخش را ویرایش کنید:

```
DB_DATABASE=university
DB_USERNAME=root
DB_PASSWORD=
```

### 5️⃣ ساخت کلید اپلیکیشن
```bash
php artisan key:generate
```

### 6️⃣ اجرای مایگریشن + سیدر (اختیاری)
```bash
php artisan migrate --seed
```

### 7️⃣ ساخت استایل (اگر Tailwind فعال است)
```bash
npm run dev
```

### 8️⃣ اجرای پروژه
```bash
php artisan serve
```

پروژه در آدرس زیر قابل دسترس است:

```
http://127.0.0.1:8000
```
