<x-layouts.app>

    {{-- Album Header --}}
    <section class="relative bg-emerald-950 py-24 md:py-32 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-amber-400 blur-3xl"></div>
        </div>
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white leading-tight tracking-tight mb-4">
                {{ $post->title }}
            </h1>
            <div class="flex items-center justify-center gap-2 text-emerald-200/70 text-sm">
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                @if($post->published_at)
                    {{ $post->published_at->locale('id')->isoFormat('D MMM YYYY') }}
                @else
                    {{ $post->created_at->locale('id')->isoFormat('D MMM YYYY') }}
                @endif
            </div>
        </div>
    </section>

    {{-- Gallery Content --}}
    <section class="-mt-8 relative z-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl p-6 md:p-10 border border-gray-100">

                {{-- Description --}}
                @if ($post->body || $post->excerpt)
                    <div class="prose max-w-none mb-8 text-gray-700">
                        <p>{!! nl2br(e($post->excerpt ?: $post->body)) !!}</p>
                    </div>
                @endif

                {{-- Cover --}}
                @if ($post->cover_image)
                    <div class="mb-8 -mx-6 md:-mx-10">
                        <img src="{{ asset('storage/' . $post->cover_image) }}"
                             alt="{{ $post->title }}"
                             class="w-full h-[300px] md:h-[400px] object-cover rounded-xl">
                    </div>
                @endif

                {{-- Gallery Grid --}}
                @php
                    $images = array_filter((array) ($post->gallery_images ?? []));
                @endphp

                @if ($images)
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($images as $image)
                            <a href="{{ asset('storage/' . $image) }}"
                               target="_blank"
                               class="group block rounded-xl overflow-hidden ring-1 ring-gray-200 hover:shadow-lg transition-all duration-300">
                                <img src="{{ asset('storage/' . $image) }}"
                                     alt="{{ $post->title }}"
                                     class="w-full h-40 md:h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-gray-400 py-8 italic">Belum ada foto dalam galeri ini.</p>
                @endif
            </div>
        </div>
    </section>

    {{-- Back Link --}}
    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a href="{{ route('gallery.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-700 hover:text-emerald-600 transition">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
            </svg>
            Kembali ke Galeri
        </a>
    </section>

</x-layouts.app>
