<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Post $post, Request $request)
    {
        $relation = $request->user()->likes()->where('post_id', $post->id);
        $relation->exists()
            ? $relation->delete()
            : $request->user()->likes()->create(['post_id' => $post->id]);
        return response()->json(['status' => 'ok']);
    }
}
