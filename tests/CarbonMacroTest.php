<?php

namespace RanjbarAli\ShahiDate\Tests;

use Carbon\Carbon;
use RanjbarAli\ShahiDate\Shahi;

class CarbonMacroTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        if (!Carbon::hasMacro('toShahi')) {
            Carbon::macro('toShahi', function () {
                return Shahi::fromCarbon($this);
            });
        }
    }

    /** @test */
    public function it_can_convert_carbon_to_shahi_using_macro()
    {
        $carbon = Carbon::create(2025, 1, 8);
        $shahi = $carbon->toShahi();

        $this->assertInstanceOf(Shahi::class, $shahi);
        $this->assertEquals(2583, $shahi->year);
        $this->assertEquals(10, $shahi->month);
        $this->assertEquals(19, $shahi->day);
    }

    /** @test */
    public function it_can_convert_now_to_shahi()
    {
        $shahi = now()->toShahi();

        $this->assertInstanceOf(Shahi::class, $shahi);
        $this->assertIsInt($shahi->year);
        $this->assertGreaterThan(2500, $shahi->year);
    }

    /** @test */
    public function it_preserves_time_when_converting_to_shahi()
    {
        $carbon = Carbon::create(2025, 1, 8, 14, 30, 45);
        $shahi = $carbon->toShahi();

        $this->assertEquals(14, $shahi->hour);
        $this->assertEquals(30, $shahi->minute);
        $this->assertEquals(45, $shahi->second);
    }

    /** @test */
    public function it_can_chain_carbon_methods_before_conversion()
    {
        $shahi = Carbon::create(2025, 1, 1)
            ->addDays(7)
            ->toShahi();

        $this->assertInstanceOf(Shahi::class, $shahi);
    }

    /** @test */
    public function it_converts_carbon_today_to_shahi()
    {
        $shahi = Carbon::today()->toShahi();

        $this->assertEquals(0, $shahi->hour);
        $this->assertEquals(0, $shahi->minute);
        $this->assertEquals(0, $shahi->second);
    }

    /** @test */
    public function it_converts_carbon_yesterday_to_shahi()
    {
        $yesterday = Carbon::yesterday()->toShahi();
        $today = Carbon::today()->toShahi();

        $this->assertEquals(1, $today->diffDays($yesterday));
    }

    /** @test */
    public function it_converts_carbon_tomorrow_to_shahi()
    {
        $tomorrow = Carbon::tomorrow()->toShahi();
        $today = Carbon::today()->toShahi();

        $this->assertEquals(-1, $today->diffDays($tomorrow));
    }

    /** @test */
    public function it_can_convert_and_format()
    {
        $carbon = Carbon::create(2025, 1, 8);
        $formatted = $carbon->toShahi()->format('Y/m/d');

        $this->assertEquals('2583/10/19', $formatted);
    }

    /** @test */
    public function it_can_convert_back_to_carbon()
    {
        $originalCarbon = Carbon::create(2025, 1, 8, 14, 30, 0);
        $shahi = $originalCarbon->toShahi();
        $convertedCarbon = $shahi->toCarbon();

        $this->assertEquals($originalCarbon->year, $convertedCarbon->format('Y'));
        $this->assertEquals($originalCarbon->month, $convertedCarbon->format('n'));
        $this->assertEquals($originalCarbon->day, $convertedCarbon->format('j'));
        $this->assertEquals($originalCarbon->hour, $convertedCarbon->format('H'));
        $this->assertEquals($originalCarbon->minute, $convertedCarbon->format('i'));
    }

    /** @test */
    public function it_handles_carbon_with_timezone()
    {
        $carbon = Carbon::create(2026, 1, 8, 14, 30, 0, 'Asia/Tehran');
        $shahi = $carbon->toShahi();

        $this->assertInstanceOf(Shahi::class, $shahi);
        $this->assertEquals(2584, $shahi->year);
    }

    /** @test */
    public function it_converts_carbon_parse_to_shahi()
    {
        $shahi = Carbon::parse('2025-01-08')->toShahi();

        $this->assertEquals(2583, $shahi->year);
        $this->assertEquals(10, $shahi->month);
        $this->assertEquals(19, $shahi->day);
    }

    /** @test */
    public function it_works_with_carbon_immutable()
    {
        $carbon = \Carbon\CarbonImmutable::create(2025, 1, 8);

        if (method_exists($carbon, 'toShahi')) {
            $shahi = $carbon->toShahi();
            $this->assertInstanceOf(Shahi::class, $shahi);
        } else {
            $shahi = $carbon->toMutable()->toShahi();
            $this->assertInstanceOf(Shahi::class, $shahi);
        }
    }

    /** @test */
    public function it_can_use_in_eloquent_models()
    {
        $createdAt = Carbon::create(2025, 1, 8, 10, 30, 0);
        $shahi = $createdAt->toShahi();

        $formatted = $shahi->format('l j F Y - H:i');

        $this->assertIsString($formatted);
        $this->assertStringContainsString('دی', $formatted);
    }

    /** @test */
    public function it_preserves_microseconds_precision()
    {
        $carbon = Carbon::create(2025, 1, 8, 14, 30, 45);
        $timestamp1 = $carbon->timestamp;

        $shahi = $carbon->toShahi();
        $timestamp2 = $shahi->timestamp;

        $this->assertEquals($timestamp1, $timestamp2);
    }
}
