@php
    use App\Models\Tag;
    use App\Models\Article;
    use Illuminate\Database\Eloquent\Collection;
@endphp

@php
    /** @var Tag $tag */
    /** @var Collection|Article[] $articles */
@endphp

<x-layout>
    <x-slot:heading>
        {{$tag->web_title}}
    </x-slot:heading>
    <article class="single-tag-page">
        <section class="main">
            <h3 class="mb-4">Articles tagged under <strong>{{$tag->web_title}}</strong></h3>
            <section class="articles-list gap-2 flex flex-col">
                @if($articles)
                    @foreach($articles as $article)

                        <x-articles.card
                            :title="$article->title"
                            :body="$article->body"
                            :byline="$article->byline ?? 'Unknown author'"
                            :webPublicationDate="$article->webPublicationDate"
                            :subtitle="$article->subtitle ?? '' "
                            :publicationUrl="$article->publication_url"
                            :thumbnail="$article->thumbnail"
                        />
                    @endforeach
                @endif
            </section>
        </section>
    </article>

</x-layout>
