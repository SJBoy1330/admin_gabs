// Class definition
var KTAccountSettingsDeactivateAccount = function () {
    // Private variables
    var form;
    var validation;
    var submitButton;

    // Private functions
    var initValidation = function () {
        validation = FormValidation.formValidation(
            form,
            {
                fields: {
                    deactivate: {
                        validators: {
                            notEmpty: {
                                message: 'Silakan centang kotak untuk menonaktifkan akun Anda'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );
    }

    var handleForm = function () {
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            validation.validate().then(function (status) {
                if (status == 'Valid') {
                    swal.fire({
                        text: "Apakah Anda yakin ingin menonaktifkan akun Anda?",
                        icon: "warning",
                        buttonsStyling: false,
                        showDenyButton: true,
                        confirmButtonText: "Ya, nonaktifkan",
                        denyButtonText: 'Batal',
                        customClass: {
                            confirmButton: "btn btn-light-primary",
                            denyButton: "btn btn-danger"
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deactivated_account();
                        } else if (result.isDenied) {
                            Swal.fire({
                                text: 'Akun tidak dinonaktifkan.',
                                icon: 'info',
                                confirmButtonText: "Oke",
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: "btn btn-light-primary"
                                }
                            });
                        }
                    });

                } else {
                    swal.fire({
                        text: "Maaf, sepertinya ada kesalahan. Silakan coba lagi.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Oke, mengerti!",
                        customClass: {
                            confirmButton: "btn btn-light-primary"
                        }
                    });
                }
            });
        });
    }

    // Public methods
    return {
        init: function () {
            form = document.querySelector('#form_deactivated');
            if (!form) return;
            submitButton = document.querySelector('#button_deactivated');

            initValidation();
            handleForm();
        }
    }

    function deactivated_account() {
        var icon;
        var btn = $('#button_update_email');
        var btn_text = btn.html();

        $.ajax({
            url: form.getAttribute('action'),
            method: form.getAttribute('method'),
            data: {
                _token: csrf_token
            },
            dataType: 'json',
            beforeSend: function () {
                btn.html('Memuat...');
                btn.attr('disabled', true);
            },
            success: function (data) {
                btn.html(btn_text);
                btn.attr('disabled', false);

                if (data.status == 200) {
                    icon = 'success';
                } else if (data.status == 700) {
                    icon = 'error';
                } else {
                    icon = 'warning';
                }

                Swal.fire({
                    html: data.message,
                    icon: icon,
                    buttonsStyling: false,
                    confirmButtonText: "Oke",
                    customClass: {
                        confirmButton: css_btn_confirm
                    }
                }).then(function (t) {
                    if (t.isConfirmed && data.status == 200) {
                        document.location.href = data.redirect;
                    }
                });
            }
        });
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTAccountSettingsDeactivateAccount.init();
});
