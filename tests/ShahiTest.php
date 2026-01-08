<?php

namespace RanjbarAli\ShahiDate\Tests;

use RanjbarAli\ShahiDate\Shahi;
use RanjbarAli\ShahiDate\Facades\Shahi as ShahiFacade;
use Carbon\Carbon;

class ShahiTest extends TestCase
{
    /** @test */
    public function it_can_create_instance_from_now()
    {
        $shahi = new Shahi();

        $this->assertInstanceOf(Shahi::class, $shahi);
        $this->assertIsInt($shahi->year);
        $this->assertIsInt($shahi->month);
        $this->assertIsInt($shahi->day);
    }

    /** @test */
    public function it_can_create_instance_using_helper()
    {
        $shahi = shahi();

        $this->assertInstanceOf(Shahi::class, $shahi);
    }

    /** @test */
    public function it_can_create_instance_using_facade()
    {
        $shahi = ShahiFacade::now();

        $this->assertInstanceOf(Shahi::class, $shahi);
    }

    /** @test */
    public function it_can_create_from_gregorian_date()
    {
        $shahi = Shahi::createFromGregorian(2025, 1, 8);

        $this->assertEquals(2583, $shahi->year);
        $this->assertEquals(10, $shahi->month);
        $this->assertEquals(19, $shahi->day);
    }

    /** @test */
    public function it_can_create_from_shahi_date()
    {
        $shahi = Shahi::create(2537, 10, 18);

        $this->assertEquals(2537, $shahi->year);
        $this->assertEquals(10, $shahi->month);
        $this->assertEquals(18, $shahi->day);
    }

    /** @test */
    public function it_can_convert_to_gregorian()
    {
        $shahi = Shahi::create(2583, 10, 19, 0, 0, 0);
        $gregorian = $shahi->toGregorian();

        $this->assertStringContainsString('2025-01-08', $gregorian);
    }

    /** @test */
    public function it_can_parse_string_date()
    {
        $shahi = Shahi::parse('2537-10-18');

        $this->assertEquals(2537, $shahi->year);
        $this->assertEquals(10, $shahi->month);
        $this->assertEquals(18, $shahi->day);
    }

    /** @test */
    public function it_can_parse_string_date_with_slash()
    {
        $shahi = Shahi::parse('2537/10/18');

        $this->assertEquals(2537, $shahi->year);
        $this->assertEquals(10, $shahi->month);
        $this->assertEquals(18, $shahi->day);
    }

    /** @test */
    public function it_can_format_date()
    {
        $shahi = Shahi::create(2537, 10, 18);

        $this->assertEquals('2537/10/18', $shahi->formatDate());
        $this->assertEquals('2537-10-18', $shahi->format('Y-m-d'));
    }

    /** @test */
    public function it_can_format_with_persian_names()
    {
        $shahi = Shahi::create(2583, 10, 19);

        $formatted = $shahi->format('F');
        $this->assertEquals('دی', $formatted);
    }

    /** @test */
    public function it_can_add_days()
    {
        $shahi = Shahi::create(2537, 10, 18);
        $shahi->addDays(5);

        $this->assertEquals(23, $shahi->day);
    }

    /** @test */
    public function it_can_subtract_days()
    {
        $shahi = Shahi::create(2537, 10, 18);
        $shahi->subDays(5);

        $this->assertEquals(13, $shahi->day);
    }

    /** @test */
    public function it_can_add_months()
    {
        $shahi = Shahi::create(2537, 10, 18);
        $shahi->addMonths(2);

        $this->assertEquals(12, $shahi->month);
    }

    /** @test */
    public function it_can_add_years()
    {
        $shahi = Shahi::create(2537, 10, 18);
        $shahi->addYears(1);

        $this->assertEquals(2538, $shahi->year);
    }

    /** @test */
    public function it_can_get_start_of_day()
    {
        $shahi = Shahi::create(2537, 10, 18, 14, 30, 45);
        $shahi->startDay();

        $this->assertEquals(0, $shahi->hour);
        $this->assertEquals(0, $shahi->minute);
        $this->assertEquals(0, $shahi->second);
    }

    /** @test */
    public function it_can_get_end_of_day()
    {
        $shahi = Shahi::create(2537, 10, 18, 14, 30, 45);
        $shahi->endDay();

        $this->assertEquals(23, $shahi->hour);
        $this->assertEquals(59, $shahi->minute);
        $this->assertEquals(59, $shahi->second);
    }

    /** @test */
    public function it_can_get_start_of_month()
    {
        $shahi = Shahi::create(2537, 10, 18);
        $shahi->startMonth();

        $this->assertEquals(1, $shahi->day);
    }

    /** @test */
    public function it_can_get_end_of_month()
    {
        $shahi = Shahi::create(2537, 10, 18);
        $shahi->endMonth();

        $this->assertEquals(30, $shahi->day);
    }

    /** @test */
    public function it_can_compare_dates()
    {
        $date1 = Shahi::create(2537, 10, 18);
        $date2 = Shahi::create(2537, 11, 1);

        $this->assertTrue($date1->lt($date2));
        $this->assertTrue($date2->gt($date1));
        $this->assertFalse($date1->eq($date2));
    }

    /** @test */
    public function it_can_calculate_diff_in_days()
    {
        $date1 = Shahi::create(2537, 10, 18);
        $date2 = Shahi::create(2537, 10, 28);

        $diff = $date2->diffDays($date1);

        $this->assertEquals(10, $diff);
    }

    /** @test */
    public function it_can_check_leap_year()
    {
        // سال 2537 شاهنشاهی = 1357 جلالی
        $isLeap = Shahi::isLeapYearStatic(2588);

        $this->assertTrue($isLeap);
    }

    /** @test */
    public function it_can_convert_from_carbon()
    {
        $carbon = Carbon::create(2025, 1, 8);
        $shahi = Shahi::fromCarbon($carbon);

        $this->assertEquals(2583, $shahi->year);
        $this->assertEquals(10, $shahi->month);
        $this->assertEquals(19, $shahi->day);
    }

    /** @test */
    public function it_can_convert_to_carbon()
    {
        $shahi = Shahi::create(2583, 10, 19);
        $carbon = $shahi->toCarbon();

        $this->assertInstanceOf(Carbon::class, $carbon);
        $this->assertEquals(2025, $carbon->year);
        $this->assertEquals(1, $carbon->month);
        $this->assertEquals(8, $carbon->day);
    }

    /** @test */
    public function it_can_get_month_name()
    {
        $shahi = Shahi::create(2583, 1, 1);
        $this->assertEquals('فروردین', $shahi->monthName);

        $shahi = Shahi::create(2583, 10, 1);
        $this->assertEquals('دی', $shahi->monthName);
    }

    /** @test */
    public function it_can_get_day_name()
    {
        $shahi = Shahi::create(2583, 10, 19); // چهارشنبه

        $this->assertIsString($shahi->dayName);
        $this->assertContains($shahi->dayName, [
            'یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه',
            'پنج‌شنبه', 'جمعه', 'شنبه'
        ]);
    }

    /** @test */
    public function it_can_get_quarter()
    {
        $shahi = Shahi::create(2537, 1, 1);
        $this->assertEquals(1, $shahi->quarter);

        $shahi = Shahi::create(2537, 10, 1);
        $this->assertEquals(4, $shahi->quarter);
    }

    /** @test */
    public function it_can_copy_instance()
    {
        $shahi1 = Shahi::create(2537, 10, 18);
        $shahi2 = $shahi1->copy();

        $shahi2->addDays(10);

        $this->assertNotEquals($shahi1->day, $shahi2->day);
        $this->assertEquals(18, $shahi1->day);
        $this->assertEquals(28, $shahi2->day);
    }

    /** @test */
    public function it_can_convert_to_array()
    {
        $shahi = Shahi::create(2537, 10, 18, 14, 30, 0);
        $array = $shahi->toArray();

        $this->assertIsArray($array);
        $this->assertArrayHasKey('year', $array);
        $this->assertArrayHasKey('month', $array);
        $this->assertArrayHasKey('day', $array);
    }

    /** @test */
    public function it_can_create_today()
    {
        $today = Shahi::today();

        $this->assertEquals(0, $today->hour);
        $this->assertEquals(0, $today->minute);
        $this->assertEquals(0, $today->second);
    }

    /** @test */
    public function it_can_create_yesterday()
    {
        $yesterday = Shahi::yesterday();
        $today = Shahi::today();

        $this->assertEquals(1, $today->diffDays($yesterday));
    }

    /** @test */
    public function it_can_create_tomorrow()
    {
        $tomorrow = Shahi::tomorrow();
        $today = Shahi::today();

        $this->assertEquals(-1, $today->diffDays($tomorrow));
    }

    /** @test */
    public function it_converts_to_string()
    {
        $shahi = Shahi::create(2537, 10, 18, 14, 30, 45);
        $string = (string) $shahi;

        $this->assertIsString($string);
        $this->assertStringContainsString('2537', $string);
    }

    /** @test */
    public function it_can_be_json_serialized()
    {
        $shahi = Shahi::create(2537, 10, 18, 14, 30, 45);
        $json = json_encode($shahi);

        $this->assertJson($json);
        $this->assertStringContainsString('2537', $json);
    }
}
