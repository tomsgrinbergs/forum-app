<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Show Thread
        </h2>
    </x-slot>

    <div class="my-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-right">
                <x-button :href="route('threads.index')">Back</x-button>
            </div>
        </div>
    </div>

    <div class="my-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="border-b pb-4 mb-4 flex justify-between items-end">
                        <h1 class="text-3xl">{{ $thread->title }}</h1>
                        <div>by {{ $thread->user->name }}</div>
                    </div>
                    <p class="whitespace-pre-wrap">{{ $thread->content }}</p>
                </div>
            </div>
        </div>
    </div>

    @foreach ($thread->comments as $comment)
        <div class="my-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-end">
                            <p class="whitespace-pre-wrap">{{ $comment->content }}</p>
                            <div>by {{ $comment->user->name }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @auth
        <div class="my-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <form method="POST" action="{{ route('comments.store', $thread) }}">
                            @csrf

                            <div class="mb-4">
                                <x-label for="comment" :value="__('Comment')" />
                                <x-input id="comment" class="block mt-1 w-full" type="textarea" rows="5" name="comment" :value="old('comment')" required />
                                @error('comment')
                                    <div class="text-red-600 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <x-button>Submit</x-button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endauth
</x-app-layout>
