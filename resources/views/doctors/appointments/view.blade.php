<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Appointment - Hospital Management System</title>
    @vite('resources/css/app.css')

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }



        .doctor-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .booking-card {
            background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(15px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.3);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }

        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 14px;
            font-weight: 500;
        }

        .calendar-day:hover {
            background-color: #e0f2fe;
            transform: scale(1.05);
        }

        .calendar-day.available {
            background-color: #dcfce7;
            color: #166534;
        }

        .calendar-day.selected {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            transform: scale(1.1);
        }

        .calendar-day.unavailable {
            background-color: #fee2e2;
            color: #991b1b;
            cursor: not-allowed;
        }

        .time-slot {
            padding: 8px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
            font-weight: 500;
        }

        .time-slot:hover {
            border-color: #10b981;
            background-color: #ecfdf5;
        }

        .time-slot.selected {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border-color: #059669;
        }

        .stat-card {
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border-left: 4px solid #0ea5e9;
        }

        .floating-icon {
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.3);
        }

        .availability-badge {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .price-highlight {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border: 1px solid #f59e0b;
        }

        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
            }

            .doctor-section {
                order: 1;
            }

            .booking-section {
                order: 2;
            }
        }
    </style>
</head>

<body class=" min-h-screen">

    @include('layouts.header')

    <div class="container mx-auto p-4 sm:p-6 lg:p-8 mt-8">
        <div class="grid grid-cols-3 gap-8 main-container">

            <!-- Doctor Details Section -->
            <div class="col-span-2 doctor-section">
                <div class="doctor-card rounded-3xl p-8 shadow-2xl">
                    <!-- Doctor Header -->
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 mb-8">
                        <div class="relative">
                            @if($doctor->profile_picture)
                            <img src="{{ asset('storage/' . $doctor->profile_picture) }}"
                                alt="{{ $doctor->name }}"
                                class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                            @else
                            @if ($doctor->gender === 'male')
                            <img src="https://img.freepik.com/free-photo/hospital-healthcare-workers-covid-19-treatment-concept-young-doctor-scrubs-making-daily-errands-clinic-listening-patient-symptoms-look-camera-professional-physician-curing-diseases_1258-57233.jpg"
                                alt="doctorimg"
                                class="w-32 h-32  rounded-full object-cover border-4 border-white shadow-lg">
                            @else
                            <img src="https://img.freepik.com/free-photo/healthcare-workers-preventing-virus-quarantine-campaign-concept-cheerful-friendly-asian-female-physician-doctor-with-clipboard-daily-checkup-standing-white-background_1258-107867.jpg"
                                alt="doctorimg"
                                class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                            @endif
                            @endif
                            <div class="absolute -top-2 -right-2 floating-icon w-12 h-12 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="flex-1 text-center sm:text-left">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Dr. {{ $doctor->name }}</h1>
                            <p class="text-xl text-indigo-600 font-semibold mb-3">{{ $doctor->specialization }}</p>

                            <div class="flex flex-wrap gap-3 justify-center sm:justify-start">
                                @if($isAvailable)
                                <span class="availability-badge px-4 py-2 rounded-full text-sm font-semibold">
                                    ✅ Available Today
                                </span>
                                @else
                                <span class="bg-gradient-to-r from-red-100 to-red-200 text-red-700 px-4 py-2 rounded-full text-sm font-semibold border border-red-300">
                                    ❌ Not Available
                                </span>
                                @endif

                                <span class="bg-gradient-to-r from-blue-100 to-blue-200 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold border border-blue-300">
                                    {{ $doctor->experience ?? '5+' }} Years Experience
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Doctor Stats -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                        <div class="stat-card p-4 rounded-xl">
                            <div class="flex items-center">
                                <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold text-gray-900">1,250+</p>
                                    <p class="text-sm text-gray-600">Patients Treated</p>
                                </div>
                            </div>
                        </div>

                        <div class="stat-card p-4 rounded-xl">
                            <div class="flex items-center">
                                <div class="p-2 bg-green-100 rounded-lg mr-3">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold text-gray-900">4.9</p>
                                    <p class="text-sm text-gray-600">Rating</p>
                                </div>
                            </div>
                        </div>

                        <div class="stat-card p-4 rounded-xl">
                            <div class="flex items-center">
                                <div class="p-2 bg-purple-100 rounded-lg mr-3">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold text-gray-900">30 min</p>
                                    <p class="text-sm text-gray-600">Avg. Consultation</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- About Doctor -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">About Doctor</h3>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            {{ $doctor->about ?? 'Dr. ' . $doctor->name . ' is a highly experienced ' . strtolower($doctor->specialization) . ' with expertise in comprehensive patient care. Known for compassionate treatment and advanced medical knowledge.' }}
                        </p>

                        <!-- Consultation Fee -->
                        <div class="price-highlight p-4 rounded-xl inline-block w-full">
                            <div class="flex items-center space-x-3 ">
                                <div class="p-2 bg-orange-100 rounded-lg">
                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold text-orange-700">₹{{ $doctor->consultation_fee ?? '500' }}</p>
                                    <p class="text-sm text-orange-600">Consultation Fee</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Specialties -->
                    <div class="mb-8 flex flex-col gap-6">
                        <!-- Left: Specialties -->
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Specialties</h3>
                            <div class="flex flex-wrap gap-3">
                                <span class="bg-gradient-to-r from-indigo-100 to-indigo-200 text-indigo-700 px-4 py-2 rounded-full text-sm font-medium border border-indigo-300">{{ $doctor->specialization }}</span>
                                <span class="bg-gradient-to-r from-green-100 to-green-200 text-green-700 px-4 py-2 rounded-full text-sm font-medium border border-green-300">Preventive Care</span>
                                <span class="bg-gradient-to-r from-purple-100 to-purple-200 text-purple-700 px-4 py-2 rounded-full text-sm font-medium border border-purple-300">Emergency Treatment</span>
                                <span class="bg-gradient-to-r from-orange-100 to-orange-200 text-orange-700 px-4 py-2 rounded-full text-sm font-medium border border-orange-300">Patient Counseling</span>
                            </div>
                        </div>

                        <!-- Right: Doctor Location Map -->
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Location</h3>
                            <div class="rounded-xl overflow-hidden border border-gray-200 shadow">
                                <div id="doctorMap" class="w-full h-64 rounded-xl border border-gray-200 shadow"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Existing Appointments -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Recent Appointments</h3>
                        @if($appointments->isEmpty())
                        <div class="p-6 text-center bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl border border-gray-200">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V7a2 2 0 012-2h4a2 2 0 012 2v0M8 7v10a2 2 0 002 2h4a2 2 0 002-2V7m-6 0h6"></path>
                            </svg>
                            <p class="text-gray-500 font-medium">No appointments scheduled yet</p>
                        </div>
                        @else
                        <div class="space-y-3">
                            @foreach($appointments->take(3) as $appointment)
                            <div class="p-4 bg-gradient-to-r from-white to-gray-50 rounded-xl border border-gray-200 flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-600">{{ $appointment->start_time }} - {{ $appointment->end_time }}</p>
                                </div>
                                <span class="px-3 py-1 text-sm rounded-full font-medium
                                            @if($appointment->status === 'confirmed') bg-green-100 text-green-700 border border-green-300
                                            @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-700 border border-yellow-300
                                            @else bg-red-100 text-red-700 border border-red-300 @endif">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                </div>
            </div>

            <!-- Booking Form Section -->
            <div class="col-span-1 booking-section">
                <div class="booking-card rounded-3xl p-6 shadow-2xl sticky top-8">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Book Appointment</h2>
                    </div>

                    <form id="appointmentForm" method="POST" action="{{ route('appointments.create') }}">
                        @csrf

                        <!-- Calendar -->
                        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Select Date</label>
                            <div class="bg-white p-4 rounded-xl border border-gray-200">
                                <div class="flex justify-between items-center mb-4">
                                    <button type="button" class="p-2 hover:bg-gray-100 rounded-lg" onclick="previousMonth()">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </button>
                                    <h3 id="currentMonth" class="font-bold text-lg"></h3>
                                    <button type="button" class="p-2 hover:bg-gray-100 rounded-lg" onclick="nextMonth()">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="grid grid-cols-7 gap-1 mb-2">
                                    <div class="text-center text-xs font-semibold text-gray-500 py-2">Sun</div>
                                    <div class="text-center text-xs font-semibold text-gray-500 py-2">Mon</div>
                                    <div class="text-center text-xs font-semibold text-gray-500 py-2">Tue</div>
                                    <div class="text-center text-xs font-semibold text-gray-500 py-2">Wed</div>
                                    <div class="text-center text-xs font-semibold text-gray-500 py-2">Thu</div>
                                    <div class="text-center text-xs font-semibold text-gray-500 py-2">Fri</div>
                                    <div class="text-center text-xs font-semibold text-gray-500 py-2">Sat</div>
                                </div>

                                <div id="calendarDays" class="calendar"></div>
                            </div>
                            <input type="hidden" name="appointment_date" id="selectedDate">
                        </div>

                        <!-- Time Slots -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Available Time Slots</label>
                            <div class="grid grid-cols-2 gap-3" id="timeSlots">
                                <div class="time-slot" data-time="09:00">09:00 AM</div>
                                <div class="time-slot" data-time="10:00">10:00 AM</div>
                                <div class="time-slot" data-time="11:00">11:00 AM</div>
                                <div class="time-slot" data-time="14:00">02:00 PM</div>
                                <div class="time-slot" data-time="15:00">03:00 PM</div>
                                <div class="time-slot" data-time="16:00">04:00 PM</div>
                            </div>
                            <input type="hidden" name="start_time" id="selectedTime">
                        </div>

                        <!-- Patient Details -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Patient Name</label>
                            <input type="text" name="patient_name" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all" placeholder="Enter patient name" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" name="phone" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all" placeholder="Enter phone number" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Brief Description</label>
                            <textarea name="description" rows="3" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all resize-none" placeholder="Describe your symptoms or reason for visit"></textarea>
                        </div>

                        <!-- Book Button -->
                        <button type="submit" class="btn-primary w-full py-4 px-6 rounded-xl text-white font-bold text-lg cursor-pointer">
                            Book Appointment
                        </button>

                        <p class="text-xs text-gray-500 text-center mt-3">
                            You will receive a confirmation call within 2 hours
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}"></script>
    <script>
        let currentDate = new Date();
        let selectedDateElement = null;
        let selectedTimeElement = null;

        function generateCalendar(year, month) {
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startDate = new Date(firstDay);
            startDate.setDate(startDate.getDate() - firstDay.getDay());

            const calendarDays = document.getElementById('calendarDays');
            const currentMonth = document.getElementById('currentMonth');

            currentMonth.textContent = new Date(year, month).toLocaleDateString('en-US', {
                month: 'long',
                year: 'numeric'
            });
            calendarDays.innerHTML = '';

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            for (let i = 0; i < 42; i++) {
                const date = new Date(startDate);
                date.setDate(startDate.getDate() + i);

                const dayElement = document.createElement('div');
                dayElement.classList.add('calendar-day');
                dayElement.textContent = date.getDate();

                if (date.getMonth() !== month) {
                    dayElement.classList.add('text-gray-400');
                } else if (date < today) {
                    dayElement.classList.add('unavailable');
                } else {
                    dayElement.classList.add('available');
                    dayElement.addEventListener('click', () => selectDate(dayElement, date));
                }

                calendarDays.appendChild(dayElement);
            }
        }

        function selectDate(element, date) {
            if (selectedDateElement) {
                selectedDateElement.classList.remove('selected');
            }

            selectedDateElement = element;
            element.classList.add('selected');

            const formattedDate = date.toISOString().split('T')[0];
            document.getElementById('selectedDate').value = formattedDate;
        }

        function previousMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
        }

        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
        }

        // Time slot selection
        document.querySelectorAll('.time-slot').forEach(slot => {
            slot.addEventListener('click', function() {
                if (selectedTimeElement) {
                    selectedTimeElement.classList.remove('selected');
                }

                selectedTimeElement = this;
                this.classList.add('selected');

                document.getElementById('selectedTime').value = this.dataset.time;
            });
        });

        // Form validation
        document.getElementById('appointmentForm').addEventListener('submit', function(e) {
            if (!document.getElementById('selectedDate').value) {
                e.preventDefault();
                alert('Please select a date');
                return;
            }

            if (!document.getElementById('selectedTime').value) {
                e.preventDefault();
                alert('Please select a time slot');
                return;
            }
        });

        // Initialize calendar
        generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
    </script>
    <script>
        function initMap() {
            const doctorLocation = {
                    lat: {{ $doctor->latitude ?? 28.6139 }},
                    lng: {{ $doctor->longitude ?? 77.2090 }}
                };

            const map = new google.maps.Map(document.getElementById("doctorMap"), {
                zoom: 14,
                center: doctorLocation,
            });

            new google.maps.Marker({
                position: doctorLocation,
                map: map,
                title: "Dr. {{ $doctor->name }}'s Location"
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initMap"></script>

</body>

</html>