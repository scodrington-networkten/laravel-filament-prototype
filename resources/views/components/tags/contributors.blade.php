<x-layout>
    <x-slot:heading>
        Contributors
    </x-slot:heading>
    <h3 class="subtitle">Authors and contributors</h3>
    <section class="sections flex flex-col gap-2">
        @if($tags)
            <div class="contributors-list section-tags flex flex-wrap gap-2">
                @foreach($tags as $tag)

                    @php
                        $url = "contributor/{$tag->uid}";
                        $image = !empty($tag->image_url) ? $tag->image_url : '/placeholder_profile_image.webp';
                    @endphp

                    <article class="contributor-profile-card">

                        <a href="{{$url}}">
                            <img
                                alt="{{$tag->web_title}}"
                                src="{{$image}}"
                                class="thumbnail"
                            />
                        </a>

                        <div class="contributor-info">
                            <h3 class="name"><a href="{{$url}}">{{$tag->web_title}}</a></h3>
                            <div class="bio">{{$tag->formatted_bio}}</div>
                            @if(!empty($tag->articles))
                                <div class="article-count">
                                    <i class="fa-solid fa-newspaper"></i>
                                    <strong>{{count($tag->articles)}}</strong> {{count($tag->articles) > 1 ? 'Articles' : 'Article'}}
                                </div>

                            @endif
                            <a
                                title="{{$tag->web_title}}"
                                href="{{$url}}"
                                class="button button-small"> Read More
                            </a>
                        </div>


                    </article>

                @endforeach
            </div>

        @endif
    </section>
</x-layout>
