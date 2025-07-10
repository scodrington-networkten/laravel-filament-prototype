@php use App\helpers\Helper; @endphp
@props([
    'article'
])
<?php
$date          = new DateTime($article->webPublicationDate);
$publishedDate = $date->format('d/m/Y, H:i');


/*
$tags = $item['tags'] ?? null;


$elements  = $item['elements'] ?? null;
$thumbnail = Helper::array_find($elements, fn($item) => $item['relation'] === 'thumbnail'
);

$main = Helper::array_find($elements, fn($item) => $item['relation'] === 'main');*/

$articleType = $article->type ?? null;

?>

<x-layout>
    <x-slot:heading>
        {{$article->headline}}
    </x-slot:heading>
    <article class="single-article-page {{$articleType}}">
        <h2 class="trail">{!!  $article->subtitle ?? $article->subtitle !!} </h2>
        <p class="text-sm text-gray-500 mb-2">{{ $publishedDate }} by {{ $article->byline }}</p>


        <section class="main">
            <div class="content">{!! $article->body !!}</div>
        </section>

        {{--
        @if(!empty($tags))

            <div class="tags flex flex-wrap gap-2">
                @foreach($tags as $tag)
                    @continue($tag['type'] !== 'keyword')
                    @continue(!isset($tag['sectionName']))

                    @php
                        $tagName = $tag['webTitle'] ?? null;
                        $url = basename(parse_url($tag['id'], PHP_URL_PATH));
                    @endphp

                    <p>
                        <a class="button button-small" href="{{ $url }}" title="{{ $tagName }}">
                            {{ $tagName }}
                        </a>
                    </p>
                @endforeach
            </div>
        @endif



        <section class="main">
            @if (!empty($thumbnail))
                <figure class="thumbnail">
                    <img
                        src="{{$thumbnail['assets'][0]['file']}}"
                        alt="{{$thumbnail['assets'][0]['typeData']['altText']}}"
                    />
                    <figcaption>{{$thumbnail['assets'][0]['typeData']['altText']}}</figcaption>
                </figure>
            @endif
            <div class="content">{!! $item['fields']['body'] !!}</div>
        </section>

--}}

    </article>

</x-layout>
