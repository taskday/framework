<?php

use Taskday\Http\Middleware\HandleInertiaRequests;
use Illuminate\Support\Facades\Route;

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
Route::get('/scripts/{handle}', [\Taskday\Http\Controllers\AssetController::class, 'scripts']);
Route::get('/styles/{handle}', [\Taskday\Http\Controllers\AssetController::class,  'styles']);

Route::middleware(['auth:sanctum', 'verified'])->group(function(){

    // Push Notifications Subscriptions
    Route::post('subscriptions',               [\Taskday\Http\Controllers\PushSubscriptionController::class, 'update']);
    Route::post('subscriptions/delete',        [\Taskday\Http\Controllers\PushSubscriptionController::class, 'destroy']);

    // Dashboard
    Route::redirect('/','dashboard');
    Route::get('/dashboard',                   [\Taskday\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Search
    Route::get('/search',                   [\Taskday\Http\Controllers\DashboardController::class, 'search'])->name('search');

    // Workspaces
    Route::resource('workspaces',               \Taskday\Http\Controllers\WorkspaceController::class);

    // Members
    Route::post('workspaces/{workspace}/members', [\Taskday\Http\Controllers\WorkspaceController::class, 'updateMembers'])->name('workspaces.members.store');
    Route::post('projects/{project}/members',     [\Taskday\Http\Controllers\ProjectController::class, 'updateMembers'])->name('projects.members.store');

    // Fields
    Route::resource('fields',                   \Taskday\Http\Controllers\FieldController::class);
    Route::resource('projects.fields',            \Taskday\Http\Controllers\ProjectFieldController::class)->only(['update', 'store', 'destroy']);

    // Projects
    Route::resource('workspaces.projects',        \Taskday\Http\Controllers\ProjectController::class)->only(['store', 'create']);
    Route::resource('projects',                   \Taskday\Http\Controllers\ProjectController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
    Route::get('projects/{project}/import-create', [\Taskday\Http\Controllers\ProjectImportController::class, 'create'])->name('projects.import-create');
    Route::post('projects/{project}/import-store', [\Taskday\Http\Controllers\ProjectImportController::class, 'store'])->name('projects.import-store');
    Route::get('projects/{project}/import-edit',    [\Taskday\Http\Controllers\ProjectImportController::class, 'edit'])->name('projects.import-edit');
    Route::put('projects/{project}/import-update',    [\Taskday\Http\Controllers\ProjectImportController::class, 'update'])->name('projects.import-update');

    // Cards
    Route::resource('cards',                    \Taskday\Http\Controllers\CardController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
    Route::resource('projects.cards',           \Taskday\Http\Controllers\CardController::class)->only(['store']);
    Route::put('cards/{card}/fields/{field}',   [\Taskday\Http\Controllers\CardFieldController::class, 'update'])->name('cards.fields.update');

    // Comments
    Route::resource('cards.comments',           \Taskday\Http\Controllers\CommentController::class)->only(['store', 'update', 'destroy']);
    Route::resource('comments.medias',          \Taskday\Http\Controllers\MediaController::class)->only('show');

    // Notifications
    Route::resource('notifications',             \Taskday\Http\Controllers\NotificationController::class)->only('index');
});

