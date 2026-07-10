{{-- ==============================================
    BERITA TERBARU (Latest News)
    Layout: Responsive card grid
    Style: Premium editorial cards — double-bezel framed
    Data Source: Post model + Category model
    ============================================== --}}

<section class="relative bg-white py-24 md:py-32 overflow-hidden">
    {{-- Subtle decorative elements --}}
    <div class="pointer-events-none absolute top-0 right-0 w-96 h-96 rounded-full bg-emerald-100/20 blur-3xl"></div>
    <div class="pointer-events-none absolute bottom-10 left-0 w-80 h-80 rounded-full bg-amber-100/20 blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Eyebrow + Heading --}}
        <div class="text-center max-w-2xl mx-auto mb-16 md:mb-20">
            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-900/5 px-4 py-1.5 text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-800 mb-4">
                <svg class="size-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                Berita
            </span>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-emerald-950 leading-[1.1] tracking-tight">
                Berita Terbaru
            </h2>
            <div class="w-10 h-0.5 bg-gradient-to-r from-amber-500 to-emerald-700 mx-auto mt-6 rounded-full mb-5"></div>
            <p class="text-base md:text-lg text-neutral-600 leading-relaxed">
                Informasi terbaru, prestasi, kegiatan, akademik, dan pengumuman resmi MTsN 5 Tanah Laut.
            </p>
        </div>

        {{-- Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6">

            @forelse($posts as $post)
                <div class="group relative rounded-[1.75rem] bg-neutral-100 p-0.5 shadow-[0_4px_20px_-8px_rgba(0,0,0,0.08)] transition-all duration-500 hover:shadow-[0_12px_40px_-6px_rgba(5,73,46,0.18)] hover:-translate-y-1">
                    <div class="rounded-[calc(1.75rem-0.375rem)] bg-white overflow-hidden relative h-full flex flex-col">

                        {{-- Cover Image --}}
                        <div class="relative aspect-[16/10] overflow-hidden">
                            <img
                                src="{{ $post->cover_image ? asset('storage/' . $post->cover_image) : asset('images/placeholder-news.jpg') }}"
                                alt="{{ $post->title }}"
                                loading="lazy"
                                class="w-full h-full object-cover transition-transform duration-700 ease-[cubic-bezier(0.32,0.72,0,1)] group-hover:scale-105"
                            />
                            {{-- Gradient overlay on image --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent pointer-events-none"></div>
                        </div>

                        {{-- Card Body --}}
                        <div class="relative p-6 flex flex-col flex-grow">

                            {{-- Category Badges + Date Row --}}
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                @forelse($post->categories as $category)
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium text-white shadow-sm"
                                        style="background-color: {{ $category->color ?? '#059669' }}">
                                        {{ $category->name }}
                                    </span>
                                @empty
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium text-white shadow-sm"
                                        style="background-color: #059669">
                                        Umum
                                    </span>
                                @endforelse
                            </div>

                            {{-- Title --}}
                            <h3 class="text-lg font-bold text-neutral-900 leading-tight mb-2 group-hover:text-emerald-800 transition-colors duration-300 line-clamp-2">
                                <a href="{{ route('berita.show', $post) }}" class="focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 focus-visible:ring-offset-2 rounded">
                                    <span class="absolute inset-0"></span>
                                    {{ $post->title }}
                                </a>
                            </h3>

                            {{-- Excerpt --}}
                            <p class="text-sm text-neutral-500 leading-relaxed mb-4 line-clamp-3 flex-grow">
                                {{ $post->excerpt }}
                            </p>

                            {{-- Footer Row: Date + Link --}}
                            <div class="flex items-center justify-between pt-4 border-t border-neutral-100 mt-auto">
                                {{-- Publish Date --}}
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

                                {{-- Read More Link --}}
                                <a
                                    href="{{ route('berita.show', $post) }}"
                                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 hover:text-emerald-600 transition group/link focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                                    Baca Selengkapnya
                                    <svg class="size-3.5 transition-transform duration-300 group-hover/link:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Empty State --}}
                <div class="md:col-span-2 lg:col-span-3 text-center py-16">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-neutral-100 mb-4">
                        <svg class="size-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <p class="text-neutral-500 text-sm font-medium">Belum ada berita yang tersedia.</p>
                    <p class="text-neutral-400 text-xs mt-1">Konten akan muncul setelah admin mempublikasikan berita.</p>
                </div>
            @endforelse

        </div>

        {{-- Footer Button --}}
        <div class="text-center mt-12">
            <a
                href="{{ route('news') }}"
                class="group inline-flex items-center gap-2 rounded-full bg-emerald-900 px-8 py-3.5 text-sm font-semibold text-white shadow-lg shadow-emerald-900/20 transition-all duration-500 hover:bg-emerald-800 hover:shadow-xl hover:shadow-emerald-800/25 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
            >
                Lihat Semua Berita
                <svg class="size-4 transition-transform duration-300 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

    </div>
</section>
