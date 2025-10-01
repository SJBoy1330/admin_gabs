let bannerTable;
let currentFilterStatus = '';


document.addEventListener('DOMContentLoaded', function () {
    // Init DataTable
    bannerTable = initGlobalDatatable('#table_banner', function () {
        return { filter_status: currentFilterStatus };
    });

    // Reload DataTable kalau filter berubah
    document.querySelectorAll('.table-filter').forEach(el => {
        el.addEventListener('change', function () {
            if (bannerTable) bannerTable.ajax.reload();
        });
    });
});

// Fungsi filter status
function filter_status(element) {
    currentFilterStatus = element.value;
    if (bannerTable) bannerTable.ajax.reload();
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
    let form = document.getElementById('form_banner');
    let title = $('#title_modal').data('title').split('|');

    if (id == null) {
        $('#title_modal').text(title[1]);
        form.setAttribute('action', BASE_URL + '/cms/banner/insert');
    } else {
        $('#title_modal').text(title[0]);
        form.setAttribute('action', BASE_URL + '/cms/banner/update');
    }

    $.ajax({
        url: BASE_URL + '/modal_banner',
        method: 'POST',
        data: { _token: csrf_token, id: id },
        cache: false,
        beforeSend: function () {
            $('#display_form_banner').html(div_loading);
        },
        success: function (msg) {
            $('#display_form_banner').html(msg);

            // Init Select2
            $('#select_button').select2({
                dropdownParent: $('#form_banner')
            });

            initEditors();
           
        }
    });
}



function setLangContent(element, id) {
    $('.lang_button').removeClass('badge-primary');
    $('.lang_button').addClass('badge-secondary');

    $(element).addClass('badge-primary');
    $(element).removeClass('badge-secondary');

    $('.content_lang').addClass('d-none');

    $('.cross_lang_'+id).removeClass('d-none');
}



function initEditors() {
    $('[id^="description_"]').each(function () {
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
