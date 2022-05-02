<?php

namespace Taskday\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Taskday\Models\Project;

class ProjectBuilder extends Builder
{
    /**
     * Scope to have cards count where.
     */
    public function withCardsCountWhere(
        Builder $query,
        string $name,
        string $value
    ) {
        $query->withCount([
            'cards' => function (Builder $q) use ($name, $value) {
                $q->whereCustom($name, $value);
            },
        ]);
    }

    /**
     * Get workspaces only visible to the current user.
     */
    public function visibleTo(Builder $query, $user)
    {
        $query->whereIn('id', $user->projects->pluck('id'));
    }
}
