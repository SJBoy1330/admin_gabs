let facilityTable;

document.addEventListener('DOMContentLoaded', function () {
    facilityTable = initGlobalDatatable('#table_facility');

    // Trigger reload on each filter
    document.querySelectorAll('.table-filter').forEach(el => {
        el.addEventListener('change', function () {
            if (facilityTable) facilityTable.ajax.reload();
        });
    });
});

var image = document.getElementById('display_image');
var title = $('#title_modal').data('title').split('|');
$(function () {

    $('.hps_image').on('click', function () {
        // console.log('hapus');
        $('input[name=name_image]').val("");
    });

    

});

function action_data(id = null) {
    let form = document.getElementById('form_facility');
    let title = $('#title_modal').data('title').split('|');

    if (id == null) {
        $('#title_modal').text(title[1]);
        form.setAttribute('action', BASE_URL + '/master/facility/insert');
    } else {
        $('#title_modal').text(title[0]);
        form.setAttribute('action', BASE_URL + '/master/facility/update');
    }

    $.ajax({
        url: BASE_URL + '/modal_facility',
        method: 'POST',
        data: { _token: csrf_token, id: id },
        cache: false,
        beforeSend: function () {
            $('#display_form_facility').html(div_loading);
        },
        success: function (msg) {
            $('#display_form_facility').html(msg);
           
        }
    });
}