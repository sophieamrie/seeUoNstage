<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::where('user_id', Auth::id())->with('event')->get();
        return view('user.favorites.index', compact('favorites'));
    }

    public function store($eventId)
    {
        Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'event_id' => $eventId,
        ]);

        return back();
    }

    public function destroy($eventId)
    {
        Favorite::where('user_id', Auth::id())
                ->where('event_id', $eventId)
                ->delete();

        return back();
    }

    public function toggle(Event $event)
    {
        $favorite = Favorite::where('user_id', Auth::id())
                            ->where('event_id', $event->id)
                            ->first();

        if ($favorite) {
            $favorite->delete();
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'event_id' => $event->id,
            ]);
        }

        return back();
    }
}