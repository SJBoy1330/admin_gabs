let unitTable;
let currentFilterStatus = '';

document.addEventListener('DOMContentLoaded', function () {
    unitTable = initGlobalDatatable('#table_unit', function () {
        return {
            filter_status: currentFilterStatus
        };
    });

    // Trigger reload on each filter
    document.querySelectorAll('.table-filter').forEach(el => {
        el.addEventListener('change', function () {
            if (unitTable) unitTable.ajax.reload();
        });
    });
});

var title = $('#title_modal').data('title').split('|');

function ubah_data(element, id) {
    var form = document.getElementById('form_unit');
    $('#title_modal').text(title[0]);
    form.setAttribute('action', BASE_URL + '/master/unit/update');
    $.ajax({
        url: BASE_URL + '/single/units/id_unit',
        method: 'POST',
        data: { 
            _token : csrf_token,
            id: id 
        },
        dataunit: 'json',
        success: function (data) {
            $('input[name="id_unit"]').val(data.id_unit);
            $('input[name="name"]').val(data.name);
        }
    })
}

function tambah_data() {
    var form = document.getElementById('form_unit');
    form.setAttribute('action', BASE_URL + '/master/unit/insert');
    $('#title_modal').text(title[1]);
    $('#form_unit input[unit="text"]').val('');
    $('#form_unit input[unit="email"]').val('');
}

