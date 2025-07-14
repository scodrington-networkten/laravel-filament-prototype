@php /** @var \App\Models\Article $article */ @endphp

@php
    use App\helpers\Helper;
    use App\Models\Article;
@endphp

<?php
$date          = new DateTime($article->webPublicationDate);
$publishedDate = $date->format('d/m/Y, H:i');
$articleType   = $article->type ?? null;

$thumbnail = null;
foreach ($article->media as $media) {
    $relation = $media->relation;

    if ($relation == 'thumbnail') {
        $thumbnail = $media;
        break;
    }
}

$thumbnailMetadata = json_decode($thumbnail->metadata);

//dd($thumbnailMetadata);

?>

<x-layout>
    <x-slot:heading>
        {{$article->headline}}
    </x-slot:heading>
    <article class="single-article-page {{$articleType}}">
        <h2 class="trail">{!!  $article->subtitle ?? $article->subtitle !!} </h2>
        <p class="text-sm text-gray-500 mb-2">{{ $publishedDate }} by {{ $article->byline }}</p>

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

           --}}

        <section class="main">

            @if($article->hasThumbnailImage())
                {!! $article->getImageForMediaItem($article->getThumbnailImage()) !!}
            @endif

            @if (!empty($thumbnail))
                <figure class="thumbnail">
                    <img
                        alt="{{$thumbnailMetadata->alt_text}}"
                        width="{{$thumbnailMetadata->width}}"
                        height="{{$thumbnailMetadata->height}}"
                        src="{{$thumbnail->url}}"
                    />
                    <figcaption>{{!empty($thumbnailMetadata->caption) ? $thumbnailMetadata->caption : 'no caption supplied'}}</figcaption>
                </figure>
            @endif
            <div class="content">{!! $article->body !!}</div>
        </section>

    </article>

</x-layout>
