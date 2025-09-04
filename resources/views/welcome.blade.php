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
    @include('layouts.header')

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
    @include('layouts.footer')

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