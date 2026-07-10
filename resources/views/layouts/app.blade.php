<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? e($title . ' — ') : '' }}{{ __('app.site_name') }}</title>

    @if(isset($description))
        <meta name="description" content="{{ $description }}">
    @endif
    @if(isset($image))
        <meta property="og:image" content="{{ $image }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts / Styles -->
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @stack('styles')
</head>
<body class="bg-white text-gray-900 font-sans antialiased min-h-screen flex flex-col">

{{-- Navigation --}}
<x-nav.index />

{{-- Main Content --}}
<main class="flex-1 w-full">
    {{ $slot }}
</main>

{{-- Footer --}}
<x-footer.main />
<x-footer.bottom-bar />

</body>
</html>
