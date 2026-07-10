<div class="space-y-4">
    @php
        $images = \Illuminate\Support\Arr::wrap($getState() ?? []);
    @endphp

    @if (empty(array_filter($images)))
        <p class="text-sm text-gray-500 dark:text-gray-400 italic">Belum ada foto galeri.</p>
    @else
        <div class="flex flex-wrap gap-4">
            @foreach ($images as $image)
                @php
                    $path = trim($image);
                @endphp
                @if ($path && \Illuminate\Support\Facades\Storage::disk('public')->exists($path))
                    <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($path) }}"
                       target="_blank"
                       class="inline-block rounded-lg overflow-hidden ring-1 ring-gray-200 hover:opacity-80 transition-opacity">
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($path) }}"
                             alt="Gallery image"
                             class="h-32 w-auto object-cover"/>
                    </a>
                @endif
            @endforeach
        </div>
    @endif
</div>
