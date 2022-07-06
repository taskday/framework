<?php

use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Taskday\Models\Field;
use Taskday\Models\User;

it('can list all fields', function () {

    // Arrange
    $this->actingAs(
        $user = User::factory()->create(),
        'web'
    );

    $field = Field::factory()->create();

    Permission::create([
        'name' => 'view fields',
        'guard_name' => 'web'
    ])->assignRole(
        Role::create([
            'name' => 'staff',
            'guard_name' => 'web'
        ])
    );

    $user->assignRole('staff');

    // Act
    $response = $this
        ->get(route('fields.index'));

    // Assert
    $response->assertInertia(fn(AssertableInertia $page) => $page
        ->component('Fields/Index')
        ->where('title', 'Fields')
        ->has('breadcrumbs', 1)
        ->where('breadcrumbs.0.title', "Dashboard")
        ->has('fields.data', 3)
        ->where('fields.data.0.title', $field->title)
    );
});
