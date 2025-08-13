@php
use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ucfirst($routeBase) }}
        </h2>
    </x-slot>

    <x-slot name="create">
        @if ($routeBase !== 'products')
            <a href="{{ route($routeBase . '.create') }}"
                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">
                Add {{ ucfirst(Str::singular($routeBase)) }}
            </a>
        @endif
    </x-slot>


    @vite(['resources/css/DataTableFix/style.css'])

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="py-12 min-h-screen bg-gray-100"
        id="datatableWrapper"
        data-headers='@json($headers)'
        data-route-base="{{ $routeBase }}"
        data-csrf-token="{{ csrf_token() }}">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">

                    <div class="mb-4 flex flex-col gap-2">
                        {{-- Placeholder for JS flash messages --}}
                        <div id="flashMessageContainer"></div>

                        <div class="flex justify-between items-center">
                            @if ($routeBase !== 'products')
                                <a href="{{ route($routeBase . '.trash') }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                    Go to Trash
                                </a>
                            @endif
                            

                            <div>
                                {{-- Optional: keep server-side session flash messages --}}
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
                    </div>

                    @if ($routeBase !== 'products' )
                    <div id="massUpdateSection" class="hidden bg-gray-300 p-4 rounded mb-6">
                        <form id="massUpdateForm" action="{{ route($routeBase . '.massUpdate') }}" method="POST">
                            @csrf
                            <div class="flex items-center gap-4 flex-wrap">
                                <label for="field" class="font-semibold">Field to update:</label>
                                @php
                                    $formFields = config('CustomeFields.form_fields.' . $routeBase);
                                @endphp

                                <select id="field" name="field" required class="border rounded px-2 py-1">
                                    <option value="">Select field</option>
                                    @foreach ($formFields as $field)
                                        @php
                                            $type = $field['type'] ?? null;
                                            $name = $field['name'] ?? '';
                                        @endphp

                                        @if ($type && !in_array($type, ['file', 'image', 'select-multiple', 'select']) && $name !== 'action')
                                            <option value="{{ $name }}">
                                                {{ $field['label'] ?? ucfirst($name) }}
                                            </option>
                                        @endif
                                    @endforeach


                                </select>


                                <label for="new_value" class="font-semibold">New value:</label>
                                <input type="text" id="new_value" name="new_value" required
                                    class="border rounded px-2 py-1" placeholder="Enter new value" />

                                <button type="submit"
                                    class="bg-blue-600 text-white rounded px-4 py-2 hover:bg-blue-700">
                                    Update Selected
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif


                    {{-- DataTable --}}
                    <table id="dataTable" class="min-w-full table-auto border border-gray-300 text-sm" style="width:100%">
                        <thead class="bg-gray-100 border-b border-gray-300">
                            <tr>
                                @if ($routeBase !== 'products')
                                    <th><input type="checkbox" id="select-all"></th>
                                @endif
                                @foreach ($headers as $field)
                                    <th>{{ $field['label'] ?? ucfirst($field['name']) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @vite('resources/js/dataTables/index.js')
    @endpush
</x-app-layout>