@props([
    'item'
])
<?php
$date          = new DateTime($item['webPublicationDate']);
$publishedDate = $date->format('d/m/Y, H:i');
?>

<x-layout>
    <x-slot:heading>
        {{$item['fields']['headline']}}
    </x-slot:heading>
    <article class="single-article-page">
        <h2 class="byline">{{$item['fields']['byline']}}</h2>
        <p class="text-sm text-gray-500 mb-2">{{ $publishedDate }} by {{ $item['fields']['byline'] }}</p>
        <div class="description">{!! $item['fields']['body'] !!}</div>
    </article>

</x-layout>
