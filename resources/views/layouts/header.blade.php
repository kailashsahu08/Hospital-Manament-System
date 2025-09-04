<nav class="bg-gray-200 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo/App Name -->
                    <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-15 w-auto">
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-8">
                    <a href="/" class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium">Home</a>
                    <a href="/doctors" class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium">Doctors</a>
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
            <a href="/" class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium">Home</a>
                    <a href="/doctors" class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium">Doctors</a>
                    <a href="/about" class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium">About</a>
                    <a href="/contact" class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium">Contact</a>
                    @auth
                        <a href="{{ route('filament.admin.pages.dashboard') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">Dashboard</a>
                    @else
                        <a href="/admin/login" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">Login</a>
                    @endauth
            </div>
        </div>
    </nav>