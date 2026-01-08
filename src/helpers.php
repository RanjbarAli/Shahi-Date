<?php

use RanjbarAli\ShahiDate\Shahi;

if (!function_exists('shahi')) {
    /**
     * Create new Shahi instance
     *
     * @param mixed $datetime
     * @param string|null $timezone
     * @return Shahi
     */
    function shahi($datetime = null, ?string $timezone = null): Shahi
    {
        return new Shahi($datetime, $timezone);
    }
}
