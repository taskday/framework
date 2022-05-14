<?php

namespace Taskday\Models;

use Taskday\Builders\CardBuilder;
use Taskday\Events\CardFieldUpdatedEvent;
use Taskday\Models\Concerns\Commentable;
use Taskday\Models\Concerns\Linkable;
use Taskday\Fields\Filter;
use Taskday\Fields\Filters\ContainsFilter;
use Taskday\Fields\Filters\EqualsFilter;
use Taskday\Fields\Filters\NotContainsFilter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;
use Taskday\Facades\Taskday;
use Taskday\Support\Page\Breadcrumb;

/**
 * @property Project $project
 */
class Card extends Model
{
    use HasFactory, Searchable, Linkable, Commentable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $with = [
        'user',
        'fields',
    ];

    /**
     * The attributes the are included in the json.
     *
     * @var array
     */
    protected $appends = [
        'customFields',
        'breadcrumbs'
    ];

    /**
     * Model boot
     */
    protected static function boot() {
        parent::boot();
        static::addGlobalScope('order', function (CardBuilder $builder) {
            $builder->orderBy('order', 'desc');
        });
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(config('taskday.user.model'));
    }

    /**
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @return BelongsToMany
     */
    public function fields(): BelongsToMany
    {
        return $this->belongsToMany(Field::class)
            ->using(CardField::class)
            ->withPivot('value');
    }

    /**
     * Return handle mapping for fields
     */
    public function getCustomFieldsAttribute()
    {
        return $this->fields->mapWithKeys(function($field) {
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
            new Breadcrumb($this->project->workspace->title, route('workspaces.show', $this->project->workspace)),
            new Breadcrumb($this->project->title, route('projects.show', $this->project)),
        ];
    }

    /**
     * @param string $handle
     * @param Field|null $field
     * @return CustomField
     */
    public function getCustom(string $handle, $field = null)
    {
        if (is_null($field)) {
            $field = $this->fields()->where('handle', $handle)->first();
        }

        return optional($field);
    }

    /**
     * Set the value of the given custom field.
     */
    public function setCustom(Field $field, ?string $value = null): self
    {
        $oldValue = $field->cards()->where('card_id', $this->id)->first()?->pivot?->value ?? '';

        $field->cards()->syncWithoutDetaching(
            [$this->id => ['value' => $value ?? '']]
        );

        event(new CardFieldUpdatedEvent($oldValue, $value ?? '', $field, $this));

        return $this;
    }

    /**
     * Set the value of the given custom field.
     *
     * @param Field $field
     * @param string $value
     * @return Collection
     */
    public function getFieldsByType(string $type)
    {
        return $this->fields()->where('type', $type)->get();
    }

    /**
     * Begin querying the model.
     *
     * @return CardBuilder
     */
    public static function query() : CardBuilder
    {
        return parent::query();
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  Builder  $query
     * @return CardBuilder
     */
    public function newEloquentBuilder($query)
    {
        return new CardBuilder($query);
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
            'content' => $this->content,
        ];
    }

    public function scopeWithFieldHandle($query, $handle)
    {
        $query->whereHas('fields', fn ($q) => $q->where('handle', $handle));
    }

    /**
     *
     * @param mixed $query
     * @param string $class The custom field class
     * @param string $value
     * @return $this|void
     */
    public function scopeWithFieldFilter(\Illuminate\Database\Eloquent\Builder $query, string $handle, string $operator, string $value)
    {
        $operator = match ($operator) {
            Filter::IS_EQUAL => new EqualsFilter(),
            Filter::IS_NOT_EQUAL => new EqualsFilter(),
            Filter::IS_GREATER_THAN => new EqualsFilter(),
            Filter::IS_LESS_THAN => new EqualsFilter(),
            Filter::CONTAINS => new ContainsFilter(),
            Filter::NOT_CONTAINS => new NotContainsFilter(),
            default => null
        };

        if (is_null($operator)) {
            return $this;
        }

        $operator->handle($query, $handle, $value);
    }

    /**
     *
     * @param mixed $query
     * @param string $class The custom field class
     * @param string $value
     * @return $this|void
     */
    public function scopeWithFieldSorting(\Illuminate\Database\Eloquent\Builder $query, string $handle)
    {
        $desc = str_starts_with($handle, '-');
        $field = Field::where('handle', str_replace('-', '', $handle))->first();

        Taskday::getFieldByType($field->type);

        $sorter = Taskday::getFieldByType($field->type)?->getSorter();

        if (is_null($sorter)) {
            return $query->addSelect([
                'handle_value' => Field::select(['card_field.value'])
                    ->whereColumn('card_field.card_id', 'cards.id')
                    ->join('card_field', 'card_field.field_id', '=', 'fields.id')
                    ->where('handle', $handle)
                    ->take(1),
            ])
            ->orderBy(
                'handle_value',
                $desc ? 'DESC' : 'ASC'
            );
        } else {
            return $sorter->handle($query, $field, $desc);
        }
    }

    /**
     * Get workspaces only visible to the current user.
     */
    public function scopeSharedWithCurrentUser($query)
    {
        $projects = Card::select('id')
            ->whereHas('project', function ($project) {
                $project->sharedWithCurrentUser()->whereHas('workspace', function ($query) {
                    $query->where('team_id', Auth::user()->current_team_id);
                });
            })
            ->pluck('id')
            ->unique()
            ->values();

        $query->whereIn('id', $projects);
    }
}
