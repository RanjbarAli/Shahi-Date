<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Shahi Date Validation Language Lines - Persian
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the Shahi Date validator class. Some of these rules have multiple versions
    | such as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'shahi_date' => 'فرمت :attribute معتبر نیست. فرمت صحیح: 2537-10-18',

    'shahi_date_after' => ':attribute باید بعد از :date باشد.',

    'shahi_date_after_equal' => ':attribute باید بعد از :date یا برابر با آن باشد.',

    'shahi_date_before' => ':attribute باید قبل از :date باشد.',

    'shahi_date_before_equal' => ':attribute باید قبل از :date یا برابر با آن باشد.',

    'shahi_date_equals' => ':attribute باید برابر با :date باشد.',

    'shahi_date_between' => ':attribute باید بین :start_date و :end_date باشد.',

    /*
    |--------------------------------------------------------------------------
    | Custom Attribute Names
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'date' => 'تاریخ',
        'birthdate' => 'تاریخ تولد',
        'start_date' => 'تاریخ شروع',
        'end_date' => 'تاریخ پایان',
        'event_date' => 'تاریخ رویداد',
        'created_at' => 'تاریخ ایجاد',
        'updated_at' => 'تاریخ بروزرسانی',
        'deleted_at' => 'تاریخ حذف',
        'published_at' => 'تاریخ انتشار',
        'expire_date' => 'تاریخ انقضا',
        'deadline' => 'مهلت',
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Values
    |--------------------------------------------------------------------------
    */

    'values' => [
        'today' => 'امروز',
        'yesterday' => 'دیروز',
        'tomorrow' => 'فردا',
    ],
];
