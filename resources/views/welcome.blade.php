<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | expenses</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-l from-blue-200 via-blue-200 to-blue-300">

    <nav
        class="flex items-center justify-between p-4 bg-white bg-opacity-70 backdrop-blur-md shadow-md sticky top-0 z-50">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <img src="{{ asset('assets/logo.png') }}" alt="expenses Logo" class="w-10 h-10">
            <div class="text-3xl font-bold text-blue-500">expenses</div>
        </div>

        <!-- Mobile Menu Button -->
        <button id="menu-btn" class="md:hidden focus:outline-none">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>

        <!-- Desktop Menu -->
        <ul class="hidden md:flex space-x-6 text-gray-600">
            <li><a href="#" class="hover:text-blue-500">Home</a></li>
            <li><a href="#about" class="hover:text-blue-500">About</a></li>
            <li><a href="#features" class="hover:text-blue-500">Features</a></li>
            <li><a href="#team" class="hover:text-blue-500">Team</a></li>
        </ul>

        <a href="{{ route('login') }}"
            class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 hidden md:block">
            Get Started
        </a>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="absolute top-16 left-0 w-full bg-white shadow-md hidden md:hidden">
            <ul class="flex flex-col items-center py-4 space-y-4 text-gray-600">
                <li><a href="#" class="hover:text-blue-500">Home</a></li>
                <li><a href="#about" class="hover:text-blue-500">About</a></li>
                <li><a href="#features" class="hover:text-blue-500">Features</a></li>
                <li><a href="#team" class="hover:text-blue-500">Team</a></li>
                <li>
                    <a href="{{ route('login') }}"
                        class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                        Get Started
                    </a>
                </li>
            </ul>
        </div>
    </nav>


    <!-- Hero Section -->
    <section
        class="flex flex-col-reverse md:flex-row items-center justify-between px-6 md:px-10 py-16 space-y-6 md:space-y-0">
        <!-- Left Content -->
        <div class="md:w-1/2 space-y-6 text-justify md:text-left lg:ml-11">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight">
                Smart Transport, <span class="text-blue-500">Seamless Attendance.</span>
            </h1>
            <p class="text-gray-700 text-base md:text-lg leading-relaxed">
                expenses revolutionizes college transportation with <span class="font-semibold">barcode-based attendance
                    tracking</span>,
                <span class="font-semibold">real-time bus tracking</span>, and <span class="font-semibold">automated
                    notifications</span>.
                Ensure student safety, improve efficiency, and access detailed reports - all in one system.
            </p>
            <button onclick="document.getElementById('about').scrollIntoView({ behavior: 'smooth' });"
                class="bg-blue-500 text-white px-8 py-3 rounded-full shadow-lg hover:bg-blue-600 transition duration-300">
                Explore expenses
            </button>
        </div>

        <!-- Right Image -->
        <div class="md:w-1/2 flex justify-center">
            <img src="{{ asset('assets/landing.svg') }}" alt="Transport Illustration"
                class="w-full max-w-xs md:max-w-md transform hover:scale-105 transition duration-300">
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 px-6 md:px-20">
        <div class="max-w-8xl mx-auto flex flex-col md:flex-row items-center gap-20">

            <!-- Left Side (Intro & Detailed Description) -->
            <div class="md:w-1/2 text-justify">
                <h2 class="text-4xl font-bold text-gray-900 leading-tight mb-6">
                    About
                </h2>
                <p class="text-gray-700 text-lg leading-relaxed mb-4">
                    The <span class="font-semibold text-blue-500">Automated Transport Management System (expenses)</span>
                    is a <strong>modern and efficient</strong> solution
                    designed to <strong>optimize transportation for educational institutions</strong>.
                    Our system <strong>automates attendance tracking, monitors vehicles in real-time, and enhances
                        safety</strong>
                    for students and staff.
                </p>
                <p class="text-gray-700 text-lg leading-relaxed mb-4">
                    <strong>Say goodbye to manual logs and inefficiencies!</strong> expenses ensures a <strong>smooth and
                        reliable</strong> transport
                    experience with <strong>instant notifications, automated reports, and a user-friendly
                        interface</strong>.
                    Faculty and parents can now stay <strong>updated about bus locations and student safety at all
                        times</strong>.
                </p>
                <p class="text-gray-700 text-lg leading-relaxed">
                    Built with <strong>cutting-edge technology</strong>, expenses is <strong>secure, scalable, and easy to
                        integrate</strong> into
                    any institution's transport system.
                </p>
            </div>

            <!-- Right Side (Key Features) -->
            <div class="md:w-1/2">
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">🌟 Why Choose expenses?</h3>
                <ul class="space-y-4 text-gray-700 text-lg">
                    <li class="flex items-center">
                        <span class="text-orange-500 text-2xl mr-3">🚍</span>
                        <span><span class="font-semibold">Live GPS Tracking:</span> Track buses in real-time for
                            improved safety.</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-orange-500 text-2xl mr-3">📢</span>
                        <span><span class="font-semibold">Instant Alerts:</span> Get notified about bus arrivals, and
                            attendance.</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-orange-500 text-2xl mr-3">🎫</span>
                        <span><span class="font-semibold">Automated Attendance:</span> Secure check-in & check-out with
                            barcode scanning.</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-orange-500 text-2xl mr-3">📊</span>
                        <span><span class="font-semibold">Reports:</span> Generate attendance reports
                            effortlessly.</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-orange-500 text-2xl mr-3">⚡</span>
                        <span><span class="font-semibold">User-Friendly Interface:</span> Simple, easy-to-use for all
                            users.</span>
                    </li>
                </ul>
            </div>

        </div>
    </section>

    <section id="features">
        <div class="max-w-4xl mx-auto py-16 px-6">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-12">Modules</h2>

            <div class="relative">
                <!-- Vertical Line -->
                <div class="absolute left-1/2 transform -translate-x-1/2 w-1 bg-blue-500 h-full hidden md:block">
                </div>

                <!-- Timeline Items -->
                <div class="space-y-10">

                    <!-- Timeline Card 1 -->
                    <div class="flex flex-col md:flex-row items-center md:items-start">
                        <div class="md:w-1/2 text-left md:pr-8">
                            <div
                                class="bg-white md:border-l-4 border-blue-500 shadow-lg rounded-xl p-6 w-full md:max-w-md transform transition duration-300 hover:shadow-xl hover:-translate-y-1">
                                <div class="flex items-center space-x-3">
                                    <h3 class="text-xl md:text-2xl font-semibold text-gray-900">User Management</h3>
                                </div>
                                <p class="text-sm md:text-base text-gray-600 mt-4 leading-relaxed">
                                    Manage roles and authentication for <span
                                        class="font-semibold text-gray-900">Admins, Faculty, Drivers, Students, and
                                        Parents</span>.
                                </p>
                            </div>
                        </div>
                        <div
                            class="w-10 h-10 bg-blue-500 text-white font-bold flex items-center justify-center rounded-full border-4 border-white absolute left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            1</div>
                    </div>

                    <!-- Timeline Card 2 -->
                    <div class="flex flex-col md:flex-row-reverse items-center md:items-start">
                        <div class="md:w-1/2 text-left md:pl-8">
                            <div
                                class="bg-white md:border-l-4 border-blue-500 shadow-lg rounded-xl p-6 w-full md:max-w-md transform transition duration-300 hover:shadow-xl hover:-translate-y-1">
                                <div class="flex items-center space-x-3">
                                    <h3 class="text-xl md:text-2xl font-semibold text-gray-900">Academic Management
                                    </h3>
                                </div>
                                <p class="text-sm md:text-base text-gray-600 mt-4 leading-relaxed">
                                    Seamless integration of academic schedules with transport operations.
                                </p>
                            </div>
                        </div>
                        <div
                            class="w-10 h-10 bg-blue-500 text-white font-bold flex items-center justify-center rounded-full border-4 border-white absolute left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            2</div>
                    </div>

                    <!-- Timeline Card 3 -->
                    <div class="flex flex-col md:flex-row items-center md:items-start">
                        <div class="md:w-1/2 text-left md:pr-8">
                            <div
                                class="bg-white md:border-l-4 border-blue-500 shadow-lg rounded-xl p-6 w-full md:max-w-md transform transition duration-300 hover:shadow-xl hover:-translate-y-1">
                                <h3 class="text-xl md:text-2xl font-semibold text-gray-900">Transport Management</h3>
                                <p class="text-sm md:text-base text-gray-600 mt-4 leading-relaxed">
                                    Assign buses, manage routes, and optimize schedules efficiently.
                                </p>
                            </div>
                        </div>
                        <div
                            class="w-10 h-10 bg-blue-500 text-white font-bold flex items-center justify-center rounded-full border-4 border-white absolute left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            3</div>
                    </div>

                    <!-- Timeline Card 4 -->
                    <div class="flex flex-col md:flex-row-reverse items-center md:items-start">
                        <div class="md:w-1/2 text-left md:pl-8">
                            <div
                                class="bg-white md:border-l-4 border-blue-500 shadow-lg rounded-xl p-6 w-full md:max-w-md transform transition duration-300 hover:shadow-xl hover:-translate-y-1">
                                <h3 class="text-xl md:text-2xl font-semibold text-gray-900">Attendance Management</h3>
                                <p class="text-sm md:text-base text-gray-600 mt-4 leading-relaxed">
                                    Automate attendance tracking using <span
                                        class="font-semibold text-gray-900">barcode
                                        scanning</span> and real-time reports.
                                </p>
                            </div>
                        </div>
                        <div
                            class="w-10 h-10 bg-blue-500 text-white font-bold flex items-center justify-center rounded-full border-4 border-white absolute left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            4</div>
                    </div>

                    <!-- Timeline Card 5 -->
                    <div class="flex flex-col md:flex-row items-center md:items-start">
                        <div class="md:w-1/2 text-left md:pr-8">
                            <div
                                class="bg-white md:border-l-4 border-blue-500 shadow-lg rounded-xl p-6 w-full md:max-w-md transform transition duration-300 hover:shadow-xl hover:-translate-y-1">
                                <h3 class="text-xl md:text-2xl font-semibold text-gray-900">Live Vehicle Tracking</h3>
                                <p class="text-sm md:text-base text-gray-600 mt-4 leading-relaxed">
                                    Track bus locations in <span class="font-semibold text-gray-900">real-time</span>,
                                    ensuring safety and instant updates.
                                </p>
                            </div>
                        </div>
                        <div
                            class="w-10 h-10 bg-blue-500 text-white font-bold flex items-center justify-center rounded-full border-4 border-white absolute left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            5</div>
                    </div>

                    <!-- Timeline Card 6 -->
                    <div class="flex flex-col md:flex-row-reverse items-center md:items-start">
                        <div class="md:w-1/2 text-left md:pl-8">
                            <div
                                class="bg-white md:border-l-4 border-blue-500 shadow-lg rounded-xl p-6 w-full md:max-w-md transform transition duration-300 hover:shadow-xl hover:-translate-y-1">
                                <h3 class="text-xl md:text-2xl font-semibold text-gray-900">Reports & Analytics</h3>
                                <p class="text-sm md:text-base text-gray-600 mt-4 leading-relaxed">
                                    Generate <span class="font-semibold text-gray-900">detailed reports</span> on
                                    transport efficiency, attendance, and vehicle usage.
                                </p>
                            </div>
                        </div>
                        <div
                            class="w-10 h-10 bg-blue-500 text-white font-bold flex items-center justify-center rounded-full border-4 border-white absolute left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            6</div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section id="team" class="py-16 px-6 md:px-20">
        <div class="max-w-6xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-8">Our <span
                    class="text-blue-500">Team</span></h2>
            <p class="text-gray-700 text-base md:text-lg leading-relaxed max-w-3xl mx-auto mb-12">
                Our team is dedicated to revolutionizing <strong>Automated Transport Management System (expenses)</strong>
                with innovation and efficiency.
            </p>

            <!-- Team Members Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">

                <!-- Team Member 1 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-2xl font-semibold text-gray-900">ABINAYASRI B</h3>
                    <p class="text-blue-500 font-medium">730421104001</p>
                    <p class="text-gray-700 text-sm mt-3">
                        Student, Department of Computer Science & Engineering.
                    </p>
                </div>

                <!-- Team Member 2 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-2xl font-semibold text-gray-900">JAYA PRAKASH M</h3>
                    <p class="text-blue-500 font-medium">730421104032</p>
                    <p class="text-gray-700 text-sm mt-3">
                        Student, Department of Computer Science & Engineering.
                    </p>
                </div>

                <!-- Team Member 3 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-2xl font-semibold text-gray-900">KANNAN M</h3>
                    <p class="text-blue-500 font-medium">730421104034</p>
                    <p class="text-gray-700 text-sm mt-3">
                        Student, Department of Computer Science & Engineering.
                    </p>
                </div>

            </div>

            <!-- Guide Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-10 mt-12">
                <div class="flex flex-col justify-center items-center h-full">
                    <div
                        class="bg-white p-6 rounded-lg shadow-md w-full max-w-3xl h-full flex flex-col justify-center">
                        <h3 class="text-2xl font-semibold text-gray-900">Guided By</h3>
                        <p class="text-blue-500 font-medium">Dr. SIVAKUMAR G</p>
                        <p class="text-gray-700 text-sm mt-3">
                            Professor, Department of Computer Science & Engineering, providing expert guidance and
                            support.
                        </p>
                    </div>
                </div>
                <div class="flex flex-col justify-center items-center h-full">
                    <div
                        class="bg-white p-6 rounded-lg shadow-md w-full max-w-3xl h-full flex flex-col justify-center">
                        <h3 class="text-2xl font-semibold text-gray-900">Coordinated By</h3>
                        <p class="text-blue-500 font-medium">KALAISELVI T</p>
                        <p class="text-gray-700 text-sm mt-3">
                            Associate Professor, Department of Computer Science & Engineering.
                        </p>
                    </div>
                </div>
            </div>


        </div>
    </section>

    <footer class="bg-blue-500 text-white py-6 text-center">
        <p>&copy; 2025 expenses. All rights reserved.</p>
    </footer>

    <!-- JavaScript for Mobile Menu Toggle -->
    <script>
        document.getElementById('menu-btn').addEventListener('click', function() {
            let mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>

</body>

</html>
