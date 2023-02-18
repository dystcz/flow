<?php

use Dystcz\Flow\Domain\Flows\Http\Controllers\StepController;
use Dystcz\Flow\Domain\Flows\Http\Controllers\StepEditController;
use Dystcz\Flow\Domain\Flows\Http\Controllers\StepShowController;
use Dystcz\Flow\Domain\Flows\Http\Controllers\TemplatesController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'flows',
    'middleware' => ['api'],
], function () {
    Route::group([
        'prefix' => 'templates',
    ], function () {
        Route::get('/', TemplatesController::class);
    });

    Route::group([
        'prefix' => '{step}',
    ], function () {
        Route::get('/', StepShowController::class);
        Route::get('/edit', StepEditController::class);
        Route::patch('/', StepController::class);
    });
});
