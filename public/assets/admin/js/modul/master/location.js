let locationTable;
let currentFilterStatus = '';

document.addEventListener('DOMContentLoaded', function () {
    locationTable = initGlobalDatatable('#table_location', function () {
        return {
            filter_status: currentFilterStatus
        };
    });

    // Trigger reload on each filter
    document.querySelectorAll('.table-filter').forEach(el => {
        el.addEventListener('change', function () {
            if (locationTable) locationTable.ajax.reload();
        });
    });
});

var title = $('#title_modal').data('title').split('|');

function ubah_data(element, id) {
    var form = document.getElementById('form_location');
    $('#title_modal').text(title[0]);
    form.setAttribute('action', BASE_URL + '/master/location/update');
    $.ajax({
        url: BASE_URL + '/single/locations/id_location',
        method: 'POST',
        data: { 
            _token : csrf_token,
            id: id 
        },
        datalocation: 'json',
        success: function (data) {
            $('input[name="id_location"]').val(data.id_location);
            $('input[name="name"]').val(data.name);
        }
    })
}

function tambah_data() {
    var form = document.getElementById('form_location');
    form.setAttribute('action', BASE_URL + '/master/location/insert');
    $('#title_modal').text(title[1]);
    $('#form_location input[location="text"]').val('');
    $('#form_location input[location="email"]').val('');
}

