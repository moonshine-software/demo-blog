<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;

class LikesController extends Controller
{
    public function __invoke(LikeRequest $request): RedirectResponse
    {
        /* @var Model $model */
        $model = new $request->type;
        $item = $model->findOrFail($request->id);

        $like = $item->likes()->firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        if(!$like->wasRecentlyCreated) {
            $like->delete();
        }

        return redirect()->back();
    }
}
