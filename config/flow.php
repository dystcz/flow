<?php

declare(strict_types=1);

return [

    /**
     * Flow step settings.
     */
    'steps' => [

        /**
         * Step model class.
         * Can be extended, when you need some specific functionality.
         */
        'model' => Dystcz\Flow\Domain\Flows\Models\Step::class,

        /**
         * Flow step attributes column name used in flow steps table.
         */
        'step_attributes_column' => 'flow_attributes',

        /**
         * Flow steps table name.
         */
        'table_name' => 'flow_steps',

        /**
         * Flow step edges settings.
         */
        'edges' => [

            /**
             * Step edge model class.
             */
            'model' => Dystcz\Flow\Domain\Flows\Models\StepEdge::class,

            /**
             * Flow step edges table name.
             */
            'table_name' => 'flow_step_edges',

        ],

        /**
         * Flow step users settings.
         */
        'users' => [

            /**
             * Flow step user pivot table name.
             */
            'table_name' => 'flow_step_user',

        ],

        /**
         * Step notifications settings.
         */
        'notifications' => [

            /**
             * Default notification channels.
             * Channels used when sending step notifications.
             */
            'default_channels' => ['mail', 'database'],
        ],
    ],

    /**
     * Flow templates settings.
     */
    'templates' => [

        /**
         * FlowTemplate model class.
         * Can be extended, when you need some specific functionality.
         */
        'model' => Dystcz\Flow\Domain\Flows\Models\Template::class,

        /**
         * Flow templates table name.
         */
        'table_name' => 'flow_templates',

        /**
         * Groups which are hidden by global scope.
         */
        'hidden_groups' => ['hidden'],
    ],

    /**
     * Flow nodes settings.
     */
    'nodes' => [

        /**
         * Flow node model class.
         * Can be extended, when you need some specific functionality.
         */
        'model' => Dystcz\Flow\Domain\Flows\Models\Node::class,

        /**
         * Flow nodes table name.
         */
        'table_name' => 'flow_nodes',

        /**
         * Flow node edges settings.
         */
        'edges' => [

            /**
             * Node edge model class.
             */
            'model' => Dystcz\Flow\Domain\Flows\Models\NodeEdge::class,

            /**
             * Flow nodes edges table name.
             */
            'table_name' => 'flow_node_edges',

        ],

        /**
         * Flow node users settings.
         */
        'users' => [

            /**
             * Flow node user pivot table name.
             */
            'table_name' => 'flow_node_user',

        ],
    ],

    /**
     * Users settings.
     */
    'users' => [

        // Model class for responsible users and notifiable users
        // If null, we will use the model from auth config
        'model' => null,

        /**
         * Users table name.
         */
        'table_name' => 'users',
    ],

    'handlers' => [

        /**
         * Default namespace for flow step make command.
         * Can be also overridden by --domain or -d option if you DDD.
         * By default it is null, so the namespace will be something like App\Flow\Handlers.
         */
        'default_namespace' => null,

    ],

    /**
     * Flow notifications settings.
     */
    'notifications' => [

        /**
         * Default notification channels.
         * Channels used when sending flow notifications.
         */
        'default_channels' => ['mail', 'database'],

    ],

    /**
     * Testing mode.
     * All flows steps are considered complete when saved.
     */
    'testing' => env('FLOW_TESTING', false),

];
