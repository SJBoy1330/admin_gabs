@extends('layouts.admin.main')

@push('script')
<script src="{{ asset('assets/admin/js/modul/setting/logo.js') }}"></script>';
<script src="{{ asset('assets/admin/js/modul/setting/umum.js') }}"></script>';
@endpush


@section('content')
<!--begin::Container-->
<div class="container-xxl" id="kt_content_container">
    <!--begin::Card-->
    <div class="card card-flush">
        <!--begin::Card body-->
        <div class="card-body">
            <!--begin:::Tabs-->
            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x border-transparent fs-4 fw-semibold mb-15">
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a onclick="set_url_params('umum')" class="nav-link text-active-primary d-flex align-items-center pb-5 @if(!$page || $page == 'umum') active @endif" data-bs-toggle="tab" href="#general_pane">
                        <i class="ki-duotone ki-home fs-2 me-2"></i>Umum
                    </a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a onclick="set_url_params('seo')" class="nav-link text-active-primary d-flex align-items-center pb-5 @if($page == 'seo') active @endif" data-bs-toggle="tab" href="#seo_pane">
                        <i class="fa-brands fa-searchengin fs-2 me-2"></i>SEO
                    </a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a onclick="set_url_params('sosmed')" class="nav-link text-active-primary d-flex align-items-center pb-5 @if($page == 'sosmed') active @endif" data-bs-toggle="tab" href="#sosmed_pane">
                        <i class="fa-solid fa-hashtag fs-2 me-2"></i>Sosial Media
                    </a>
                </li>
                <!--end:::Tab item-->
            </ul>
            <!--end:::Tabs-->

            <!--begin:::Tab content-->
            <div class="tab-content" id="tab_pane">
                <!--begin:::Tab pane-->
                <div class="tab-pane fade @if(!$page || $page == 'umum') show active @endif" id="general_pane" role="tabpanel">
                    @include('admin.setting.page.logo')
                </div>
                <!--end:::Tab pane-->

                <!--begin:::Tab pane-->
                <div class="tab-pane fade @if($page == 'seo') show active @endif" id="seo_pane" role="tabpanel">
                    @include('admin.setting.page.seo')
                </div>
                <!--end:::Tab pane-->

                <!--begin:::Tab pane-->
                <div class="tab-pane fade @if($page == 'sosmed') show active @endif" id="sosmed_pane" role="tabpanel">
                    @include('admin.setting.page.sosmed')
                </div>
                <!--end:::Tab pane-->
            </div>
            <!--end:::Tab content-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</div>
<!--end::Container-->


<!--begin::Modal-->
<div class="modal fade" id="kt_modal_sosmed" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title_modal_sosmed" data-title="Tambah Sosial Media|Edit Sosmed"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="form_sosmed" class="form" action="{{ route('insert.sosmed') }}" method="POST" enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column me-n7 pe-7">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_sosmed_icon">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Icon</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="icon" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Kode Icon" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <input type="hidden" name="id_sosmed">

                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_sosmed_name">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Nama</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Nama" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->

                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="button" id="submit_sosmed" data-loader="big" onclick="submit_form(this,'#form_sosmed')" class="btn btn-primary">
                            <span class="indicator-label">Simpan</span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->
@endsection