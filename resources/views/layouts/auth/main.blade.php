<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{ url('/') }}/"/>
    <title>{{ ucfirst($setting->meta_title) }}{{ isset($title) ? ' | '.$title : '' }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    

    <!-- UNTUK SEO -->
    <link rel="icon" href="{{ image_check($setting->icon,'setting') }}?v={{ time() }}" type="image/x-icon">
    
    <link href="{{ asset('assets/public/plugins/global/plugins.bundle.css'); }}" rel="stylesheet" type="text/css" />
     <link href="{{ asset('assets/public/css/style.bundle.css') }}" rel="stylesheet" type="text/css">
     <link rel="stylesheet" href="{{ asset('assets/base_color/color.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/auth/css/style.css') }}" type="text/css"/>
    <link href="{{ asset('assets/public/css/custom_pribadi.css'); }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/public/css/loading_custom.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    @yield('content')

    @include('partials.global.loading_modal')
    <script>
        var BASE_URL = "{{ url('/') }}";
        var hostUrl = "{{ asset('assets/admin/') }}";
        var css_btn_confirm = 'btn btn-primary';
        var css_btn_cancel = 'btn btn-danger';
        var image_default = "{{ asset('assets/public/images/user.jpg') }}";
        var csrf_token = "{{ csrf_token() }}";
    </script>

    <script src="{{ asset('assets/public/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/public/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/public/js/mekanik.js') }}"></script>
    <script src="{{ asset('assets/public/js/function.js') }}"></script>
    <script src="{{ asset('assets/public/js/global.js') }}"></script>
    <script src="{{ asset('assets/auth/js/script.js') }}"></script>
    <script src="{{ asset('assets/auth/js/modul/login.js') }}"></script>
    <script src="{{ asset('assets/auth/js/modul/register.js') }}"></script>
</body>

</html>