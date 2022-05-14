<?php

use Illuminate\Support\Facades\Route;
use Taskday\Http\Controllers;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Scripts & Styles...
Route::get('/scripts/{handle}', [Controllers\AssetController::class, 'scripts']);
Route::get('/styles/{handle}', [Controllers\AssetController::class,  'styles']);

Route::middleware(['web', 'auth:sanctum', 'verified'])->group(function(){

    // Push Notifications Subscriptions
    Route::post('subscriptions',               [Controllers\PushSubscriptionController::class, 'update']);
    Route::post('subscriptions/delete',        [Controllers\PushSubscriptionController::class, 'destroy']);

    // Dashboard
    Route::redirect('/','dashboard');
    Route::get('/dashboard',                   [Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Workspaces
    Route::resource('workspaces',               Controllers\WorkspaceController::class);

    // Members
    Route::put('workspaces/{workspace}/members', [Controllers\WorkspaceController::class, 'updateMembers'])->name('workspaces.members.update');
    Route::put('projects/{project}/members',     [Controllers\ProjectController::class, 'updateMembers'])->name('projects.members.update');

    // Fields
    Route::resource('fields',                   Controllers\FieldController::class);
    Route::resource('projects.fields',            Controllers\ProjectFieldController::class)->only(['update', 'store', 'destroy']);

    // Projects
    Route::resource('workspaces.projects',        Controllers\ProjectController::class)->only(['store', 'create']);
    Route::resource('projects',                   Controllers\ProjectController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
    Route::get('projects/{project}/import-create', [Controllers\ProjectImportController::class, 'create'])->name('projects.import-create');
    Route::post('projects/{project}/import-store', [Controllers\ProjectImportController::class, 'store'])->name('projects.import-store');
    Route::get('projects/{project}/import-edit',    [Controllers\ProjectImportController::class, 'edit'])->name('projects.import-edit');
    Route::put('projects/{project}/import-update',    [Controllers\ProjectImportController::class, 'update'])->name('projects.import-update');

    // Cards
    Route::resource('cards',                    Controllers\CardController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
    Route::resource('projects.cards',           Controllers\CardController::class)->only(['store']);
    Route::put('cards/{card}/fields/{field}',   [Controllers\CardFieldController::class, 'update'])->name('cards.fields.update');

    // Comments
    Route::resource('cards.comments',           Controllers\CommentController::class)->only(['store', 'update', 'destroy']);
    Route::resource('comments.medias',          Controllers\MediaController::class)->only('show');

    // Notifications
    Route::resource('notifications',             Controllers\NotificationController::class)->only('index');
});

