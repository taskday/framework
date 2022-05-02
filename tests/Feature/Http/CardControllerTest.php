<?php

use Inertia\Testing\AssertableInertia;
use Taskday\Models\User;

it('it can list all cards', function () {

    // Arrange
    $user = User::factory()->withCurrentTeam()->create();
    $workspace = $user->createWorkspace('My Workspace');
    $project = $user->createProject('My Project', $workspace);
    $card1 = $project->createCard('My Card 1');
    $project->createCard('My Card 2');
    $project->createCard('My Card 3');

    // Act
    $response = $this
        ->actingAs($user)
        ->get(route('cards.index'));

    // Assert
    $response->assertInertia(fn(AssertableInertia $page) => $page
        ->component('Cards/Index')
        ->where('title', 'Cards')
        ->has('breadcrumbs', 1)
        ->where('breadcrumbs.0.title', "Dashboard")
        ->has('cards.data', 3)
        ->where('cards.data.0.title', $card1->title)
    );
});
