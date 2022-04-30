<?php
declare(strict_types=1);

namespace Taskday\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Comment extends Model implements HasMedia
{
    use Searchable, InteractsWithMedia;

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
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return mixed
     */
    public function creator(): MorphTo
    {
        return $this->morphTo('creator');
    }

    /**
     * Create a comment and persists it.
     *
     * @param Model $commentable
     * @param array $data
     * @param Model|\Illuminate\Contracts\Auth\Authenticatable $creator
     *
     * @return static
     */
    public function createComment(Model $commentable, array $data, Model $creator): self
    {
        return $commentable->comments()->create(array_merge($data, [
            'creator_id' => $creator->getAuthIdentifier(),
            'creator_type' => $creator->getMorphClass(),
        ]));
    }

    /**
     * Update a comment by an ID.
     *
     * @param int   $id
     * @param array $data
     *
     * @return bool
     */
    public function updateComment(int $id, array $data): bool
    {
        return (bool) static::find($id)->update($data);
    }

    /**
     * Delete a comment by an ID.
     *
     * @param int $id
     *
     * @return bool
     */
    public function deleteComment(int $id): bool
    {
        return (bool) static::find($id)->delete();
    }

    /**
     * Determine whether the user is the owner of the project.
     *
     * @param User $user
     * @return bool
     */
    public function ownerIs($user)
    {
        return $this->creator_id == $user->id;
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
            'body' => $this->body,
        ];
    }
}
