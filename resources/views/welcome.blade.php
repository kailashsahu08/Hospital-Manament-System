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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Animated Background Pattern */
        .hero-pattern {
            background-color: #ffffff;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            animation: patternMove 20s linear infinite;
        }

        @keyframes patternMove {
            0% { background-position: 0 0; }
            100% { background-position: 100px 100px; }
        }

        /* Swiper Styles with Animation */
        .swiper {
            width: 100%;
            height: 50vh;
            min-height: 400px;
        }

        .swiper-slide {
            text-align: center;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: transform 0.3s ease;
        }

        .swiper-slide:hover {
            transform: scale(1.02);
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .swiper-slide:hover img {
            transform: scale(1.05);
        }

        /* Animated Gradient Background */
        .animated-gradient {
            background: linear-gradient(-45deg, #22c55e, #15803d, #166534, #14532d);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Feature Card Animations */
        .feature-card {
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* Testimonial Card Animations */
        .testimonial-card {
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        /* Button Hover Animation */
        .animated-button {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .animated-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .animated-button::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }

        .animated-button:hover::after {
            width: 300px;
            height: 300px;
        }

        /* Floating Animation for Icons */
        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        /* Fade In Animation */
        .fade-in {
            opacity: 0;
            animation: fadeIn 1s ease forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .swiper {
                height: 60vh;
                min-height: 350px;
            }
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
                    <a href="/about" class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium">About</a>
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
                <a href="#" class="text-gray-700 hover:text-green-600 block px-3 py-2 text-base font-medium">Home</a>
                <a href="#" class="text-gray-700 hover:text-green-600 block px-3 py-2 text-base font-medium">About</a>
                <a href="#" class="text-gray-700 hover:text-green-600 block px-3 py-2 text-base font-medium">Contact</a>
                <a href="/login" class="bg-green-600 hover:bg-green-700 text-white block px-3 py-2 rounded-md text-base font-medium mt-1">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Carousel -->
    <div class="relative">
        <div class="swiper hero-swiper">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide">
                    <div class="relative w-full h-full">
                        <img src="https://images.unsplash.com/photo-1587351021759-3e566b6af7cc?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" alt="Modern Hospital" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-green-900/90 to-green-800/75"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center text-white px-4">
                                <h1 class="text-2xl md:text-3xl lg:text-4xl tracking-tight font-extrabold">
                                    <span class="block xl:inline">Professional</span>
                                    <span class="block text-green-300 xl:inline">Hospital Management</span>
                                </h1>
                                <p class="mt-2 text-sm md:text-base lg:text-lg max-w-md mx-auto">
                                    Experience seamless healthcare operations with our state-of-the-art management system
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Slide 2 -->
                <div class="swiper-slide">
                    <div class="relative w-full h-full">
                        <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" alt="Medical Technology" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-green-900/90 to-green-800/75"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center text-white px-4">
                                <h1 class="text-2xl md:text-3xl lg:text-4xl tracking-tight font-extrabold">
                                    <span class="block xl:inline">Advanced</span>
                                    <span class="block text-green-300 xl:inline">Medical Technology</span>
                                </h1>
                                <p class="mt-2 text-sm md:text-base lg:text-lg max-w-md mx-auto">
                                    Cutting-edge solutions for modern healthcare facilities
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Slide 3 -->
                <div class="swiper-slide">
                    <div class="relative w-full h-full">
                        <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" alt="Patient Care" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-green-900/90 to-green-800/75"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center text-white px-4">
                                <h1 class="text-2xl md:text-3xl lg:text-4xl tracking-tight font-extrabold">
                                    <span class="block xl:inline">Exceptional</span>
                                    <span class="block text-green-300 xl:inline">Patient Care</span>
                                </h1>
                                <p class="mt-2 text-sm md:text-base lg:text-lg max-w-md mx-auto">
                                    Enhancing patient experience through innovative healthcare solutions
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center fade-in">
                <h2 class="text-base text-green-600 font-semibold tracking-wide uppercase">Features</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Advanced Healthcare Management Tools
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Comprehensive tools designed specifically for healthcare facilities to enhance service quality and operational efficiency.
                </p>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="relative feature-card bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-all duration-300">
                        <div class="flex flex-col items-center text-center">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-green-500 text-white floating mb-4">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Appointment Management</h3>
                            <p class="text-base text-gray-500">
                                Efficiently manage patient appointments, scheduling, and follow-ups with our intuitive system.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="relative feature-card bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-all duration-300">
                        <div class="flex flex-col items-center text-center">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-green-500 text-white floating mb-4">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Billing & Insurance</h3>
                            <p class="text-base text-gray-500">
                                Streamline billing processes, insurance claims, and payment tracking with our secure platform.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="relative feature-card bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-all duration-300">
                        <div class="flex flex-col items-center text-center">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-green-500 text-white floating mb-4">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Pharmacy Management</h3>
                            <p class="text-base text-gray-500">
                                Track and manage medical inventory with real-time updates and automated reordering.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonial Section -->
    <div class="bg-green-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-12 fade-in">
                <h2 class="text-base text-green-600 font-semibold tracking-wide uppercase">Testimonials</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Trusted by Healthcare Professionals
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="testimonial-card bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                            <span class="text-green-800 font-bold text-xl">M</span>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-bold">Michael Johnson</h4>
                            <p class="text-gray-600">hospital Manager</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"This system has revolutionized how we manage our operations. The efficiency gains have been remarkable."</p>
                </div>

                <!-- Testimonial 2 -->
                <div class="testimonial-card bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                            <span class="text-green-800 font-bold text-xl">S</span>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-bold">Sarah Williams</h4>
                            <p class="text-gray-600">General Manager</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"The Patient management features have helped us improve our service quality and increase our repeat business."</p>
                </div>

                <!-- Testimonial 3 -->
                <div class="testimonial-card bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                            <span class="text-green-800 font-bold text-xl">R</span>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-bold">Robert Chen</h4>
                            <p class="text-gray-600">Operations Director</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"The reporting tools provide invaluable insights that have helped us optimize our revenue strategy."</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="animated-gradient">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl fade-in">
                <span class="block">Ready to transform your healthcare facility?</span>
                <span class="block text-green-200">Start your free trial today.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="#" class="animated-button inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-green-600 bg-white hover:bg-green-50">
                        Get started
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="#" class="animated-button inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-800 hover:bg-green-900">
                        Learn more
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-1">
                    <h3 class="text-lg font-semibold mb-4">Hospital Management System</h3>
                    <p class="text-gray-300 text-sm">
                        Providing cutting-edge solutions for the hospitality industry since 2023.
                    </p>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-span-1">
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm">Home</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm">About Us</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm">Services</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm">Contact</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm">Blog</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="col-span-1">
                    <h3 class="text-lg font-semibold mb-4">Our Services</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm">Room Management</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm">Reservation System</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm">Billing & Invoicing</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm">Inventory Control</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm">Staff Management</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-span-1">
                    <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-gray-400 mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>123 hospital Street, City, Country</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-gray-400 mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>+1 (123) 456-7890</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-gray-400 mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>contact@hospitalmanagement.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 border-t border-gray-700 pt-8">
                <p class="text-center text-gray-400 text-sm">
                    &copy; 2025 hospital Management System. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Initialize Swiper
        const swiper = new Swiper('.hero-swiper', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            }
        });

        // Mobile menu script
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Add fade-in animation to elements when they come into view
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.feature-card, .testimonial-card').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>

</html>