@php /** @var \App\Models\Article $article */ @endphp

@php
    use App\helpers\Helper;
    use App\Models\Article;
@endphp

<?php
$date          = new DateTime($article->webPublicationDate);
$publishedDate = $date->format('d/m/Y, H:i');
$articleType   = $article->type ?? null;

?>

<x-layout>
    <x-slot:heading>
        {{$article->headline}}
    </x-slot:heading>
    <article class="single-article-page {{$articleType}}">
        <h2 class="trail">{!! $article->subtitle !!} </h2>
        <p class="text-sm text-gray-500 mb-2">{{ $publishedDate }} by {{ $article->byline }}</p>

        <section class="main">

            @if($article->getKeywordTags())
                <div class="keyword-tags flex flex-wrap gap-2 mb-2">
                    @foreach($article->getKeywordTags() as $tag)
                        <a class="button button-small" href="/tags/{{$tag->uid}}">
                            {{$tag->web_title}}
                        </a>
                    @endforeach
                </div>
            @endif

            @if (!empty($article->thumbnail))
                {!!  $article->thumbnail !!}
            @endif
            <div class="content">{!! $article->body !!}</div>
        </section>

    </article>

</x-layout>
