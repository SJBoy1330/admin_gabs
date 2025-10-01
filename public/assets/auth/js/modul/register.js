var KTSignupGeneral = function () {
    var e, t, i;
    return {
        init: function () {
            e = document.querySelector("#form_register"), t = document.querySelector("#button_register"), i = FormValidation.formValidation(e, {
                fields: {
                    email: {
                        validators: {
                            regexp: {
                                regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                message: "Format alamat email tidak valid"
                            },
                            notEmpty: {
                                message: "Alamat email tidak boleh kosong"
                            }
                        }
                    },
                    'name': {
                        validators: {
                            notEmpty: {
                                message: "Nama lengkap tidak boleh kosong"
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: "Kata sandi tidak boleh kosong!"
                            }
                        }
                    },
                    'repassword': {
                        validators: {
                            notEmpty: {
                                message: 'Konfirmasi kata sandi tidak boleh kosong!'
                            },
                            identical: {
                                compare: function () {
                                    return form.querySelector('[name="password"]').value;
                                },
                                message: 'Konfirmasi kata sandi tidak valid!'
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger,
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            }), t.addEventListener("click", (function (n) {
                n.preventDefault(), i.validate().then((function (i) {
                    "Valid" == i ? register_process(t, e) : Swal.fire({
                        text: "Tidak ada data terdeteksi! Silahkan cek data yang anda masukan",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: css_btn_confirm
                        }
                    })
                }))
            }))
        }
    }
}();

function register_process(button, form) {
    var message, icon;
    var btn = $('#button_register');
    var btn_text = btn.html();

    $.ajax({
        url: form.getAttribute('action'),
        method: form.getAttribute('method'),
        data: {
            _token: csrf_token,
            email: form.querySelector('[name="email"]').value,
            name: form.querySelector('[name="name"]').value,
            repassword: form.querySelector('[name="repassword"]').value,
            password: form.querySelector('[name="password"]').value
        },
        dataType: 'json',
        beforeSend: function () {
            btn.html('Tunggu sebentar...');
            btn.attr('disabled', true);
        },
        success: function (data) {
            // console.log(data);
            btn.html(btn_text);
            btn.attr('disabled', false);
            if (data.status == 200) {
                icon = 'success';
            } else if (data.status == 700) {
                icon = 'error';
            } else {
                icon = 'warning';
            }
            if (data.status == 200) {
                Swal.fire({
                    html: data.message,
                    icon: icon,
                    buttonsStyling: !1,
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: css_btn_confirm
                    }
                }).then((function (t) {
                    if (t.isConfirmed) {
                        form.querySelector('[name="email"]').value = "",
                        form.querySelector('[name="name"]').value = "",
                        form.querySelector('[name="repassword"]').value = "",
                        form.querySelector('[name="password"]').value = "";
                        if (data.redirect) {
                            location.href = data.redirect;
                        }
                    }
                }))
            } else {
                Swal.fire({
                    html: data.message,
                    icon: icon,
                    buttonsStyling: !1,
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: css_btn_confirm
                    }
                })
            }
        }
    });
}
KTUtil.onDOMContentLoaded((function () {
    KTSignupGeneral.init()
}));
