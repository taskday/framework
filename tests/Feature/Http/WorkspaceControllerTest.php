<?php

use Inertia\Testing\AssertableInertia;
use Taskday\Models\Project;
use Taskday\Models\Team;
use Taskday\Models\User;
use Taskday\Models\Workspace;

it('can list all workspaces', function () {
    // Arrange
    $user = User::factory()->withCurrentTeam()->create();
    $workspace = $user->createWorkspace('My Workspace');
    $project = $user->createProject('My Project', $workspace);

    $friend = User::factory()->withCurrentTeam()->create();
    $friendWorkspace = $friend->createWorkspace("Friend's Workspace");
    $friend->createProject("Friend's Project", $friendWorkspace);
    $sharedProject = $friend->createProject("Shared Project", $friendWorkspace);
    $sharedProject->addMember($user);

    // Act
    $response = $this
        ->actingAs($user)
        ->get(route('workspaces.index'));

    // Assert
    expect($workspace->title)->toBe('My Workspace');
    expect($workspace->team_id)->toBe($user->current_team_id);
    expect(Workspace::all(), 4);
    expect(Project::all(), 2);
    expect(Team::count())->toBe(2);

    $response->assertInertia(fn(AssertableInertia $page) => $page
        ->component('Workspaces/Index')
        ->where('title', 'Workspaces')
        ->has('breadcrumbs', 2)
        ->where('breadcrumbs.0.title', 'Dashboard')
        ->where('breadcrumbs.1.title', 'Workspaces')
        ->count('workspaces', 2)
        ->where('workspaces.0.title', $workspace->title)
        ->count('workspaces.0.projects', 1)
        ->count('workspaces.1.projects', 1)
        ->where('workspaces.0.projects.0.title', $project->title)
        ->where('workspaces.1.projects.0.title', $sharedProject->title)
    );
});
