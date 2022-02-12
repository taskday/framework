<?php

namespace Taskday\Http\Controllers;

class AssetController extends Controller
{
    public function scripts($handle)
    {
        $plugin = taskday()->plugins()->get($handle);

        $bundle = $plugin->bundle();

        $path = $bundle->scripts()[0];

        return response(
            file_get_contents($path),
            200,
            [
                'Content-Type' => 'application/javascript',
            ]
        )->setLastModified(\DateTime::createFromFormat('U', (string) filemtime($path)));
    }

    public function styles($handle)
    {
        $path = taskday()->styles[$handle] ?? null;

        abort_if(is_null($path), 404);

        return response(
            file_get_contents($path),
            200,
            [
                'Content-Type' => 'text/css',
            ]
        )->setLastModified(\DateTime::createFromFormat('U', (string) filemtime($path)));
    }
}
