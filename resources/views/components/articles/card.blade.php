@props([
    'title',
    'description',
    'date',
    'author'
])
<article class="p-4 border rounded-md shadow">
    <h2 class="text-lg font-semibold">{{ $title }}</h2>
    <p class="text-sm text-gray-500">{{ $date }} by {{ $author }}</p>
    <p class="mt-2">{{ $description }}</p>
</article>
