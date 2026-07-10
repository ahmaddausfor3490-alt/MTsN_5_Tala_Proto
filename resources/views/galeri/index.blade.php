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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Dokumentasi
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white leading-tight tracking-tight">
                Galeri Kegiatan
            </h1>
            <div class="w-10 h-0.5 bg-amber-500 mx-auto mt-6 rounded-full mb-5"></div>
            <p class="text-base md:text-lg text-emerald-100/80 max-w-2xl mx-auto">
                Dokumentasi foto kegiatan dan momen berharga di MTsN 5 Tanah Laut.
            </p>
        </div>
    </section>

    {{-- Albums Grid --}}
    <section class="-mt-8 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($albums->isEmpty())
                <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
                    <svg class="mx-auto size-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-500 font-medium">Belum ada galeri yang tersedia.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($albums as $album)
                        <a href="{{ route('gallery.show', $album) }}"
                           class="group block bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-gray-100">
                            {{-- Cover --}}
                            <div class="relative aspect-[16/10] overflow-hidden">
                                @php
                                $cover = collect($album->gallery_images)->first();
                            @endphp

                            @if ($cover)
                                <img
                                    src="{{ asset('storage/' . $cover) }}"
                                    alt="{{ $album->title ?: $album->published_at->translatedFormat('d F Y') }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                >
                            @else
                                    <div class="w-full h-full bg-emerald-100 flex items-center justify-center">
                                        <svg class="size-12 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                                <div class="absolute bottom-4 left-4 right-4">
                                    <h3 class="text-white font-bold text-lg leading-tight line-clamp-2">{{ $album->title }}</h3>
                                    <p class="text-white/80 text-xs mt-1">{{ $album->title ?: $album->published_at->translatedFormat('d F Y') }}</p>
                                </div>
                            </div>
                            {{-- Thumbnail Strip --}}
                            <div class="p-4">
                                @php
                                    $thumbImages = array_filter((array) ($album->gallery_images ?? []));
                                @endphp
                                @if ($thumbImages)
                                    <div class="flex gap-2 overflow-hidden">
                                        @foreach (array_slice($thumbImages, 0, 4) as $thumb)
                                            <img src="{{ asset('storage/' . $thumb) }}"
                                                 alt=""
                                                 class="w-1/4 h-12 object-cover rounded flex-shrink-0">
                                        @endforeach
                                    </div>
                                @endif
                                <div class="mt-3 flex items-center justify-between text-xs text-gray-500">
                                    <span>{{ count($thumbImages) }} foto</span>
                                    <span class="inline-flex items-center gap-1 text-emerald-700 font-semibold group/link">
                                        Buka
                                        <svg class="size-3.5 transition-transform group-hover/link:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $albums->links() }}
                </div>
            @endif
        </div>
    </section>

</x-layouts.app>
