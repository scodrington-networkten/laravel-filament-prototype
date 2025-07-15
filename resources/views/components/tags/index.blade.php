<x-layout>
    <x-slot:heading>
        Tags
    </x-slot:heading>
    <h3 class="mb-3"> Current tag listing</h3>
    <section class="sections flex flex-col gap-2">
        @if($tags)
            <div class="section-tags flex flex-wrap gap-2">
                @foreach($tags as $tag)
                    <a
                        title="{{$tag->web_title}}"
                        href="/tags/{{$tag->uid}}"
                        class="button button-small">
                        {{$tag->web_title}}
                    </a>
                @endforeach
            </div>

        @endif
    </section>
</x-layout>
