@props([
    'href' => '#',
    'classes' => '',
    'current' => false
])

@php

    $classes = !empty($classes) ? $classes : 'rounded-md px-3 py-2 text-sm font-medium';
    if ($current) {
        $classes .= ' bg-red bg-gray-900 text-white';
    } else {
        $classes .= ' text-gray-300 hover:bg-gray-700 hover:text-white';
    }
@endphp

<a href="{{ $href }}" class="{{ $classes}}" aria-current="{{ $current }}">
    {{ $slot }}
</a>
