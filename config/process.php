<?php

return [

    'processes' => [
        // Process model class
        'model' => Dystcz\Process\Models\Process::class,
    ],

    'process_config' => [
        // Process config model class
        'model' => Dystcz\Process\Models\ProcessConfig::class,

        // Model class for responsible people
        'responsible_person_model' => Domain\Users\Models\User::class,

        // Model class for notifiable people
        'notifiable_person_model' => Domain\Users\Models\User::class,
    ],

];
