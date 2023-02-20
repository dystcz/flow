<?php

use Dystcz\Flow\Tests\Support\Blueprints\TestBlueprint;
use Dystcz\Flow\Tests\Support\Models\TestModel;

it('creates a template with a given name', function () {
    $blueprint = new TestBlueprint();

    $template = $blueprint->createTemplate();

    expect($template)
        ->name->toBe('Test template')
        ->model_type->toBe(TestModel::class);

    $this->assertDatabaseHas('flow_templates', [
        'name' => 'Test template',
    ]);
});

it('creates a flow with defined steps', function () {
    $blueprint = new TestBlueprint();
});
