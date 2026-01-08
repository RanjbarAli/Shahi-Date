<?php

namespace RanjbarAli\ShahiDate;

use Carbon\Carbon;
use DateTime;
use JsonSerializable;

class Shahi implements JsonSerializable
{
    const IMPERIAL_OFFSET = 1180;

    protected int $year;
    protected int $month;
    protected int $day;
    protected int $hour;
    protected int $minute;
    protected int $second;
    protected int $timestamp;
    protected string $timezone;

    protected static array $monthNames = [
        1 => 'فروردین',
        2 => 'اردیبهشت',
        3 => 'خرداد',
        4 => 'تیر',
        5 => 'مرداد',
        6 => 'شهریور',
        7 => 'مهر',
        8 => 'آبان',
        9 => 'آذر',
        10 => 'دی',
        11 => 'بهمن',
        12 => 'اسفند',
    ];

    protected static array $weekDays = [
        0 => 'شنبه',
        1 => 'یک‌شنبه',
        2 => 'دوشنبه',
        3 => 'سه‌شنبه',
        4 => 'چهارشنبه',
        5 => 'پنج‌شنبه',
        6 => 'جمعه',
    ];

    public function __construct($datetime = null, ?string $timezone = null)
    {
        $this->timezone = $timezone ?? date_default_timezone_get();
        if ($datetime === null) {
            $datetime = 'now';
        }
        if (is_numeric($datetime)) {
            $this->timestamp = (int) $datetime;
            $this->setFromTimestamp($this->timestamp);
        } elseif ($datetime instanceof DateTime) {
            $this->timestamp = $datetime->getTimestamp();
            $this->setFromTimestamp($this->timestamp);
        } elseif ($datetime instanceof Carbon) {
            $this->timestamp = $datetime->timestamp;
            $this->setFromTimestamp($this->timestamp);
        } else {
            $this->parseInstance($datetime);
        }
    }

    public static function now(?string $timezone = null): self
    {
        return new static('now', $timezone);
    }

    public static function today(?string $timezone = null): self
    {
        return static::now($timezone)->setTime(0, 0, 0);
    }

    public static function tomorrow(?string $timezone = null): self
    {
        return static::today($timezone)->addDays(1);
    }

    public static function yesterday(?string $timezone = null): self
    {
        return static::today($timezone)->subDays(1);
    }

    public static function create(int $year, int $month = 1, int $day = 1, int $hour = 0, int $minute = 0, int $second = 0): self
    {
        $instance = new static();
        $instance->year = $year;
        $instance->month = $month;
        $instance->day = $day;
        $instance->hour = $hour;
        $instance->minute = $minute;
        $instance->second = $second;
        $instance->updateTimestamp();
        return $instance;
    }

    public static function createFromGregorian(int $gy, int $gm, int $gd, int $hour = 0, int $minute = 0, int $second = 0): self
    {
        [$jy, $jm, $jd] = self::gregorianToShahi($gy, $gm, $gd);
        return (new static())->setDateTime($jy + self::IMPERIAL_OFFSET, $jm, $jd, $hour, $minute, $second);
    }

    protected static function gregorianToShahi(int $gy, int $gm, int $gd): array
    {
        $g_d_m = [0,31,59,90,120,151,181,212,243,273,304,334];
        if($gy > 1600){
            $jy=979;
            $gy-=1600;
        }else{
            $jy=0;
            $gy-=621;
        }
        $gy2=($gm>2)?($gy+1):$gy;
        $days=(365*$gy) + ((int)(($gy2+3)/4)) - ((int)(($gy2+99)/100)) + ((int)(($gy2+399)/400)) - 80 + $gd + $g_d_m[$gm-1];
        $jy+=33*(int)($days/12053);
        $days%=12053;
        $jy+=4*(int)($days/1461);
        $days%=1461;
        if($days>365){
            $jy+=(int)(($days-1)/365);
            $days=($days-1)%365;
        }
        if($days<186){
            $jm=1+(int)($days/31);
            $jd=1+($days%31);
        }else{
            $jm=7+(int)(($days-186)/30);
            $jd=1+(($days-186)%30);
        }
        return [$jy,$jm,$jd];
    }

    public static function createTimestamp(int $timestamp): self
    {
        return new static($timestamp);
    }

    public static function fromCarbon(Carbon $carbon): self
    {
        return new static($carbon->timestamp);
    }

    public static function fromDateTime(DateTime $datetime): self
    {
        return new static($datetime->getTimestamp());
    }

    public static function parse($datetime, ?string $timezone = null): self
    {
        $instance = new static();
        $instance->parseInstance($datetime);
        return $instance;
    }

    protected function parseInstance($datetime): void
    {
        if (preg_match('/^(\d{4})[\/\-](\d{1,2})[\/\-](\d{1,2})$/', $datetime, $matches)) {
            $this->year = (int)$matches[1];
            $this->month = (int)$matches[2];
            $this->day = (int)$matches[3];
            $this->hour = 0;
            $this->minute = 0;
            $this->second = 0;
            $this->updateTimestamp();
        } else {
            $dt = new DateTime($datetime);
            [$jy,$jm,$jd] = self::gregorianToShahi((int)$dt->format('Y'), (int)$dt->format('m'), (int)$dt->format('d'));
            $this->year = $jy + self::IMPERIAL_OFFSET;
            $this->month = $jm;
            $this->day = $jd;
            $this->hour = (int)$dt->format('H');
            $this->minute = (int)$dt->format('i');
            $this->second = (int)$dt->format('s');
            $this->updateTimestamp();
        }
    }

    protected function setFromTimestamp(int $timestamp): void
    {
        $dt = new DateTime();
        $dt->setTimestamp($timestamp);
        [$jy,$jm,$jd] = self::gregorianToShahi((int)$dt->format('Y'), (int)$dt->format('m'), (int)$dt->format('d'));
        $this->year = $jy + self::IMPERIAL_OFFSET;
        $this->month = $jm;
        $this->day = $jd;
        $this->hour = (int)$dt->format('H');
        $this->minute = (int)$dt->format('i');
        $this->second = (int)$dt->format('s');
        $this->timestamp = $timestamp;
    }

    protected function updateTimestamp(): void
    {
        [$gy, $gm, $gd] = $this->imperialToGregorian($this->year, $this->month, $this->day);
        $this->timestamp = mktime($this->hour, $this->minute, $this->second, $gm, $gd, $gy);
    }

    protected function imperialToGregorian(int $iy, int $im, int $id): array
    {
        $jy = $iy - self::IMPERIAL_OFFSET;
        return $this->jalaliToGregorian($jy, $im, $id);
    }

    protected function gregorianToImperial(int $gy, int $gm, int $gd): array
    {
        [$jy,$jm,$jd] = $this->gregorianToJalali($gy,$gm,$gd);
        return [$jy+self::IMPERIAL_OFFSET,$jm,$jd];
    }

    protected function gregorianToJalali(int $gy, int $gm, int $gd): array
    {
        $gDaysInMonth = [31,28,31,30,31,30,31,31,30,31,30,31];
        $jDaysInMonth = [31,31,31,31,31,31,30,30,30,30,30,29];
        $gy-=1600;$gm-=1;$gd-=1;
        $gDayNo=365*$gy+intdiv($gy+3,4)-intdiv($gy+99,100)+intdiv($gy+399,400);
        for($i=0;$i<$gm;$i++)$gDayNo+=$gDaysInMonth[$i];
        if($gm>1&&($gy%4==0&&$gy%100!=0||$gy%400==0))$gDayNo++;
        $gDayNo+=$gd;
        $jDayNo=$gDayNo-79;
        $jNp=intdiv($jDayNo,12053);
        $jDayNo=$jDayNo%12053;
        $jy=979+33*$jNp+4*intdiv($jDayNo,1461);
        $jDayNo=$jDayNo%1461;
        if($jDayNo>=366){$jy+=intdiv($jDayNo-1,365);$jDayNo=($jDayNo-1)%365;}
        if($jDayNo<186){$jm=1+intdiv($jDayNo,31);$jd=1+($jDayNo%31);}
        else{$jm=7+intdiv($jDayNo-186,30);$jd=1+(($jDayNo-186)%30);}
        return [$jy,$jm,$jd];
    }

    protected function jalaliToGregorian(int $jy,int $jm,int $jd): array
    {
        $gDaysInMonth=[31,28,31,30,31,30,31,31,30,31,30,31];
        $jDaysInMonth=[31,31,31,31,31,31,30,30,30,30,30,29];
        $jy-=979;$jm-=1;$jd-=1;
        $jDayNo=365*$jy+intdiv($jy,33)*8+intdiv($jy%33+3,4);
        for($i=0;$i<$jm;$i++)$jDayNo+=$jDaysInMonth[$i];
        $jDayNo+=$jd;
        $gDayNo=$jDayNo+79;
        $gy=1600+400*intdiv($gDayNo,146097);$gDayNo=$gDayNo%146097;
        $leap=true;
        if($gDayNo>=36525){$gDayNo--; $gy+=100*intdiv($gDayNo,36524); $gDayNo=$gDayNo%36524; if($gDayNo>=365)$gDayNo++; $leap=false;}
        $gy+=4*intdiv($gDayNo,1461);$gDayNo=$gDayNo%1461;
        if($gDayNo>=366){$leap=false;$gDayNo--; $gy+=intdiv($gDayNo,365); $gDayNo=$gDayNo%365;}
        for($i=0;$gDayNo>=$gDaysInMonth[$i]+($i==1&&$leap);$i++)$gDayNo-=$gDaysInMonth[$i]+($i==1&&$leap);
        $gm=$i+1;$gd=$gDayNo+1;
        return [$gy,$gm,$gd];
    }

    public function __get(string $name)
    {
        return match($name){
            'year'=>$this->year,
            'month'=>$this->month,
            'day'=>$this->day,
            'hour'=>$this->hour,
            'minute'=>$this->minute,
            'second'=>$this->second,
            'timestamp'=>$this->timestamp,
            'dayOfWeek'=>($this->timestamp>0)?(int) date('w',$this->timestamp):0,
            'dayOfYear'=> $this->diffDays(static::create($this->year,1,1))+1,
            'weekOfYear'=> (int) ceil(($this->diffDays(static::create($this->year,1,1))+1)/7),
            'daysInMonth'=> $this->getDaysInMonth($this->year,$this->month),
            'monthName'=> self::$monthNames[$this->month],
            'dayName'=> self::$weekDays[$this->dayOfWeek],
            'quarter'=> (int) ceil($this->month/3),
            default=>null
        };
    }

    public function __set(string $name,$value): void
    {
        if(in_array($name,['year','month','day','hour','minute','second'])){
            $this->$name=(int)$value;
            $this->updateTimestamp();
        }
    }

    public function startDay(): self
{
    return $this->setTime(0, 0, 0);
}

public function endDay(): self
{
    return $this->setTime(23, 59, 59);
}

public function startMonth(): self
{
    return $this->setDate($this->year, $this->month, 1)->startDay();
}

public function endMonth(): self
{
    return $this->setDate($this->year, $this->month, $this->getDaysInMonth($this->year, $this->month))->endDay();
}

public function lt(self $other): bool
{
    return $this->timestamp < $other->timestamp;
}

public function lte(self $other): bool
{
    return $this->timestamp <= $other->timestamp;
}

public function gt(self $other): bool
{
    return $this->timestamp > $other->timestamp;
}

public function gte(self $other): bool
{
    return $this->timestamp >= $other->timestamp;
}

public function between(self $start, self $end): bool
{
    return $this->timestamp >= $start->timestamp && $this->timestamp <= $end->timestamp;
}

public function copy(): self
{
    return clone $this;
}

public function toArray(): array
{
    return [
        'year' => $this->year,
        'month' => $this->month,
        'day' => $this->day,
        'hour' => $this->hour,
        'minute' => $this->minute,
        'second' => $this->second,
        'timestamp' => $this->timestamp,
        'timezone' => $this->timezone,
    ];
}

public function formatDifference(?self $other = null, string $unit = 'days'): int
{
    $other ??= self::now();
    return match($unit){
        'days'=>intdiv($this->timestamp - $other->timestamp, 86400),
        'hours'=>intdiv($this->timestamp - $other->timestamp, 3600),
        'minutes'=>intdiv($this->timestamp - $other->timestamp, 60),
        'seconds'=> $this->timestamp - $other->timestamp,
        default=>intdiv($this->timestamp - $other->timestamp, 86400),
    };
}

    protected function getDaysInMonth(int $year,int $month): int
    {
        if($month<=6)return 31;
        if($month<=11)return 30;
        return $this->isLeapYear($year)?30:29;
    }

    public function isLeapYear(?int $year=null): bool
    {
        return self::isLeapYearStatic($year??$this->year);
    }

    public function eq(Shahi $date): bool
    {
        return $date->year === $this->year
            && $date->month === $this->month
            && $date->day === $this->day;
    }

    public static function isLeapYearStatic(int $year): bool
    {
        $jy=$year-self::IMPERIAL_OFFSET;
        return ((($jy-474)%2820+474+38)*682)%2816<682;
    }

    public function __toString(): string{return $this->formatDatetime();}
    public function jsonSerialize(): string{return $this->formatDatetime();}
    public function setTime(int $h,int $m,int $s=0): self{$this->hour=$h;$this->minute=$m;$this->second=$s;$this->updateTimestamp();return $this;}
    public function setDate(int $y,int $m,int $d): self{$this->year=$y;$this->month=$m;$this->day=$d;$this->updateTimestamp();return $this;}
    public function setDateTime(int $y,int $m,int $d,int $h=0,int $min=0,int $s=0): self{$this->year=$y;$this->month=$m;$this->day=$d;$this->hour=$h;$this->minute=$min;$this->second=$s;$this->updateTimestamp();return $this;}
    public function format(string $f): string
    {
        $map=[
            'Y'=>$this->year,'y'=>substr((string)$this->year,-2),
            'm'=>str_pad((string)$this->month,2,'0',STR_PAD_LEFT),'n'=>$this->month,
            'd'=>str_pad((string)$this->day,2,'0',STR_PAD_LEFT),'j'=>$this->day,
            'H'=>str_pad((string)$this->hour,2,'0',STR_PAD_LEFT),
            'i'=>str_pad((string)$this->minute,2,'0',STR_PAD_LEFT),
            's'=>str_pad((string)$this->second,2,'0',STR_PAD_LEFT),
            'F'=>self::$monthNames[$this->month],
            'l'=>self::$weekDays[$this->dayOfWeek]
        ];
        return str_replace(array_keys($map),array_values($map),$f);
    }

    public function formatWord(string $f): string{return $this->format($f);}
    public function formatDatetime(): string{return $this->format('Y/m/d H:i:s');}
    public function formatDate(): string{return $this->format('Y/m/d');}
    public function formatTime(): string{return $this->format('H:i:s');}
    public function formatJalaliDatetime(): string{return $this->formatDatetime();}
    public function formatJalaliDate(): string{return $this->formatDate();}
    public function toGregorian(): string{return date('Y-m-d H:i:s',$this->timestamp);}
    public function toDateTime(): DateTime{$dt=new DateTime();$dt->setTimestamp($this->timestamp);return $dt;}
    public function toCarbon(): Carbon{return Carbon::createFromTimestamp($this->timestamp);}
    public function getTimestamp(): int{return $this->timestamp;}

    public function addDays(int $d): self{$this->timestamp+=$d*86400;$this->setFromTimestamp($this->timestamp);return $this;}
    public function subDay(): self{return $this->addDays(-1);}
    public function subDays(int $d): self{return $this->addDays(-$d);}
    public function addDay(): self{return $this->addDays(1);}
    public function addWeeks(int $w): self{return $this->addDays($w*7);}
    public function addWeek(): self{return $this->addDays(7);}
    public function subWeeks(int $w): self{return $this->addWeeks(-$w);}
    public function subWeek(): self{return $this->addWeeks(-7);}
    public function addMonths(int $m): self{$this->month+=$m;while($this->month>12){$this->month-=12;$this->year++;}while($this->month<1){$this->month+=12;$this->year--;}if($this->day>$this->getDaysInMonth($this->year,$this->month))$this->day=$this->getDaysInMonth($this->year,$this->month);$this->updateTimestamp();return $this;}
    public function addMonth(): self{return $this->addMonths(1);}
    public function subMonths(int $m): self{return $this->addMonths(-$m);}
    public function subMonth(): self{return $this->addMonths(-1);}
    public function addYears(int $y): self{$this->year+=$y;$this->updateTimestamp();return $this;}
    public function addYear(): self{return $this->addYears(1);}
    public function subYears(int $y): self{return $this->addYears(-$y);}
    public function subYear(): self{return $this->addYears(-1);}
    public function addHours(int $h): self{$this->timestamp+=$h*3600;$this->setFromTimestamp($this->timestamp);return $this;}
    public function addHour(): self{return $this->addHours(1);}
    public function subHours(int $h): self{return $this->addHours(-$h);}
    public function subHour(): self{return $this->addHours(-1);}
    public function addMinutes(int $m): self{$this->timestamp+=$m*60;$this->setFromTimestamp($this->timestamp);return $this;}
    public function addMinute(): self{return $this->addMinutes(1);}
    public function subMinutes(int $m): self{return $this->addMinutes(-$m);}
    public function subMinute(): self{return $this->addMinutes(-1);}
    public function addSeconds(int $s): self{$this->timestamp+=$s;$this->setFromTimestamp($this->timestamp);return $this;}
    public function addSecond(): self{return $this->addSeconds(1);}
    public function subSeconds(int $s): self{return $this->addSeconds(-$s);}
    public function subSecond(): self{return $this->addSeconds(-1);}
    public function diffDays(self $other): int{return (int)floor(($this->timestamp-$other->timestamp)/86400);}
}
