<x-layout>
    <x-slot:heading>
        Latest
    </x-slot:heading>
    <h3 class="mb-4">Checkout the latest news and stories</h3>

    <section class="latest-news flex flex-col gap-2">
        @foreach($newsItems as $newsItem)
            <x-articles.card
                :title="$newsItem->title"
                :body="$newsItem->body"
                :byline="$newsItem->byline ?? 'Unknown author'"
                :webPublicationDate="$newsItem->webPublicationDate"
                :subtitle="$newsItem->subtitle ?? '' "
                :publicationUrl="$newsItem->publication_url"
                :thumbnail="$newsItem->thumbnail"
            />

        @endforeach
    </section>
</x-layout>
