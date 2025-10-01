

$('[id^="about_1_"]').each(function () {
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


$('[id^="about_2_"]').each(function () {
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
                'link',            // insert link
                'imageUpload',     // upload image
                "mediaEmbed",
                '|',
                "bulletedList", 
                "numberedList",
                'alignment:left',
                'alignment:center',
                'alignment:right',
                "|", "blockQuote", "insertTable"
            ]
        },
        alignment: {
            options: ['left', 'center', 'right'],
            isEnabled: true
        },
        fontSize: {
            options: [10, 15, 20, 25, 30, 35, 40, 45, 50],
            supportAllValues: true
        },
        language: 'en',
        extraPlugins: [ MyCustomUploadAdapterPlugin ] // nanti plugin ini handle Base64
    }).then(editor => {
        textarea.ckeditorInstance = editor;
    }).catch(error => {
        console.error(error);
    });
});



// Plugin untuk Base64 upload
function MyCustomUploadAdapterPlugin(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new Base64UploadAdapter(loader);
    };
}

class Base64UploadAdapter {
    constructor(loader) {
        this.loader = loader;
    }
    upload() {
        return this.loader.file
            .then(file => new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = () => resolve({ default: reader.result });
                reader.onerror = err => reject(err);
                reader.readAsDataURL(file); // ubah ke Base64
            }));
    }
    abort() {}
}



function setLangContent(element, id) {
    $('.lang_button').removeClass('badge-primary');
    $('.lang_button').addClass('badge-secondary');

    $(element).addClass('badge-primary');
    $(element).removeClass('badge-secondary');

    $('.content_lang').addClass('d-none');

    $('.cross_lang_'+id).removeClass('d-none');
}

function setLangContent2(element,id) {
    $('.lang_button_2').removeClass('badge-primary');
    $('.lang_button_2').addClass('badge-secondary');

    $(element).addClass('badge-primary');
    $(element).removeClass('badge-secondary');

    $('.content_lang_2').addClass('d-none');

    $('.cross_lang_2_'+id).removeClass('d-none');
}