<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Start a New Thread') }}
        </h2>
    </x-slot>

    <div class="my-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-right">
                <x-button :href="route('threads.index')">Cancel</x-button>
            </div>
        </div>
    </div>

    <div class="my-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="POST" action="{{ route('threads.store') }}">
                        @csrf

                        <div class="mb-4">
                            <x-label for="title" :value="__('Title')" />
                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            @error('title')
                                <div class="text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="content" :value="__('Content')" />
                            <x-input id="content" class="block mt-1 w-full" type="textarea" rows="5" name="content" :value="old('content')" required />
                            @error('content')
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
</x-app-layout>
