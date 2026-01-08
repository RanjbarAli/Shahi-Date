<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Shahi Date Validation Language Lines - English
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the Shahi Date validator class. Some of these rules have multiple versions
    | such as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'shahi_date' => 'The :attribute is not a valid Shahi date format. Valid format: 2537-10-18',

    'shahi_date_after' => 'The :attribute must be after :date.',

    'shahi_date_after_equal' => 'The :attribute must be after or equal to :date.',

    'shahi_date_before' => 'The :attribute must be before :date.',

    'shahi_date_before_equal' => 'The :attribute must be before or equal to :date.',

    'shahi_date_equals' => 'The :attribute must be equal to :date.',

    'shahi_date_between' => 'The :attribute must be between :start_date and :end_date.',

    /*
    |--------------------------------------------------------------------------
    | Custom Attribute Names
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'date' => 'date',
        'birthdate' => 'birth date',
        'start_date' => 'start date',
        'end_date' => 'end date',
        'event_date' => 'event date',
        'created_at' => 'creation date',
        'updated_at' => 'update date',
        'deleted_at' => 'deletion date',
        'published_at' => 'publication date',
        'expire_date' => 'expiration date',
        'deadline' => 'deadline',
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Values
    |--------------------------------------------------------------------------
    */

    'values' => [
        'today' => 'today',
        'yesterday' => 'yesterday',
        'tomorrow' => 'tomorrow',
    ],
];
