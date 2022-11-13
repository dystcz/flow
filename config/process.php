<?php

return [

    'processes' => [

        // Process model class
        'model' => Dystcz\Process\Models\Process::class,
        'observer' => Dystcz\Process\Observers\ProcessObserver::class,
        'collection' => Dystcz\Process\Collections\ProcessCollection::class,
    ],

    'process_config' => [

        // Process config model class
        'model' => Dystcz\Process\Models\ProcessConfig::class,
        'collection' => Dystcz\Process\Collections\ProcessConfigCollection::class,

        // Model class for responsible people
        'responsible_person_model' => Domain\Users\Models\User::class,

        // Model class for notifiable people
        'notifiable_person_model' => Domain\Users\Models\User::class,
    ],

    'notifications' => [

        // Default notification channels
        'default_channels' => ['mail', 'database'],

    ],

];
