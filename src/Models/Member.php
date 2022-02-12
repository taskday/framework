<?php

namespace Taskday\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Member extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $with = ['user'];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Get the commentable entity that the comment belongs to.
     *
     * @return mixed
     */
    public function memberable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * User related to this member model.
     *
     * @return mixed
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(config('taskday.user.model'));
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            "id" => $this->id,
            "memberable" => $this->memberable->toArray(),
            "user" => $this->user->toArray(),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
