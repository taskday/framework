<?php

namespace Taskday\Base\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Laravel\Scout\Searchable;
use OwenIt\Auditing\Contracts\Auditable;
use Taskday\Models\Concerns\Linkable;

/**
 * @property Project $project
 */
class Model extends EloquentModel implements Auditable
{
    use HasFactory,
        Searchable,
        Linkable,
        \OwenIt\Auditing\Auditable;
}
