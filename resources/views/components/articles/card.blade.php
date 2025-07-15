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
    'publicationUrl',
    'thumbnail'
])


<?php

$subtitle = strip_tags($subtitle);

//calculate the url for the article
$path     = parse_url($publicationUrl, PHP_URL_PATH);
$baseName = pathinfo($path, PATHINFO_FILENAME);

?>


<article class="article-card p-4 border rounded-md shadow {{!empty($thumbnail) ? 'has-thumbnail' : ''}}">
    @if($thumbnail)
        <div class="secondary">
            {!!  $thumbnail !!}
        </div>
    @endif
    <div class="primary">
        <a class="" href="/articles/{{$baseName}}">
            <h2 class="text-lg font-semibold">{{ $title }}</h2>
        </a>
        <p class="byline text-sm text-gray-500">{{ $webPublicationDate }} by {{ $byline }}</p>
        <p class="abstract mt-2 mb-3">{!! $subtitle !!}</p>
        <a class="button" href="/articles/{{$baseName}}">Find out more</a>
    </div>

</article>
