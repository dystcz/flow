<?php

declare(strict_types=1);

use Dystcz\Flow\Tests\TestCase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(TestCase::class)->in('.');
uses(LazilyRefreshDatabase::class)->in('Feature');
