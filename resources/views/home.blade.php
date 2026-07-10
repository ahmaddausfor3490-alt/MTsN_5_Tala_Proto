<x-layouts.app>

{{-- ========== HERO SECTION ========== --}}
<section class="relative h-[90vh] min-h-[600px] w-full overflow-hidden lg:h-screen">

    {{-- Full-width background image --}}
    <img
        src="{{ asset('images/Hero_Sekolah.jpeg') }}"
        alt="MTsN 5 Tanah Laut"
        class="absolute inset-0 h-full w-full object-cover"
        loading="eager"
    />

    {{-- Dark emerald overlay ~80% --}}
    <div class="absolute inset-0 bg-emerald-950/80"></div>

    {{-- Left-aligned content — 45% width --}}
    <div class="relative z-10 mx-auto flex h-full max-w-7xl items-center px-4 sm:px-6 lg:px-8">
        <div class="w-full" style="max-width: 45%;">

            {{-- Badge --}}
            <div class="mb-6 flex items-center gap-2">
                <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 backdrop-blur-sm">
                    <svg class="size-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"/>
                    </svg>
                    <span class="text-xs font-semibold uppercase tracking-wider text-white/90">
                        Sekolah Unggulan
                    </span>
                </span>
            </div>

            {{-- Heading --}}
            <h1 class="text-3xl font-bold leading-tight tracking-tight text-white sm:text-4xl lg:text-5xl xl:text-6xl">
                <span class="block">Membentuk Generasi</span>
                <span class="block text-amber-400">Unggul &amp; Berkarakter</span>
            </h1>

            {{-- Description --}}
            <p class="mt-6 max-w-lg text-base leading-relaxed text-emerald-100/80 sm:text-lg">
                MTsN 5 Tanah Laut — lembaga pendidikan Islami yang berkomitmen mencetak generasi berilmu, berakhlak mulia, dan siap bersaing di era global.
            </p>

            {{-- CTA Buttons --}}
            <div class="mt-10 flex flex-wrap gap-4">
                <a href="{{ route('profile') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-7 py-3 text-base font-semibold text-white shadow-lg shadow-amber-500/25 transition hover:bg-amber-600 hover:shadow-xl hover:shadow-amber-600/20">
                    Tentang Kami
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <a href="{{ route('contact') }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-white/30 bg-white/10 px-7 py-3 text-base font-semibold text-white backdrop-blur-sm transition hover:bg-white/20 hover:border-white/40">
                    Hubungi Kami
                </a>
            </div>

        </div>
    </div>

    {{-- SVG Wave Divider — bottom of hero --}}
    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-[0]">
        <svg xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 1440 320"
             preserveAspectRatio="none"
             class="relative -mt-[1px] h-auto w-full">
            <path fill="#FFFFFF"
                  d="M0,64L80,101.3C160,139,320,213,480,213.3C640,213,800,139,960,122.7C1120,107,1280,149,1360,170.7L1440,192L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z">
            </path>
        </svg>
    </div>

</section>
{{-- END HERO --}}

    {{-- Quick info cards --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 md:-mt-20 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
            @php
                $cards = [
                    ['title' => 'Profil Madrasah', 'desc' => 'Sejarah dan identitas lengkap MTsN 5 Tanah Laut.', 'href' => route('profile'), 'icon' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z'],
                    ['title' => 'Visi & Misi', 'desc' => 'Arah dan tujuan pendidikan kami.', 'href' => route('vision-mission'), 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                    ['title' => 'Berita Terbaru', 'desc' => 'Informasi dan kegiatan terbaru.', 'href' => route('news'), 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2'],
                ];
            @endphp
            @foreach($cards as $card)
                <a href="{{ $card['href'] }}"
                   class="group block bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition border border-neutral-100">
                    <div class="size-12 rounded-xl bg-emerald-100 text-emerald-900 flex items-center justify-center mb-4 group-hover:bg-amber-500 group-hover:text-white transition">
                        <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">{{ $card['title'] }}</h3>
                    <p class="text-sm text-neutral-600">{{ $card['desc'] }}</p>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Profil Madrasah --}}
    @include('homepage.components.profil-madrasah')

    {{-- Statistik Sekolah --}}
    <section class="bg-white py-20 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Section Heading --}}
            <div class="text-center mb-16 md:mb-20">
                <span class="inline-block text-xs font-semibold tracking-[0.2em] uppercase text-amber-500 mb-3">
                    Data &amp; Fakta
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-emerald-900 mb-4">
                    Statistik Sekolah
                </h2>
                <div class="w-12 h-1 bg-amber-500 mx-auto rounded-full mb-4"></div>
                <p class="text-sm text-gray-500 max-w-xl mx-auto">
                    Capaian dan data terkini MTsN 5 Tanah Laut
                </p>
            </div>

            {{-- Cards Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @php
                    $statItems = [
                        ['key' => 'students',       'label' => 'Siswa',           'icon' => 'academic-cap'],
                        ['key' => 'teachers',       'label' => 'Guru & Staf',     'icon' => 'user-group'],
                        ['key' => 'posts',          'label' => 'Berita Terbaru',  'icon' => 'newspaper'],
                        ['key' => 'upcoming_agenda','label' => 'Agenda Aktif',    'icon' => 'calendar-days'],
                        ['key' => 'gallery_items',  'label' => 'Galeri Foto',     'icon' => 'photo'],
                        ['key' => 'faqs',           'label' => 'FAQ',             'icon' => 'question-mark-circle'],
                    ];
                @endphp

                @foreach($statItems as $stat)
                    <div class="group bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center gap-5">

                            {{-- Icon Circle --}}
                            <div class="shrink-0 size-16 rounded-full bg-emerald-50 flex items-center justify-center">
                                <x-dynamic-component component="heroicon-o-{{ $stat['icon'] }}" class="size-8 text-emerald-700" />
                            </div>

                            {{-- Vertical Divider --}}
                            <div class="shrink-0 w-px h-12 bg-gray-200"></div>

                            {{-- Content --}}
                            <div class="min-w-0">
                                <div class="text-3xl font-bold text-emerald-900 leading-tight">
                                    {{ number_format($stats[$stat['key']] ?? 0) }}
                                </div>
                                <div class="text-sm text-gray-500 mt-0.5 font-medium">
                                    {{ $stat['label'] }}
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- Program Unggulan --}}
    @include('homepage.components.program-unggulan')

    {{-- Galeri Kegiatan --}}
    @include('homepage.components.galeri-kegiatan')

    {{-- Berita Terbaru --}}
    @include('homepage.components.news')

    {{-- Testimoni --}}
    @include('homepage.components.testimoni')

    {{-- Call-To-Action --}}
    @include('homepage.components.cta')

</x-layouts.app>
