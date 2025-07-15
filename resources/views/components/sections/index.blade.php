<x-layout>
    <x-slot:heading>
        Sections
    </x-slot:heading>
    <h3 class="mb-4">Primary news sections</h3>
    <section class="sections flex flex-col gap-2">
        @if($sections)
            <div class="section-tags flex flex-wrap gap-2">
                @foreach($sections as $section)
                    <a
                        class="button button-small"
                        href="/sections/{{$section->uid}}">{{$section->web_title}}</a>
                @endforeach
            </div>
        @endif
    </section>
</x-layout>
