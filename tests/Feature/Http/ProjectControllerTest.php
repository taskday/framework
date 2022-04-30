<?php

use Inertia\Testing\AssertableInertia;
use Taskday\Models\Project;
use Taskday\Models\Team;
use Taskday\Models\User;
use Taskday\Models\Workspace;

it('can show a project', function () {
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
        ->get(route('projects.show', $project));

    // Assert
    expect($workspace->title)->toBe('My Workspace');
    expect($workspace->team_id)->toBe($user->current_team_id);
    expect(Workspace::all(), 4);
    expect(Project::all(), 2);
    expect(Team::count())->toBe(2);

    $response->assertInertia(fn(AssertableInertia $page) => $page
        ->component('Projects/Show')
        ->where('title', $project->title)
        ->has('breadcrumbs', 3)
        ->where('breadcrumbs.0.title', "Workspaces")
        ->where('breadcrumbs.1.title', $workspace->title)
        ->where('breadcrumbs.2.title', $project->title)
    );
});
