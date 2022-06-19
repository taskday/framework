<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('projects.{projectId}', function ($user, $projectId) {
    return true;
});
