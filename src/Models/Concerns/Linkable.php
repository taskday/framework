<?php
declare(strict_types = 1);

namespace Taskday\Models\Concerns;

use Illuminate\Support\Str;

trait Linkable
{
    public function initializeLinkable()
    {
        $this->appends[] = 'link';
    }

    public function getLinkAttribute()
    {
        $class = new \ReflectionClass(static::class);

        $name = Str::of($class->getShortName())->plural()->lower();

        return route("$name.show", $this);
    }
}
