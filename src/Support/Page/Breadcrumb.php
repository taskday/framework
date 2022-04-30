<?php

namespace Taskday\Support\Page;

use Illuminate\Contracts\Support\Arrayable;

class Breadcrumb implements Arrayable
{
    public function __construct(
        public string $title,
        public ?string $url = null
    ) { }

    public function toArray()
    {
        return [
            'title' => $this->title,
            'url' => $this->url,
        ];
    }
}
