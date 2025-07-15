@php
    use App\Models\Section;
    use App\Models\Tag;
    use App\Models\Article;
    use Illuminate\Database\Eloquent\Collection
@endphp

@php
    /** @var Section $section */
    /** @var Collection|Tag[] $tags */
    /** @var Collection|Article[] $articles */

@endphp

<x-layout>
    <x-slot:heading>
        {{$section->web_title}}
    </x-slot:heading>
    <article class="single-section-page">
        <section class="main">
            <section class="content gap-2 flex flex-col">

                @if($tags)
                    <section class="tag-list">
                        <h3 class="mb-3">Tags belonging to this section</h3>
                        <div class="content flex flex-wrap gap-1">
                            @foreach($tags as $tag)
                                <a
                                    class="button button-small"
                                    href="/tags/{{$tag->uid}}">{{$tag->web_title}}
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if($articles)
                    <section class="article-list">
                        <h3 class="mb-3">Latest articles for section</h3>
                        <div class="content flex flex-col gap-4">
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
                        </div>
                    </section>
                @endif

            </section>
        </section>
    </article>

</x-layout>
