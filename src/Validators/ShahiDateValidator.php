<?php

namespace RanjbarAli\ShahiDate\Validators;

use RanjbarAli\ShahiDate\Shahi;
use Illuminate\Validation\Validator;

class ShahiDateValidator
{
    /**
     * Validate date format
     */
    public static function validateDate($value): bool
    {
        if (empty($value)) {
            return false;
        }

        try {
            // Check if it's a valid Shahi date format
            if (preg_match('/^(\d{4})[\/\-](\d{1,2})[\/\-](\d{1,2})/', $value, $matches)) {
                $year = (int) $matches[1];
                $month = (int) $matches[2];
                $day = (int) $matches[3];

                // Validate month
                if ($month < 1 || $month > 12) {
                    return false;
                }

                // Validate day
                if ($day < 1) {
                    return false;
                }

                // Get max days in month
                if ($month <= 6) {
                    $maxDays = 31;
                } elseif ($month <= 11) {
                    $maxDays = 30;
                } else {
                    $maxDays = Shahi::isLeapYearStatic($year) ? 30 : 29;
                }

                if ($day > $maxDays) {
                    return false;
                }

                return true;
            }

            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Validate date is after another date
     */
    public static function validateAfter($value, $compareDate, ?Validator $validator = null): bool
    {
        if (!self::validateDate($value)) {
            return false;
        }

        try {
            $date = new Shahi($value);

            // Handle 'today', 'yesterday', 'tomorrow'
            if ($compareDate === 'today') {
                $compare = Shahi::today();
            } elseif ($compareDate === 'yesterday') {
                $compare = Shahi::yesterday();
            } elseif ($compareDate === 'tomorrow') {
                $compare = Shahi::tomorrow();
            } elseif ($validator && array_key_exists($compareDate, $validator->getData())) {
                // Compare with another field
                $compare = new Shahi($validator->getData()[$compareDate]);
            } else {
                $compare = new Shahi($compareDate);
            }

            return $date->gt($compare);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Validate date is after or equal to another date
     */
    public static function validateAfterOrEqual($value, $compareDate, ?Validator $validator = null): bool
    {
        if (!self::validateDate($value)) {
            return false;
        }

        try {
            $date = new Shahi($value);

            if ($compareDate === 'today') {
                $compare = Shahi::today();
            } elseif ($compareDate === 'yesterday') {
                $compare = Shahi::yesterday();
            } elseif ($compareDate === 'tomorrow') {
                $compare = Shahi::tomorrow();
            } elseif ($validator && array_key_exists($compareDate, $validator->getData())) {
                $compare = new Shahi($validator->getData()[$compareDate]);
            } else {
                $compare = new Shahi($compareDate);
            }

            return $date->gte($compare);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Validate date is before another date
     */
    public static function validateBefore($value, $compareDate, ?Validator $validator = null): bool
    {
        if (!self::validateDate($value)) {
            return false;
        }

        try {
            $date = new Shahi($value);

            if ($compareDate === 'today') {
                $compare = Shahi::today();
            } elseif ($compareDate === 'yesterday') {
                $compare = Shahi::yesterday();
            } elseif ($compareDate === 'tomorrow') {
                $compare = Shahi::tomorrow();
            } elseif ($validator && array_key_exists($compareDate, $validator->getData())) {
                $compare = new Shahi($validator->getData()[$compareDate]);
            } else {
                $compare = new Shahi($compareDate);
            }

            return $date->lt($compare);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Validate date is before or equal to another date
     */
    public static function validateBeforeOrEqual($value, $compareDate, ?Validator $validator = null): bool
    {
        if (!self::validateDate($value)) {
            return false;
        }

        try {
            $date = new Shahi($value);

            if ($compareDate === 'today') {
                $compare = Shahi::today();
            } elseif ($compareDate === 'yesterday') {
                $compare = Shahi::yesterday();
            } elseif ($compareDate === 'tomorrow') {
                $compare = Shahi::tomorrow();
            } elseif ($validator && array_key_exists($compareDate, $validator->getData())) {
                $compare = new Shahi($validator->getData()[$compareDate]);
            } else {
                $compare = new Shahi($compareDate);
            }

            return $date->lte($compare);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Validate date equals another date
     */
    public static function validateEquals($value, $compareDate, ?Validator $validator = null): bool
    {
        if (!self::validateDate($value)) {
            return false;
        }

        try {
            $date = new Shahi($value);

            if ($compareDate === 'today') {
                $compare = Shahi::today();
            } elseif ($compareDate === 'yesterday') {
                $compare = Shahi::yesterday();
            } elseif ($compareDate === 'tomorrow') {
                $compare = Shahi::tomorrow();
            } elseif ($validator && array_key_exists($compareDate, $validator->getData())) {
                $compare = new Shahi($validator->getData()[$compareDate]);
            } else {
                $compare = new Shahi($compareDate);
            }

            return $date->eq($compare);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Validate date is between two dates
     */
    public static function validateBetween($value, $startDate, $endDate): bool
    {
        if (!self::validateDate($value)) {
            return false;
        }

        try {
            $date = new Shahi($value);

            if ($startDate === 'today') {
                $start = Shahi::today();
            } else {
                $start = new Shahi($startDate);
            }

            if ($endDate === 'today') {
                $end = Shahi::today();
            } else {
                $end = new Shahi($endDate);
            }

            return $date->between($start, $end);
        } catch (\Exception $e) {
            return false;
        }
    }
}
