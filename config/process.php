<?php

return [

    /**
     * Processes settings.
     */
    'processes' => [

        /**
         * Process model class.
         * Can be extended, when you need some specific functionality.
         */
        'model' => Dystcz\Process\Domain\Processes\Models\Process::class,

        /**
         * Process attributes column name used in processes table.
         */
        'process_attributes_column' => 'process_attributes',
    ],

    /**
     * Process nodes settings.
     */
    'nodes' => [

        /**
         * Process node model class.
         * Can be extended, when you need some specific functionality.
         */
        'model' => Dystcz\Process\Domain\Processes\Models\ProcessNode::class,
    ],

    /**
     * Users settings.
     */
    'users' => [

        // Model class for responsible users and notifiable users
        // If null, we will use the model from auth config
        'model' => null,
    ],

    /**
     * Process templates settings.
     */
    'templates' => [

        /**
         * Process template model class.
         * Can be extended, when you need some specific functionality.
         */
        'model' => Dystcz\Process\Domain\Processes\Models\ProcessTemplate::class,
    ],

    /**
     * Process notifications settings.
     */
    'notifications' => [

        /**
         * Default notification channels.
         * Channels used when sending process notifications.
         */
        'default_channels' => ['mail', 'database'],

    ],

    /**
     * Testing mode.
     * All processes are considered complete when saved.
     */
    'testing' => env('PROCESS_TESTING', false),

];
