@php
    $segment1 = request()->segment(1);
    $segment2 = request()->segment(2);
@endphp
<!--begin::Aside-->
<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
    <!--begin::Logo-->
    <div class="aside-logo flex-column-auto pt-10 pt-lg-10" id="kt_aside_logo">
        <a href="{{ route('dashboard') }}">
            @if($setting->icon  && file_exists(public_path('data/setting/' . $setting->icon )))
                <img alt="Logo" src="{{ asset('data/setting/' . $setting->icon ) }}" class="h-60px" />
            @endif
        </a>
    </div>
    <!--end::Logo-->
    <!--begin::Nav-->
    <div class="aside-menu flex-column-fluid pt-0 pb-7 py-lg-10 d-flex justify-content-start align-items-start" id="kt_aside_menu">
        <!--begin::Aside menu-->
        <div id="kt_aside_menu_wrapper" class=" w-100 hover-scroll-y scroll-lg-ms d-flex" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu" data-kt-scroll-offset="0">
            <div id="kt_aside_menu" class="menu menu-column menu-title-gray-600 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-icon-gray-500 menu-arrow-gray-500 fw-semibold fs-6 my-auto" data-kt-menu="true">
                <!--begin:Menu item-->
                <div data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Dashboard" class="menu-item {{ ($segment1 == 'dashboard') ? 'here show' : '' }}  py-2">
                    <!--begin:Menu link-->
                    <a href="{{ route('dashboard') }}" class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="ki-duotone ki-home-2 fs-2x">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="User" class="menu-item {{ ($segment1 == 'master' && $segment2 == 'user') ? 'here show' : '' }}  py-2">
                    <!--begin:Menu link-->
                    <a href="{{ route('master.user') }}" class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="fa-solid fa-users fs-2x"></i>
                        </span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item {{ ($segment1 == 'cms') ? 'here show' : '' }} py-2">
                    <!--begin:Menu link-->
                    <span class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="fa-solid fa-palette fs-2x"></i>
                        </span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-250px mh-75 overflow-auto">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-section fs-5 fw-bolder ps-1 py-1">CMS</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a href="{{ route('cms.banner') }}" class="menu-link  {{ ($segment1 == 'cms' && $segment2 == 'banner') ? 'active' : '' }}">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-images fs-4"></i>
                                </span>
                                <span class="menu-title">Banner</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a href="{{ route('cms.about') }}" class="menu-link  {{ ($segment1 == 'cms' && $segment2 == 'about') ? 'active' : '' }}">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-address-card fs-4"></i>
                                </span>
                                <span class="menu-title">About</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a href="{{ route('cms.project') }}" class="menu-link  {{ ($segment1 == 'cms' && $segment2 == 'project') ? 'active' : '' }}">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-diagram-project fs-4"></i>
                                </span>
                                <span class="menu-title">Projek</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a href="{{ route('cms.article') }}" class="menu-link  {{ ($segment1 == 'cms' && $segment2 == 'article') ? 'active' : '' }}">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-newspaper fs-4"></i>
                                </span>
                                <span class="menu-title">Artikel</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item {{ ($segment1 == 'master' && $segment2 != 'user') ? 'here show' : '' }} py-2">
                    <!--begin:Menu link-->
                    <span class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="ki-duotone ki-abstract-26 fs-2x">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-250px mh-75 overflow-auto">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-section fs-5 fw-bolder ps-1 py-1">Master</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                       
                        <!--begin:Menu item-->
                        <div class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a href="{{ route('master.unit') }}" class="menu-link  {{ ($segment1 == 'master' && $segment2 == 'unit') ? 'active' : '' }}">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-tags fs-4"></i>
                                </span>
                                <span class="menu-title">Unit</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a href="{{ route('master.location') }}" class="menu-link  {{ ($segment1 == 'master' && $segment2 == 'location') ? 'active' : '' }}">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-location fs-4"></i>
                                </span>
                                <span class="menu-title">Lokasi</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a href="{{ route('master.type') }}" class="menu-link  {{ ($segment1 == 'master' && $segment2 == 'type') ? 'active' : '' }}">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-quote-right fs-4"></i>
                                </span>
                                <span class="menu-title">Tipe</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a href="{{ route('master.facility') }}" class="menu-link  {{ ($segment1 == 'master' && $segment2 == 'facility') ? 'active' : '' }}">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-bed fs-4"></i>
                                </span>
                                <span class="menu-title">Fasilitas</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        
                        
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Kontak" class="menu-item {{ ($segment1 == 'list' && $segment2 == 'contact') ? 'here show' : '' }}  py-2">
                    <!--begin:Menu link-->
                    <a href="{{ route('list.contact') }}" class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="fa-solid fa-address-book fs-2x"></i>
                        </span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Pengaturan" class="menu-item {{ ($segment1 == 'setting') ? 'here show' : '' }} py-2">
                    <!--begin:Menu link-->
                    <a href="{{ route('setting') }}" class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="ki-duotone ki-setting-2 fs-2x">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                
                
            </div>
        </div>
        <!--end::Aside menu-->
    </div>
    <!--end::Nav-->
    <!--begin::Footer-->
    <div class="aside-footer flex-column-auto pb-5 pb-lg-10" id="kt_aside_footer">
        <!--begin::Menu-->
        <div class="d-flex flex-center w-100 scroll-px" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Log Out">
            <a type="button" class="btn btn-custom" href="{{ route('logout') }}" onclick="confirm_alert(this, event, 'Are you sure you want to leave the system?')">
                <i class="ki-duotone ki-entrance-left fs-2x">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </a>
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Footer-->
</div>
<!--end::Aside-->