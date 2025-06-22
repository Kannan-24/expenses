<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Session Activity') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Manage and review your active sessions on other browsers and devices.') }}
        </p>
    </header>

    @if (count($sessions) > 0)
        <div class="mt-6 space-y-6">
            @foreach ($sessions as $session)
                <div class="flex items-center">
                    <div>
                        @if ($session->agent->isDesktop())
                            <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9.75 17h4.5m-9.5 0h14.5a2 2 0 002-2V7a2 2 0 00-2-2H4.75a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        @else
                            <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
                            </svg>
                        @endif
                    </div>
                    <div class="ml-3">
                        <div class="text-sm text-gray-600">
                            {{ $session->agent->platform() ?: 'Unknown' }} - {{ $session->agent->browser() ?: 'Unknown' }}
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">
                                {{ $session->ip_address }},
                                @if ($session->is_current_device)
                                    <span class="text-green-500 font-semibold">{{ __('This device') }}</span>
                                @else
                                    {{ __('Last active') }} {{ $session->last_active }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="mt-4 text-sm text-gray-600">
            {{ __('No active sessions found.') }}
        </p>
    @endif

    <div class="flex justify-end mt-6">
        <form method="POST" action="{{ route('logout.other-browser-sessions') }}">
            @csrf

            <x-danger-button>
                {{ __('Log Out Other Browser Sessions') }}
            </x-danger-button>
        </form>
    </div>
</section>
