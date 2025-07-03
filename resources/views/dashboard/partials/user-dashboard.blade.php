<div class=" space-y-6">

    <!-- Enhanced Welcome Message with Time-based Greeting -->
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-2xl shadow-xl">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="absolute -top-4 -right-4 w-32 h-32 bg-white opacity-10 rounded-full"></div>
        <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-white opacity-10 rounded-full"></div>
        <div class="relative p-8 text-white">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-3xl lg:text-4xl font-bold mb-2">
                        Good <span id="greeting"></span>, {{ auth()->user()->name }}!
                    </h1>
                    <p class="text-blue-100 text-lg mb-4 lg:mb-0">
                        Here's your financial overview for this month
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-xl p-4">
                    <div class="text-right">
                        <p class="text-sm text-blue-100">Current Date</p>
                        <p class="text-xl font-semibold" id="currentDate"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Income Card -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-green-100 rounded-xl group-hover:bg-green-200 transition-colors">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">This Month's</p>
                            <p class="text-lg font-bold text-gray-900">Income</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-3xl font-bold text-green-600">₹{{ number_format($totalIncome, 2) }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $insights['income_change'] >= 0 ? '+'.$insights['income_change'].'%' : ' '.$insights['income_change'].'%' }} from last month</p>
                    </div>
                    <div class="text-right">
                        <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            @if ($insights['income_change'] >= 0)
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" stroke="currentcolor" stroke-width="1.5"></path> <path d="M7 14L9.29289 11.7071C9.68342 11.3166 10.3166 11.3166 10.7071 11.7071L12.2929 13.2929C12.6834 13.6834 13.3166 13.6834 13.7071 13.2929L17 10M17 10V12.5M17 10H14.5" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                                </svg>                                
                            @else
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M7.53033 9.46967C7.23744 9.17678 6.76256 9.17678 6.46967 9.46967C6.17678 9.76256 6.17678 10.2374 6.46967 10.5303L8.76256 12.8232C9.44598 13.5066 10.554 13.5066 11.2374 12.8232L12.8232 11.2374C12.9209 11.1398 13.0791 11.1398 13.1768 11.2374L15.1893 13.25H14.5C14.0858 13.25 13.75 13.5858 13.75 14C13.75 14.4142 14.0858 14.75 14.5 14.75H17C17.4142 14.75 17.75 14.4142 17.75 14V11.5C17.75 11.0858 17.4142 10.75 17 10.75C16.5858 10.75 16.25 11.0858 16.25 11.5V12.1893L14.2374 10.1768C13.554 9.49336 12.446 9.49336 11.7626 10.1768L10.1768 11.7626C10.0791 11.8602 9.92085 11.8602 9.82322 11.7626L7.53033 9.46967Z" fill="currentcolor"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9426 1.25C9.63423 1.24999 7.82519 1.24998 6.41371 1.43975C4.96897 1.63399 3.82895 2.03933 2.93414 2.93414C2.03933 3.82895 1.63399 4.96897 1.43975 6.41371C1.24998 7.82519 1.24999 9.63423 1.25 11.9426V12.0574C1.24999 14.3658 1.24998 16.1748 1.43975 17.5863C1.63399 19.031 2.03933 20.1711 2.93414 21.0659C3.82895 21.9607 4.96897 22.366 6.41371 22.5603C7.82519 22.75 9.63423 22.75 11.9426 22.75H12.0574C14.3658 22.75 16.1748 22.75 17.5863 22.5603C19.031 22.366 20.1711 21.9607 21.0659 21.0659C21.9607 20.1711 22.366 19.031 22.5603 17.5863C22.75 16.1748 22.75 14.3658 22.75 12.0574V11.9426C22.75 9.63423 22.75 7.82519 22.5603 6.41371C22.366 4.96897 21.9607 3.82895 21.0659 2.93414C20.1711 2.03933 19.031 1.63399 17.5863 1.43975C16.1748 1.24998 14.3658 1.24999 12.0574 1.25H11.9426ZM3.9948 3.9948C4.56445 3.42514 5.33517 3.09825 6.61358 2.92637C7.91356 2.75159 9.62178 2.75 12 2.75C14.3782 2.75 16.0864 2.75159 17.3864 2.92637C18.6648 3.09825 19.4355 3.42514 20.0052 3.9948C20.5749 4.56445 20.9018 5.33517 21.0736 6.61358C21.2484 7.91356 21.25 9.62178 21.25 12C21.25 14.3782 21.2484 16.0864 21.0736 17.3864C20.9018 18.6648 20.5749 19.4355 20.0052 20.0052C19.4355 20.5749 18.6648 20.9018 17.3864 21.0736C16.0864 21.2484 14.3782 21.25 12 21.25C9.62178 21.25 7.91356 21.2484 6.61358 21.0736C5.33517 20.9018 4.56445 20.5749 3.9948 20.0052C3.42514 19.4355 3.09825 18.6648 2.92637 17.3864C2.75159 16.0864 2.75 14.3782 2.75 12C2.75 9.62178 2.75159 7.91356 2.92637 6.61358C3.09825 5.33517 3.42514 4.56445 3.9948 3.9948Z" fill="currentcolor"></path> </g>
                                </svg>
                            @endif
                            {{ $insights['income_change'] >= 0 ? ' +'.$insights['income_change'].'%' : ' '.$insights['income_change'].'%' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-2 bg-gradient-to-r from-green-400 to-green-600"></div>
        </div>

        <!-- Expense Card -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-red-100 rounded-xl group-hover:bg-red-200 transition-colors">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">This Month's</p>
                            <p class="text-lg font-bold text-gray-900">Expense</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-3xl font-bold text-red-600">₹{{ number_format($totalExpense, 2) }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $insights['expense_change'] >= 0 ? '+'.$insights['expense_change'].'%' : ' '.$insights['expense_change'].'%' }} from last month</p>
                    </div>
                    <div class="text-right">
                        <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            @if ($insights['expense_change'] >= 0)
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" stroke="currentcolor" stroke-width="1.5"></path> <path d="M7 14L9.29289 11.7071C9.68342 11.3166 10.3166 11.3166 10.7071 11.7071L12.2929 13.2929C12.6834 13.6834 13.3166 13.6834 13.7071 13.2929L17 10M17 10V12.5M17 10H14.5" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                                </svg>                                
                            @else
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" stroke="currentcolor" stroke-width="1.5"></path> <path d="M7 10L9.29289 12.2929C9.68342 12.6834 10.3166 12.6834 10.7071 12.2929L12.2929 10.7071C12.6834 10.3166 13.3166 10.3166 13.7071 10.7071L17 14M17 14V11.5M17 14H14.5" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                                </svg>
                            @endif
                            {{ $insights['expense_change'] >= 0 ? ' +'.$insights['expense_change'].'%' : ' '.$insights['expense_change'].'%' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-2 bg-gradient-to-r from-red-400 to-red-600"></div>
        </div>

        <!-- Net Balance Card -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-blue-100 rounded-xl group-hover:bg-blue-200 transition-colors">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M8.5 9.99984H15.5M8.5 6.5H15.5M14 18.0002L8.5 13.5002L10 13.5C14.4447 13.5 14.4447 6.5 10 6.5M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Net</p>
                            <p class="text-lg font-bold text-gray-900">Balance</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-3xl font-bold {{ $monthlyNetBalance >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                            ₹{{ number_format($monthlyNetBalance, 2) }}
                        </p>
                        <p class="text-sm text-gray-500 mt-1">Current month</p>
                    </div>
                    <div class="text-right">
                        <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $monthlyNetBalance >= 0 ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }}">
                            {{ $monthlyNetBalance >= 0 ? 'Profit' : 'Loss' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-2 bg-gradient-to-r {{ $monthlyNetBalance >= 0 ? 'from-blue-400 to-blue-600' : 'from-red-400 to-red-600' }}"></div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Transactions - Takes 2 columns -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9375 1.25H12.0625C14.1308 1.24998 15.7678 1.24997 17.0485 1.44129C18.3725 1.63907 19.4223 2.05481 20.2395 2.96274C21.0464 3.85936 21.4066 4.99222 21.5798 6.42355C21.75 7.83014 21.75 9.63498 21.75 11.9478V12.0522C21.75 14.365 21.75 16.1699 21.5798 17.5765C21.4066 19.0078 21.0464 20.1406 20.2395 21.0373C19.4223 21.9452 18.3725 22.3609 17.0485 22.5587C15.7678 22.75 14.1308 22.75 12.0625 22.75H11.9375C9.8692 22.75 8.23221 22.75 6.95147 22.5587C5.62747 22.3609 4.57769 21.9452 3.76055 21.0373C2.95359 20.1406 2.59338 19.0078 2.42018 17.5765C2.24998 16.1699 2.24999 14.365 2.25 12.0522V11.9478C2.24999 9.63499 2.24998 7.83014 2.42018 6.42355C2.59338 4.99222 2.95359 3.85936 3.76055 2.96274C4.57769 2.05481 5.62747 1.63907 6.95147 1.44129C8.23221 1.24997 9.86922 1.24998 11.9375 1.25ZM7.17309 2.92483C6.04626 3.09316 5.37637 3.40965 4.87549 3.96619C4.36443 4.53404 4.06563 5.31193 3.90932 6.60374C3.7513 7.90972 3.75 9.62385 3.75 12C3.75 14.3762 3.7513 16.0903 3.90932 17.3963C4.06563 18.6881 4.36443 19.466 4.87549 20.0338C5.37637 20.5903 6.04626 20.9068 7.17309 21.0752C8.33029 21.248 9.8552 21.25 12 21.25C14.1448 21.25 15.6697 21.248 16.8269 21.0752C17.9537 20.9068 18.6236 20.5903 19.1245 20.0338C19.6356 19.466 19.9344 18.6881 20.0907 17.3963C20.2487 16.0903 20.25 14.3762 20.25 12C20.25 9.62385 20.2487 7.90972 20.0907 6.60374C19.9344 5.31193 19.6356 4.53404 19.1245 3.96619C18.6236 3.40965 17.9537 3.09316 16.8269 2.92483C15.6697 2.75196 14.1448 2.75 12 2.75C9.8552 2.75 8.33029 2.75196 7.17309 2.92483ZM8.91612 5.24994C8.9438 5.24997 8.97176 5.25 9 5.25H15C15.0282 5.25 15.0562 5.24997 15.0839 5.24994C15.4647 5.24954 15.7932 5.24919 16.0823 5.32667C16.8588 5.53472 17.4653 6.1412 17.6733 6.91766C17.7508 7.2068 17.7505 7.53533 17.7501 7.91612C17.75 7.9438 17.75 7.97176 17.75 8C17.75 8.02824 17.75 8.0562 17.7501 8.08389C17.7505 8.46468 17.7508 8.7932 17.6733 9.08234C17.4653 9.8588 16.8588 10.4653 16.0823 10.6733C15.7932 10.7508 15.4647 10.7505 15.0839 10.7501C15.0562 10.75 15.0282 10.75 15 10.75H9C8.97176 10.75 8.9438 10.75 8.91612 10.7501C8.53533 10.7505 8.2068 10.7508 7.91766 10.6733C7.1412 10.4653 6.53472 9.8588 6.32667 9.08234C6.24919 8.7932 6.24954 8.46468 6.24994 8.08389C6.24997 8.0562 6.25 8.02824 6.25 8C6.25 7.97176 6.24997 7.9438 6.24994 7.91612C6.24954 7.53533 6.24919 7.2068 6.32667 6.91766C6.53472 6.1412 7.1412 5.53472 7.91766 5.32667C8.2068 5.24919 8.53533 5.24954 8.91612 5.24994ZM9 6.75C8.48673 6.75 8.37722 6.75644 8.30589 6.77556C8.04707 6.84491 7.84491 7.04707 7.77556 7.30589C7.75644 7.37722 7.75 7.48673 7.75 8C7.75 8.51327 7.75644 8.62278 7.77556 8.69412C7.84491 8.95293 8.04707 9.1551 8.30589 9.22445C8.37722 9.24356 8.48673 9.25 9 9.25H15C15.5133 9.25 15.6228 9.24356 15.6941 9.22445C15.9529 9.1551 16.1551 8.95293 16.2244 8.69412C16.2436 8.62278 16.25 8.51327 16.25 8C16.25 7.48673 16.2436 7.37722 16.2244 7.30589C16.1551 7.04707 15.9529 6.84491 15.6941 6.77556C15.6228 6.75644 15.5133 6.75 15 6.75H9Z" fill="currentColor"></path> <path d="M9 13C9 13.5523 8.55229 14 8 14C7.44772 14 7 13.5523 7 13C7 12.4477 7.44772 12 8 12C8.55229 12 9 12.4477 9 13Z" fill="currentColor"></path> <path d="M9 17C9 17.5523 8.55229 18 8 18C7.44772 18 7 17.5523 7 17C7 16.4477 7.44772 16 8 16C8.55229 16 9 16.4477 9 17Z" fill="currentColor"></path> <path d="M13 13C13 13.5523 12.5523 14 12 14C11.4477 14 11 13.5523 11 13C11 12.4477 11.4477 12 12 12C12.5523 12 13 12.4477 13 13Z" fill="currentColor"></path> <path d="M13 17C13 17.5523 12.5523 18 12 18C11.4477 18 11 17.5523 11 17C11 16.4477 11.4477 16 12 16C12.5523 16 13 16.4477 13 17Z" fill="currentColor"></path> <path d="M17 13C17 13.5523 16.5523 14 16 14C15.4477 14 15 13.5523 15 13C15 12.4477 15.4477 12 16 12C16.5523 12 17 12.4477 17 13Z" fill="currentColor"></path> <path d="M17 17C17 17.5523 16.5523 18 16 18C15.4477 18 15 17.5523 15 17C15 16.4477 15.4477 16 16 16C16.5523 16 17 16.4477 17 17Z" fill="currentColor"></path> </g>
                        </svg>

                        Recent Transactions
                    </h3>
                    <a href="{{ route('transactions.index') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        View All
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">#</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">Date</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">Type</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">Method</th>
                                <th class="text-right py-3 px-4 font-semibold text-gray-700 text-sm">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($recentExpenses as $expense)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4 text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                                    <td class="py-4 px-4 text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($expense->date)->format('M d, Y') }}
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $expense->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $expense->type === 'income' ? 'Income' : 'Expense' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            @if ($expense->wallet)
                                                <div class="w-2 h-2 bg-blue-400 rounded-full mr-2"></div>
                                                <span class="text-sm text-gray-600">{{ $expense->wallet->name }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-right">
                                        <span class="text-sm font-semibold {{ $expense->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $expense->type === 'income' ? '+' : '-' }}₹{{ number_format($expense->amount, 2) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-12">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <p class="text-gray-500 font-medium">No recent transactions</p>
                                            <p class="text-gray-400 text-sm">Your transactions will appear here</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Enhanced Wallets Widget -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        My Wallets
                    </h3>
                    <a href="{{ route('wallets.index') }}"
                        class="text-sm text-purple-600 hover:text-purple-800 font-medium flex items-center">
                        Manage
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="p-6 space-y-4">
                @foreach ($wallets as $wallet)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $wallet->name }}</p>
                                <p class="text-sm text-gray-500">{{ $wallet->type ?? 'Savings' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-lg text-gray-900">₹{{ number_format($wallet->balance, 2) }}</p>
                        </div>
                    </div>
                @endforeach

                <div class="mt-6 pt-4 border-t border-gray-200">
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-blue-50 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-blue-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">Total Balance</p>
                                <p class="text-sm text-gray-600">All wallets combined</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">₹{{ number_format($wallets->sum('balance'), 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Categories Chart -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Top Spending Categories
                </h3>
            </div>
            <div class="p-6">
                <canvas id="topCategoriesChart" height="150"></canvas>
            </div>
        </div>

        <!-- Budget Usage Chart -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                    Budget vs Spending
                </h3>
            </div>
            <div class="p-6">
                <canvas id="budgetChart" height="150"></canvas>
            </div>
        </div>
    </div>

    <!-- Monthly Overview Table -->
    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none"  viewBox="0 0 24 24">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M8.4179 3.25077C8.69861 2.65912 9.30146 2.25 9.99986 2.25H13.9999C14.6983 2.25 15.3011 2.65912 15.5818 3.25077C16.2654 3.25574 16.7981 3.28712 17.2737 3.47298C17.8418 3.69505 18.3361 4.07255 18.6998 4.5623C19.0667 5.05639 19.2389 5.68968 19.476 6.56133C19.4882 6.60604 19.5005 6.65137 19.513 6.69735L20.1039 8.86428C20.4914 9.06271 20.8304 9.32993 21.1133 9.6922C21.7353 10.4888 21.8454 11.4377 21.7348 12.5261C21.6274 13.5822 21.2949 14.9122 20.8787 16.577L20.8523 16.6824C20.5891 17.7352 20.3755 18.59 20.1213 19.2572C19.8563 19.9527 19.5199 20.5227 18.9653 20.9558C18.4107 21.3888 17.7761 21.5769 17.0371 21.6653C16.3282 21.75 15.4472 21.75 14.362 21.75H9.63771C8.55255 21.75 7.67147 21.75 6.96266 21.6653C6.22365 21.5769 5.58901 21.3888 5.03439 20.9558C4.47977 20.5227 4.14337 19.9527 3.8784 19.2572C3.62426 18.5901 3.41058 17.7353 3.1474 16.6825L3.121 16.5769C2.70479 14.9121 2.37229 13.5822 2.26492 12.5261C2.15427 11.4377 2.26442 10.4888 2.88642 9.6922C3.16927 9.32993 3.50834 9.06271 3.89582 8.86428L4.48667 6.69735C4.49921 6.65137 4.51154 6.60604 4.5237 6.56134C4.76077 5.68968 4.93302 5.05639 5.29995 4.5623C5.66367 4.07255 6.15788 3.69505 6.72607 3.47298C7.20162 3.28712 7.73436 3.25574 8.4179 3.25077ZM8.41931 4.75219C7.75748 4.75888 7.4919 4.78416 7.2721 4.87007C6.96615 4.98964 6.70003 5.19291 6.50419 5.45662C6.32808 5.69376 6.22474 6.02508 5.93384 7.09195L5.58026 8.38869C6.61806 8.24996 7.95786 8.24998 9.62247 8.25H14.3772C16.0419 8.24998 17.3817 8.24996 18.4195 8.38869L18.0659 7.09194C17.775 6.02508 17.6716 5.69377 17.4955 5.45663C17.2997 5.19291 17.0336 4.98964 16.7276 4.87007C16.5078 4.78416 16.2422 4.75888 15.5804 4.75219C15.2991 5.34225 14.6971 5.75 13.9999 5.75H9.99986C9.30262 5.75 8.70062 5.34225 8.41931 4.75219ZM9.99986 3.75C9.86179 3.75 9.74986 3.86193 9.74986 4C9.74986 4.13807 9.86179 4.25 9.99986 4.25H13.9999C14.1379 4.25 14.2499 4.13807 14.2499 4C14.2499 3.86193 14.1379 3.75 13.9999 3.75H9.99986ZM5.69971 9.88649C4.78854 10.0183 4.34756 10.2582 4.06873 10.6153C3.78989 10.9725 3.66411 11.4584 3.75723 12.3744C3.85233 13.3099 4.15656 14.5345 4.59127 16.2733C4.86853 17.3824 5.06163 18.1496 5.28013 18.7231C5.49144 19.2778 5.69835 19.5711 5.95751 19.7735C6.21667 19.9758 6.5514 20.1054 7.14076 20.1759C7.75015 20.2488 8.54133 20.25 9.68452 20.25H14.3152C15.4584 20.25 16.2496 20.2488 16.859 20.1759C17.4483 20.1054 17.783 19.9758 18.0422 19.7735C18.3014 19.5711 18.5083 19.2778 18.7196 18.7231C18.9381 18.1496 19.1312 17.3824 19.4084 16.2733C19.8432 14.5345 20.1474 13.3099 20.2425 12.3744C20.3356 11.4584 20.2098 10.9725 19.931 10.6153C19.6522 10.2582 19.2112 10.0183 18.3 9.88649C17.3694 9.75187 16.1075 9.75 14.3152 9.75H9.68452C7.89217 9.75 6.63034 9.75187 5.69971 9.88649Z" fill="currentColor"></path> </g>
                </svg>
                Monthly Financial Summary
            </h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">#</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">Month</th>
                            <th class="text-right py-3 px-4 font-semibold text-gray-700 text-sm">Income</th>
                            <th class="text-right py-3 px-4 font-semibold text-gray-700 text-sm">Expense</th>
                            <th class="text-right py-3 px-4 font-semibold text-gray-700 text-sm">Net</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($monthlyData as $month)
                            @php
                                $netAmount = $month->total_income - $month->total_expense;
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-4 text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                                <td class="py-4 px-4 text-sm font-medium text-gray-900">
                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $month->month)->format('F Y') }}
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <span class="text-sm font-semibold text-green-600">
                                        +₹{{ number_format($month->total_income, 2) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <span class="text-sm font-semibold text-red-600">
                                        -₹{{ number_format($month->total_expense, 2) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <span class="text-sm font-bold {{ $netAmount >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $netAmount >= 0 ? '+' : '' }}₹{{ number_format($netAmount, 2) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-12">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        <p class="text-gray-500 font-medium">No monthly data available</p>
                                        <p class="text-gray-400 text-sm">Start adding transactions to see your monthly summary</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Enhanced Chart Section -->
    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Income vs Expense Trends
                </h3>
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Period:</label>
                    <select id="dateRangeSelector"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white shadow-sm">
                        <option value="today">Today</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="7d" selected>Last 7 Days</option>
                        <option value="30d">Last 30 Days</option>
                        <option value="3m">Last 3 Months</option>
                        <option value="6m">Last 6 Months</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="relative">
                <canvas id="incomeExpenseChart" height="100"></canvas>
            </div>
        </div>
    </div>

</div>


@if (session('just_registered'))
    <script>
        window.dataLayer = window.dataLayer || [];
        dataLayer.push({
            event: 'expense_register_success',
            method: '{{ session('registration_method', 'email') }}'
        });
    </script>

    {{-- Clear the session so it only fires once --}}
    @php
        session()->forget('just_registered');
        session()->forget('registration_method');
    @endphp
@endif

<script>
    // Dynamic greeting and date
    function updateGreetingAndDate() {
        const now = new Date();
        const hour = now.getHours();
        let greeting;
        
        if (hour < 12) greeting = 'Morning';
        else if (hour < 17) greeting = 'Afternoon';
        else greeting = 'Evening';
        
        document.getElementById('greeting').textContent = greeting;
        
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };
        document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', options);
    }
    
    updateGreetingAndDate();

    let incomeExpenseChart;

    async function loadChart(range = '7d') {
        try {
            const response = await fetch(`{{ route('chart.data') }}?range=${range}`);
            const res = await response.json();

            const ctx = document.getElementById('incomeExpenseChart').getContext('2d');

            if (incomeExpenseChart) {
                incomeExpenseChart.destroy();
            }

            incomeExpenseChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: res.labels,
                    datasets: [{
                            label: 'Income',
                            data: res.income,
                            backgroundColor: 'rgba(34,197,94,0.1)',
                            borderColor: 'rgba(34,197,94,1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(34,197,94,1)',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        },
                        {
                            label: 'Expense',
                            data: res.expense,
                            backgroundColor: 'rgba(239,68,68,0.1)',
                            borderColor: 'rgba(239,68,68,1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(239,68,68,1)',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: {
                                    size: 12,
                                    weight: '500'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.95)',
                            titleColor: '#374151',
                            bodyColor: '#374151',
                            borderColor: '#e5e7eb',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ₹' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            border: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f3f4f6'
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                callback: value => '₹' + value.toLocaleString()
                            }
                        }
                    }
                }
            });
        } catch (error) {
            console.error('Error loading chart data:', error);
        }
    }

    document.getElementById('dateRangeSelector').addEventListener('change', function() {
        loadChart(this.value);
    });

    window.addEventListener('load', () => {
        loadChart();
    });

    // Enhanced Top Categories Chart
    const topCategoriesCTX = document.getElementById('topCategoriesChart').getContext('2d');
    new Chart(topCategoriesCTX, {
        type: 'bar',
        data: {
            labels: @json($topCategories->pluck('name')),
            datasets: [{
                label: 'Total Amount',
                data: @json($topCategories->pluck('total_amount')),
                backgroundColor: [
                    'rgba(59,130,246,0.8)',
                    'rgba(16,185,129,0.8)',
                    'rgba(245,158,11,0.8)',
                    'rgba(239,68,68,0.8)',
                    'rgba(139,92,246,0.8)'
                ],
                borderColor: [
                    'rgba(59,130,246,1)',
                    'rgba(16,185,129,1)',
                    'rgba(245,158,11,1)',
                    'rgba(239,68,68,1)',
                    'rgba(139,92,246,1)'
                ],
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#374151',
                    bodyColor: '#374151',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return 'Spent: ₹' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    border: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6'
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        callback: function(value) {
                            return '₹' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Enhanced Budget Chart
    const budgetChartCTX = document.getElementById('budgetChart').getContext('2d');
    const budgetData = @json($budgetData);

    const labels = budgetData.map(item => item.category);
    const allocated = budgetData.map(item => item.allocated);
    const spent = budgetData.map(item => item.spent);

    const budgetChart = new Chart(budgetChartCTX, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                    label: 'Budget Allocated',
                    data: allocated,
                    backgroundColor: 'rgba(34, 197, 94, 0.7)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false
                },
                {
                    label: 'Amount Spent',
                    data: spent,
                    backgroundColor: 'rgba(239, 68, 68, 0.7)',
                    borderColor: 'rgba(239, 68, 68, 1)',
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 12,
                            weight: '500'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#374151',
                    bodyColor: '#374151',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ₹${context.parsed.y.toFixed(2)}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    border: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6'
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        callback: function(value) {
                            return '₹' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>