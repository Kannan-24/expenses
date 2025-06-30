<x-app-layout>
    <x-slot name="title">
        {{ __('Dashboard') }} - {{ config('app.name', 'ExpenseTracker') }}
    </x-slot>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    @if (auth()->user()->hasRole('admin'))
        @include('dashboard.partials.admin-dashboard')
    @else
        @include('dashboard.partials.user-dashboard')
    @endif

</x-app-layout>
