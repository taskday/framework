<?php

namespace Taskday\Models;

use Taskday\Builders\ProjectBuilder;
use Taskday\Models\Concerns\Archivable;
use Taskday\Models\Concerns\BelongsToUser;
use Taskday\Models\Concerns\Linkable;
use Taskday\Models\Concerns\Memberable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Query\Builder;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Taskday\Support\Page\Breadcrumb;

/**
 * @property Workspace $workspace
 * @package Taskday\Models
 */
class Project extends Model
{
    use HasFactory, Searchable, Linkable, Archivable, Memberable, BelongsToUser, LogsActivity;

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
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->useLogName('project')->logOnly(['title', 'description']);
    }


    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
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
    public function fields()
    {
        return $this->belongsToMany(Field::class)
            ->withPivot(['order', 'hidden', 'group'])
            ->using(FieldProject::class)
            ->orderBy('pivot_order')
            ->withTimestamps();
    }

    public function comments()
    {
        return $this->hasManyThrough(Comment::class, Card::class, 'project_id', 'commentable_id')->with(['creator', 'commentable'])->latest();
    }

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
        return   [
            new Breadcrumb('Dashboard', route('dashboard')),
            new Breadcrumb($this->workspace->title, route('workspaces.show', $this->workspace)),
            new Breadcrumb($this->title, route('projects.show', $this)),
        ];
    }

    /**
     * @return HasMany
     */
    public function sharedUsers(): HasManyThrough
    {
        return $this->hasManyThrough(config('taskday.user.model'), Member::class, 'memberable_id', 'id', 'id', 'user_id')
            ->where('memberable_type', Project::class);
    }

    /**
     * Create a card for the given user. If the user is
     * not passed the owner will be used as owner
     * of the newly created card.
     *
     * @param string $title
     * @param User|null $user
     * @return Card|null
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
     * @inheritdoc
     */
    public function parent()
    {
        return $this->workspace;
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
