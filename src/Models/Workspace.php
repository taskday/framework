<?php

declare(strict_types=1);

namespace Taskday\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Taskday\Models\Concerns\Archivable;
use Taskday\Models\Concerns\Memberable;
use Taskday\Models\Concerns\BelongsToUser;
use Taskday\Models\Concerns\Linkable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;
use Taskday\Support\Page\Breadcrumb;

class Workspace extends Model
{
    use HasFactory, Searchable, Linkable, Archivable, Memberable, BelongsToUser;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes the are included in the json.
     *
     * @var array
     */
    protected $appends = [
        'breadcrumbs'
    ];


    /**
     * @return HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Create a project for the given user.
     *
     * @param string $title
     * @param User $user
     * @return Model
     */
    public function createProject(array|string $data, Model $user)
    {
        return $this->projects()->create(is_array($data) ? array_merge($data, [
            'user_id' => $user->id,
        ]) : [
            'title' => $data,
            'user_id' => $user->id,
        ]);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->getKey(),
            'title' => $this->title,
        ];
    }

    /**
     * Alternative title of the project for search result.
     *
     * @return Breadcrumb[]
     */
    public function getBreadcrumbsAttribute(): array
    {
        return [
            new Breadcrumb('Dashboard', route('dashboard')),
            new Breadcrumb('Workspaces', route('workspaces.index')),
        ];
    }

    /**
     * Get workspaces only visible to the current user.
     */
    public function scopeVisibleTo($query, Model $user)
    {
        $query->whereIn('id', $user->workspaces->pluck('id'));
    }

    /**
     * Get workspaces only visible to the current user.
     */
    public function forCurrentTeam($query)
    {
        $query->orWhere('team_id', Auth::user()->current_team_id);
    }
}
