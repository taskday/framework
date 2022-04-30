<?php

namespace Database\Factories\Taskday\Models;


use Taskday\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;
use Taskday\Models\User;

class TeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Team::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->word,
            'personal_team' => $this->faker->boolean,
        ];
    }
}
