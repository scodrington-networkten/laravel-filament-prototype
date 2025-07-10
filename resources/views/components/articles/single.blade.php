@props([
    'item'
])
<?php
$date          = new DateTime($item['webPublicationDate']);
$publishedDate = $date->format('d/m/Y, H:i');


$tags = $item['tags'] ?? null;

?>

<x-layout>
    <x-slot:heading>
        {{$item['fields']['headline']}}
    </x-slot:heading>
    <article class="single-article-page">
        <h2 class="trail">{{isset($item['fields']['trailText']) ? $item['fields']['trailText'] : ''}} </h2>
        <p class="text-sm text-gray-500 mb-2">{{ $publishedDate }} by {{ $item['fields']['byline'] }}</p>

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


        <div class="description">{!! $item['fields']['body'] !!}</div>
    </article>

</x-layout>
