<?php

namespace RanjbarAli\ShahiDate\Tests;

use Illuminate\Support\Facades\Validator;

class ValidationTest extends TestCase
{
    /** @test */
    public function it_validates_shahi_date_format()
    {
        $validator = Validator::make(
            ['date' => '2537-10-18'],
            ['date' => 'shahi_date']
        );

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function it_fails_invalid_shahi_date_format()
    {
        $validator = Validator::make(
            ['date' => '2537-13-18'], // invalid month
            ['date' => 'shahi_date']
        );

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function it_fails_invalid_day_in_month()
    {
        $validator = Validator::make(
            ['date' => '2537-10-32'], // day 32 doesn't exist
            ['date' => 'shahi_date']
        );

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function it_validates_date_after()
    {
        $validator = Validator::make(
            ['date' => '2537-11-01'],
            ['date' => 'shahi_date_after:2537-10-01']
        );

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function it_fails_date_after_validation()
    {
        $validator = Validator::make(
            ['date' => '2537-10-01'],
            ['date' => 'shahi_date_after:2537-11-01']
        );

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function it_validates_date_after_with_today()
    {
        $tomorrow = shahi()->addDays(1)->formatDate();

        $validator = Validator::make(
            ['date' => $tomorrow],
            ['date' => 'shahi_date_after:today']
        );

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function it_validates_date_after_equal()
    {
        $validator = Validator::make(
            ['date' => '2537-10-18'],
            ['date' => 'shahi_date_after_equal:2537-10-18']
        );

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function it_validates_date_before()
    {
        $validator = Validator::make(
            ['date' => '2537-10-01'],
            ['date' => 'shahi_date_before:2537-11-01']
        );

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function it_fails_date_before_validation()
    {
        $validator = Validator::make(
            ['date' => '2537-11-01'],
            ['date' => 'shahi_date_before:2537-10-01']
        );

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function it_validates_date_before_equal()
    {
        $validator = Validator::make(
            ['date' => '2537-10-18'],
            ['date' => 'shahi_date_before_equal:2537-10-18']
        );

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function it_validates_date_equals()
    {
        $validator = Validator::make(
            ['date' => '2537-10-18'],
            ['date' => 'shahi_date_equals:2537-10-18']
        );

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function it_fails_date_equals_validation()
    {
        $validator = Validator::make(
            ['date' => '2537-10-18'],
            ['date' => 'shahi_date_equals:2537-10-19']
        );

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function it_validates_date_between()
    {
        $validator = Validator::make(
            ['date' => '2537-10-15'],
            ['date' => 'shahi_date_between:2537-10-01,2537-10-30']
        );

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function it_fails_date_between_validation()
    {
        $validator = Validator::make(
            ['date' => '2537-11-15'],
            ['date' => 'shahi_date_between:2537-10-01,2537-10-30']
        );

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function it_validates_with_slash_format()
    {
        $validator = Validator::make(
            ['date' => '2537/10/18'],
            ['date' => 'shahi_date']
        );

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function it_validates_comparison_between_fields()
    {
        $validator = Validator::make(
            [
                'start_date' => '2537-10-01',
                'end_date' => '2537-10-30',
            ],
            ['end_date' => 'shahi_date_after:start_date']
        );

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function it_fails_comparison_between_fields()
    {
        $validator = Validator::make(
            [
                'start_date' => '2537-10-30',
                'end_date' => '2537-10-01',
            ],
            ['end_date' => 'shahi_date_after:start_date']
        );

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function it_validates_leap_year_date()
    {
        // 2537 is a leap year, so month 12 has 30 days
        $validator = Validator::make(
            ['date' => '2588-12-30'],
            ['date' => 'shahi_date']
        );

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function it_fails_non_leap_year_date()
    {
        // 2536 is not a leap year, so month 12 has only 29 days
        $validator = Validator::make(
            ['date' => '2536-12-30'],
            ['date' => 'shahi_date']
        );

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function it_validates_date_with_time()
    {
        $validator = Validator::make(
            ['datetime' => '2537-10-18 14:30:00'],
            ['datetime' => 'shahi_date']
        );

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function it_fails_empty_date()
    {
        $validator = Validator::make(
            ['date' => ''],
            ['date' => 'required|shahi_date']
        );

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function it_validates_with_yesterday_keyword()
    {
        $today = shahi()->formatDate();

        $validator = Validator::make(
            ['date' => $today],
            ['date' => 'shahi_date_after:yesterday']
        );

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function it_validates_with_tomorrow_keyword()
    {
        $today = shahi()->formatDate();

        $validator = Validator::make(
            ['date' => $today],
            ['date' => 'shahi_date_before:tomorrow']
        );

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function it_validates_first_month_dates()
    {
        // Farvardin has 31 days
        $validator = Validator::make(
            ['date' => '2537-01-31'],
            ['date' => 'shahi_date']
        );

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function it_validates_seventh_month_dates()
    {
        // Mehr has 30 days
        $validator = Validator::make(
            ['date' => '2537-07-30'],
            ['date' => 'shahi_date']
        );

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function it_fails_invalid_day_in_seventh_month()
    {
        // Mehr has only 30 days
        $validator = Validator::make(
            ['date' => '2537-07-31'],
            ['date' => 'shahi_date']
        );

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function it_validates_multiple_rules()
    {
        $validator = Validator::make(
            [
                'birthdate' => '2500-01-01',
                'event_date' => '2537-10-18',
            ],
            [
                'birthdate' => 'required|shahi_date|shahi_date_before:today',
                'event_date' => 'required|shahi_date|shahi_date_after:birthdate',
            ]
        );

        $this->assertTrue($validator->passes());
    }
}
