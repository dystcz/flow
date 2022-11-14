<?php

return [

    'processes' => [

        // Process model class
        'model' => Dystcz\Process\Models\Process::class,

        // Process collection class
        'collection' => Dystcz\Process\Collections\ProcessCollection::class,

        // Process observer class
        'observer' => Dystcz\Process\Observers\ProcessObserver::class,
    ],

    'nodes' => [

        // Process node model class
        'model' => Dystcz\Process\Models\ProcessNode::class,

        // Process node collection class
        'collection' => Dystcz\Process\Collections\ProcessNodeCollection::class,

        // Process node observer class
        'observer' => Dystcz\Process\Observers\ProcessNodeObserver::class,

        // Model class for responsible people
        'responsible_person_model' => Domain\Users\Models\User::class,

        // Model class for notifiable people
        'notifiable_person_model' => Domain\Users\Models\User::class,
    ],

    'templates' => [

        // Process template model class
        'model' => Dystcz\Process\Models\ProcessTemplate::class,

        // Process template collection class
        'collection' => Dystcz\Process\Collections\ProcessTemplateCollection::class,

        // Process template observer class
        'observer' => Dystcz\Process\Observers\ProcessObserver::class,
    ],

    'notifications' => [

        // Default notification channels
        'default_channels' => ['mail', 'database'],

    ],

];
