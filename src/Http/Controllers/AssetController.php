<?php

namespace Taskday\Http\Controllers;

use Taskday\Facades\Taskday;
class AssetController extends Controller
{
    public function scripts($handle)
    {
        $plugin = Taskday::plugins()->get($handle);

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
        $plugin = Taskday::plugins()->get($handle);

        $bundle = $plugin->bundle();

        $path = $bundle->styles()[0] ?? null;

        if(is_null($path)) {
            return response('', 200);
        }

        return response(
            file_get_contents($path),
            200,
            [
                'Content-Type' => 'text/css',
            ]
        )->setLastModified(\DateTime::createFromFormat('U', (string) filemtime($path)));
    }
}
