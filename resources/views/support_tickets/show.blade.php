<x-app-layout>
    <x-slot name="title">
        {{ __('Support Ticket') }} #{{ $supportTicket->id }} - {{ config('app.name', 'Cazhoo') }}
    </x-slot>

    <x-slot name="head">
        @vite(['resources/js/editor.js'])
    </x-slot>

    <div class=" space-y-6">

        {{-- Header Section --}}
        <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-800 dark:via-blue-900 dark:to-indigo-900 border-b border-blue-500 dark:border-blue-600 rounded-2xl shadow-xl overflow-hidden">
            <div class="relative p-8 text-white">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <div class="flex items-center space-x-3 mb-2">
                            <div class="p-2 bg-white bg-opacity-20 dark:bg-white/10 rounded-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl lg:text-4xl font-bold text-white">Support Ticket #{{ $supportTicket->id }}</h1>
                                <p class="text-blue-100 dark:text-blue-200 text-lg mt-1">{{ $supportTicket->subject }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status Badge -->
                    <div class="mt-4 lg:mt-0">
                        @php
                            $statusConfig = [
                                'opened' => ['bg-green-500 dark:bg-green-600', 'text-white', 'Open'],
                                'closed' => ['bg-red-500 dark:bg-red-600', 'text-white', 'Closed'],
                                'admin_replied' => ['bg-blue-500 dark:bg-blue-600', 'text-white', 'Admin Replied'],
                                'customer_replied' => ['bg-yellow-500 dark:bg-yellow-600', 'text-white', 'Customer Replied'],
                            ];
                            $config = $statusConfig[$supportTicket->status] ?? ['bg-gray-500 dark:bg-gray-700', 'text-white', 'Unknown'];
                        @endphp
                        <div class="inline-flex items-center px-6 py-3 {{ $config[0] }} {{ $config[1] }} rounded-xl font-semibold shadow-lg">
                            <div class="w-2 h-2 bg-white dark:bg-white/80 rounded-full mr-3 animate-pulse"></div>
                            {{ $config[2] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Ticket Details Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-100 dark:border-gray-800 p-6 sticky top-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Ticket Information
                    </h2>
            
                    <div class="space-y-4">
                        <!-- Ticket ID -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900 rounded-lg">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Ticket ID</span>
                            <span class="text-sm font-bold text-blue-600 dark:text-blue-400">#{{ $supportTicket->id }}</span>
                        </div>
            
                        <!-- Subject -->
                        <div class="p-3 bg-gray-50 dark:bg-gray-900 rounded-lg">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 block mb-2">Subject</span>
                            <span class="text-sm text-gray-900 dark:text-gray-100">{{ $supportTicket->subject }}</span>
                        </div>
            
                        <!-- Created By -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900 rounded-lg">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Created By</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-6 h-6 bg-gradient-to-br from-blue-400 to-purple-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">{{ strtoupper(substr($supportTicket->user->name, 0, 1)) }}</span>
                                </div>
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $supportTicket->user->name }}</span>
                            </div>
                        </div>
            
                        <!-- Created Date -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900 rounded-lg">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Created</span>
                            <div class="text-right">
                                <span class="text-sm text-gray-900 dark:text-gray-100 block">{{ $supportTicket->created_at->format('M d, Y') }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $supportTicket->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
            
                        <!-- Last Updated -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900 rounded-lg">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Last Updated</span>
                            <div class="text-right">
                                <span class="text-sm text-gray-900 dark:text-gray-100 block">{{ $supportTicket->updated_at->format('M d, Y') }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $supportTicket->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
            
                        <!-- Messages Count -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900 rounded-lg">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Total Replies</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300">
                                {{ $supportTicket->messages->count() }} messages
                            </span>
                        </div>
                    </div>
            
                    <!-- Action Buttons -->
                    <div class="mt-8 space-y-3">
                        @if ($supportTicket->status != 'closed')
                            <form action="{{ route('support_tickets.close', $supportTicket) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center justify-center px-4 py-2 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    Close Ticket
                                </button>
                            </form>
                        @elseif ($supportTicket->status == 'closed' && !$supportTicket->trashed())
                            <form action="{{ route('support_tickets.reopen', $supportTicket) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center justify-center px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                    </svg>
                                    Reopen Ticket
                                </button>
                            </form>
                        @endif
            
                        @if ($supportTicket->trashed())
                            <form action="{{ route('support_tickets.recover', $supportTicket) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Restore Ticket
                                </button>
                            </form>
                        @endif
            
                        @if (!$supportTicket->trashed())
                            <form action="{{ route('support_tickets.destroy', $supportTicket) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this ticket?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
                    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Write a Reply
                        </h3>

                        <form action="{{ route('support_tickets.reply', $supportTicket) }}" method="POST" class="space-y-6 ">
                            @csrf
                            <div>
                                <label for="editor" class="block text-sm font-semibold text-gray-700 mb-3">Your Message</label>
                                <div class="border border-gray-300 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 ">
                                    <textarea id="editor" name="message" rows="8" 
                                              placeholder="Type your reply here..."
                                              class="w-full p-4 border-0 focus:ring-0 focus:outline-none resize-none text-gray-900 ">{{ old('message') }}</textarea>
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
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <!-- Header -->
                    <div class="bg-white dark:bg-gray-900 p-4 sm:p-6 border-b border-gray-100 dark:border-gray-700">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="flex items-center">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-purple-500 to-blue-600 rounded-full flex items-center justify-center mr-3 sm:mr-4">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">Conversation History</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 sm:hidden">{{ $supportTicket->messages->count() }} messages in this thread</p>
                                </div>
                            </div>
                            <div class="hidden sm:flex items-center space-x-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">
                                    {{ $supportTicket->messages->count() }} messages
                                </span>
                            </div>
                        </div>
                    </div>
                
                    <!-- Messages Container -->
                    <div class="max-h-96 sm:max-h-[500px] overflow-y-auto">
                        <div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
                            @forelse ($supportTicket->messages->sortByDesc('created_at') as $message)
                                <div class="group">
                                    <div class="flex space-x-3 sm:space-x-4">
                                        <!-- Avatar -->
                                        <div class="flex-shrink-0">
                                            @if($message->user->hasRole('admin'))
                                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-red-500 to-pink-600 rounded-full flex items-center justify-center shadow-lg ring-2 ring-white">
                                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg ring-2 ring-white">
                                                    <span class="text-white font-bold text-sm sm:text-base">{{ strtoupper(substr($message->user->name, 0, 1)) }}</span>
                                                </div>
                                            @endif
                                        </div>
                
                                        <!-- Message Content -->
                                        <div class="flex-1 min-w-0">
                                            <!-- Message Bubble -->
                                            <div class="bg-gray-50 dark:bg-gray-800 group-hover:bg-gray-500 dark:group-hover:bg-gray-600 rounded-2xl p-4 sm:p-5 shadow-sm transition-all duration-200">
                                                <!-- Message Header -->
                                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-3 space-y-1 sm:space-y-0">
                                                    <div class="flex items-center space-x-2">
                                                        <span class="font-semibold text-gray-900 dark:text-white text-sm sm:text-base">
                                                            {{ $message->user->name }}
                                                        </span>
                                                        @if($message->user->hasRole('admin'))
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 border border-red-200 dark:bg-red-900 dark:text-red-300 dark:border-red-700">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                                </svg>
                                                                Staff
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="text-left sm:text-right">
                                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $message->created_at->format('M d, Y') }}</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $message->created_at->format('H:i') }} • {{ $message->created_at->diffForHumans() }}</p>
                                                    </div>
                                                </div>
                
                                                <!-- Message Body -->
                                                <div class="prose prose-sm dark:prose-invert max-w-none text-gray-800 dark:text-gray-100 break-words leading-relaxed">
                                                    {!! $message->message !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 sm:py-12">
                                    <div class="mx-auto w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-2">No Messages Yet</h3>
                                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 max-w-sm mx-auto">This conversation is waiting for the first message. Start the discussion!</p>
                                </div>
                            @endforelse
                        </div>
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