$(document).ready(function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    $('#leads-table').DataTable({
        processing: true,
        serverSide: true,
        ajax:  $('#leads-table').data('url'),
        columns: [{
            data: 'profile',
            name: 'profile',
            render: function (data) {
                return data ? `<img src="/storage/${data}" width="40" class="rounded-full">` : '-';
            }
        },
        {
            data: 'name',
            name: 'name'
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
            data: 'source',
            name: 'source   '
        },
        {
            data: 'status',
            name: 'status'
        },
        {
            data: 'message',
            name: 'message'
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
            render: function (id, type, row) {
                return `
                                    <div class="flex flex-row items-center ">
                                        <a href="/leads/restore/${id}" class="bg-green-500 hover:bg-green-700 text-white px-2 py-1 rounded text-xs mr-2">Restore</a>
                                        <form method="POST" action="/leads/force-delete/${id}" onsubmit="return confirm('Permanently delete this account?');" style="display:inline;">
                                            <input type="hidden" name="_token" value="${csrfToken}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs"> Delete.. </button>
                                        </form>
                                    </div>
                                `;
            }
        }
        ]
    });
});