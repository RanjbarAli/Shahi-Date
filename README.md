# Shahi Date - تقویم شاهنشاهی
پکیج لاراول برای تبدیل تاریخ میلادی به شاهنشاهی (Imperial Persian Calendar) و برعکس



[![Latest Version](https://img.shields.io/packagist/v/ranjbarali/shahi-date.svg?style=flat-square)](https://packagist.org/packages/ranjbarali/shahi-date)
[![Total Downloads](https://img.shields.io/packagist/dt/ranjbarali/shahi-date.svg?style=flat-square)](https://packagist.org/packages/ranjbarali/shahi-date)
[![License](https://img.shields.io/packagist/l/ranjbarali/shahi-date.svg?style=flat-square)](https://packagist.org/packages/ranjbarali/shahi-date)


## ویژگی‌ها

- ✅ تبدیل میلادی به شاهنشاهی و برعکس
- ✅ سازگار با Carbon
- ✅ Validation Rules برای فرم‌های لاراول
- ✅ فرمت‌های متنوع تاریخ و زمان
- ✅ محاسبات تاریخ (جمع، تفریق، مقایسه)
- ✅ نام ماه‌ها و روزهای هفته به فارسی
- ✅ پشتیبانی از سال کبیسه
- ✅ سازگار با لاراول 10، 11، 12

## پیش‌نیازها
- PHP >= 8.1  
- Laravel >= 10 (سازگار با Laravel 10، 11 و 12)  
- Composer

## نصب

```bash
composer require ranjbarali/shahi-date
```

پکیج به صورت خودکار در لاراول ثبت می‌شود.

## استفاده سریع

### ایجاد تاریخ

```php
use RanjbarAli\ShahiDate\Facades\Shahi;

// تاریخ فعلی
$date = shahi();
$date = Shahi::now();

// امروز (ساعت 00:00:00)
$date = Shahi::today();

// دیروز و فردا
$date = Shahi::yesterday();
$date = Shahi::tomorrow();

// از تاریخ شاهنشاهی
$date = Shahi::create(2537, 10, 18, 14, 30, 0);

// از تاریخ میلادی
$date = Shahi::createFromGregorian(2025, 1, 8);

// از رشته
$date = Shahi::parse('2537-10-18');
$date = shahi('2537/10/18 14:30:00');
```

### تبدیل به میلادی

```php
$date = shahi();

// رشته میلادی
echo $date->toGregorian(); // 2025-01-08 14:30:00

// آبجکت DateTime
$datetime = $date->toDateTime();

// آبجکت Carbon
$carbon = $date->toCarbon();
```

### تبدیل از میلادی/Carbon

```php
// از Carbon
$carbon = now();
$shahi = Shahi::fromCarbon($carbon);

// از DateTime
$datetime = new DateTime();
$shahi = Shahi::fromDateTime($datetime);

// از Timestamp
$shahi = Shahi::createTimestamp(time());
```

### دریافت مقادیر (Getters)

```php
$date = shahi();

echo $date->year;        // 2537
echo $date->month;       // 10
echo $date->day;         // 18
echo $date->hour;        // 14
echo $date->minute;      // 30
echo $date->second;      // 0

echo $date->monthName;   // دی
echo $date->dayName;     // چهارشنبه
echo $date->dayOfWeek;   // 3
echo $date->dayOfYear;   // 292
echo $date->weekOfYear;  // 42
echo $date->daysInMonth; // 30
echo $date->quarter;     // 4
```

### تنظیم مقادیر (Setters)

```php
$date = shahi();

// تنظیم مستقیم
$date->year = 2538;
$date->month = 1;
$date->day = 15;

// با متد
$date->setDate(2538, 1, 15);
$date->setTime(14, 30, 0);
$date->setDateTime(2538, 1, 15, 14, 30, 0);
```

### فرمت‌دهی

```php
$date = shahi();

// فرمت دلخواه
echo $date->format('Y/m/d');              // 2537/10/18
echo $date->format('Y-m-d H:i:s');        // 2537-10-18 14:30:00

// با کلمات فارسی
echo $date->formatWord('l j F Y');        // چهارشنبه 18 دی 2537

// فرمت‌های از پیش تعریف شده
echo $date->formatDatetime();             // 2537/10/18 14:30:00
echo $date->formatDate();                 // 2537/10/18
echo $date->formatTime();                 // 14:30:00
echo $date->formatJalaliDatetime();       // 2537/10/18 14:30:00
echo $date->formatJalaliDate();           // 2537/10/18
```

#### کاراکترهای فرمت

| کاراکتر | توضیح | مثال |
|---------|-------|------|
| Y | سال چهار رقمی | 2537 |
| y | سال دو رقمی | 37 |
| m | ماه با صفر ابتدا | 01 تا 12 |
| n | ماه بدون صفر | 1 تا 12 |
| d | روز با صفر ابتدا | 01 تا 31 |
| j | روز بدون صفر | 1 تا 31 |
| H | ساعت 24 ساعته | 00 تا 23 |
| i | دقیقه | 00 تا 59 |
| s | ثانیه | 00 تا 59 |
| F | نام کامل ماه | فروردین |
| l | نام کامل روز هفته | یک‌شنبه |

### محاسبات تاریخ

```php
$date = shahi();

// اضافه کردن
$date->addDays(10);
$date->addWeeks(2);
$date->addMonths(3);
$date->addYears(1);

// کم کردن
$date->subDays(5);
$date->subWeeks(1);
$date->subMonths(2);
$date->subYears(1);

// زنجیره‌ای
$date->addMonths(2)->addDays(15)->subYears(1);
```

### مرزبندی‌ها (Boundaries)

```php
$date = shahi();

// شروع و پایان روز
$date->startDay();   // 2537-10-18 00:00:00
$date->endDay();     // 2537-10-18 23:59:59

// شروع و پایان هفته
$date->startWeek();  // اول هفته
$date->endWeek();    // آخر هفته

// شروع و پایان ماه
$date->startMonth(); // اول ماه
$date->endMonth();   // آخر ماه

// شروع و پایان سال
$date->startYear();  // اول سال
$date->endYear();    // آخر سال
```

### مقایسه تاریخ‌ها

```php
$date1 = shahi('2537-10-18');
$date2 = shahi('2537-11-01');

// مقایسه
$date1->gt($date2);   // بزرگتر از (false)
$date1->gte($date2);  // بزرگتر مساوی (false)
$date1->lt($date2);   // کوچکتر از (true)
$date1->lte($date2);  // کوچکتر مساوی (true)
$date1->eq($date2);   // مساوی (false)

// با رشته
$date1->gt('2537-09-01'); // true
```

### محاسبه اختلاف

```php
$date1 = shahi('2537-10-18');
$date2 = shahi('2537-11-01');

// اختلاف روز
echo $date2->diffDays($date1);    // 13

// اختلاف ماه
echo $date2->diffMonths($date1);  // 0

// فرمت انسانی
echo $date1->formatDifference();  // 13 روز قبل
echo $date2->formatDifference($date1); // 13 روز بعد
```

### بررسی سال کبیسه

```php
// بررسی سال
if (Shahi::isLeapYear(2537)) {
    echo 'سال 2537 کبیسه است';
}

// بررسی تاریخ فعلی
$date = shahi();
if ($date->isLeapYear()) {
    echo 'امسال کبیسه است';
}
```

### Validation در Laravel

```php
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'event_date' => 'required|shahi_date',
            'birthdate' => 'shahi_date_before:2520-01-01',
            'start_date' => 'shahi_date_after:today',
            'end_date' => 'shahi_date_after:start_date',
        ]);
    }
}
```

#### قوانین اعتبارسنجی موجود

- `shahi_date` - تاریخ شاهنشاهی معتبر
- `shahi_date_after:date` - بعد از تاریخ مشخص
- `shahi_date_after_equal:date` - بعد یا مساوی تاریخ
- `shahi_date_before:date` - قبل از تاریخ مشخص
- `shahi_date_before_equal:date` - قبل یا مساوی تاریخ
- `shahi_date_equals:date` - برابر با تاریخ

### کپی کردن Instance

```php
$date1 = shahi();
$date2 = $date1->copy();

$date2->addDays(10);

echo $date1->format('Y/m/d'); // تغییر نمی‌کند
echo $date2->format('Y/m/d'); // 10 روز جلوتر
```

## نمونه‌های کاربردی

### نمایش تاریخ در Blade

```blade
<!-- تاریخ امروز -->
<p>امروز: {{ shahi()->format('l j F Y') }}</p>

<!-- تاریخ ایجاد پست -->
<p>تاریخ انتشار: {{ shahi($post->created_at)->formatDate() }}</p>

<!-- چند روز پیش -->
<p>{{ shahi($post->created_at)->formatDifference() }}</p>
```

### ذخیره در دیتابیس

```php
// در Model
protected $casts = [
    'event_date' => 'datetime',
];

// ذخیره
$event = new Event();
$event->title = 'رویداد مهم';
$event->event_date = shahi('2538-01-15')->toDateTime();
$event->save();

// نمایش
$shahiDate = shahi($event->event_date);
echo $shahiDate->format('Y/m/d');
```

### کار با Carbon

```php
// تبدیل Carbon به شاهنشاهی
$carbon = now();
$shahi = Shahi::fromCarbon($carbon);

// تبدیل شاهنشاهی به Carbon
$shahi = shahi();
$carbon = $shahi->toCarbon();

// استفاده ترکیبی
$created = shahi($post->created_at);
$diffInDays = $created->diffDays(shahi());
```

## تفاوت تقویم شاهنشاهی با جلالی

تقویم شاهنشاهی = تقویم جلالی + 1180 سال

- جلالی 1304 = شاهنشاهی 2484
- جلالی 1404 = شاهنشاهی 2584
- جلالی 1400 = شاهنشاهی 2580

## تست

```bash
composer test
```

## مجوز

این پکیج تحت مجوز MIT منتشر شده است. [LICENSE](LICENSE)

## سازنده

**Ali Ranjbar Jelodar**
- Email: info@aliranjbar.ir
- GitHub: [@RanjbarAli](https://github.com/RanjbarAli)

## حمایت

اگر این پکیج برای شما مفید بود، می‌توانید با دادن ⭐ به ریپازیتوری از آن حمایت کنید.

## مشارکت

Pull Request ها و گزارش مشکلات همیشه خوشامد هستند!

1. Fork کنید
2. برنچ feature بسازید (`git checkout -b feature/amazing-feature`)
3. تغییرات را commit کنید (`git commit -m 'Add amazing feature'`)
4. به برنچ push کنید (`git push origin feature/amazing-feature`)
5. Pull Request باز کنید
