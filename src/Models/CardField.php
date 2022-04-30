<?php

namespace Taskday\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CardField extends Pivot
{
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
