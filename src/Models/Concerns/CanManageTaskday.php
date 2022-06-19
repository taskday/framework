<?php

namespace Taskday\Models\Concerns;

use Taskday\Models\Contracts\Shareable;
use Taskday\Models\Workspace;
use Taskday\Models\Project;
use Taskday\Models\Card;
use Taskday\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Laravel\Scout\Searchable;
use NotificationChannels\WebPush\HasPushSubscriptions;

trait CanManageTaskday
{
    use Searchable;
    use HasPushSubscriptions;

    /**
     * @return HasMany
     */
    public function workspaces(): HasMany
    {
        return $this->hasMany(Workspace::class);
    }

    /**
     * @return HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * @return HasMany
     */
    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }

    /**
     * @return HasMany
     */
    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    /**
     * @return HasMany
     */
    public function sharedProjects(): HasManyThrough
    {
        return $this->hasManyThrough(Project::class, Member::class, 'user_id', 'id', 'id', 'memberable_id')
            ->where('memberable_type', Project::class)->distinct();
    }

    /**
     * @return HasMany
     */
    public function sharedWorkspaces(): BelongsToMany
    {
        return $this->belongsToMany(Workspace::class, 'members', 'user_id', 'memberable_id')
            ->where('memberable_type', Workspace::class)->distinct();
    }

    public function latestWorkspaces()
    {
        $workspaces = $this->sharedWorkspaces();

        return $workspaces->with([
            'projects' => function ($query) {
                $query->with([
                    'fields' => function ($query) { $query->wherePivot('hidden', 0); },
                    'cards.fields'
                ]);
            },
        ])
        ->orderBy('updated_at', 'desc')
        ->limit(6)
        ->get();
    }

    /**
     * Create a new Workspace with User as owner.
     *
     * @param $title
     * @param $description
     * @return Workspace
     */
    public function createWorkspace($title, $description = null): Workspace
    {
        return tap($this->workspaces()->create([
            'title' => $title,
            'description' => $description,
            'team_id' => $this->current_team_id,
        ]), function($workspace) {
            $workspace->addMember($this->id);
        });
    }

    /**
     * Create a Project in the given Workspace.
     *
     * @param string $title
     * @param Workspace $workspace
     * @return Project|null
     */
    public function createProject(array|string $data, Workspace $workspace): ?Project
    {
        return tap($workspace->createProject($data, $this), function($project) {
            $project->addMember($this->id);
        });
    }

    /**
     * Create a Card in the given Project.
     *
     * @param string $name
     * @param Project $project
     * @return Card|null
     */
    public function createCard(string $name, Project $project): ?Card
    {
        if (! $this->can('update', $project)) {
            return null;
        }

        return $project->createCard($name, $this);
    }

    /**
     * Share a sharable with a User.
     *
     * @param Shareable $item
     * @param User $user
     * @return bool
     */
    public function share($item, Model $user)
    {
        if ($this->cannot('share', $item)) {
            return false;
        }

        $item->share($user);

        return true;
    }

    /**
     * Share a sharable with a User.
     *
     * @param Shareable $item
     * @param User $user
     * @return bool
     */
    public function unshare($item, Model $user)
    {
        if ($this->cannot('unshare', $item)) {
            return false;
        }

        $item->unshare($user);

        return true;
    }
}
