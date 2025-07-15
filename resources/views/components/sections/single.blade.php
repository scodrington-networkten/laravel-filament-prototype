@php
    use App\Models\Section;
    use App\Models\Article
@endphp

@php
    /** @var Section $section */
    /** @var Collection|Article[] $articles */

@endphp

<x-layout>
    <x-slot:heading>
        {{$section->web_title}}
    </x-slot:heading>
    <article class="single-tag-page">
        <section class="main">
            <h3 class="mb-4">Articles under the <strong>{{$section->web_title}}</strong> section</h3>
            <section class="articles-list gap-2 flex flex-col">
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
            </section>
        </section>
    </article>

</x-layout>
