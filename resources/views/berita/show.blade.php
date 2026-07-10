<x-layouts.app>

    {{-- Article Hero --}}
    <section class="relative bg-emerald-950 pt-40 md:pt-48 pb-16 md:pb-24 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-amber-400 blur-3xl"></div>
        </div>
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            {{-- Categories --}}
            <div class="flex flex-wrap items-center justify-center gap-2 mb-4">
                @forelse ($post->categories as $category)
                    <span class="px-3 py-1 rounded-full text-xs font-medium text-white shadow-sm"
                          style="background-color: {{ $category->color ?? '#059669' }}">
                        {{ $category->name }}
                    </span>
                @empty
                    <span class="px-3 py-1 rounded-full text-xs font-medium text-white shadow-sm"
                          style="background-color: #059669">Umum</span>
                @endforelse
            </div>

            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight tracking-tight mb-6">
                {{ $post->title }}
            </h1>

            {{-- Meta --}}
            <div class="flex flex-wrap items-center justify-center gap-4 text-emerald-200/70 text-sm">
                @if ($post->author)
                    <div class="flex items-center gap-2">
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        {{ $post->author->name }}
                    </div>
                @endif
                <div class="flex items-center gap-2">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $post->published_at?->locale('id')->isoFormat('D MMM YYYY') ?? $post->created_at->locale('id')->isoFormat('D MMM YYYY') }}
                </div>
            </div>
        </div>
    </section>

    {{-- Article Content --}}
    <section class="-mt-12 relative z-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <article class="bg-white rounded-2xl shadow-xl p-6 md:p-10 lg:p-12 border border-gray-100">
                {{-- Cover --}}
                @if ($post->cover_image)
                    <div class="mb-8 -mx-6 md:-mx-10 lg:-mx-12">
                        <img src="{{ asset('storage/' . $post->cover_image) }}"
                             alt="{{ $post->title }}"
                             class="w-full h-[300px] md:h-[400px] object-cover rounded-t-[calc(1.5rem-2px)]">
                    </div>
                @endif

                {{-- Body --}}
                <div class="prose prose-lg max-w-none prose-emerald prose-headings:font-bold prose-a:text-emerald-700 prose-img:rounded-xl">
                    {!! nl2br(e($post->body)) !!}
                </div>
            </article>
        </div>
    </section>

    {{-- Related Posts --}}
    @if ($relatedPosts->isNotEmpty())
    <section class="bg-gray-50 py-20 md:py-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl md:text-3xl font-bold text-emerald-900 text-center mb-10">Berita Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($relatedPosts as $related)
                    <div class="group relative rounded-2xl bg-neutral-100 p-0.5 shadow-[0_4px_20px_-8px_rgba(0,0,0,0.08)] transition-all duration-500 hover:shadow-[0_12px_40px_-6px_rgba(5,73,46,0.18)] hover:-translate-y-1">
                        <div class="rounded-[calc(1.75rem-0.375rem)] bg-white overflow-hidden relative h-full flex flex-col">
                            <div class="relative aspect-[16/10] overflow-hidden">
                                <img src="{{ $related->cover_image ? asset('storage/' . $related->cover_image) : asset('images/placeholder-news.jpg') }}"
                                     alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"/>
                            </div>
                            <div class="p-6 flex flex-col flex-grow">
                                <h3 class="text-base font-bold text-neutral-900 leading-tight mb-3 line-clamp-2 group-hover:text-emerald-800 transition">
                                    <a href="{{ route('berita.show', $related) }}" class="focus:outline-none">
                                        <span class="absolute inset-0"></span>
                                        {{ $related->title }}
                                    </a>
                                </h3>
                                <div class="flex items-center gap-1.5 text-xs text-neutral-400 pt-3 border-t border-neutral-100 mt-auto">
                                    <svg class="size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $related->published_at?->locale('id')->isoFormat('D MMM YYYY') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

</x-layouts.app>
