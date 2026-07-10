{{-- =============================================
    CALL-TO-ACTION
    Layout: Full-width dramatic banner
    Style: Gradient glass with floating orbs
    ============================================= --}}

<section class="relative overflow-hidden py-24 md:py-32">
    {{-- Mesh gradient background --}}
    <div class="absolute inset-0 bg-gradient-to-br from-emerald-950 via-emerald-900 to-emerald-800"></div>
    <div class="absolute top-0 left-1/4 w-[500px] h-[500px] rounded-full bg-emerald-600/20 blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-0 right-1/4 w-[400px] h-[400px] rounded-full bg-amber-500/15 blur-[120px] pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full bg-teal-500/10 blur-[140px] pointer-events-none"></div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        {{-- Eyebrow --}}
        <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-200 mb-8 backdrop-blur-sm border border-white/10">
            Bergabung Bersama Kami
        </span>

        <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-[1.1] tracking-tight mb-6">
            Siap Menjadi Bagian dari<br class="hidden sm:block"/>
            <span class="text-amber-400">Keluarga Besar Kami?</span>
        </h2>

        <p class="text-base md:text-lg text-emerald-100/70 leading-relaxed max-w-2xl mx-auto mb-10">
            MTsN 5 Tanah Laut membuka kesempatan bagi siswa baru, wali murid, dan masyarakat umum untuk mengenal lebih dekat pendidikan berkualitas kami.
        </p>

        {{-- CTA Buttons with Button-in-Button architecture --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            {{-- Primary CTA --}}
            <a href="{{ url('/ppdb') }}"
               class="group relative inline-flex items-center gap-2 rounded-full bg-amber-500 px-9 py-4 text-base font-bold text-white shadow-xl shadow-amber-500/25 transition-all duration-500 hover:bg-amber-400 hover:shadow-2xl hover:shadow-amber-400/25 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2 focus:ring-offset-emerald-900">
                PPDB 2025
                <span class="w-8 h-8 rounded-full bg-white/15 flex items-center justify-center group-hover:bg-white/20 group-hover:scale-105 transition-all duration-500 group-active:scale-95">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </span>
            </a>

            {{-- Secondary CTA --}}
            <a href="{{ route('contact') }}"
               class="group relative inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/10 px-9 py-4 text-base font-semibold text-white backdrop-blur-sm transition-all duration-500 hover:bg-white/20 hover:border-white/50 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-white/30 focus:ring-offset-2 focus:ring-offset-emerald-900">
                Hubungi Kami
                <span class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center group-hover:bg-white/15 group-hover:scale-105 group-hover:translate-x-0.5 transition-all duration-500">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                </span>
            </a>
        </div>

        {{-- Social proof --}}
        <div class="mt-12 flex flex-col sm:flex-row items-center justify-center gap-4 text-sm text-emerald-200/50">
            <div class="flex -space-x-2">
                @foreach(['bg-emerald-400','bg-amber-400','bg-teal-400','bg-emerald-300'] as $i => $color)
                    <div class="size-8 rounded-full {{ $color }} ring-2 ring-emerald-900 flex items-center justify-center text-white text-[10px] font-bold">
                        {{ ['A', 'B', 'C', 'D'][$i] }}
                    </div>
                @endforeach
            </div>
            <span>Lebih dari {{ number_format($stats['students'] ?? 500) }} siswa aktif terdaftar</span>
        </div>
    </div>
</section>
