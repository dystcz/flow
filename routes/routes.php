<?php

use Dystcz\Process\Handlers\ProcessHandler;
use Dystcz\Process\Models\Process;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'processes',
    'middleware' => ['api'],
], function () {
    Route::get('/{process}/edit', function (Process $process) {
        return App::make($process->handler)->edit();
    });

    Route::patch('/{process}', ProcessHandler::class);
});
