<?php

declare(strict_types=1);

use Dystcz\Flow\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(TestCase::class)->in('.');
uses(DatabaseMigrations::class, LazilyRefreshDatabase::class)->in('Feature');
