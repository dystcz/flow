<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Factories;

use Dystcz\Flow\Domain\Flows\Models\Template;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class TemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Template::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'model_type' => Model::class,
            'name' => $this->faker->name(),
        ];
    }

    public function default(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'default' => true,
            ];
        });
    }
}
