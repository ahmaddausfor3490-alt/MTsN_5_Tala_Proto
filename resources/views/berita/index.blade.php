<x-layouts.app>

    {{-- Page Header --}}
    <section class="relative bg-emerald-950 py-24 md:py-32 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-amber-400 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 rounded-full bg-emerald-400 blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-[11px] font-semibold uppercase tracking-[0.2em] text-amber-400 mb-4">
                <svg class="size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                Info Terkini
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white leading-tight tracking-tight">
                Berita &amp; Kegiatan
            </h1>
            <div class="w-10 h-0.5 bg-amber-500 mx-auto mt-6 rounded-full mb-5"></div>
            <p class="text-base md:text-lg text-emerald-100/80 max-w-2xl mx-auto">
                Update terbaru seputar kegiatan, prestasi, dan pengumuman resmi dari MTsN 5 Tanah Laut.
            </p>
        </div>
    </section>

    {{-- Filter Bar + Listing --}}
    <section class="relative z-10 -mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl p-4 md:p-6 mb-8 border border-gray-100">

                {{-- Search --}}
                <form method="GET" action="{{ route('news') }}" class="flex flex-col md:flex-row gap-4">
                    {{-- Category Filter --}}
                    <div class="flex-1">
                        <select name="category" onchange="this.form.submit()"
                            class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm text-gray-700 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }} ({{ $cat->posts_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>

            {{-- Posts Grid --}}
            @if ($posts->isEmpty())
                <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
                    <svg class="mx-auto size-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <p class="text-gray-500 font-medium">Belum ada berita yang tersedia.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($posts as $post)
                        <article class="group relative rounded-2xl bg-neutral-100 p-0.5 shadow-[0_4px_20px_-8px_rgba(0,0,0,0.08)] transition-all duration-500 hover:shadow-[0_12px_40px_-6px_rgba(5,73,46,0.18)] hover:-translate-y-1">
                            <div class="rounded-[calc(1.75rem-0.375rem)] bg-white overflow-hidden relative h-full flex flex-col">

                                {{-- Cover Image --}}
                                <div class="relative aspect-[16/10] overflow-hidden">
                                    <img src="{{ $post->cover_image ? asset('storage/' . $post->cover_image) : asset('images/placeholder-news.jpg') }}"
                                         alt="{{ $post->title }}"
                                         class="w-full h-full object-cover transition-transform duration-700 ease-[cubic-bezier(0.32,0.72,0,1)] group-hover:scale-105"/>
                                </div>

                                {{-- Card Body --}}
                                <div class="relative p-6 flex flex-col flex-grow">
                                    {{-- Categories --}}
                                    <div class="flex flex-wrap items-center gap-2 mb-3">
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

                                    {{-- Title --}}
                                    <h3 class="text-lg font-bold text-neutral-900 leading-tight mb-2 group-hover:text-emerald-800 transition-colors duration-300 line-clamp-2">
                                        <a href="{{ route('berita.show', $post) }}" class="focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                                            <span class="absolute inset-0"></span>
                                            {{ $post->title }}
                                        </a>
                                    </h3>

                                    {{-- Excerpt --}}
                                    <p class="text-sm text-neutral-500 leading-relaxed mb-4 line-clamp-3 flex-grow">
                                        {{ Str::limit($post->excerpt ?? '', 120) }}
                                    </p>

                                    {{-- Footer --}}
                                    <div class="flex items-center justify-between pt-4 border-t border-neutral-100 mt-auto">
                                        <div class="flex items-center gap-1.5 text-xs text-neutral-400">
                                            <svg class="size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            @if($post->published_at)
                                                {{ $post->published_at->locale('id')->isoFormat('D MMM YYYY') }}
                                            @else
                                                {{ $post->created_at->locale('id')->isoFormat('D MMM YYYY') }}
                                            @endif
                                        </div>
                                        <a href="{{ route('berita.show', $post) }}"
                                           class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 hover:text-emerald-600 transition group/link">
                                            Baca
                                            <svg class="size-3.5 transition-transform duration-300 group-hover/link:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </section>

</x-layouts.app>
