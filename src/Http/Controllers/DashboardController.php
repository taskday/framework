<?php

namespace Taskday\Http\Controllers;

use Taskday\Facades\Taskday;
use Taskday\Models\Card;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'title' => 'Dashboard',
            'widgets' => Taskday::widgets(),
            'cards' => Card::query()
                ->with(['comments'])
                ->where('user_id', Auth::id())
                ->when(Request::input('search'), function ($query) {
                    $query->whereIn('id', Card::search(Request::input('search'))->get()->pluck('id'));
                })
                ->orderBy('updated_at', 'desc')
                ->paginate(20)
                ->withQueryString()
                ->through(fn ($card) => [
                    'id' => $card->id,
                    'title' => $card->title,
                    'content' => $card->content,
                    'comments' => $card->comments,
                ]),
            'filters' => Request::only(['search', 'card']),
        ]);
    }
}
