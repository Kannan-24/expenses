<x-app-layout>

    <x-slot name="title">
        {{ __('Reply to Ticket') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <x-slot name="head">
        @vite(['resources/js/editor.js'])
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8 bg-white p-6 rounded-2xl shadow m-4 flex flex-col overflow-y-auto"
            style="height: 88vh;">
            <!-- Breadcrumb -->
            <div class="flex justify-between items-center mb-4">
                <nav class="flex text-sm text-gray-500" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center hover:text-blue-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 2a1 1 0 01.7.3l7 7a1 1 0 01-1.4 1.4L16 10.42V17a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6.58l-.3.28a1 1 0 01-1.4-1.44l7-7A1 1 0 0110 2z" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li class="flex items-center">
                            <a href="{{ route('support_tickets.index') }}"
                                class="inline-flex items-center hover:text-blue-600">
                                <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                                </svg>
                                Support
                            </a>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                            </svg>
                            <span class="text-gray-700">Ticket #{{ $supportTicket->id }}</span>
                        </li>
                    </ol>
                </nav>
            </div>

            <hr class="p-2 border-t border-gray-400">

            <div class="flex flex-col gap-4">
                <h2 class="text-lg font-semibold text-gray-800">Ticket Details:</h2>
                <div class="grid grid-cols-1 gap-4">
                    <div class="flex items-center gap-4">
                        <span class="w-24 text-sm font-bold text-gray-900">Subject</span>
                        <span class="mx-1">:</span>
                        <span class="text-base text-gray-600">{{ $supportTicket->subject }}</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="w-24 text-sm font-bold text-gray-900">Status</span>
                        <span class="mx-1">:</span>
                        <span class="text-base text-gray-600">
                            @if ($supportTicket->status === 'opened')
                                <span class="bg-green-100 text-green-800 font-semibold px-2 py-1 rounded">
                                    Open
                                </span>
                            @elseif ($supportTicket->status === 'closed')
                                <span class="bg-red-100 text-red-800 font-semibold px-2 py-1 rounded">
                                    Closed
                                </span>
                            @elseif ($supportTicket->status === 'admin_replied')
                                <span class="bg-blue-100 text-blue-800 font-semibold px-2 py-1 rounded">
                                    Admin Replied
                                </span>
                            @elseif ($supportTicket->status === 'customer_replied')
                                <span class="bg-yellow-100 text-yellow-800 font-semibold px-2 py-1 rounded">
                                    User Replied
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-800 font-semibold px-2 py-1 rounded">
                                    Unknown
                                </span>
                            @endif
                        </span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="w-24 text-sm font-bold text-gray-900">Created At</span>
                        <span class="mx-1">:</span>
                        <span
                            class="text-base text-gray-600">{{ $supportTicket->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="w-24 text-sm font-bold text-gray-900">Updated At</span>
                        <span class="mx-1">:</span>
                        <span
                            class="text-base text-gray-600">{{ $supportTicket->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="w-24 text-sm font-bold text-gray-900">Created By</span>
                        <span class="mx-1">:</span>
                        <span class="text-base text-gray-600">{{ $supportTicket->user->name }}</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="w-24 text-sm font-bold text-gray-900">Replies</span>
                        <span class="mx-1">:</span>
                        <span class="text-base text-gray-600">{{ $supportTicket->messages->count() }}</span>
                    </div>

                    <div class="flex items-center gap-4">
                        <form action="{{ route('support_tickets.close', $supportTicket) }}" method="POST">
                            @csrf
                            <x-danger-button type="submit" class="mt-2">
                                {{ __('Close Ticket') }}
                            </x-danger-button>
                        </form>
                        <form action="{{ route('support_tickets.destroy', $supportTicket) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this ticket?')">
                            @csrf
                            @method('DELETE')
                            <x-danger-button type="submit" class="mt-2">
                                {{ __('Delete Ticket') }}
                            </x-danger-button>
                        </form>
                    </div>
                </div>

                <hr class="border-t border-gray-300 my-4">
                <h3 class="text-lg font-semibold text-gray-800">Reply to Ticket:</h3>

                <form action="{{ route('support_tickets.reply', $supportTicket) }}" method="POST">
                    @csrf


                    <div class="mb-5">
                        <textarea id="editor" name="message"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            >{{ old('message') }}</textarea>
                        @error('message')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>
                            {{ __('Send Reply') }}
                        </x-primary-button>
                    </div>
                </form>

                <hr class="border-t border-gray-300 my-4">

                <h3 class="text-lg font-semibold text-gray-800">Messages:</h3>
                <div class="space-y-4">
                    @foreach ($supportTicket->messages->sortByDesc('created_at') as $message)
                        <div class="p-4 bg-gray-50 rounded-lg shadow-sm">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-semibold text-gray-700">
                                    {{ $message->user->hasRole('admin') ? 'Admin' : 'User' }}:
                                    {{ $message->user->name }} - {{ $message->created_at->format('d M Y, H:i') }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    {{ $message->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <div class="text-gray-800">
                                {!! $message->message !!}
                            </div>
                        </div>
                    @endforeach
                </div>


            </div>
        </div>
    </div>
</x-app-layout>
