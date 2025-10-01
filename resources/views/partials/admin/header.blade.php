<!--begin::Header-->
<div id="kt_header" class="header align-items-stretch">
    <!--begin::Container-->
    <div class="container-xxl d-flex align-items-stretch justify-content-between">
    <!--begin::Brand-->
    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 w-lg-225px me-5">
        <!--begin::Aside mobile toggle-->
        <div class="btn btn-icon btn-active-icon-primary ms-n2 me-2 d-flex d-lg-none" id="kt_aside_toggle">
        <i class="ki-duotone ki-abstract-14 fs-1">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
        </div>
        <!--end::Aside mobile toggle-->
        <!--begin::Logo-->
        <a href="{{ url('/') }}">
            @if($setting->logo  && file_exists(public_path('data/setting/' . $setting->logo )))
                <img alt="Logo" src="{{ asset('data/setting/' . $setting->logo ) }}" class="h-50px" />
            @endif
        </a>
        
        <!--end::Logo-->
    </div>
    <!--end::Brand-->
    <!--begin::Wrapper-->
    <div class="d-flex align-items-stretch justify-content-end flex-lg-grow-1">
        <!--begin::Toolbar wrapper-->
        <div class="d-flex align-items-stretch flex-shrink-0">
        <!--begin::User-->
        <div class="d-flex align-items-center ms-lg-5" id="">
            <!--begin::User info-->
            <div class="btn btn-active-light d-flex align-items-center bg-hover-light py-2 px-2 px-md-3">
            <!--begin::Symbol-->
            <div class="symbol symbol-30px symbol-md-40px">
                <img src="{{ image_check('user.jpg','default','user') }}" alt="image" />
            </div>
            <!--end::Symbol-->
            </div>
            <!--end::User info-->
        </div>
        <!--end::User -->
        <!--begin::Header menu toggle-->
        <div class="d-flex d-lg-none align-items-center" title="Show header menu">
            <button class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_header_menu_mobile_toggle">
            <i class="ki-duotone ki-text-align-left fs-1 fw-bold">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
                <span class="path4"></span>
            </i>
            </button>
        </div>
        <!--end::Header menu toggle-->
        </div>
        <!--end::Toolbar wrapper-->
    </div>
    <!--end::Wrapper-->
    </div>
    <!--end::Container-->
</div>
<!--end::Header-->