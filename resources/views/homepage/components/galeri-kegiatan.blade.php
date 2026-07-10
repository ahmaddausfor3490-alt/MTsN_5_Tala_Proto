{{-- =============================================
    GALERI KEGIATAN (Student Activities Gallery)
    Layout: Horizontal scroll cards (album-style)
    Style: Double-bezel framed cards with gradient overlays
    ============================================= --}}

<section class="relative bg-white py-24 md:py-32 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Eyebrow + Heading --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-12 md:mb-16">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full bg-emerald-900/5 px-4 py-1.5 text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-800 mb-4">
                    <span class="size-1.5 rounded-full bg-amber-500"></span>
                    Galeri
                </span>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-emerald-950 leading-[1.1] tracking-tight">
                    Galeri Kegiatan
                </h2>
                <div class="w-10 h-0.5 bg-gradient-to-r from-amber-500 to-emerald-700 mt-6 rounded-full mb-5 sm:mb-0"></div>
            </div>
            <a href="{{ route('gallery.index') }}" class="shrink-0 inline-flex items-center gap-2 text-sm font-semibold text-emerald-800 hover:text-emerald-700 transition group">
                Lihat Semua
                <svg class="size-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        {{-- Horizontal Scroll Container --}}
        <div class="relative -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8">
            {{-- Gradient fade edges --}}
            <div class="pointer-events-none absolute left-0 top-0 bottom-0 z-10 w-12 sm:w-20 bg-gradient-to-r from-white to-transparent"></div>
            <div class="pointer-events-none absolute right-0 top-0 bottom-0 z-10 w-12 sm:w-20 bg-gradient-to-l from-white to-transparent"></div>

            <div class="flex gap-5 overflow-x-auto pb-6 snap-x snap-mandatory scrollbar-hide" style="-webkit-overflow-scrolling: touch; scrollbar-width: none;">
                @if ($galleryAlbums->isNotEmpty())
                    @foreach($galleryAlbums as $index => $album)
                        <div class="snap-start shrink-0 w-[280px] sm:w-[320px]">
                            <a href="{{ route('gallery.show', $album) }}"
                               class="block group rounded-[1.5rem] bg-neutral-100 p-0.5 shadow-[0_4px_20px_-8px_rgba(0,0,0,0.1)] transition-all duration-500 hover:shadow-[0_12px_40px_-6px_rgba(5,73,46,0.2)] hover:-translate-y-1">
                                <div class="rounded-[calc(1.5rem-0.375rem)] overflow-hidden relative aspect-[4/3]">
                                   @php
                                        $cover = collect($album->gallery_images ?? [])->first();
                                        @endphp
                                        @if ($cover)
                                            <img
                                                src="{{ asset('storage/' . $cover) }}"
                                                alt="{{ $album->title ?: 'Galeri Kegiatan' }}"
                                                loading="lazy"
                                                class="w-full h-full object-cover transition-transform duration-700 ease-[cubic-bezier(0.32,0.72,0,1)] group-hover:scale-105"
                                            />
                                        @else
                                        <div class="w-full h-full bg-emerald-100 flex items-center justify-center">
                                            <svg class="size-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif

                                    {{-- Gradient overlay --}}
                                    <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/80 via-emerald-950/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                                    {{-- Caption --}}
                                    <div class="absolute bottom-0 left-0 right-0 p-5 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                                        <p class="text-white text-sm font-medium leading-snug">{{ $album->title }}</p>
                                        @php
                                            $photoCount = count(array_filter((array)($album->gallery_images ?? [])));
                                        @endphp
                                        <p class="text-white/60 text-[11px] mt-1">{{ $photoCount }} foto</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="w-full text-center py-8">
                        <p class="text-neutral-400 text-sm italic">Belum ada galeri kegiatan yang tersedia.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Scroll hint --}}
        <div class="hidden sm:flex items-center justify-center gap-2 mt-6 text-xs text-neutral-400">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/></svg>
            Geser untuk melihat lebih banyak
        </div>
    </div>
</section>
