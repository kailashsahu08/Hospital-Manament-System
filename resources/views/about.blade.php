<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Hospital Management System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-yKBrpVUlC19bnIn0Fik3n2A0F+LO1pZksBbAHUgbsO5L8+B1Cxu8BWRV47rCtROxEfqWZylhEc1tWZiVYM5SYg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .hero-pattern {
            background-color: #ffffff;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>

<body class="antialiased bg-gray-50">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo/App Name -->
                    <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-15 w-auto">
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-8">
                    <a href="/" class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium">Home</a>
                    <a href="/about" class="text-green-600 px-3 py-2 text-sm font-medium">About</a>
                    <a href="/contact" class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium">Contact</a>
                    @auth
                        <a href="{{ route('filament.admin.pages.dashboard') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">Dashboard</a>
                    @else
                        <a href="/admin/login" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">Login</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center sm:hidden">
                    <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden sm:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/" class="text-gray-700 hover:text-green-600 block px-3 py-2 text-base font-medium">Home</a>
                <a href="/about" class="text-green-600 block px-3 py-2 text-base font-medium">About</a>
                <a href="/contact" class="text-gray-700 hover:text-green-600 block px-3 py-2 text-base font-medium">Contact</a>
                <a href="/login" class="bg-green-600 hover:bg-green-700 text-white block px-3 py-2 rounded-md text-base font-medium mt-1">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1587351021759-3e566b6af7cc?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" alt="Modern Hospital Building">
            <div class="absolute inset-0 bg-gradient-to-r from-green-900/90 to-green-800/75"></div>
        </div>

        <!-- Content -->
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32">
            <div class="text-center">
                <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                    <span class="block xl:inline">About Our</span>
                    <span class="block text-green-300 xl:inline"> Hospital</span>
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-gray-200 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Providing Excellence in Healthcare Since 1990
                </p>
                <div class="mt-8 flex justify-center">
                    <div class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                        <i class="fas fa-phone-alt mr-2"></i>
                        Emergency: (555) 123-4567
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Mission Section -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-12">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-extrabold text-gray-900">Our Mission</h2>
                    <p class="mt-4 text-lg text-gray-500">Committed to excellence in healthcare delivery</p>
                </div>
                <p class="text-gray-600 leading-relaxed text-center max-w-3xl mx-auto">
                    We are committed to providing exceptional healthcare services with compassion and innovation. 
                    Our mission is to improve the health and well-being of our community through accessible, 
                    high-quality medical care and cutting-edge technology.
                </p>
            </div>

            <!-- Values Section -->
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900">Our Core Values</h2>
                <p class="mt-4 text-lg text-gray-500">The principles that guide our healthcare delivery</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white rounded-lg shadow-lg p-8 transform hover:scale-105 transition-transform duration-300">
                    <div class="text-green-600 text-4xl mb-4">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Compassion</h3>
                    <p class="text-gray-600">
                        We treat every patient with empathy and understanding, ensuring their comfort and well-being.
                        Our healthcare professionals are dedicated to providing personalized care with a human touch.
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-8 transform hover:scale-105 transition-transform duration-300">
                    <div class="text-green-600 text-4xl mb-4">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Excellence</h3>
                    <p class="text-gray-600">
                        We maintain the highest standards of medical care and professional service.
                        Our commitment to excellence drives us to continuously improve and innovate.
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-8 transform hover:scale-105 transition-transform duration-300">
                    <div class="text-green-600 text-4xl mb-4">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Community</h3>
                    <p class="text-gray-600">
                        We actively engage with and support our local community's health needs.
                        Our hospital serves as a healthcare hub for the entire community.
                    </p>
                </div>
            </div>

            <!-- Team Section -->
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900">Our Leadership Team</h2>
                <p class="mt-4 text-lg text-gray-500">Meet the experts leading our healthcare institution</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-lg p-8 text-center transform hover:scale-105 transition-transform duration-300">
                    <div class="w-32 h-32 mx-auto rounded-full bg-gray-200 mb-4 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" alt="Dr. Sarah Johnson" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Dr. Sarah Johnson</h3>
                    <p class="text-green-600 font-medium">Chief Medical Officer</p>
                    <p class="mt-2 text-gray-600">20+ years of experience in healthcare management</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-8 text-center transform hover:scale-105 transition-transform duration-300">
                    <div class="w-32 h-32 mx-auto rounded-full bg-gray-200 mb-4 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" alt="Dr. Michael Chen" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Dr. Michael Chen</h3>
                    <p class="text-green-600 font-medium">Head of Surgery</p>
                    <p class="mt-2 text-gray-600">Specialized in advanced surgical procedures</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-8 text-center transform hover:scale-105 transition-transform duration-300">
                    <div class="w-32 h-32 mx-auto rounded-full bg-gray-200 mb-4 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1594824476967-48c8b964273f?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" alt="Dr. Emily Rodriguez" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Dr. Emily Rodriguez</h3>
                    <p class="text-green-600 font-medium">Director of Patient Care</p>
                    <p class="mt-2 text-gray-600">Expert in patient care and healthcare quality</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p>&copy; 2024 Hospital Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Mobile menu script -->
    <script>
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html> 