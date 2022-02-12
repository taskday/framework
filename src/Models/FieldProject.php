<?php

namespace Taskday\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;

class FieldProject extends Model
{
    use AsPivot;
    use HasFactory;

    protected $fillable = [
        'field_id',
        'project_id',
    ];

    protected $casts = [
        'hidden' => 'boolean'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
