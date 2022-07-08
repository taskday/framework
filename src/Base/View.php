<?php

declare(strict_types=1);

namespace Taskday\Base;

use Taskday\Base\Concerns\HasType;
use Illuminate\Contracts\Support\Arrayable;

abstract class View implements Arrayable
{
    use HasType;

    public function toArray()
    {
        return [
            'type' => static::type()
        ];
    }
}
