<x-layout>
    <x-slot:heading>
        Latest
    </x-slot:heading>
    <p>Latest News page here</p>

    <section class="latest-news flex flex-col gap-2">
        @foreach($newsItems as $newsItem)

            <x-articles.card
                :title="$newsItem['title']"
                :date="$newsItem['date']"
                :author="$newsItem['author']"
                :description="$newsItem['description']"
            />

        @endforeach
    </section>
</x-layout>
