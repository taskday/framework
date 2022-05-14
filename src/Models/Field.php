<?php

namespace Taskday\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Taskday\Plugins\CustomField;
use Database\Factories\FieldFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method FieldFactory static factory(...$args)
 * @package Taskday\Models
 */
class Field extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
        'hidden' => 'boolean'
    ];

    /**
     *
     * @return BelongsToMany
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)
            ->using(FieldProject::class)
            ->withTimestamps();
    }

    /**
     *
     * @return BelongsToMany
     */
    public function cards(): BelongsToMany
    {
        return $this->belongsToMany(Card::class)
            ->using(CardField::class)
            ->withPivot('value');
    }

    public function scopeHandle($query, string $handle)
    {
        return $query->where('handle', $handle);
    }
}
