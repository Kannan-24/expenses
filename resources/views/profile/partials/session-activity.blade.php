<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Browser Sessions') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('If necessary, you may logout of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
        </p>
    </header>

    @if (count($sessions ?? []) > 0)
        <div class="mt-5 space-y-6">
            @foreach (($sessions ?? []) as $session)
                <div class="flex items-center">
                    <div>
                        @if ($session->agent->isDesktop())
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-8 h-8 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                            </svg>
                        @endif
                    </div>
                    <div class="ms-3">
                        <div class="text-sm text-gray-600">
                            {{ $session->agent->platform() ?: __('Unknown') }} - {{ $session->agent->browser() ?: __('Unknown') }}
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">
                                {{ $session->ip_address }},
                                @if ($session->is_current_device)
                                    <span class="text-green-500 font-semibold">{{ __('This device') }}</span>
                                @else
                                    {{ __('Last active') }} {{ $session->last_active }}
                                    <a href="{{ route('profile.logoutOtherDevice', $session->id) }}"
                                        class="text-red-500 hover:text-red-600 font-semibold">
                                        {{ __('Logout') }}
                                    </a>
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

    <x-danger-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-logout')">
        {{ __('Logout Other Browser Sessions') }}
    </x-danger-button>

    <x-modal name="confirm-user-logout" :show="$errors->logoutOtherDevice->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.logoutOtherDevices') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to logout other browser sessions?') }}
            </h2>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}" />
                <x-input-error :messages="$errors->logoutOtherDevice->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-danger-button class="ms-3">
                    {{ __('Logout Other Sessions') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
