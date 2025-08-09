<x-app-layout>
    <x-slot name="title">
        {{ __('People Management') }} - {{ config('app.name', 'Cazhoo') }}
    </x-slot>

    <div class="min-h-screen">
        <div class="max-w-7xl mx-auto">
            <!-- Enhanced Header Section -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-6 overflow-hidden">
                <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-800 dark:via-blue-900 dark:to-indigo-900 border-b border-blue-500 dark:border-blue-600 p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <!-- Title and Breadcrumb -->
                        <div>
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-2">People Management</h1>
                            <nav class="flex text-sm" aria-label="Breadcrumb">
                                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                                    <li class="inline-flex items-center">
                                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-blue-200 hover:text-white transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 2a1 1 0 01.7.3l7 7a1 1 0 01-1.4 1.4L16 10.42V17a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6.58l-.3.28a1 1 0 01-1.4-1.44l7-7A1 1 0 0110 2z" />
                                            </svg>
                                            Dashboard
                                        </a>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mx-2 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                                        </svg>
                                        <span class="text-blue-100 font-medium">People</span>
                                    </li>
                                </ol>
                            </nav>
                        </div>

                        <!-- Stats and Create Button -->
                        <div class="flex items-center space-x-4">
                            <div class="text-center">
                                <p class="text-sm text-blue-200">Total People</p>
                                <p class="text-2xl font-bold text-white">{{ $people->total() }}</p>
                            </div>
                            <div class="w-px h-12 bg-blue-300 opacity-50"></div>
                            <a href="{{ route('expense-people.create') }}"
                               class="inline-flex items-center justify-center px-4 sm:px-6 py-3 bg-white dark:bg-gray-100 text-blue-700 dark:text-blue-800 font-semibold rounded-xl hover:bg-blue-50 dark:hover:bg-gray-200 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                <span class="hidden sm:inline">Add Person</span>
                                <span class="sm:hidden">Add</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 mb-6 p-4 sm:p-6">
                <form method="GET" class="space-y-4">
                    <!-- Search Bar -->
                    <div class="relative max-w-2xl mx-auto">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search people by name..."
                               class="w-full pl-12 pr-12 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                               autocomplete="off" />
                        
                        @if(request('search'))
                            <a href="{{ route('expense-people.index') }}"
                               class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </div>

                    <!-- Search Summary -->
                    @if(request('search'))
                        <div class="text-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Showing results for "<span class="font-semibold text-blue-600 dark:text-blue-400">{{ request('search') }}</span>"
                                <span class="mx-2">•</span>
                                {{ $people->total() }} {{ Str::plural('person', $people->total()) }} found
                            </p>
                        </div>
                    @endif
                </form>
            </div>

            <!-- People Content -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Desktop Table View -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">#</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Person</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Details</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($people as $person)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $loop->iteration + ($people->currentPage() - 1) * $people->perPage() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $person->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <div class="w-auto flex gap-x-4">
                                            <span class="w-auto inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                                Added {{ $person->created_at->format('M d, Y') }}
                                            </span>
                                            @if($person->updated_at != $person->created_at)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Updated {{ $person->updated_at->diffForHumans() }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('expense-people.edit', $person->id) }}"
                                               class="inline-flex items-center px-3 py-1.5 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 text-xs font-medium rounded-lg hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('expense-people.destroy', $person->id) }}" method="POST" class="inline-block"
                                                  onsubmit="return confirm('Are you sure you want to delete this person? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-1.5 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 text-xs font-medium rounded-lg hover:bg-red-200 dark:hover:bg-red-800 transition-colors">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            @if(request('search'))
                                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No people found</h3>
                                                <p class="text-gray-500 dark:text-gray-400 mb-4">No people match your search criteria.</p>
                                                <a href="{{ route('expense-people.index') }}"
                                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                                    Clear Search
                                                </a>
                                            @else
                                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No people found</h3>
                                                <p class="text-gray-500 dark:text-gray-400 mb-4">Get started by adding your first person.</p>
                                                <a href="{{ route('expense-people.create') }}"
                                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    Add Person
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="lg:hidden divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($people as $person)
                        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $person->name }}</h3>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                    #{{ $loop->iteration + ($people->currentPage() - 1) * $people->perPage() }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Added</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $person->created_at->format('M d, Y') }}</p>
                                </div>
                                @if($person->updated_at != $person->created_at)
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Last Updated</p>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $person->updated_at->diffForHumans() }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center justify-between pt-3 border-t border-gray-200 dark:border-gray-600">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Actions:</span>
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('expense-people.edit', $person->id) }}" 
                                       class="inline-flex items-center text-blue-600 dark:text-blue-400 text-sm font-medium">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('expense-people.destroy', $person->id) }}" method="POST" class="inline-block"
                                          onsubmit="return confirm('Are you sure you want to delete this person?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center text-red-600 dark:text-red-400 text-sm font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                @if(request('search'))
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No people found</h3>
                                    <p class="text-gray-500 dark:text-gray-400 mb-4">No people match your search criteria.</p>
                                    <a href="{{ route('expense-people.index') }}"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                        Clear Search
                                    </a>
                                @else
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No people found</h3>
                                    <p class="text-gray-500 dark:text-gray-400 mb-4">Get started by adding your first person.</p>
                                    <a href="{{ route('expense-people.create') }}"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Add Person
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Enhanced Pagination -->
            @if($people->hasPages())
                <div class="mt-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                        <div class="text-sm text-gray-700 dark:text-gray-300">
                            Showing {{ $people->firstItem() }} to {{ $people->lastItem() }} of {{ $people->total() }} people
                        </div>
                        <div>
                            <x-pagination :paginator="$people" />
                        </div>
                    </div>
                </div>
            @endif

            
                

                
            </div>
        </div>
    </div>
    
</x-app-layout>