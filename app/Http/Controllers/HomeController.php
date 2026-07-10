<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Faq;
use App\Models\Post;
use App\Models\Teacher;
use App\Models\Setting;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function __invoke()
    {
        $newsPosts = Post::query()
            ->published()
            ->where('content_type', 'news')
            ->with('categories')
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        $galleryAlbums = Post::query()
            ->published()
            ->where('content_type', 'gallery')
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        $stats = [
            'teachers' => Teacher::query()->where('is_active', true)->count(),
            'students' => (int) (Setting::where('key', 'total_students')->value('value') ?? 0),
            'posts' => $newsPosts->count(),
            'announcements' => Announcement::query()->active()->count(),
            'upcoming_agenda' => Agenda::query()->upcoming()->count(),
            'gallery_items' => Post::query()
                ->published()
                ->where('content_type', 'gallery')
                ->count(),
            'faqs' => Faq::query()->where('is_active', true)->count(),
        ];

        return view('home', [
            'stats' => $stats,
            'galleryImages' => $galleryAlbums->flatMap(function ($post) {
                $images = $post->gallery_images ?? [];
                return collect($images)->map(fn ($path) => [
                    'path'    => $path,
                    'caption' => $post->title,
                    'date'    => $post->published_at?->toDateString(),
                ])->filter(fn ($img) => ! empty($img['path']));
            })->take(8)->values(),
            'testimonials' => Testimonial::query()
                ->where('is_active', true)
                ->orderByDesc('created_at')
                ->limit(6)
                ->get(['id', 'name', 'role', 'avatar', 'text', 'rating'])
                ->values(),
            'posts' => $newsPosts,
            'galleryAlbums' => $galleryAlbums,
        ]);
    }
}
