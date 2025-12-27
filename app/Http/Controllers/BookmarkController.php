<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function toggle(Post $post, Request $request)
    {
        $relation = $request->user()->bookmarks()->where('post_id', $post->id);

        $relation->exists()
            ? $relation->delete()
            : $request->user()->bookmarks()->create(['post_id' => $post->id]);

        return response()->json(['status' => 'ok']);
    }
}
