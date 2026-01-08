<?php

namespace RanjbarAli\ShahiDate\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            \RanjbarAli\ShahiDate\ShahiDateServiceProvider::class,
        ];
    }
}
