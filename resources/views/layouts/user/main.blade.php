<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
@include('partials.user.header')
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
    
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                @include('partials.user.navbar')

                <!--begin::Container-->
                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl p-0">
                    <!--begin::Post-->
                    <div class="content flex-row-fluid p-0" id="kt_content">
                         @yield('content')
                    </div>
                    <!--end::Post-->
                </div>
                <!--end::Container-->
                @include('partials.user.footer')
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>

    @include('partials.global.loading_modal')
    @include('partials.global.modal_embed')
    <!--end::Root-->
    @include('partials.user.tail')
</body>
<!--end::Body-->

</html>