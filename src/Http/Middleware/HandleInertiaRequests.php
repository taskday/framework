<?php

namespace Taskday\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Middleware;
use Taskday\Http\Resources\UserResource;
use Taskday\Models\Workspace;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'taskday::app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Closure  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        $response = parent::handle($request, $next);

        if ($response instanceof RedirectResponse && (bool) $request->header('X-Inertia-Modal-Redirect-Back')) {
            return back(303);
        }

        if (Inertia::getShared('isModal')) {
            $response->headers->set('X-Inertia-Modal', true);
        }

        return $response;
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'isModal' => (bool) $request->header('X-Inertia-Modal'),
            'csrf_token' => csrf_token(),
            'user' => Auth::check() ? UserResource::make(Auth::user()) : null,
            'global' => Auth::check() ? [
                'workspaces' => Workspace::sharedWithCurrentUser()->get(),
                'notifications' => Auth::user()->unreadNotifications,
                'users' => Auth::user()->currentTeam ? Auth::user()->currentTeam->allUsers()->transform(function ($user) {
                    return UserResource::make($user);
                }) : [],
            ] : [],
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                ];
            },
        ]);
    }
}
