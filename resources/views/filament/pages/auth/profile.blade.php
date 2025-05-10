<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Top Bar -->
        <div class="bg-white shadow">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="py-6">
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-semibold text-gray-900">Profile Settings</h1>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-500">Welcome, {{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    {{ $this->form }}
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page> 