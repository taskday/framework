<?php

namespace Taskday\Http\Controllers;

use Taskday\Facades\Taskday;
use Illuminate\Http\Response;

class AssetController extends Controller
{
    protected function file($type, $path): Response
    {

        if (! file_exists($path) || $path === false) {
            $data = $path;
            $timestamp = \DateTime::createFromFormat('U', now()->format('U'));
        } else {
            $data = file_get_contents($path);
            $timestamp = \DateTime::createFromFormat('U', (string) filemtime($path));
        }


        return response($data, 200, [
            'Content-Type' => $type,
        ])
        ->setLastModified($timestamp);
    }

    public function scripts($handle)
    {
        $plugin = app($handle);

        $bundle = $plugin->bundle();

        if (! $bundle) {
            return $this->file('application/javascript', '');
        }

        if ($path = ($bundle->scripts()[0] ?? null)) {
            return $this->file('application/javascript', $path);
        }

        return $this->file('application/javascript', '');
    }

    public function styles($handle)
    {
        $plugin = app($handle);

        $bundle = $plugin->bundle();

        if (! $bundle) {
            return $this->file('text/css', '');
        }

        if ($path = ($bundle->styles()[0] ?? null)) {
            return $this->file('text/css', $path);
        }

        return $this->file('text/css', '');
    }
}
