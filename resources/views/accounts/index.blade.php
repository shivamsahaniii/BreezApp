<!-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Account
        </h2>
    </x-slot>

    <x-slot name="create">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('accounts.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">
                Add Account</a>
        </h2>
    </x-slot>

    @vite(['resources/css/DataTableFix/style.css'])

    <div class="py-12 min-h-screen bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">

                    <div class="mb-4 flex justify-between items-center">
                        <a href="{{ route('accounts.trash') }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Go to Trash
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
                    <table id="accounts-table" class="min-w-full table-auto border border-gray-300 text-sm">
                        <thead class="bg-gray-100 border-b border-gray-300">
                            <tr>
                                <th>Profile</th>
                                <th>Account Name</th>
                                <th>Industry</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Website</th>
                                <th>Address</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#accounts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("accounts.index") }}',
                columns: [{
                        data: 'profile',
                        name: 'profile',
                        render: function(data) {
                            return data ?
                                `<img src="/storage/${data}" class="w-12 h-12 object-cover rounded-full mx-auto" />` :
                                '-';
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'industry',
                        name: 'industry'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'website',
                        name: 'website'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    // Show User Name from relationship
                    {
                        data: 'user_name',
                        name: 'user_name',

                    },
                    {
                        data: 'id',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(id, type, row) {
                            return `
                                    <div class="flex flex-row items-center">
                                        <a href="/accounts/${id}" class="bg-green-500 hover:bg-green-700 text-white px-2 py-1 rounded text-xs mr-2">View</a>
                                        <a href="/accounts/${id}/edit" class="bg-yellow-500 hover:bg-yellow-700 text-white px-2 py-1 rounded text-xs mr-2">Edit</a>
                                        <form method="POST" action="/accounts/${id}" onsubmit="return confirm('Are you sure you want to delete this account?');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">Trash</button>
                                        </form>
                                    </div>
                                `;
                        }
                    }
                ]
            });
        });
    </script>
    @endpush
</x-app-layout> -->