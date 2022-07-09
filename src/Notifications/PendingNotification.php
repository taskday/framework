<?php

namespace Taskday\Notifications;
class PendingNotification
{
    public $title = '';

    public $body = '';

    public $actionUrl = null;

    public $actionLabel = null;

    public $user = null;

    public function title(string $title): static
    {
        $this->title = $title;

        return  $this;
    }

    public function body(string $body): static
    {
        $this->body = $body;

        return  $this;
    }

    public function action(string $label, string $url): static
    {
        $this->actionUrl = $url;
        $this->actionLabel = $label;

        return  $this;
    }

    public function user($user): static
    {
        $this->user = $user;

        return  $this;
    }
}
