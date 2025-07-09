@props([
    'href' => '#',
    'classes' => '',
])

@php
    $path = trim($href, '/'); // remove leading/trailing slash
    if ($path === '') {
        // Home page special case
        $isCurrent = request()->is('/');
    } else {
        $isCurrent = request()->is($path);
    }

    $classes = !empty($classes) ? $classes : 'rounded-md px-3 py-2 text-sm font-medium';
    if ($isCurrent) {
        $classes .= ' nav-link bg-red bg-gray-900 text-white';
    } else {
        $classes .= ' nav-link text-gray-300 hover:bg-gray-700 hover:text-white';
    }
@endphp

<a
    href="{{ $href }}"
    class="{{ $classes}}">
    {{ $slot }}
</a>
