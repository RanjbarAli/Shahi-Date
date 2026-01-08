<?php

namespace RanjbarAli\ShahiDate\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \RanjbarAli\ShahiDate\Shahi now(?string $timezone = null)
 * @method static \RanjbarAli\ShahiDate\Shahi today(?string $timezone = null)
 * @method static \RanjbarAli\ShahiDate\Shahi yesterday(?string $timezone = null)
 * @method static \RanjbarAli\ShahiDate\Shahi tomorrow(?string $timezone = null)
 * @method static \RanjbarAli\ShahiDate\Shahi parse($datetime, ?string $timezone = null)
 * @method static \RanjbarAli\ShahiDate\Shahi create(int $year, int $month = 1, int $day = 1, int $hour = 0, int $minute = 0, int $second = 0)
 * @method static \RanjbarAli\ShahiDate\Shahi createFromGregorian(int $year, int $month = 1, int $day = 1, int $hour = 0, int $minute = 0, int $second = 0)
 * @method static \RanjbarAli\ShahiDate\Shahi createTimestamp(int $timestamp)
 * @method static \RanjbarAli\ShahiDate\Shahi fromCarbon(\Carbon\Carbon $carbon)
 * @method static \RanjbarAli\ShahiDate\Shahi fromDateTime(\DateTime $datetime)
 * @method static bool isLeapYearStatic(int $year)
 *
 * @see \RanjbarAli\ShahiDate\Shahi
 */
class Shahi extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'shahi';
    }
}
