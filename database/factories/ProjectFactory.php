<?php

namespace Database\Factories;

use Taskday\Models\Project;
use Taskday\Models\Workspace;
use Taskday\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'workspace_id' => fn () => Workspace::factory()->create()->id,
            'user_id' => fn () => User::factory()->create()->id
        ];
    }
}
