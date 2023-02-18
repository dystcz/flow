<?php

namespace Dystcz\Flow\Domain\Flows\Factories;

use Carbon\Carbon;
use Dystcz\Flow\Domain\Flows\Models\Step;
use Illuminate\Database\Eloquent\Factories\Factory;

class StepFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Step::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
        ];
    }

    public function closed(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'closed_at' => Carbon::now(),
            ];
        });
    }

    public function finished(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'finished_at' => Carbon::now(),
            ];
        });
    }
}
