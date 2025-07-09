<x-layout>
    <x-slot:heading>
        Latest
    </x-slot:heading>
    <p>Latest News page here</p>

    <section class="latest-news flex flex-col gap-2">
        @foreach($newsItems as $newsItem)


            <x-articles.card
                :headline="$newsItem['fields']['headline']"
                :body="$newsItem['fields']['body']"
                :byline="$newsItem['fields']['byline'] ?? 'Unknown author'"
                :pubDate="$newsItem['webPublicationDate']"
                :standFirst="$newsItem['fields']['standfirst'] ?? '' "
                :webUrl="$newsItem['webUrl']"
            />

        @endforeach
    </section>
</x-layout>
