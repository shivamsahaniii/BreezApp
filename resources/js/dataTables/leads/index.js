$(document).ready(function () {
    const $massUpdateSection = $('#massUpdateSection');

    // Index of updated_at column (verify in your columns array)
    const updatedAtIndex = 10;

    const table = $('#leads-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: $('#leads-table').data('url'),
        order: [[updatedAtIndex, 'desc']], // Sort by updated_at
        columns: [
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function (id) {
                    return `<input type="checkbox" class="row-checkbox" value="${id}">`;
                }
            },
            {
                data: 'profile',
                name: 'profile',
                render: data => data
                    ? `<img src="/storage/${data}" class="w-12 h-12 object-cover rounded-full mx-auto" />`
                    : 'NA'
            },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'source', name: 'source' },
            { data: 'status', name: 'status' },
            { data: 'message', name: 'message' },
            { data: 'user_name', name: 'user_name' },
            {
                data: 'id',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function (id) {
                    const token = $('meta[name="csrf-token"]').attr('content');
                    return `
                        <div class="flex flex-row items-center">
                            <a href="/leads/${id}" class="bg-green-500 hover:bg-green-700 text-white px-2 py-1 rounded text-xs mr-2">View</a>
                            <a href="/leads/${id}/edit" class="bg-yellow-500 hover:bg-yellow-700 text-white px-2 py-1 rounded text-xs mr-2">Edit</a>
                            <form method="POST" action="/leads/${id}" onsubmit="return confirm('Are you sure?');" style="display:inline;">
                                <input type="hidden" name="_token" value="${token}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">Trash</button>
                            </form>
                        </div>
                    `;
                }
            },
            { data: 'updated_at', name: 'updated_at', visible: false, searchable: false }
        ]
    });

    // Toggle mass update section visibility based on checked checkboxes
    function toggleMassUpdateSection() {
        const selectedCount = $('.row-checkbox:checked').length;
        $massUpdateSection.toggleClass('hidden', selectedCount === 0);
    }

    // On individual checkbox change
    $(document).on('change', '.row-checkbox', function () {
        // Sync 'select all' checkbox status
        const totalCheckboxes = $('.row-checkbox').length;
        const checkedCheckboxes = $('.row-checkbox:checked').length;
        $('#select-all').prop('checked', totalCheckboxes === checkedCheckboxes);

        toggleMassUpdateSection();
    });

    // On select all checkbox change
    $('#select-all').on('change', function () {
        $('.row-checkbox').prop('checked', this.checked);
        toggleMassUpdateSection();
    });

    // Mass update form submit
    $('#massUpdateForm').on('submit', function (e) {
        e.preventDefault();

        const field = $('#field').val();
        const value = $('#new_value').val();
        const selectedIds = $('.row-checkbox:checked').map(function () {
            return $(this).val();
        }).get();

        if (!field || !value || selectedIds.length === 0) {
            alert('Please select records and provide update details.');
            return;
        }

        const formData = new FormData();
        formData.append('field', field);
        formData.append('new_value', value);
        selectedIds.forEach(id => formData.append('ids[]', id));

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                // Optionally use a nicer toast notification here
                alert(response.message || 'Mass update successful!');

                // Reset form and checkboxes
                $('#field').val('');
                $('#new_value').val('');
                $('#select-all').prop('checked', false);
                $('.row-checkbox').prop('checked', false);
                $massUpdateSection.addClass('hidden');

                // Reload table and keep ordering
                table.order([[updatedAtIndex, 'desc']]).ajax.reload(null, false);
            },
            error: function (xhr) {
                console.error(xhr.responseJSON || xhr.responseText);
                alert('Error occurred, please try again.');
            }
        });
    });

    // Reset mass update section on DataTable redraw
    table.on('draw', function () {
        $('#select-all').prop('checked', false);
        $('.row-checkbox').prop('checked', false);
        $massUpdateSection.addClass('hidden');
    });
});
