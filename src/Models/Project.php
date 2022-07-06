<?php

declare(strict_types=1);

namespace Taskday\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;
use Taskday\Builders\ProjectBuilder;
use Taskday\Models\Concerns\Archivable;
use Taskday\Models\Concerns\HasOwner;
use Taskday\Models\Concerns\Linkable;
use Taskday\Models\Concerns\Memberable;
use Taskday\Support\Page\Breadcrumb;
use Taskday\Base\Filter;

class Project extends Model
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
     * The relationship to always egaer laod.
     *
     * @var array
     */
    protected $with = ['fields'];

    /**
     * The relationship to always egaer laod.
     *
     * @var array
     */
    protected $appends = [
        'customFields',
        'breadcrumbs'
    ];

    /**
     * Get all the custom fields for the project.
     */
    public function getCustomFieldsAttribute()
    {
        return $this->fields->mapWithKeys(function ($field) {
            return [
                $field->handle => $field
            ];
        });
    }

    /**
     * Alternative title of the project for search result.
     *
     * @return Breadcrumb[]
     */
    public function getBreadcrumbsAttribute(): array
    {
        if (! $this->workspace) return [];

        return [
            new Breadcrumb($this->workspace->title, route('workspaces.show', $this->workspace)),
            new Breadcrumb($this->title, route('projects.show', $this)),
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }

    public function fields(): BelongsToMany
    {
        return $this->belongsToMany(Field::class)
            ->withPivot(['order', 'hidden', 'group'])
            ->using(FieldProject::class)
            ->orderBy('pivot_order')
            ->withTimestamps();
    }

    public function comments(): HasManyThrough
    {
        return $this->hasManyThrough(Comment::class, Card::class, 'project_id', 'commentable_id')
            ->with(['creator', 'commentable'])
            ->latest();
    }

    public function sharedUsers(): HasManyThrough
    {
        return $this->hasManyThrough(config('taskday.user.model'), Member::class, 'memberable_id', 'id', 'id', 'user_id')
            ->where('memberable_type', Project::class);
    }

    /**
     * Get workspaces only visible to the current user.
     */
    public function scopeSharedWithCurrentUser($query)
    {
        return $query->whereIn('id', Auth::user()->sharedProjects->modelKeys());
    }

    public function parent()
    {
        return $this->workspace;
    }

    public function scopeFilter(ProjectBuilder $query, array $filters, ?string $sortBy = null)
    {
        foreach ($filters as $handle => $filter) {
            if (!array_key_exists('value', $filter) || !array_key_exists('operator', $filter)) {
                continue;
            }

            $operator = match($filter['operator']) {
                'contains' => Filter::CONTAINS,
                'is_equal' => Filter::IS_EQUAL,
                'no_equal' => Filter::IS_NOT_EQUAL,
                'greater_than' => Filter::IS_GREATER_THAN,
                'less_than' => Filter::IS_LESS_THAN,
                'not_contains' => Filter::NOT_CONTAINS,
                default => Filter::IS_EQUAL,
            };

            if (array_key_exists('type', $filter) && $filter['type'] === 'builtin') {
                if ($handle == 'project') {
                    $query->where('id', $operator, $filter['value'] ?? '');
                }

                if ($handle == 'workspace') {
                    $query->whereHas('workspace', function ($query) use ($operator, $filter) {
                        $query->where('id', $operator, $filter['value'] ?? '');
                    });
                }
            } else {
                $query->whereHas('cards', function ($query) use ($handle, $operator, $filter, $sortBy) {
                    if (! is_null($sortBy)) {
                        $query->withFieldSorting($sortBy);
                    }

                    $query->withFieldFilter($handle, $operator, $filter['value'] ?? '');
                });
            }
        }
    }

    /**
     * Create a card for the given user. If the user is not
     * passed the owner will be used as owner of the
     * newly created card.
     */
    public function createCard(string $title, Model $user = null): ?Card
    {
        $user = $user ?: $this->owner;

        if ($user->cannot('update', $this)) {
            return null;
        }

        $card = $this->cards()->create([
            'title' => $title,
            'user_id' => $user->id,
        ]);

        foreach ($this->fields as $field) {
            $custom = $card->getCustom($field->handle);

            if (is_null($custom)) {
                $card->setCustom($field->handle, '');
            }
        }

        return $card;
    }

    /**
     * Add or update a custom field to the project.
     */
    public function addOrUpdateField(Field $field, array $data = []): void
    {
        $this->fields()->syncWithoutDetaching([$field->id => $data]);
    }

    /**
     * Remove the given field from the project.
     */
    public function removeField(Field $field): void
    {
        $this->fields()->detach($field->id);
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
            'title' => utf8_encode($this->title),
            'description' => $this->description,
        ];
    }

    /**
     * Begin querying the model.
     *
     * @return ProjectBuilder
     */
    public static function query(): ProjectBuilder
    {
        return parent::query();
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  Builder  $query
     * @return ProjectBuilder
     */
    public function newEloquentBuilder($query)
    {
        return new ProjectBuilder($query);
    }
}
