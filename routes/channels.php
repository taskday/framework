<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{userId}', function ($user, $userId) {
    return $user->id == $userId;
});

Broadcast::channel('projects.{projectId}', function ($user, $projectId) {
    return true;
});

Broadcast::channel('cards.{cardId}', function ($user, $cardId) {
    return true;
});

Broadcast::channel('cards.any', function ($user) {
    return true;
});
