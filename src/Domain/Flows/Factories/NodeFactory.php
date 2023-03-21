<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Factories;

use Dystcz\Flow\Domain\Flows\Models\Node;
use Illuminate\Database\Eloquent\Factories\Factory;

class NodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Node::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}
