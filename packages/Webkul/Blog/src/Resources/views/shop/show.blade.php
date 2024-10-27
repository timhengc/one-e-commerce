<x-shop::layouts>
    <x-slot:title>
        {{ $blogPost->title }}
    </x-slot>

    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">{{ $blogPost->title }}</h1>
        <div class="prose max-w-none">
            {!! $blogPost->description !!}
        </div>
    </div>
</x-shop::layouts>