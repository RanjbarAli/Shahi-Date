<?php

namespace RanjbarAli\ShahiDate;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use RanjbarAli\ShahiDate\Validators\ShahiDateValidator;

class ShahiDateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register the main class to use with the facade
        $this->app->singleton('shahi', function ($app) {
            return new \RanjbarAli\ShahiDate\Shahi();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish language files
        $this->publishes([
            __DIR__ . '/../resources/lang' => $this->app->langPath('vendor/shahi-date'),
        ], 'shahi-date-lang');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'shahi-date');

        // Register custom validation rules
        $this->registerValidationRules();

        // Register Carbon macro
        $this->registerCarbonMacro();
    }

    /**
     * Register custom validation rules
     */
    protected function registerValidationRules(): void
    {
        // shahi_date - بررسی فرمت تاریخ شاهنشاهی
        Validator::extend('shahi_date', function ($attribute, $value, $parameters, $validator) {
            return ShahiDateValidator::validateDate($value);
        }, trans('shahi-date::validation.shahi_date'));

        // shahi_date_after - بعد از تاریخ مشخص
        Validator::extend('shahi_date_after', function ($attribute, $value, $parameters, $validator) {
            $compareDate = $parameters[0] ?? null;
            return ShahiDateValidator::validateAfter($value, $compareDate, $validator);
        });

        Validator::replacer('shahi_date_after', function ($message, $attribute, $rule, $parameters) {
            $date = $parameters[0] ?? '';
            $date = trans('shahi-date::validation.values.' . $date, [], $date);
            return str_replace(':date', $date, trans('shahi-date::validation.shahi_date_after'));
        });

        // shahi_date_after_equal - بعد یا مساوی تاریخ
        Validator::extend('shahi_date_after_equal', function ($attribute, $value, $parameters, $validator) {
            $compareDate = $parameters[0] ?? null;
            return ShahiDateValidator::validateAfterOrEqual($value, $compareDate, $validator);
        });

        Validator::replacer('shahi_date_after_equal', function ($message, $attribute, $rule, $parameters) {
            $date = $parameters[0] ?? '';
            $date = trans('shahi-date::validation.values.' . $date, [], $date);
            return str_replace(':date', $date, trans('shahi-date::validation.shahi_date_after_equal'));
        });

        // shahi_date_before - قبل از تاریخ مشخص
        Validator::extend('shahi_date_before', function ($attribute, $value, $parameters, $validator) {
            $compareDate = $parameters[0] ?? null;
            return ShahiDateValidator::validateBefore($value, $compareDate, $validator);
        });

        Validator::replacer('shahi_date_before', function ($message, $attribute, $rule, $parameters) {
            $date = $parameters[0] ?? '';
            $date = trans('shahi-date::validation.values.' . $date, [], $date);
            return str_replace(':date', $date, trans('shahi-date::validation.shahi_date_before'));
        });

        // shahi_date_before_equal - قبل یا مساوی تاریخ
        Validator::extend('shahi_date_before_equal', function ($attribute, $value, $parameters, $validator) {
            $compareDate = $parameters[0] ?? null;
            return ShahiDateValidator::validateBeforeOrEqual($value, $compareDate, $validator);
        });

        Validator::replacer('shahi_date_before_equal', function ($message, $attribute, $rule, $parameters) {
            $date = $parameters[0] ?? '';
            $date = trans('shahi-date::validation.values.' . $date, [], $date);
            return str_replace(':date', $date, trans('shahi-date::validation.shahi_date_before_equal'));
        });

        // shahi_date_equals - برابر با تاریخ
        Validator::extend('shahi_date_equals', function ($attribute, $value, $parameters, $validator) {
            $compareDate = $parameters[0] ?? null;
            return ShahiDateValidator::validateEquals($value, $compareDate, $validator);
        });

        Validator::replacer('shahi_date_equals', function ($message, $attribute, $rule, $parameters) {
            $date = $parameters[0] ?? '';
            $date = trans('shahi-date::validation.values.' . $date, [], $date);
            return str_replace(':date', $date, trans('shahi-date::validation.shahi_date_equals'));
        });

        // shahi_date_between - بین دو تاریخ
        Validator::extend('shahi_date_between', function ($attribute, $value, $parameters, $validator) {
            $startDate = $parameters[0] ?? null;
            $endDate = $parameters[1] ?? null;
            return ShahiDateValidator::validateBetween($value, $startDate, $endDate);
        });

        Validator::replacer('shahi_date_between', function ($message, $attribute, $rule, $parameters) {
            $startDate = $parameters[0] ?? '';
            $endDate = $parameters[1] ?? '';
            $startDate = trans('shahi-date::validation.values.' . $startDate, [], $startDate);
            $endDate = trans('shahi-date::validation.values.' . $endDate, [], $endDate);

            $message = trans('shahi-date::validation.shahi_date_between');
            $message = str_replace(':start_date', $startDate, $message);
            $message = str_replace(':end_date', $endDate, $message);

            return $message;
        });
    }

    /**
     * Register Carbon macro for converting to Shahi
     */
    protected function registerCarbonMacro(): void
    {
        Carbon::macro('toShahi', function () {
            return Shahi::fromCarbon($this);
        });

        CarbonImmutable::macro('toShahi', function () {
            return Shahi::fromCarbon($this);
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return ['shahi'];
    }
}
