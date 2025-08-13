<x-app-layout>
    <x-slot name="header">
        <div class="text-3xl font-extrabold text-gray-900">Dashboard</div>
        <p class="mt-1 text-sm text-gray-500">
            Your central hub for managing accounts, contacts, and leads.
        </p>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Greeting -->
            <div class="bg-white rounded-xl shadow-sm px-6 py-8 text-center mb-10">
                <h2 class="text-2xl font-semibold text-gray-800">Hi, {{ Auth::user()->name }} 👋</h2>
                <p class="text-gray-500 mt-1">Welcome back! Here's a quick overview of your CRM.</p>
            </div>

            <!-- Stats Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Accounts -->
                <div class="group bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1 text-center">
                    <div class="w-12 h-12 mx-auto mb-4 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition">
                        <!-- Office Building Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M6 21V3h12v18M9 8h6M9 12h6" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Accounts</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ \App\Models\Account\Account::count() }}</p>
                </div>

                <!-- Contacts -->
                <div class="group bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1 text-center">
                    <div class="w-12 h-12 mx-auto mb-4 bg-green-100 text-green-600 rounded-full flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition">
                        <!-- Users Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m5-6.13a4 4 0 110-8 4 4 0 010 8z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Contacts</h3>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ \App\Models\Contact\Contact::count() }}</p>
                </div>

                <!-- Leads -->
                <div class="group bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1 text-center">
                    <div class="w-12 h-12 mx-auto mb-4 bg-red-100 text-red-600 rounded-full flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition">
                        <!-- Target Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c.552 0 1 .672 1 1.5s-.448 1.5-1 1.5-1-.672-1-1.5.448-1.5 1-1.5zm9 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Leads</h3>
                    <p class="text-3xl font-bold text-red-600 mt-2">{{ \App\Models\Lead\Lead::count() }}</p>
                </div>
            </div>

            <!-- Optional: Recent Activity Section -->
            {{-- <div class="mt-12">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Recent Activity</h3>
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-gray-500">No recent activity yet.</p>
                </div>
            </div> --}}
        </div>
    </div>
</x-app-layout>
