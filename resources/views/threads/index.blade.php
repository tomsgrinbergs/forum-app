<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Forum') }}
        </h2>
    </x-slot>

    <div class="my-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <form class="flex items-center" method="GET" action="{{ route('threads.index') }}">
                    <select id="category" name="category" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $filterCategory == $category->id ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>

                    <x-button class="ml-4">Filter</x-button>
                </form>
                @auth
                    <x-button :href="route('threads.create')">Start a New Thread</x-button>
                @endauth
            </div>
        </div>
    </div>

    @if ($threads->isNotempty())
        <div class="my-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-2 bg-white border-b border-gray-200">

                        <ul class="divide-y">
                            @foreach ($threads as $thread)
                                <li class="py-4 flex justify-between">
                                    <a href="{{ route('threads.show', $thread) }}">
                                        @if ($thread->category)
                                            <span class="bg-yellow-700 inline-block leading-none px-2 py-1 rounded-full text-white mr-4">
                                                {{ $thread->category->title }}
                                            </span>
                                        @endif
                                        {{ $thread->title }}
                                    </a>
                                    <span>{{ $thread->user->name }}</span>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
