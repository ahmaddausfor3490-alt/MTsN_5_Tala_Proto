{{-- ==============================================
    PROFIL SINGKAT MADRASAH (School Profile)
    Layout: Two-column — visual card + content
    Style: Premium editorial — rounded-3xl cards,
           glass effect, soft shadows, emerald/amber
    ============================================== --}}

<section class="relative bg-neutral-50/80 py-20 md:py-28 overflow-hidden">
    {{-- Subtle decorative background --}}
    <div class="pointer-events-none absolute top-0 right-0 w-80 h-80 rounded-full bg-emerald-100/30 blur-3xl"></div>
    <div class="pointer-events-none absolute bottom-0 left-10 w-72 h-72 rounded-full bg-amber-100/30 blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="text-center max-w-2xl mx-auto mb-14 md:mb-18">
            <span class="inline-block text-xs font-semibold tracking-[0.2em] uppercase text-amber-600 mb-3">Profil</span>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-emerald-950 leading-[1.1] tracking-tight mb-4">
                Tentang MTsN 5 Tanah Laut
            </h2>
            <div class="w-10 h-0.5 bg-gradient-to-r from-amber-500 to-emerald-700 mx-auto rounded-full mb-5"></div>
            <p class="text-base md:text-lg text-neutral-600 leading-relaxed">
                MTsN 5 Tanah Laut merupakan madrasah tsanawiyah negeri yang berkomitmen mencetak generasi yang beriman, berilmu, berakhlak mulia, dan berprestasi. Dengan tenaga pendidik profesional, program unggulan, serta lingkungan belajar yang islami, kami terus menghadirkan pendidikan berkualitas bagi peserta didik.
            </p>
        </div>

        {{-- Two-Column Layout --}}
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12">

            {{-- LEFT COLUMN: Visual Card --}}
            <div class="md:col-span-5 lg:col-span-4">
                <div class="relative group">
                    {{-- Glass card wrapper --}}
                    <div class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-950 shadow-2xl ring-1 ring-emerald-950/10 transition-transform duration-500 group-hover:-translate-y-1">

                        {{-- Islamic geometric pattern overlay --}}
                        <div class="absolute inset-0 opacity-[0.06]" style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Cpath d='M40 0L80 40L40 80L0 40Z' fill='none' stroke='%23ffffff' stroke-width='1'/%3E%3C/svg%3E&quot;); background-repeat: repeat;"></div>

                        {{-- School image or placeholder --}}
                        <div class="relative p-8 pt-10 pb-12 text-center">
                            {{-- Logo / Identity --}}
                            <div class="inline-flex items-center justify-center w-24 h-24 rounded-2xl bg-white/10 backdrop-blur-sm ring-1 ring-white/20 mb-6 shadow-inner">
                                <svg class="size-12 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21a9 9 0 100-18 9 9 0 000 18z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 7a3 3 0 100 6 3 3 0 000-6z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                                </svg>
                            </div>

                            <h3 class="text-2xl font-bold text-white tracking-tight mb-2">
                                MTsN 5 Tanah Laut
                            </h3>
                            <p class="text-sm text-emerald-200/80 font-medium mb-6">
                                Kementerian Agama Republik Indonesia
                            </p>

                            {{-- Divider --}}
                            <div class="w-16 h-0.5 bg-amber-500 mx-auto rounded-full mb-6"></div>

                            {{-- Motto --}}
                            <p class="text-emerald-100/70 text-sm leading-relaxed italic">
                                "Mewujudkan Generasi yang Beriman, Berilmu, dan Berkarakter"
                            </p>
                        </div>

                        {{-- Gradient glow at bottom --}}
                        <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-black/20 to-transparent pointer-events-none"></div>
                    </div>

                    {{-- Decorative amber badge — bottom-right corner --}}
                    <div class="absolute -bottom-3 -right-3 md:bottom-4 md:right-4 rounded-2xl bg-amber-500 px-4 py-2 text-white text-xs font-semibold shadow-lg shadow-amber-500/30 ring-4 ring-emerald-50">
                        Est. 2021
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Content --}}
            <div class="md:col-span-7 lg:col-span-8">
                <div class="h-full flex flex-col justify-center">

                    {{-- Heading --}}
                    <h3 class="text-xl md:text-2xl font-bold text-emerald-900 mb-6 flex items-center gap-3">
                        Tentang Madrasah
                        <span class="flex-1 h-px bg-gradient-to-r from-emerald-300 to-transparent"></span>
                    </h3>

                    {{-- Paragraphs --}}
                    <div class="space-y-5 mb-10">
                        <p class="text-neutral-600 leading-relaxed text-base md:text-[1.05rem]">
                            MTsN 5 Tanah Laut hadir sebagai lembaga pendidikan dasar Islam yang menyelenggarakan pendidikan formal tingkat tsanawiyah di bawah naungan Kementerian AgamaRI. Madrasah ini berkomitmen untuk memberikan pendidikan yang seimbang antara ilmu agama dan ilmu pengetahuan umum.
                        </p>
                        <p class="text-neutral-600 leading-relaxed text-base md:text-[1.05rem]">
                            Dengan kurikulum Merdeka yang terintegrasi nilai-nilai keislaman, madrasah ini berupaya menghasilkan lulusan yang tidak hanya unggul secara akademik, tetapi juga memiliki akhlak mulia, kemandirian, dan semangat berkarya untuk masyarakat.
                        </p>
                    </div>

                    {{-- Highlight Items --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                        @php
                            $highlights = [
                                ['icon' => 'M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a80.107 80.107 0 01-.431-2.188 48.569 48.569 0 019.735-3.214 60.466 60.466 0 001.543 4.404c.036.098.073.196.11.294', 'text' => 'Pendidikan Berkualitas'],
                                ['icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z', 'text' => 'Guru Profesional'],
                                ['icon' => 'M12 21a9.009 9.009 0 008.716-6.747M12 21a9.009 9.009 0 01-8.716-6.747M12 21c2.485-4.255 2.387-7.48 0-10.492V7.5a4.5 4.5 0 119 0v3.008c-2.387 3.012-2.485 6.237 0 10.492z', 'text' => 'Lingkungan Islami'],
                                ['icon' => 'M16.5 18.75h-9m9 0a3 3 0 003-3h-3a3 3 0 003 3z', 'text' => 'Berprestasi'],
                            ];
                        @endphp

                        @foreach($highlights as $highlight)
                            <div class="group flex items-start gap-3 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-neutral-200/80 transition-all duration-300 hover:shadow-md hover:ring-emerald-200/80 hover:-translate-y-0.5">
                                <div class="shrink-0 mt-0.5 size-10 rounded-xl bg-gradient-to-br from-emerald-50 to-amber-50 flex items-center justify-center ring-1 ring-emerald-100/80">
                                    <svg class="size-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $highlight['icon'] }}"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-neutral-800 leading-snug">{{ $highlight['text'] }}</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- CTA Button --}}
                    <a href="{{ url('/profil') }}"
                       class="inline-flex items-center gap-2 self-start rounded-full bg-emerald-900 px-7 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-900/20 transition-all duration-500 hover:bg-emerald-800 hover:shadow-xl hover:shadow-emerald-800/25 active:scale-[0.98] sm:self-auto">
                        Profil Sekolah
                        <svg class="size-4 transition-transform duration-300 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
