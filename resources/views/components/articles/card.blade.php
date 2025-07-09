{{-- single article card --}}
@props([
    'headline',
    'body',
    'byline',
    'pubDate',
    'standFirst',
    'webUrl'
])


<?php

$standFirst = strip_tags($standFirst);

//calculate the url for the article
$path     = parse_url($webUrl, PHP_URL_PATH);
$baseName = pathinfo($path, PATHINFO_FILENAME);

?>

<article class="p-4 border rounded-md shadow">
    <h2 class="text-lg font-semibold">{{ $headline }}</h2>
    <p class="text-sm text-gray-500">{{ $pubDate }} by {{ $byline }}</p>
    <p class="mt-2 mb-3">{!! $standFirst !!}</p>
    <a class="button" href="/latest-news/{{$baseName}}">Find out more</a>
</article>
