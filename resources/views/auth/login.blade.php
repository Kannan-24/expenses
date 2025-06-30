<x-auth-layout>
    <x-slot name="title">
        {{ __('Login') }} - {{ config('app.name', 'Duo Dev Expenses') }}
    </x-slot>
    
    <div
        class="flex-1 bg-gradient-to-br from-brand-purple to-brand-purple-light relative hidden md:flex items-center justify-center overflow-hidden">
        <div class="absolute -top-1/2 -left-1/5 w-[200%] h-[200%] animate-drift"></div>

        <div class="absolute w-full h-full">
            <!-- Floating Card 1 -->
            <div
                class="absolute top-[15%] right-[10%] w-48 bg-white/15 backdrop-blur-xl rounded-3xl p-6 text-white border border-white/20 animate-float-card">
                <div class="text-sm opacity-80 mb-2">Available Balance</div>
                <div class="text-3xl font-bold mb-4">$12,543</div>
                <div class="h-10 bg-white/10 rounded-lg relative overflow-hidden">
                    <div class="absolute bottom-0 left-[10%] w-2 bg-gradient-to-t from-green-500 to-emerald-400 rounded-sm animate-grow-bar"
                        style="--height: 85%;"></div>
                    <div class="absolute bottom-0 left-[25%] w-2 bg-gradient-to-t from-green-500 to-emerald-400 rounded-sm animate-grow-bar"
                        style="--height: 95%; animation-delay: 0.2s;"></div>
                    <div class="absolute bottom-0 left-[40%] w-2 bg-gradient-to-t from-green-500 to-emerald-400 rounded-sm animate-grow-bar"
                        style="--height: 70%; animation-delay: 0.4s;"></div>
                    <div class="absolute bottom-0 left-[55%] w-2 bg-gradient-to-t from-green-500 to-emerald-400 rounded-sm animate-grow-bar"
                        style="--height: 100%; animation-delay: 0.6s;"></div>
                    <div class="absolute bottom-0 left-[70%] w-2 bg-gradient-to-t from-green-500 to-emerald-400 rounded-sm animate-grow-bar"
                        style="--height: 75%; animation-delay: 0.8s;"></div>
                </div>
            </div>

            <!-- Floating Card 2 -->
            <div class="absolute bottom-[20%] left-[10%] w-60 bg-white/15 backdrop-blur-xl rounded-3xl p-6 text-white border border-white/20 animate-float-card text-left"
                style="animation-delay: 2s;">
                <div class="text-lg font-semibold mb-3">Welcome back!</div>
                <div class="text-sm opacity-80 leading-relaxed">Continue managing your finances with ease. Track
                    your expenses, monitor your budget, and achieve your financial goals.</div>
            </div>

            <!-- Floating Icons -->
            <div class="absolute top-[20%] left-[20%] w-16 h-16 bg-white/20 rounded-full flex items-center justify-center animate-float-icon"
                style="animation-delay: 1s;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 8H10" stroke="#fff" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path
                        d="M22 10.5C22 10.4226 22 9.96726 21.9977 9.9346C21.9623 9.43384 21.5328 9.03496 20.9935 9.00214C20.9583 9 20.9167 9 20.8333 9H18.2308C16.4465 9 15 10.3431 15 12C15 13.6569 16.4465 15 18.2308 15H20.8333C20.9167 15 20.9583 15 20.9935 14.9979C21.5328 14.965 21.9623 14.5662 21.9977 14.0654C22 14.0327 22 13.5774 22 13.5"
                        stroke="#fff" stroke-width="1.5" stroke-linecap="round" />
                    <circle cx="18" cy="12" r="1" fill="#fff" />
                    <path
                        d="M13 4C16.7712 4 18.6569 4 19.8284 5.17157C20.6366 5.97975 20.8873 7.1277 20.965 9M10 20H13C16.7712 20 18.6569 20 19.8284 18.8284C20.6366 18.0203 20.8873 16.8723 20.965 15M9 4.00093C5.8857 4.01004 4.23467 4.10848 3.17157 5.17157C2 6.34315 2 8.22876 2 12C2 15.7712 2 17.6569 3.17157 18.8284C3.82475 19.4816 4.69989 19.7706 6 19.8985"
                        stroke="#fff" stroke-width="1.5" stroke-linecap="round" />
                </svg>
            </div>

            <div class="absolute bottom-[30%] right-[30%] w-16 h-16 bg-white/20 rounded-full flex items-center justify-center animate-float-icon"
                style="animation-delay: 3s;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 18V9" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M12 18V6" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M17 18V13" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                    <path
                        d="M22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C21.5093 4.43821 21.8356 5.80655 21.9449 8"
                        stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Right Panel (Form) -->
    <div class="flex-1 px-16 pt-12 pb-8 flex flex-col justify-center relative">
        <div class="absolute top-6 left-16 right-16 flex justify-between items-center">
            <a href="{{ route('home') }}"
                class="flex items-center gap-2 text-gray-600 text-sm transition-colors hover:text-brand-purple">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M15.7071 4.29289C16.0976 4.68342 16.0976 5.31658 15.7071 5.70711L9.41421 12L15.7071 18.2929C16.0976 18.6834 16.0976 19.3166 15.7071 19.7071C15.3166 20.0976 14.6834 20.0976 14.2929 19.7071L7.29289 12.7071C7.10536 12.5196 7 12.2652 7 12C7 11.7348 7.10536 11.4804 7.29289 11.2929L14.2929 4.29289C14.6834 3.90237 15.3166 3.90237 15.7071 4.29289Z"
                            fill="#4b5563"></path>
                    </g>
                </svg>
                Back
            </a>
            <div>
                <span class="text-gray-600 text-sm">Don't have account?</span>
                <a href="{{ route('register') }}" class="text-brand-purple font-medium text-sm ml-1">Sign up</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="mt-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-3 leading-tight">Sign In</h1>
            <p class="text-gray-600 text-md mb-6 leading-relaxed">Welcome back! Please sign in to your account</p>

            <form id="loginForm" method="post" action="{{ route('login') }}">
                @csrf

                <div class="mb-4 relative">
                    <input type="email" name="email" id="username" value="{{ old('email') }}" autofocus
                        autocomplete="username"
                        class="w-full px-4 py-4 border-2 border-gray-100 rounded-2xl text-base transition-all bg-gray-50 focus:outline-none focus:border-brand-purple focus:bg-white focus:shadow-lg focus:shadow-brand-purple/10"
                        placeholder="Email" required>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-4 relative" x-data="{ show: false }">
                    <input type="password" id="password" x-bind:type="show ? 'text' : 'password'" name="password"
                        autocomplete="current-password"
                        class="w-full px-4 py-4 border-2 border-gray-100 rounded-2xl text-base transition-all bg-gray-50 focus:outline-none focus:border-brand-purple focus:bg-white focus:shadow-lg focus:shadow-brand-purple/10"
                        placeholder="Password" required>
                    <span class="absolute top-1/2 right-3 -translate-y-1/2 w-8 h-8 flex justify-center items-center"
                        id="password-toggle" @click="show = !show">
                        <template x-if="!show">
                            <svg width="25" height="25" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M9 4.45962C9.91153 4.16968 10.9104 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C3.75612 8.07914 4.32973 7.43025 5 6.82137"
                                        stroke="#1f2937" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path
                                        d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z"
                                        stroke="#1f2937" stroke-width="1.5"></path>
                                </g>
                            </svg>
                        </template>
                        <template x-if="show">
                            <svg width="25" height="25" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M2.68936 6.70456C2.52619 6.32384 2.08528 6.14747 1.70456 6.31064C1.32384 6.47381 1.14747 6.91472 1.31064 7.29544L2.68936 6.70456ZM15.5872 13.3287L15.3125 12.6308L15.5872 13.3287ZM9.04145 13.7377C9.26736 13.3906 9.16904 12.926 8.82185 12.7001C8.47466 12.4742 8.01008 12.5725 7.78417 12.9197L9.04145 13.7377ZM6.37136 15.091C6.14545 15.4381 6.24377 15.9027 6.59096 16.1286C6.93815 16.3545 7.40273 16.2562 7.62864 15.909L6.37136 15.091ZM22.6894 7.29544C22.8525 6.91472 22.6762 6.47381 22.2954 6.31064C21.9147 6.14747 21.4738 6.32384 21.3106 6.70456L22.6894 7.29544ZM19 11.1288L18.4867 10.582V10.582L19 11.1288ZM19.9697 13.1592C20.2626 13.4521 20.7374 13.4521 21.0303 13.1592C21.3232 12.8663 21.3232 12.3914 21.0303 12.0985L19.9697 13.1592ZM11.25 16.5C11.25 16.9142 11.5858 17.25 12 17.25C12.4142 17.25 12.75 16.9142 12.75 16.5H11.25ZM16.3714 15.909C16.5973 16.2562 17.0619 16.3545 17.409 16.1286C17.7562 15.9027 17.8545 15.4381 17.6286 15.091L16.3714 15.909ZM5.53033 11.6592C5.82322 11.3663 5.82322 10.8914 5.53033 10.5985C5.23744 10.3056 4.76256 10.3056 4.46967 10.5985L5.53033 11.6592ZM2.96967 12.0985C2.67678 12.3914 2.67678 12.8663 2.96967 13.1592C3.26256 13.4521 3.73744 13.4521 4.03033 13.1592L2.96967 12.0985ZM12 13.25C8.77611 13.25 6.46133 11.6446 4.9246 9.98966C4.15645 9.16243 3.59325 8.33284 3.22259 7.71014C3.03769 7.3995 2.90187 7.14232 2.8134 6.96537C2.76919 6.87696 2.73689 6.80875 2.71627 6.76411C2.70597 6.7418 2.69859 6.7254 2.69411 6.71533C2.69187 6.7103 2.69036 6.70684 2.68957 6.70503C2.68917 6.70413 2.68896 6.70363 2.68892 6.70355C2.68891 6.70351 2.68893 6.70357 2.68901 6.70374C2.68904 6.70382 2.68913 6.70403 2.68915 6.70407C2.68925 6.7043 2.68936 6.70456 2 7C1.31064 7.29544 1.31077 7.29575 1.31092 7.29609C1.31098 7.29624 1.31114 7.2966 1.31127 7.2969C1.31152 7.29749 1.31183 7.2982 1.31218 7.299C1.31287 7.30062 1.31376 7.30266 1.31483 7.30512C1.31698 7.31003 1.31988 7.31662 1.32353 7.32483C1.33083 7.34125 1.34115 7.36415 1.35453 7.39311C1.38127 7.45102 1.42026 7.5332 1.47176 7.63619C1.57469 7.84206 1.72794 8.13175 1.93366 8.47736C2.34425 9.16716 2.96855 10.0876 3.8254 11.0103C5.53867 12.8554 8.22389 14.75 12 14.75V13.25ZM15.3125 12.6308C14.3421 13.0128 13.2417 13.25 12 13.25V14.75C13.4382 14.75 14.7246 14.4742 15.8619 14.0266L15.3125 12.6308ZM7.78417 12.9197L6.37136 15.091L7.62864 15.909L9.04145 13.7377L7.78417 12.9197ZM22 7C21.3106 6.70456 21.3107 6.70441 21.3108 6.70427C21.3108 6.70423 21.3108 6.7041 21.3109 6.70402C21.3109 6.70388 21.311 6.70376 21.311 6.70368C21.3111 6.70352 21.3111 6.70349 21.3111 6.7036C21.311 6.7038 21.3107 6.70452 21.3101 6.70576C21.309 6.70823 21.307 6.71275 21.3041 6.71924C21.2983 6.73223 21.2889 6.75309 21.2758 6.78125C21.2495 6.83757 21.2086 6.92295 21.1526 7.03267C21.0406 7.25227 20.869 7.56831 20.6354 7.9432C20.1669 8.69516 19.4563 9.67197 18.4867 10.582L19.5133 11.6757C20.6023 10.6535 21.3917 9.56587 21.9085 8.73646C22.1676 8.32068 22.36 7.9668 22.4889 7.71415C22.5533 7.58775 22.602 7.48643 22.6353 7.41507C22.6519 7.37939 22.6647 7.35118 22.6737 7.33104C22.6782 7.32097 22.6818 7.31292 22.6844 7.30696C22.6857 7.30398 22.6867 7.30153 22.6876 7.2996C22.688 7.29864 22.6883 7.29781 22.6886 7.29712C22.6888 7.29677 22.6889 7.29646 22.689 7.29618C22.6891 7.29604 22.6892 7.29585 22.6892 7.29578C22.6893 7.29561 22.6894 7.29544 22 7ZM18.4867 10.582C17.6277 11.3882 16.5739 12.1343 15.3125 12.6308L15.8619 14.0266C17.3355 13.4466 18.5466 12.583 19.5133 11.6757L18.4867 10.582ZM18.4697 11.6592L19.9697 13.1592L21.0303 12.0985L19.5303 10.5985L18.4697 11.6592ZM11.25 14V16.5H12.75V14H11.25ZM14.9586 13.7377L16.3714 15.909L17.6286 15.091L16.2158 12.9197L14.9586 13.7377ZM4.46967 10.5985L2.96967 12.0985L4.03033 13.1592L5.53033 11.6592L4.46967 10.5985Z"
                                        fill="#1f2937"></path>
                                </g>
                            </svg>
                        </template>
                    </span>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mb-6 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="remember_me" class="w-4 h-4 ml-2 accent-brand-purple"
                            name="remember">
                        <label for="remember_me" class="text-sm text-gray-600">
                            Remember me
                        </label>
                    </div>
                    <a href="{{ route('password.request') }}"
                        class="text-brand-purple text-sm font-medium hover:underline">Forgot Password?</a>
                </div>

                <button type="submit"
                    class="w-full bg-brand-purple text-white border-none px-4 py-4 rounded-2xl text-base font-semibold cursor-pointer transition-all flex items-center justify-center gap-2 mb-8 relative overflow-hidden hover:bg-blue-700 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-brand-purple/30 group">
                    <span
                        class="absolute top-0 -left-full w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-all duration-500 group-hover:left-full"></span>
                    Sign In
                </button>
            </form>

            <div class="text-center my-4 relative text-gray-500 text-sm flex items-center justify-center">
                <span class="w-16 border-t border-gray-300"></span>
                <span class="bg-white px-5">Or</span>
                <span class="w-16 border-t border-gray-300"></span>
            </div>

            <div class="flex gap-4 mt-4 mb-2">
                <a href="{{ route('google.login') }}"
                    class="flex items-center justify-center w-full px-4 py-4 border border-gray-300 rounded-full bg-white text-sm font-medium text-gray-700 hover:bg-gray-100 transition duration-150">
                    <span class="w-5 h-5 mr-3 inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 100 100">
                            <path fill="#4285F4"
                                d="M95.833 51.021c0-3.77-.312-6.52-.983-9.375H50.933V58.66h25.775c-.516 4.225-3.32 10.592-9.558 14.87l-.088.567 13.884 10.542.958.092c8.842-7.992 13.93-19.759 13.93-33.709" />
                            <path fill="#34A853"
                                d="M50.938 95.833c12.625 0 23.225-4.076 30.97-11.105l-14.758-11.2c-3.95 2.7-9.25 4.584-16.212 4.584a28.1 28.1 0 0 1-26.609-19.05l-.55.046-14.437 10.95-.188.516c7.692 14.971 23.492 25.258 41.784 25.258" />
                            <path fill="#FBBC05"
                                d="M24.333 59.062a27.7 27.7 0 0 1-1.57-9.063c0-3.158.574-6.212 1.504-9.062l-.025-.613L9.625 29.2l-.48.225A45.1 45.1 0 0 0 4.168 50c0 7.384 1.816 14.363 4.987 20.575z" />
                            <path fill="#EB4335"
                                d="M50.938 21.888c8.783 0 14.704 3.716 18.083 6.824l13.196-12.629C74.113 8.7 63.563 4.167 50.937 4.167c-18.295 0-34.091 10.287-41.783 25.258L24.28 40.938a28.21 28.21 0 0 1 26.659-19.05" />
                        </svg>
                    </span>
                    Sign in with Google
                </a>
            </div>
        </div>
    </div>
</x-auth-layout>
