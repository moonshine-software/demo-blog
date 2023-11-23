<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function __invoke(CommentRequest $request): RedirectResponse
    {
        /* @var Model $model */
        $model = new $request->type;
        $item = $model->findOrFail($request->id);

        if($request->comment_id) {
            Comment::query()
                ->where('id', $request->comment_id)
                ->whereNull('comment_id')
                ->firstOrFail();
        }

        $item->comments()->create([
            'user_id' => auth()->id(),
            'comment_id' => $request->comment_id ?? null,
            'text' => $request->text
        ]);

        return redirect()->back();
    }
}
