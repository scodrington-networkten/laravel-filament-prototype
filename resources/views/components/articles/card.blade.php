@php
    use App\Helpers\Helper;
@endphp

{{-- single article card --}}
@props([
    'title',
    'body',
    'byline',
    'webPublicationDate',
    'subtitle',
    'publicationUrl'
])


<?php

$subtitle = strip_tags($subtitle);

//calculate the url for the article
$path     = parse_url($publicationUrl, PHP_URL_PATH);
$baseName = pathinfo($path, PATHINFO_FILENAME);




?>

<article class="p-4 border rounded-md shadow">
    <a class="" href="/latest-news/{{$baseName}}">
        <h2 class="text-lg font-semibold">{{ $title }}</h2>
    </a>

    <p class="text-sm text-gray-500">{{ $webPublicationDate }} by {{ $byline }}</p>
    <p class="mt-2 mb-3">{!! $subtitle !!}</p>
    <a class="button" href="/latest-news/{{$baseName}}">Find out more</a>
</article>
