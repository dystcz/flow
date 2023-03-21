<?php

declare(strict_types=1);

namespace Dystcz\Flow\Tests;

use Dystcz\Flow\FlowServiceProvider;
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
            FlowServiceProvider::class,
        ];
    }
}
