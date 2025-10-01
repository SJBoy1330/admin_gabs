let typeTable;
let currentFilterStatus = '';

document.addEventListener('DOMContentLoaded', function () {
    typeTable = initGlobalDatatable('#table_type', function () {
        return {
            filter_status: currentFilterStatus
        };
    });

    // Trigger reload on each filter
    document.querySelectorAll('.table-filter').forEach(el => {
        el.addEventListener('change', function () {
            if (typeTable) typeTable.ajax.reload();
        });
    });
});

var title = $('#title_modal').data('title').split('|');

function ubah_data(element, id) {
    var form = document.getElementById('form_type');
    $('#title_modal').text(title[0]);
    form.setAttribute('action', BASE_URL + '/master/type/update');
    $.ajax({
        url: BASE_URL + '/single/types/id_type',
        method: 'POST',
        data: { 
            _token : csrf_token,
            id: id 
        },
        dataType: 'json',
        success: function (data) {
            $('input[name="id_type"]').val(data.id_type);
            $('input[name="name"]').val(data.name);
        }
    })
}

function tambah_data() {
    var form = document.getElementById('form_type');
    form.setAttribute('action', BASE_URL + '/master/type/insert');
    $('#title_modal').text(title[1]);
    $('#form_type input[type="text"]').val('');
    $('#form_type input[type="email"]').val('');
}

