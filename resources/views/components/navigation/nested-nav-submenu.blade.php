@props([
    'items' => [],
])

@foreach($items as $item)

    @php

        $href = "/tags/$item->uid";
        $title = $item->web_title;
        $path = trim($href, '/'); // remove leading/trailing slash

        if ($path === '') {
            // Home page special case
            $isCurrent = request()->is('/');
        } else {
            $isCurrent = request()->is($path);
        }

        $classes = 'rounded-md px-3 py-2 text-sm font-medium';
        if ($isCurrent) {
            $classes .= ' nav-link bg-red bg-gray-900 text-white';
        } else {
            $classes .= ' nav-link text-gray-300 hover:bg-gray-700 hover:text-white';
        }

        $articleCount = isset($item->articles) ? count($item->articles) : 0;

    @endphp
    <a
        href="{{ $href }}"
        class="{{ $classes}}">
        {{$title}} - {{$articleCount}}
    </a>

@endforeach





