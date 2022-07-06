<?php

namespace Database\Factories\Taskday\Models;

use Taskday\Models\Field;
use Illuminate\Database\Eloquent\Factories\Factory;

class FieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Field::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'handle' => $this->faker->word,
            'type' => 'string',
            'options' => '{}',
        ];
    }
}
