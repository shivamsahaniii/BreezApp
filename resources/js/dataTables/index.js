$(document).ready(function () {
    // Read config from HTML data attributes
    const $wrapper = $('#datatableWrapper');
    const headers = JSON.parse($wrapper.attr('data-headers'));
    const routeBase = $wrapper.data('route-base');
    const csrfToken = $wrapper.data('csrf-token');

    const $massUpdateSection = $('#massUpdateSection');

    let columns = [];

    // Checkbox column - only if not products
    if (routeBase !== 'products') {
        columns.push({
            data: 'id',
            orderable: false,
            searchable: false,
            render: function (id) {
                return `<input type="checkbox" class="row-checkbox" value="${id}">`;
            }
        });
    }

    headers.forEach(field => {
        const fieldName = field.name;
        const fieldType = field.type || 'text';

        if (fieldName === 'action') {
            columns.push({
                data: 'id',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function (id) {
                    return `
                        <div class="flex gap-1 justify-center">
                            <a href="/${routeBase}/${id}" class="bg-green-500 hover:bg-green-700 text-white px-2 py-1 rounded text-xs mr-2">View</a>
                            <a href="/${routeBase}/${id}/edit" class="bg-yellow-500 hover:bg-yellow-700 text-white px-2 py-1 rounded text-xs mr-2">Edit</a>
                            <form method="POST" action="/${routeBase}/${id}" onsubmit="return confirm('Are you sure you want to delete this?');" style="display:inline;">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">Trash</button>
                            </form>
                        </div>
                    `;
                }
            });
        } else if (fieldType === 'file' || fieldType === 'image' || fieldName === 'profile') {
            columns.push({
                data: fieldName,
                name: fieldName,
                orderable: false,
                searchable: false,
                render: function (data) {
                    if (data) {
                        return `<img src="/storage/${data}" class="w-12 h-12 object-cover rounded-full mx-auto" />`;
                    }
                    return '-';
                }
            });
        } else if (fieldName === 'user_id') {
            columns.push({
                data: 'user_name',
                name: 'user_name',
                title: 'Created By'
            });
        } else if (fieldName === 'account_id') {
            columns.push({
                data: 'account_name',
                name: 'account_name',
                title: 'Associated Account'
            });
        } else {
            columns.push({
                data: fieldName,
                name: fieldName
            });
        }
    });

    const table = $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: `/${routeBase}`,
        columns: columns,
        order: [[routeBase !== 'products' ? 1 : 0, 'asc']], // adjust ordering index
    });

    function toggleMassUpdateSection() {
        const selectedCount = $('.row-checkbox:checked').length;
        if (selectedCount > 0) {
            $massUpdateSection.removeClass('hidden');
        } else {
            $massUpdateSection.addClass('hidden');
        }
    }

    $(document).on('change', '.row-checkbox', function () {
        const totalCheckboxes = $('.row-checkbox').length;
        const checkedCheckboxes = $('.row-checkbox:checked').length;
        $('#select-all').prop('checked', totalCheckboxes === checkedCheckboxes);
        toggleMassUpdateSection();
    });

    $('#select-all').on('change', function () {
        $('.row-checkbox').prop('checked', this.checked);
        toggleMassUpdateSection();
    });

    function showFlashMessage(message, type = 'success') {
        const colorClass = type === 'success' ? 'bg-green-600' : 'bg-red-600';
        const $flash = $(`
            <div
                x-data="{ show: true }"
                x-show="show"
                class="mb-4 px-4 py-2 rounded text-white ${colorClass} cursor-pointer"
                title="Click to close"
            >
                ${message}
            </div>
        `);
        $('#flashMessageContainer').append($flash);
        setTimeout(() => {
            $flash.fadeOut(500, () => $flash.remove());
        }, 5000);
        $flash.on('click', () => $flash.remove());
    }

    $('#massUpdateForm').on('submit', function (e) {
        e.preventDefault();

        const field = $('#field').val();
        const newValue = $('#new_value').val();
        const selectedIds = $('.row-checkbox:checked').map(function () {
            return $(this).val();
        }).get();

        if (!field || !newValue || selectedIds.length === 0) {
            alert('Please select at least one record and fill all fields.');
            return;
        }

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: {
                _token: csrfToken,
                field: field,
                new_value: newValue,
                ids: selectedIds
            },
            success: function (response) {
                table.ajax.reload(null, false);
                $('#field').val('');
                $('#new_value').val('');
                $('#select-all').prop('checked', false);
                $('.row-checkbox').prop('checked', false);
                $massUpdateSection.addClass('hidden');
                showFlashMessage(response.message || 'Updated successfully.', 'success');
            },
            error: function (xhr) {
                showFlashMessage('An error occurred. Please try again.', 'error');
                console.error(xhr.responseText);
            }
        });
    });
});
