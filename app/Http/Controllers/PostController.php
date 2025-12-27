<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'tags'])
            ->latest();
        if (! $request->user()) {
            $query->where('visibility', 'public');
        }
        return $query->paginate(10);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'visibility' => 'in:public,private',
            'tags' => 'array',
            'image' => 'nullable|image|max:2048',
        ]);

        $post = $request->user()->posts()->create($data);

        if (! empty($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return response()->json($post->load('tags'), 201);
    }
}
