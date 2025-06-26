<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Support Ticket Details') }}
        </h2>
    </x-slot>

    <a href="{{ route('support_tickets.create') }}"
        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
        Create New Ticket
    </a>
</x-app-layout>
