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
use Laravel\Scout\Searchable;

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
        'label'
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
    public function createProject(string $title, Model $user)
    {
        return $this->projects()->create([
            'title' => $title,
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
     */
    public function getLabelAttribute()
    {
        return "";
    }

    /**
     * Get workspaces only visible to the current user.
     */
    public function scopeVisibleTo($query, Model $user)
    {
        $query->whereIn('id', $user->workspaces->pluck('id'));
    }
}
