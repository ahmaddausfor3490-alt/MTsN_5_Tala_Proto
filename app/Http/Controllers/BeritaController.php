<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query()
            ->published()
            ->where('content_type', 'news')
            ->with(['author', 'categories']);

        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        $posts = $query->orderByDesc('published_at')->paginate(9)->withQueryString();
        $categories = Category::withCount('posts')->whereHas('posts', function ($q) {
            $q->where('content_type', 'news')->where('status', 'published');
        })->get();

        return view('berita.index', compact('posts', 'categories'));
    }

    public function show(Post $post)
    {
        abort_unless($post->content_type === 'news' && $post->is_published, 404);

        $relatedPosts = Post::query()
            ->published()
            ->where('content_type', 'news')
            ->where('id', '!=', $post->id)
            ->with('categories')
            ->whereHas('categories', function ($q) use ($post) {
                $q->whereIn('id', $post->categories->pluck('id'));
            })
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('berita.show', compact('post', 'relatedPosts'));
    }
}
