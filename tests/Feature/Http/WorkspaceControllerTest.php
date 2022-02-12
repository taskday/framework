<?php

use Inertia\Testing\AssertableInertia;
use Taskday\Models\User;
use Taskday\Models\Workspace;

it('should respond with the correct component', function () {

    $this->withoutExceptionHandling();

    // Arrange
    $workspace = Workspace::factory()->create();
    $user = User::factory()->create();

    // Act
    $this->actingAs($user);
    $response = $this->get(route('workspaces.index'));

    // Assert
    $response->assertInertia(fn(AssertableInertia $page) => $page
        ->component('Workspaces/Index')
        ->where('title', 'Workspaces')
        ->count('breadcrumbs', 2)
        ->count('workspaces', 1)
    );
});
