<?php

use Dystcz\Process\Http\Controllers\ProcessController;
use Dystcz\Process\Http\Controllers\ProcessEditController;
use Dystcz\Process\Http\Controllers\ProcessTemplatesController;
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
        Route::get('/edit', ProcessEditController::class);
        Route::patch('/', ProcessController::class);
    });
});
