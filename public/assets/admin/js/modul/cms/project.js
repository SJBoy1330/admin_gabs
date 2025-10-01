let projectTable;
let currentFilterStatus = '';


document.addEventListener('DOMContentLoaded', function () {
    // Init DataTable
    projectTable = initGlobalDatatable('#table_project', function () {
        return { filter_status: currentFilterStatus };
    });

    // Reload DataTable kalau filter berubah
    document.querySelectorAll('.table-filter').forEach(el => {
        el.addEventListener('change', function () {
            if (projectTable) projectTable.ajax.reload();
        });
    });
});

// Fungsi filter status
function filter_status(element) {
    currentFilterStatus = element.value;
    if (projectTable) projectTable.ajax.reload();
}

// Show/Hide tombol
function selectButton(element) {
    let status = $(element).val();
    $('#display_button').toggleClass('d-none', status !== 'Y');
}

// Hapus image
$(document).on('click', '.hps_image', function () {
    $('input[name=name_image]').val("");
});

// Action Data Modal
function action_data(id = null) {
    let form = document.getElementById('form_project');
    let title = $('#title_modal').data('title').split('|');

    if (id == null) {
        $('#title_modal').text(title[1]);
        form.setAttribute('action', BASE_URL + '/cms/project/insert');
    } else {
        $('#title_modal').text(title[0]);
        form.setAttribute('action', BASE_URL + '/cms/project/update');
    }

    $.ajax({
        url: BASE_URL + '/modal_project',
        method: 'POST',
        data: { _token: csrf_token, id: id },
        cache: false,
        beforeSend: function () {
            $('#display_form_project').html(div_loading);
        },
        success: function (msg) {
            $('#display_form_project').html(msg);

            // Init Select2
            $('#select_id_unit').select2({
                dropdownParent: $('#form_project')
            });
            $('#select_id_location').select2({
                dropdownParent: $('#form_project')
            });
            $('#select_id_type').select2({
                dropdownParent: $('#form_project')
            });

            initEditors();

             // Load map setelah modal tampil
            setTimeout(function(){
                initMap();
            }, 300);
           
        }
    });
}



function setLangContent(element, id,lang = '') {
    $('.lang_button').removeClass('badge-primary');
    $('.lang_button').addClass('badge-secondary');

    $(element).addClass('badge-primary');
    $(element).removeClass('badge-secondary');

    $('.content_lang').addClass('d-none');

    $('.cross_lang_'+id).removeClass('d-none');

    $('#title_lang').text(lang);
}


function initEditors() {
    $('[id^="specification_"]').each(function () {
        let textarea = this;

        // Hapus instance lama kalau ada
        if (textarea.ckeditorInstance) {
            textarea.ckeditorInstance.destroy().catch(err => console.error(err));
            textarea.ckeditorInstance = null;
        }

        // Buat instance baru
        ClassicEditor.create(textarea, {
            toolbar: {
                items: [
                    'bold',
                    'italic',
                    'underline',
                    'fontSize',
                    'fontColor',
                    '|',
                    'alignment:left',
                    'alignment:center',
                    'alignment:right'
                ]
            },
            alignment: { options: ['left', 'center', 'right'], isEnabled: true },
            fontSize: { options: [10, 15, 20, 25, 30, 35, 40, 45, 50], supportAllValues: true },
            language: 'en'
        }).then(editor => {
            textarea.ckeditorInstance = editor;
        }).catch(error => {
            console.error(error);
        });
    });
}


let map;
let marker;

function initMap() {
    let defaultLat = parseFloat($("#lat").val()) || -6.200000; // Jakarta
    let defaultLng = parseFloat($("#lng").val()) || 106.816666;

    // Kalau map sudah ada, hapus dulu biar ga dobel
    if (map) {
        map.remove();
    }

    // Inisialisasi Map
    map = L.map('map').setView([defaultLat, defaultLng], 13);

    // Tambah Tile Layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap',
    }).addTo(map);

    // Marker awal
    marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

    // Set input awal
    $("#lat").val(defaultLat);
    $("#lng").val(defaultLng);

    // Drag marker update input
    marker.on('dragend', function () {
        let latlng = marker.getLatLng();
        $("#lat").val(latlng.lat);
        $("#lng").val(latlng.lng);
    });

    // Geocoder
    L.Control.geocoder({
        defaultMarkGeocode: false
    }).on('markgeocode', function (e) {
        let latlng = e.geocode.center;

        marker.setLatLng(latlng);
        map.setView(latlng, 15);

        $("#lat").val(latlng.lat);
        $("#lng").val(latlng.lng);
    }).addTo(map);
}


function setFacility(element, id) {
    if (element.checked) {
        // kalau dicentang
        $('#pane_access_' + id).removeClass('d-none');
        $('#pane_unaccess_' + id).addClass('d-none');
    } else {
        // kalau tidak dicentang
        $('#pane_access_' + id).addClass('d-none');
        $('#pane_unaccess_' + id).removeClass('d-none');
    }
}
