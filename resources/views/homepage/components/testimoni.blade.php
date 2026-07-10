{{-- =============================================
    TESTIMONI (Parent & Student Testimonials)
    Layout: Editorial card layout with quotation accents
    Style: Glass-morphism + double-bezel
    ============================================= --}}

<section class="relative bg-gradient-to-br from-emerald-950 via-emerald-900 to-[#052e1c] py-24 md:py-32 overflow-hidden">
    {{-- Background orbs --}}
    <div class="absolute top-10 left-10 w-72 h-72 rounded-full bg-emerald-500/10 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 rounded-full bg-amber-500/10 blur-3xl pointer-events-none"></div>
    {{-- Grain --}}
    <div class="pointer-events-none fixed inset-0 z-10 opacity-[0.04]"
         style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='400'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E&quot;);">
    </div>

    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Eyebrow + Heading --}}
        <div class="text-center max-w-2xl mx-auto mb-16 md:mb-20">
            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-200 mb-4">
                <span class="size-1.5 rounded-full bg-amber-400"></span>
                Testimoni
            </span>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white leading-[1.1] tracking-tight">
                Apa Kata Mereka
            </h2>
            <div class="w-10 h-0.5 bg-gradient-to-r from-amber-400 to-emerald-400 mx-auto mt-6 rounded-full mb-5"></div>
            <p class="text-base md:text-lg text-emerald-100/70 leading-relaxed">
                Pengalaman nyata dari orang tua dan alumni MTsN 5 Tanah Laut.
            </p>
        </div>

        {{-- Testimonial Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6">
            @forelse($testimonials as $testimonial)
                <div class="group relative rounded-[1.75rem] bg-white/5 p-0.5 shadow-[0_4px_24px_-8px_rgba(0,0,0,0.2)] backdrop-blur-sm hover:-translate-y-1 transition-all duration-500 hover:shadow-[0_16px_48px_-12px_rgba(0,0,0,0.3)]">
                    <div class="rounded-[calc(1.75rem-0.375rem)] bg-white/[0.03] p-6 md:p-7 relative overflow-hidden">
                        {{-- Quotation mark accent --}}
                        <svg class="absolute top-5 right-5 size-10 text-white/[0.06] pointer-events-none" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/>
                        </svg>

                        {{-- Star rating --}}
                        <div class="flex gap-1 mb-4">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="size-4 {{ $i < ($testimonial['rating'] ?? 5) ? 'text-amber-400' : 'text-white/10' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.651l-4.752-.382-1.831-4.401z"/>
                                </svg>
                            @endfor
                        </div>

                        {{-- Quote text --}}
                        <blockquote class="text-sm md:text-base text-emerald-50/90 leading-relaxed mb-6">
                            &ldquo;{{ $testimonial['text'] }}&rdquo;
                        </blockquote>

                        {{-- Author --}}
                        <div class="flex items-center gap-3 pt-4 border-t border-white/10">
                            @if(!empty($testimonial['avatar']))
                                <img src="{{ asset('storage/' . $testimonial['avatar']) }}" alt="{{ $testimonial['name'] }}" class="size-10 rounded-full ring-2 ring-white/10 object-cover">
                            @else
                                <div class="size-10 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-300 font-semibold text-sm ring-2 ring-white/10">
                                    {{ substr($testimonial['name'], 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <div class="text-sm font-semibold text-white">{{ $testimonial['name'] }}</div>
                                <div class="text-xs text-emerald-200/60">{{ $testimonial['role'] ?? 'Orang Tua Siswa' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Empty state --}}
                <div class="md:col-span-2 lg:col-span-3 text-center py-12 rounded-2xl border border-white/10 bg-white/5 backdrop-blur-sm">
                    <p class="text-emerald-200/50 text-sm">Belum ada testimoni yang ditampilkan.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
