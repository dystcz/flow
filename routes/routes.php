<?php

use Dystcz\Process\Domain\Processes\Http\Controllers\ProcessController;
use Dystcz\Process\Domain\Processes\Http\Controllers\ProcessEditController;
use Dystcz\Process\Domain\Processes\Http\Controllers\ProcessShowController;
use Dystcz\Process\Domain\Processes\Http\Controllers\ProcessTemplatesController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'processes',
    'middleware' => ['api'],
], function () {
    Route::group([
        'prefix' => 'templates',
    ], function () {
        Route::get('/', [ProcessTemplatesController::class, 'index']);
    });

    Route::group([
        'prefix' => '{process}',
    ], function () {
        Route::get('/', ProcessShowController::class);
        Route::get('/edit', ProcessEditController::class);
        Route::patch('/', ProcessController::class);
    });
});
