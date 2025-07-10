<x-layout>
    <x-slot:heading>
        Latest
    </x-slot:heading>
    <p>Latest News page here</p>

    <section class="latest-news flex flex-col gap-2">
        @foreach($newsItems as $newsItem)

            <x-articles.card
                :title="$newsItem->title"
                :body="$newsItem->body"
                :byline="$newsItem->byline ?? 'Unknown author'"
                :webPublicationDate="$newsItem->webPublicationDate"
                :subtitle="$newsItem->subtitle ?? '' "
                :publicationUrl="$newsItem->publication_url"
            />

        @endforeach
    </section>
</x-layout>
