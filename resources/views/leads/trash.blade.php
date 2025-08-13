<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lead
        </h2>
    </x-slot>

    {{-- Include CSRF token in meta --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/DataTableFix/style.css'])

    <div class="py-12 min-h-screen bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">

                    <div class="mb-4 flex justify-between items-center">
                        <a href="{{ route('leads.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">
                            Back To List
                        </a>

                        <div>
                            @if(session('success'))
                            <div class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                {{ session('success') }}
                            </div>
                            @endif

                            @if(session('error'))
                            <div class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                {{ session('error') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <table id="leads-table"
                        data-url="{{ route('leads.trash') }}"
                        class="min-w-full table-auto border border-gray-300 text-sm">

                        <thead class="bg-gray-100 border-b border-gray-300 text-center">
                            <tr>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Source</th>
                                <th>Status</th>
                                <th>Message</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/dataTables/leads/trash.js'])

</x-app-layout>