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
use Laravel\Scout\Searchable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @property Project $project
 */
class Card extends Model
{
    use HasFactory, Searchable, Linkable, Commentable, LogsActivity;

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
        'activities.causer'
    ];

    /**
     * The attributes the are included in the json.
     *
     * @var array
     */
    protected $appends = [
        'customFields',
        'label'
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
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['title']);
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
     */
    public function getLabelAttribute()
    {
        return "{$this->project->workspace->title} / {$this->project->title}";
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
     *
     * @param Field $field
     * @param string $value
     * @return self
     */
    public function setCustom(Field $field, string $value): self
    {
        $oldValue = $field->cards()->where('card_id', $this->id)->first()?->pivot?->value ?? '';

        $field->cards()->syncWithoutDetaching(
            [$this->id => ['value' => $value]]
        );

        event(new CardFieldUpdatedEvent($oldValue, $value, $field, $this));

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
        return $this->fields()->without('activities')->where('type', $type)->get();
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
    public function scopeWithFieldFilter(\Illuminate\Database\Eloquent\Builder $query, string $class, string $operator, string $value)
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

        $operator->handle($query, $class, $value);
    }
}
