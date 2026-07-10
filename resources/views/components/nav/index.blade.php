{{-- Main Navigation: transparent over hero, solid on scroll --}}
<header x-data="navComponent()"
        class="fixed top-0 inset-x-0 z-50 nav-over-hero"
        :class="scrolled ? 'nav-solid' : 'bg-transparent'"
        @keydown.escape.window="closeAll()">

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 md:h-[5.5rem]">

            {{-- Brand --}}
            <a href="/" class="flex items-center shrink-0">
                <img src="/images/images_profil_sekolah-removebg-preview.png" alt="Logo MTsN 5 Tanah Laut" loading="lazy" width="180" height="60"
                     class="h-12 md:h-14 w-auto object-contain">
            </a>

            {{-- Desktop Nav --}}
            <nav class="hidden md:flex items-center gap-7" :class="scrolled ? 'text-neutral-800' : 'text-white'">
                @foreach(\App\Support\Navigation::items() as $item)
                    <a href="{{ $item['href'] }}"
                       class="text-sm font-medium hover:text-brand-accent transition-colors relative py-1 {{ ($item['active'] ?? false) ? 'font-semibold' : '' }}">
                        {{ $item['label'] }}
                        @if($item['active'] ?? false)
                            <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-brand-accent rounded-full"></span>
                        @endif
                    </a>
                @endforeach
            </nav>

            {{-- Right --}}
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('contact') }}"
                   class="inline-flex items-center gap-2 rounded-full bg-amber-500 hover:bg-amber-600 text-white px-4 md:px-5 py-2 text-sm font-semibold transition shadow-md hover:shadow-lg">
                    Hubungi Kami
                </a>

                <button class="md:hidden p-2 rounded-md"
                        :class="scrolled ? 'text-neutral-800 hover:text-brand-accent' : 'text-white hover:text-amber-300'"
                        @click="mobileOpen = !mobileOpen"
                        aria-label="Toggle menu">
                    <svg x-show="!mobileOpen" class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileOpen" x-cloak class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu Drawer --}}
    <div x-show="mobileOpen" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden absolute top-full inset-x-0 bg-white border-t border-neutral-200 shadow-xl max-h-[80vh] overflow-y-auto">
        <nav class="max-w-6xl mx-auto px-4 py-4 flex flex-col">
            @foreach(\App\Support\Navigation::items() as $item)
                <a href="{{ $item['href'] }}"
                   @click="mobileOpen = false"
                   class="block py-3 text-sm font-medium text-neutral-800 hover:text-brand-accent border-b border-neutral-100 last:border-0">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>
    </div>
</header>

<style>
[x-cloak] { display: none !important; }
</style>
