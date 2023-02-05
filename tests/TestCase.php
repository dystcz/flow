<?php

namespace Dystcz\Process\Tests;

use Dystcz\Process\ProcessServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ProcessServiceProvider::class,
        ];
    }
}
