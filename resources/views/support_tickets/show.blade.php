<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Support Ticket') }} #{{ $supportTicket->id }}
        </h2>
    </x-slot>

    <x-slot name="head">
        @vite(['resources/js/editor.js'])
    </x-slot>

    <form action="{{ route('support_ticket.reply')}}" method="POST">
        @csrf

        <div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded-lg mt-6">          

            <div class="mb-5">
                <label for="editor" class="block text-sm font-semibold text-gray-700">Reply</label>
                <textarea id="editor" name="message"
                    class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required>{{ old('message') }}</textarea>
                @error('message')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end">
                <x-primary-button>
                    {{ __('Send Reply') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</x-app-layout>
