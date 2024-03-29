<?php

namespace Database\Factories\Taskday\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Taskday\Models\Workspace;
use Taskday\Models\User;
use Taskday\Models\Team;

class WorkspaceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Workspace::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'user_id' => User::factory(),
            'team_id' => Team::factory(),
        ];
    }
}
