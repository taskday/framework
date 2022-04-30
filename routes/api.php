<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Taskday\Http\Controllers\Api;

Route::prefix('api')->middleware(['api', 'auth:sanctum', 'verified'])->group(function () {

    // Verify authentication
    Route::get('me', fn () => Auth::user());

    // Search
    Route::get('search', [Api\SearchController::class, 'index',  ['as' => 'api']])->name('api.search');

    // Workspaces
    Route::apiResource('workspaces', Api\WorkspaceController::class, ['as' => 'api']);

    // Members
    // Route::post('workspaces/{workspace}/members', [Api\WorkspaceController::class, 'updateMembers'], ['as' => 'api'])->name('workspaces.members.store');
    // Route::post('projects/{project}/members',     [Api\ProjectController::class, 'updateMembers'], ['as' => 'api'])->name('projects.members.store');

    // Fields
    Route::apiResource('fields',                   Api\FieldController::class, ['as' => 'api']);
    Route::apiResource('cards.fields',             Api\CardFieldController::class,    ['as' => 'api'])->only(['update']);
    Route::apiResource('projects.fields',          Api\ProjectFieldController::class, ['as' => 'api'])->only(['update']);

    // Projects
    Route::apiResource('workspaces.projects',      Api\ProjectController::class, ['as' => 'api'])->only(['update', 'store', 'destroy']);
    Route::apiResource('projects',                 Api\ProjectController::class, ['as' => 'api'])->only(['index', 'show']);

    // Cards
    Route::apiResource('cards',                    Api\CardController::class, ['as' => 'api'])->only(['index', 'show', 'update', 'destroy']);
    Route::apiResource('projects.cards',           Api\CardController::class, ['as' => 'api'])->only(['store']);

    // Comments
    Route::apiResource('cards.comments',           Api\CommentController::class, ['as' => 'api']);

    // Medias
    Route::apiResource('comments.medias',          Api\MediaController::class, ['as' => 'api'])->only('show');

    // Notifications
    Route::get('notifications',                [Api\NotificationController::class, 'index'])->name('api.notifications.index');
    Route::post('notifications',               [Api\NotificationController::class, 'store'])->name('api.notifications.store');
    Route::patch('notifications/{id}/read',    [Api\NotificationController::class, 'markAsRead'])->name('api.notifications.read');
    Route::post('notifications/mark-all-read', [Api\NotificationController::class, 'markAllRead'])->name('api.notifications.readAll');
    Route::post('notifications/{id}/dismiss',  [Api\NotificationController::class, 'dismiss'])->name('api.notifications.destroy');
});

