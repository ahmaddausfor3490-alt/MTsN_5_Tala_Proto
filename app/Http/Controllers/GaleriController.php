<?php

namespace App\Http\Controllers;

use App\Models\Post;

class GaleriController extends Controller
{
    public function index()
    {
        $albums = Post::query()
            ->published()
            ->where('content_type', 'gallery')
            ->orderByDesc('published_at')
            ->paginate(12)->withQueryString();

        return view('galeri.index', compact('albums'));
    }

    public function show(Post $post)
    {
        abort_unless($post->content_type === 'gallery' && $post->is_published, 404);

        return view('galeri.show', compact('post'));
    }
}
