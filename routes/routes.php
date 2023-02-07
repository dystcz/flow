<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'processes',
    'middleware' => ['api'],
], function () {
    Route::group([
        'prefix' => 'templates',
    ], function () {
        Route::get('/', Config::get('process.processes.templates.index'));
    });

    Route::group([
        'prefix' => '{process}',
    ], function () {
        Route::get('/', Config::get('process.processes.controllers.show'));
        Route::get('/edit', Config::get('process.processes.controllers.edit'));
        Route::patch('/', Config::get('process.processes.controllers.process'));
    });
});
