<?php

namespace Database\Factories;

use Taskday\Models\Card;
use Taskday\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Card::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'project_id' => fn () => Project::factory()->create()->id
        ];
    }
}
