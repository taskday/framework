<?php

namespace Taskday\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CardField extends Pivot
{
    use LogsActivity;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
       'card',
       'field'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'card_field';

    /**
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['value']);
    }

    /**
     * @return BelongsTo
     */
    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }

    /**
     * @return BelongsTo
     */
    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }
}
