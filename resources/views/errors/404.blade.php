@extends('errors::minimal')

@section('icon')
    <svg class="w-16 h-16 text-purple-400 dark:text-purple-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 64 64">
        <circle cx="32" cy="32" r="30" stroke-width="3" class="text-purple-100 dark:text-gray-700" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M24 28h16M28 36h8" />
    </svg>
@endsection

@section('code', '404')
@section('title', __('Page Not Found'))
@section('message')
    {{ __('Sorry, the page you are looking for could not be found.') }}
@endsection

@section('actions')
    <a href="{{ url('/') }}" class="mt-8 inline-flex px-4 py-2 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
        {{ __('Go to Home') }}
    </a>
@endsection