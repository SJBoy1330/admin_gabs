<head>
    <base href="../" />
    <title>{{ (isset($setting->meta_title)) ? ucwords($setting->meta_title) : '' }}{{ (isset($title)) ? ' | '.$title : '' }}</title>
    <meta charset="utf-8" />
    @if(isset($setting->meta_description) && $setting->meta_description)
    <meta name="description" content="{{ $setting->meta_description }}" />
    @endif
    @if(isset($setting->meta_keyword) && $setting->meta_keyword)
    <meta name="keywords" content="{{ $setting->meta_keyword }}" />
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ (isset($setting->meta_title)) ? ucwords($setting->meta_title) : '' }}{{ (isset($title)) ? ' | '.$title : '' }}" />

    @if(isset($setting->icon) && $setting->icon)
    <link rel="shortcut icon" href="{{ image_check($setting->icon,'setting') }}" />
    @endif
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('assets/public/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <link href="{{ asset('assets/public/user/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/user/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/public/css/loading_custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/public/css/custom_pribadi.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/user/css/custom_user.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/user/css/aos.css') }}" rel="stylesheet" type="text/css" />
     <link rel="stylesheet" href="{{ asset('assets/base_color/color.css') }}" />
    <script type="text/javascript" src="{{ asset('assets/public/plugins/ckeditor5/ckeditor.js') }}"></script>
    <script>
        var CKEditor_tool = [
            "heading", 
            "|", 
            "fontSize", "fontFamily", "fontColor", "fontBackgroundColor", 
            "|", 
            "bold", "italic", "underline", "strikethrough", "subscript", "superscript", 
            "|", 
            "alignment", 
            "|", 
            "bulletedList", "numberedList", "todoList", 
            "|", 
            "outdent", "indent", 
            "|", 
            "blockQuote", "insertTable", "codeBlock", 
            "|", 
            "horizontalLine", "specialCharacters", "pageBreak", 
            "|", 
            "undo", "redo", "selectAll", "removeFormat"
        ];

        var font_color =  [
            {
                color: 'hsl(0, 0%, 0%)',
                label: 'Black'
            },
            {
                color : 'hsl(0, 0%, 100%)',
                label : 'White'
            },
            {
                color: 'hsl(0, 75%, 60%)',
                label: 'Red'
            },
            {
                color: 'hsl(120, 75%, 60%)',
                label: 'Green'
            },
            {
                color: 'hsl(240, 75%, 60%)',
                label: 'Blue'
            },
            {
                color: 'hsl(60, 75%, 60%)',
                label: 'Yellow'
            },
            {
                color: 'hsl(235, 85%, 35%)',
                label : 'Primary'
            }
        ];
    </script>
    <style>
        .background-partisi{
            background-position : center !important;
            background-repeat : no-repeat !important;
            background-size :cover !important;
        }
        .background-partisi-contain{
            background-position : center !important;
            background-repeat : no-repeat !important;
            background-size :contain !important;
        }

        .background-partisi-contain-left{
            background-position : left !important;
            background-repeat : no-repeat !important;
            background-size :contain !important;
        }

        .background-partisi-contain-right{
            background-position : right !important;
            background-repeat : no-repeat !important;
            background-size :contain !important;
        }
        .menu-item:hover .menu-title{
            color : var(--bs-primary) !important;
        }
        .menu-item.hover.show .menu-title{
            color : var(--bs-primary) !important;
        }

        .dataTables_empty{
            text-align : center !important;
        }
    </style>
    <!--end::Global Stylesheets Bundle-->
    <?php
    if (isset($css_add) && is_array($css_add)) {
        foreach ($css_add as $css) {
            echo $css;
        }
    } else {
        echo (isset($css_add) && ($css_add != "") ? $css_add : "");
    }
    ?>

    @stack('styles')
</head>