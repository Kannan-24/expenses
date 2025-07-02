<x-app-layout>
    <x-slot name="title">
        {{ __('Support Ticket') }} #{{ $supportTicket->id }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <x-slot name="head">
        @vite(['resources/js/editor.js'])
    </x-slot>

    <div class=" space-y-6" style="height: 93vh; overflow-y-auto;">

        <!-- Enhanced Header Section -->
        <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-2xl shadow-xl overflow-hidden">
            <div class="relative p-8 text-white">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <div class="flex items-center space-x-3 mb-2">
                            <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl lg:text-4xl font-bold">Support Ticket #{{ $supportTicket->id }}</h1>
                                <p class="text-blue-100 text-lg mt-1">{{ $supportTicket->subject }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status Badge -->
                    <div class="mt-4 lg:mt-0">
                        @php
                            $statusConfig = [
                                'opened' => ['bg-green-500', 'text-white', 'Open'],
                                'closed' => ['bg-red-500', 'text-white', 'Closed'],
                                'admin_replied' => ['bg-blue-500', 'text-white', 'Admin Replied'],
                                'customer_replied' => ['bg-yellow-500', 'text-white', 'Customer Replied'],
                            ];
                            $config = $statusConfig[$supportTicket->status] ?? ['bg-gray-500', 'text-white', 'Unknown'];
                        @endphp
                        <div class="inline-flex items-center px-6 py-3 {{ $config[0] }} {{ $config[1] }} rounded-xl font-semibold shadow-lg">
                            <div class="w-2 h-2 bg-white rounded-full mr-3 animate-pulse"></div>
                            {{ $config[2] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Breadcrumb -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <nav class="flex text-sm text-gray-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-gray-600 hover:text-blue-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a1 1 0 01.7.3l7 7a1 1 0 01-1.4 1.4L16 10.42V17a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6.58l-.3.28a1 1 0 01-1.4-1.44l7-7A1 1 0 0110 2z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                        </svg>
                        <a href="{{ route('support_tickets.index') }}" class="text-gray-600 hover:text-blue-600 transition-colors">
                            Support
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                        </svg>
                        <span class="text-gray-900 font-medium">Ticket #{{ $supportTicket->id }}</span>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Ticket Details Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 sticky top-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Ticket Information
                    </h2>
                    
                    <div class="space-y-4">
                        <!-- Ticket ID -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-semibold text-gray-700">Ticket ID</span>
                            <span class="text-sm font-bold text-blue-600">#{{ $supportTicket->id }}</span>
                        </div>

                        <!-- Subject -->
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-semibold text-gray-700 block mb-2">Subject</span>
                            <span class="text-sm text-gray-900">{{ $supportTicket->subject }}</span>
                        </div>

                        <!-- Created By -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-semibold text-gray-700">Created By</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-6 h-6 bg-gradient-to-br from-blue-400 to-purple-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">{{ strtoupper(substr($supportTicket->user->name, 0, 1)) }}</span>
                                </div>
                                <span class="text-sm text-gray-900">{{ $supportTicket->user->name }}</span>
                            </div>
                        </div>

                        <!-- Created Date -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-semibold text-gray-700">Created</span>
                            <div class="text-right">
                                <span class="text-sm text-gray-900 block">{{ $supportTicket->created_at->format('M d, Y') }}</span>
                                <span class="text-xs text-gray-500">{{ $supportTicket->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <!-- Last Updated -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-semibold text-gray-700">Last Updated</span>
                            <div class="text-right">
                                <span class="text-sm text-gray-900 block">{{ $supportTicket->updated_at->format('M d, Y') }}</span>
                                <span class="text-xs text-gray-500">{{ $supportTicket->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <!-- Messages Count -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-semibold text-gray-700">Total Replies</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $supportTicket->messages->count() }} messages
                            </span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 space-y-3">
                        @if ($supportTicket->status != 'closed')
                            <form action="{{ route('support_tickets.close', $supportTicket) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Close Ticket
                                </button>
                            </form>
                        @elseif ($supportTicket->status == 'closed' && !$supportTicket->trashed())
                            <form action="{{ route('support_tickets.reopen', $supportTicket) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                    </svg>
                                    Reopen Ticket
                                </button>
                            </form>
                        @endif

                        @if ($supportTicket->trashed())
                            <form action="{{ route('support_tickets.recover', $supportTicket) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Restore Ticket
                                </button>
                            </form>
                        @endif

                        @if (!$supportTicket->trashed())
                            <form action="{{ route('support_tickets.destroy', $supportTicket) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this ticket?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete Ticket
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Reply Form -->
                @if ($supportTicket->status != 'closed')
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Write a Reply
                        </h3>

                        <form action="{{ route('support_tickets.reply', $supportTicket) }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label for="editor" class="block text-sm font-semibold text-gray-700 mb-3">Your Message</label>
                                <div class="border border-gray-300 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500">
                                    <textarea id="editor" name="message" rows="8" 
                                              placeholder="Type your reply here..."
                                              class="w-full p-4 border-0 focus:ring-0 focus:outline-none resize-none text-gray-900">{{ old('message') }}</textarea>
                                </div>
                                @error('message')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                <div class="text-sm text-gray-500">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Your reply will update the ticket status
                                </div>
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Send Reply
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-xl p-6">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-yellow-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.314 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <div>
                                <h3 class="text-lg font-semibold text-yellow-800">Ticket Closed</h3>
                                <p class="text-sm text-yellow-700 mt-1">This ticket has been closed and cannot receive new replies. You can reopen it using the action buttons.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Messages Thread -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Conversation History
                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            {{ $supportTicket->messages->count() }} messages
                        </span>
                    </h3>

                    <div class="space-y-6">
                        @forelse ($supportTicket->messages->sortByDesc('created_at') as $message)
                            <div class="flex space-x-4">
                                <!-- Avatar -->
                                <div class="flex-shrink-0">
                                    @if($message->user->hasRole('admin'))
                                        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-600 rounded-full flex items-center justify-center shadow-lg">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                                            <span class="text-white font-bold">{{ strtoupper(substr($message->user->name, 0, 1)) }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Message Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="bg-gray-50 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                                        <!-- Message Header -->
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center space-x-2">
                                                <span class="font-bold text-gray-900">
                                                    {{ $message->user->hasRole('admin') ? '👑 Admin' : '👤 User' }}: {{ $message->user->name }}
                                                </span>
                                                @if($message->user->hasRole('admin'))
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Staff
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm font-medium text-gray-900">{{ $message->created_at->format('M d, Y') }}</p>
                                                <p class="text-xs text-gray-500">{{ $message->created_at->format('H:i') }} • {{ $message->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>

                                        <!-- Message Body -->
                                        <div class="prose prose-sm max-w-none text-gray-800">
                                            {!! $message->message !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Messages Yet</h3>
                                <p class="text-gray-600">Be the first to reply to this ticket.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .prose {
            max-width: none;
        }
        .prose p {
            margin-bottom: 1rem;
        }
        .prose ul, .prose ol {
            margin: 1rem 0;
            padding-left: 1.5rem;
        }
        .prose li {
            margin-bottom: 0.5rem;
        }
        .prose strong {
            font-weight: 600;
            color: #374151;
        }
        .prose em {
            font-style: italic;
            color: #6B7280;
        }
    </style>
</x-app-layout>