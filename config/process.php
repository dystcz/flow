<?php

return [

    'processes' => [

        // Process model class
        'model' => Dystcz\Process\Domain\Processes\Models\Process::class,

        // Process collection class
        'collection' => Dystcz\Process\Domain\Processes\Collections\ProcessCollection::class,

        // Process observer class
        'observer' => Dystcz\Process\Domain\Processes\Observers\ProcessObserver::class,

        // Process attributes column name used in processes table
        'process_attributes_column' => 'process_attributes',
    ],

    'nodes' => [

        // Process node model class
        'model' => Dystcz\Process\Domain\Processes\Models\ProcessNode::class,

        // Process node collection class
        'collection' => Dystcz\Process\Domain\Processes\Collections\ProcessNodeCollection::class,

        // Process node observer class
        'observer' => Dystcz\Process\Domain\Processes\Observers\ProcessNodeObserver::class,

        // Model class for responsible people
        'responsible_person_model' => Domain\Users\Models\User::class,

        // Model class for notifiable people
        'notifiable_person_model' => Domain\Users\Models\User::class,
    ],

    'templates' => [

        // Process template model class
        'model' => Dystcz\Process\Domain\Processes\Models\ProcessTemplate::class,

        // Process template collection class
        'collection' => Dystcz\Process\Domain\Processes\Collections\ProcessTemplateCollection::class,

        // Process template observer class
        'observer' => Dystcz\Process\Domain\Processes\Observers\ProcessTemplateObserver::class,
    ],

    'notifications' => [

        // Default notification channels
        'default_channels' => ['mail', 'database'],

    ],

];
