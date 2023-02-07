<?php

return [

    'processes' => [

        // Process model class
        'model' => Dystcz\Process\Domain\Processes\Models\Process::class,

        // Process attributes column name used in processes table
        'process_attributes_column' => 'process_attributes',

        // Process controllers
        'controllers' => [
            // Controller used to view process details
            'show' => Dystcz\Process\Domain\Processes\Http\Controllers\ProcessShowController::class,

            // Controller used to edit a process
            'edit' => Dystcz\Process\Domain\Processes\Http\Controllers\ProcessEditController::class,

            // Controller used to handle a process
            'process' => Dystcz\Process\Domain\Processes\Http\Controllers\ProcessController::class,
        ],

        // Process observer class
        'observer' => Dystcz\Process\Domain\Processes\Observers\ProcessObserver::class,
    ],

    'nodes' => [

        // Process node model class
        'model' => Dystcz\Process\Domain\Processes\Models\ProcessNode::class,

        // Process node observer class
        'observer' => Dystcz\Process\Domain\Processes\Observers\ProcessNodeObserver::class,
    ],

    'users' => [

        // Model class for responsible users and notifiable users
        // If null, we will use the model from auth config
        'model' => null,
    ],

    'templates' => [

        // Process template model class
        'model' => Dystcz\Process\Domain\Processes\Models\ProcessTemplate::class,

        // Process controllers
        'controllers' => [
            // Controller used to list process templates
            'index' => Dystcz\Process\Domain\Processes\Http\Controllers\ProcessTemplatesController::class,
        ],

        // Process template observer class
        'observer' => Dystcz\Process\Domain\Processes\Observers\ProcessTemplateObserver::class,
    ],

    'notifications' => [

        // Default notification channels
        'default_channels' => ['mail', 'database'],

    ],

];
