

// The DOM elements you wish to replace with Tagify
var input1 = document.querySelector("#keyword_website");

// Initialize Tagify components on the above inputs
new Tagify(input1);



function tambah_contact(element) {
    const div = document.getElementById('parent_phone');
    const child = div.childElementCount;
    var newCount = (child + 1);

    var html ='';
    html += '<div class="input-group mb-3" id="phone-frame-'+newCount+'">';
    html += '<input type="text" name="name_phone['+newCount+']" class="form-control form-control-lg" placeholder="Nama teller (Opsional)" autocomplete="off"/>';
    html += '<span class="input-group-text" id="phone-62-'+newCount+'">+62</span>';
    html += '<input id="phone" type="text" name="phone['+newCount+']" class="form-control form-control-lg" placeholder="Masukkan nomor telepon" autocomplete="off" aria-describedby="phone-62-'+newCount+'"/>';
    html += '<button class="btn btn-light-danger" type="button" onclick="hapus_contact('+newCount+')">';
    html += ' <i class="fa fa-trash fs-4"></i>';
    html += '</button></div>';

    div.insertAdjacentHTML('beforeend',html);
}


function hapus_contact(num) {
    $('#phone-frame-'+num).remove();
}



function tambah_email(element) {
    const div = document.getElementById('parent_email');
    const child = div.childElementCount;
    var newCount = (child + 1);

    var html ='';
    html += '<div class="input-group mb-3" id="email-frame-'+newCount+'">';
    html += '<input id="email" type="text" name="email['+newCount+']" class="form-control form-control-lg" placeholder="Masukkan alamat email" autocomplete="off"/>';
    html += '<button class="btn btn-light-danger" type="button" onclick="hapus_email('+newCount+')">';
    html += ' <i class="fa fa-trash fs-4"></i>';
    html += '</button></div>';

    div.insertAdjacentHTML('beforeend',html);
}


function hapus_email(num) {
    $('#email-frame-'+num).remove();
}


var title = $('#title_modal_sosmed').data('title').split('|');
function ubah_sosmed(element, id) {
    var form = document.getElementById('form_sosmed');
    $('#title_modal_sosmed').text(title[1]);
    form.setAttribute('action', BASE_URL + '/setting/update/sosmed');
    $.ajax({
        url: BASE_URL + '/single/sosmeds/id_sosmed',
        method: 'POST',
        data: { 
            _token : csrf_token,
            id: id
         },
        dataType: 'json',
        success: function (data) {
            $('#form_sosmed input[name="id_sosmed"]').val(data.id_sosmed);
            $('#form_sosmed input[name="name"]').val(data.name);
            $('#form_sosmed input[name="icon"]').val(data.icon);
        }
    })
}

function tambah_sosmed() {
    var form = document.getElementById('form_sosmed');
    form.setAttribute('action', BASE_URL + '/setting/insert/sosmed');
    $('#title_modal_sosmed').text(title[0]);
    $('#form_sosmed input').val('');
}


function set_url_params(pageValue) {
  const url = new URL(window.location.href);
  url.searchParams.set('page', pageValue);
  window.history.pushState({}, '', url);
}
