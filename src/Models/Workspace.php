<?php

declare(strict_types=1);

namespace Taskday\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;
use Taskday\Models\Concerns\Archivable;
use Taskday\Models\Concerns\HasOwner;
use Taskday\Models\Concerns\Linkable;
use Taskday\Models\Concerns\Memberable;
use Taskday\Support\Page\Breadcrumb;

class Workspace extends Model
{
    use HasFactory,
        HasOwner,
        Memberable,
        Searchable,
        Linkable,
        Archivable;

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
     * Breadcrumbs for the current workspace.
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

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Filter the query by the current user.
     */
    public function scopeSharedWithCurrentUser(Builder $query)
    {
        return $query->whereIn('id', Auth::user()->sharedWorkspaces->modelKeys());
    }

    /**
     * Create a project passing a title or an array of data.
     */
    public function createProject(array|string $data, Model $user): Project
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
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->getKey(),
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
