@php /** @var \App\Models\Tag $tag */ @endphp

<x-layout>
    <x-slot:heading>
        {{$tag->web_title}}
    </x-slot:heading>
    <article class="single-tag-page">

        <section class="main">
            <p>The following articles have been tagged with this tag</p>
        </section>

    </article>

</x-layout>
