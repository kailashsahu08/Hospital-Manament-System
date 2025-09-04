<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Doctors - Hospital Management System</title>
    @vite('resources/css/app.css')

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Heroicons -->
    <script src="https://cdn.jsdelivr.net/npm/heroicons@2.0.18/24/outline/index.js"></script>

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .glass-card {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow:
                0 4px 32px rgba(16, 185, 129, 0.1),
                0 2px 16px rgba(0, 0, 0, 0.05);
        }

        .glass-card:hover {
            transform: translateY(-8px);
            box-shadow:
                0 20px 64px rgba(16, 185, 129, 0.15),
                0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .avatar-ring {
            background: conic-gradient(from 0deg, #10b981, #059669, #047857, #10b981);
            animation: rotate 3s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .status-online {
            background: linear-gradient(135deg, #10b981, #059669);
            animation: pulse-green 2s ease-in-out infinite alternate;
        }

        @keyframes pulse-green {
            from {
                opacity: 1;
                transform: scale(1);
            }

            to {
                opacity: 0.8;
                transform: scale(1.1);
            }
        }

        .specialty-badge {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .metric-card {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-left: 4px solid #10b981;
        }

        .btn-primary {
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }

        .contact-item {
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            background: rgba(16, 185, 129, 0.05);
            border-radius: 8px;
            transform: translateX(4px);
        }

        .floating-elements::before {
            content: '';
            position: absolute;
            top: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.1), transparent);
            border-radius: 50%;
            z-index: 0;
        }

        .floating-elements::after {
            content: '';
            position: absolute;
            bottom: 20px;
            left: 20px;
            width: 40px;
            height: 40px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.08), transparent);
            border-radius: 50%;
            z-index: 0;
        }

        @media (max-width: 768px) {
            .doctor-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .doctor-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 2rem;
            }
        }

        @media (min-width: 1025px) {
            .doctor-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 2.5rem;
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-50 via-green-50 to-slate-100 min-h-screen">

    @include('layouts.header')

    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 "></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                    Meet Our
                    <span class="bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                        Expert Doctors
                    </span>
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    World-class healthcare professionals committed to providing exceptional medical care with compassion and expertise.
                </p>
            </div>
        </div>
    </div>

    <!-- Doctors Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="doctor-grid grid">
            @forelse ($doctors as $doctor)
            <div class="glass-card floating-elements relative rounded-2xl p-6 sm:p-10 transition-all duration-500 group">

                <!-- Status Indicator -->
                <div class="absolute top-4 right-4 z-10">
                    @if($doctor->is_verified)
                    <div class="status-online w-3 h-3 rounded-full border-2 border-white shadow-lg"></div>
                    @else
                    <div class="w-3 h-3 rounded-full bg-gray-400 border-2 border-white"></div>
                    @endif
                </div>

                <!-- Avatar Section -->
                <div class="relative flex flex-col items-center mb-6">
                    <div class="relative w-full flex justify-center">
                        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2  rounded-full p-0.5 bg-white shadow-lg">
                            @if($doctor->profile_picture)
                            <img src="{{ asset('storage/' . $doctor->profile_picture) }}"
                                alt="{{ $doctor->name }}"
                                class="w-20 h-20 sm:w-24 sm:h-24 rounded-full object-cover border-4 border-white shadow-lg">
                            @else
                            @if ($doctor->gender === 'male')
                            <img src="https://img.freepik.com/free-photo/hospital-healthcare-workers-covid-19-treatment-concept-young-doctor-scrubs-making-daily-errands-clinic-listening-patient-symptoms-look-camera-professional-physician-curing-diseases_1258-57233.jpg"
                                alt="doctorimg"
                                class="w-20 h-20 sm:w-30 sm:h-30 rounded-full object-cover border-4 border-white shadow-lg">
                            @else
                            <img src="https://img.freepik.com/free-photo/healthcare-workers-preventing-virus-quarantine-campaign-concept-cheerful-friendly-asian-female-physician-doctor-with-clipboard-daily-checkup-standing-white-background_1258-107867.jpg"
                                alt="doctorimg"
                                class="w-20 h-20 sm:w-30 sm:h-30 rounded-full object-cover border-4 border-white shadow-lg">
                            @endif
                            @endif

                            @if($doctor->is_verified)
                            <div class="absolute -bottom-1 -right-1 bg-green-500 rounded-full p-1.5 border-2 border-white shadow-lg">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Doctor Name & Title -->
                    <h3 class="mt-20 text-xl sm:text-2xl font-bold text-gray-900 text-center mb-2">
                        Dr. {{ $doctor->name }}
                    </h3>

                    <div class="specialty-badge px-4 py-2 rounded-full">
                        <p class="text-sm font-medium text-green-700">{{ $doctor->specialization ?? 'No specialization' }}</p>
                    </div>
                </div>


                <!-- Stats Row -->
                <div class="grid grid-cols-2 gap-3 mb-6 relative z-10">
                    <div class="metric-card p-3 rounded-lg">
                        <div class="text-2xl font-bold text-gray-900">{{ number_format($doctor->experience_years ,0) }}</div>
                        <div class="text-xs text-gray-600 font-medium">Years Exp.</div>
                    </div>
                    <div class="metric-card p-3 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">${{ number_format($doctor->consultation_fee, 0) }}</div>
                        <div class="text-xs text-gray-600 font-medium">Consultation</div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="space-y-3 mb-6 relative z-10">
                    <div class="contact-item flex items-center p-2 -mx-2">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </div>
                        <span class="text-sm text-gray-600 truncate">{{ $doctor->email }}</span>
                    </div>

                    <div class="contact-item flex items-center p-2 -mx-2">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                        </div>
                        <span class="text-sm text-gray-600">{{ $doctor->phone ?? 'Not Found' }}</span>
                    </div>

                    <div class="contact-item flex items-center p-2 -mx-2">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-sm text-gray-600">
                            @if($doctor->availability_start_time && $doctor->availability_end_time)
                            {{ date('g:i A', strtotime($doctor->availability_start_time)) }} -
                            {{ date('g:i A', strtotime($doctor->availability_end_time)) }}
                            @else
                            Not Available
                            @endif
                        </span>
                    </div>

                    <div class="contact-item flex items-center p-2 -mx-2">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-sm text-gray-600 truncate">
                            @if($doctor->city || $doctor->state)
                                {{ $doctor->city ?? '' }}{{ $doctor->city && $doctor->state ? ', ' : '' }}{{ $doctor->state ?? '' }}
                            @else
                                Location not available
                            @endif</span>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="relative">
                    <button class="btn-primary w-full py-3 px-6 rounded-xl text-white font-semibold transition-all duration-300 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                        <span>Book Appointment</span>
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-full flex flex-col items-center justify-center py-20">
                <div class="w-32 h-32 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-8">
                    <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 mb-4">No Doctors Available</h3>
                <p class="text-gray-500 text-center max-w-md">
                    We're currently updating our medical staff directory. Please check back soon or contact our administration.
                </p>
            </div>
            @endforelse
        </div>
    </div>

    @include('layouts.footer')
</body>

</html>