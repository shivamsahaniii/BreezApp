<!-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lead
        </h2>
    </x-slot>

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <x-slot name="create">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('leads.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">
                Add Lead</a>
        </h2>
    </x-slot>

    @vite(['resources/css/DataTableFix/style.css'])

    <div class="py-12 min-h-screen bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">

                    <div class="mb-4 flex justify-between items-center">
                        <a href="{{ route('leads.trash') }}" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700">
                            Go To Trash
                        </a>

                        <div>
                            @if(session('success'))
                            <div
                                x-data="{ show: true }"
                                x-show="show"
                                x-init="setTimeout(() => show = false, 5000)"
                                class="px-4 py-2 bg-green-600 text-white rounded mb-4">
                                {{ session('success') }}
                            </div>
                            @endif

                            @if(session('error'))
                            <div
                                x-data="{ show: true }"
                                x-show="show"
                                x-init="setTimeout(() => show = false, 5000)"
                                class="px-4 py-2 bg-red-600 text-white rounded mb-4">
                                {{ session('error') }}
                            </div>
                            @endif

                        </div>
                    </div>


                    <div id="massUpdateSection" class="hidden mb-4">
                        <form id="massUpdateForm" method="POST" action="{{ route('leads.massUpdate') }}" class="mb-4 p-4 bg-white rounded shadow">
                            @csrf
                            <div class="flex space-x-4 items-end">
                                <div>
                                    <label for="field" class="block font-semibold">Select Field to Update</label>
                                    <select name="field" id="field" class="border rounded px- py-1" required>
                                        <option value="" disabled selected>-- Select Field --</option>
                                        <option value="source">Source</option>
                                        <option value="status">Status</option>
                                        <option value="message">Message</option>
                                        <option value="phone">Phone</option>
                                        <option value="email">Email</option>
                                        <option value="name">Name</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="new_value" class="block font-semibold">New Value</label>
                                    <input type="text" name="new_value" id="new_value" placeholder="Enter new value" class="border rounded px-2 py-1" required />
                                </div>

                                <div>
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Selected Leads</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <table id="leads-table" class="min-w-full table-auto border border-gray-300 text-sm" data-url="{{ route('leads.index') }}">
                        <thead class="bg-gray-100 border-b border-gray-300">
                            <tr>
                                <th><input type="checkbox" id="select-all"></th>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Source</th>
                                <th>Status</th>
                                <th>Message</th>
                                <th>Created By </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/dataTables/leads/index.js'])

</x-app-layout> -->