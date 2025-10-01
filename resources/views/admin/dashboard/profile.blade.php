@extends('layouts.admin.main')

@push('script')
<script src="{{ asset('assets/admin/js/modul/dashboard/profile.js'); }}"></script>
<script src="{{ asset('assets/admin/js/modul/dashboard/deactivated.js'); }}"></script>
@endpush


@section('content')
<!--begin::Container-->
<div class="container-xxl" id="kt_content_container">
    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Detail Profil</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="pane_ubah_profile" class="collapse show">
            <!--begin::Form-->
            <form id="form_ubah_profile" method="POST" action="{{ route('admin.profile.update') }}" class="form">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Foto</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Image input-->
                            <div class="image-input image-input-outline" data-kt-image-input="true" style="background-position : center; background-size : cover;background-image: url('{{ image_check('user.jpg', 'user','user') }}')">
                                <!--begin::Preview existing image-->
                                <div class="image-input-wrapper w-125px h-125px" style="background-position : center; background-size : cover;background-image: url('{{ image_check(session(config('session.prefix') . '_image'), 'user','user') }}')"></div>
                                <!--end::Preview existing image-->
                                <!--begin::Label-->
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change image">
                                    <i class="ki-duotone ki-pencil fs-7">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <!--begin::Inputs-->
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="image_remove" />
                                    <input type="hidden" name="name_image" value="{{ $result->image; }}">
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Label-->
                                <!--begin::Cancel-->
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel image">
                                    <i class="ki-duotone ki-cross fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <!--end::Cancel-->
                                <!--begin::Remove-->
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                    <i class="ki-duotone ki-cross fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <!--end::Remove-->
                            </div>
                            <!--end::Image input-->
                            <!--begin::Hint-->
                            <div class="form-text">File didukung: png, jpg, jpeg.</div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nama Lengkap</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row" id="req_name">
                            <input type="text" name="name" class="form-control form-control-lg form-control-solid" placeholder="Masukkan nama lengkap" value="{{$result->name;}}" />
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Card body-->
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary" data-loader="big" id="button_simpan_profile" onclick="submit_form(this,'#form_ubah_profile')">Simpan</button>
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Basic info-->
    <!--begin::Sign-in Method-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Metode Akses Akun</h3>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_signin_method" class="collapse show">
            <!--begin::Card body-->
            <div class="card-body border-top p-9">
                <!--begin::Email Address-->
                <div class="d-flex flex-wrap align-items-center">
                    <!--begin::Label-->
                    <div id="kt_signin_email">
                        <div class="fs-6 fw-bold mb-1">Alamat Email</div>
                        <div id="display_email" class="fw-semibold text-gray-600">{{$result->email;}}</div>
                    </div>
                    <!--end::Label-->
                    <!--begin::Edit-->
                    <div id="pane_update_email" class="flex-row-fluid d-none">
                        <!--begin::Form-->
                        <form id="form_update_email" method="POST" action="{{ route('email.update'); }}" class="form" novalidate="novalidate">
                            <div class="row mb-6">
                                <div class="col-lg-6 mb-4 mb-lg-0">
                                    <div class="fv-row mb-0">
                                        <label for="email" class="form-label fs-6 fw-bold mb-3">Masukkan Alamat Email</label>
                                        <input type="email" class="form-control form-control-lg form-control-solid" id="email" placeholder="Alamat Email" name="email" value="{{$result->email;}}" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="fv-row mb-0">
                                        <label for="password" class="form-label fs-6 fw-bold mb-3">Konfirmasi Kata Sandi</label>
                                        <input type="password" class="form-control form-control-lg form-control-solid" name="password" id="password" />
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <button id="button_update_email" type="button" class="btn btn-primary me-2 px-6">simpan</button>
                                <button id="button_cancel_update_email" type="button" class="btn btn-color-gray-500 btn-active-light-primary px-6">Batal</button>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Edit-->
                    <!--begin::Action-->
                    <div id="kt_signin_email_button" class="ms-auto">
                        <button class="btn btn-light btn-active-light-primary">Ubah Email</button>
                    </div>
                    <!--end::Action-->
                </div>
                <!--end::Email Address-->
                <!--begin::Separator-->
                <div class="separator separator-dashed my-6"></div>
                <!--end::Separator-->
                <!--begin::Password-->
                <div class="d-flex flex-wrap align-items-center mb-10">
                    <!--begin::Label-->
                    <div id="kt_signin_password">
                        <div class="fs-6 fw-bold mb-1">Kata Sandi</div>
                        <div class="fw-semibold text-gray-600">************</div>
                    </div>
                    <!--end::Label-->
                    <!--begin::Edit-->
                    <div id="pane_update_password" class="flex-row-fluid d-none">
                        <!--begin::Form-->
                        <form id="form_update_password" method="POST" action="{{ route('password.update') }}" class="form" novalidate="novalidate">
                            <div class="row mb-1">
                                <div class="col-lg-4">
                                    <div class="fv-row mb-0">
                                        <label for="currentpassword" class="form-label fs-6 fw-bold mb-3">Kata Sandi</label>
                                        <input type="password" class="form-control form-control-lg form-control-solid" name="currentpassword" id="currentpassword" />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="fv-row mb-0">
                                        <label for="newpassword" class="form-label fs-6 fw-bold mb-3">Kata Sandi Baru</label>
                                        <input type="password" class="form-control form-control-lg form-control-solid" name="newpassword" id="newpassword" />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="fv-row mb-0">
                                        <label for="confirmpassword" class="form-label fs-6 fw-bold mb-3">Konfirmasi Sandi Baru</label>
                                        <input type="password" class="form-control form-control-lg form-control-solid" name="confirmpassword" id="confirmpassword" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-text mb-5">Kata sandi harus minimal 8 karakter dan mengandung simbol</div>
                            <div class="d-flex">
                                <button id="button_update_password" type="button" class="btn btn-primary me-2 px-6">Ubah Kata Sandi</button>
                                <button id="button_cancel_update_password" type="button" class="btn btn-color-gray-500 btn-active-light-primary px-6">Batal</button>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Edit-->
                    <!--begin::Action-->
                    <div id="kt_signin_password_button" class="ms-auto">
                        <button class="btn btn-light btn-active-light-primary">Ubah Kata Sandi</button>
                    </div>
                    <!--end::Action-->
                </div>
                <!--end::Password-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Sign-in Method-->
    <!--begin::Deactivate Account-->
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_deactivate" aria-expanded="true" aria-controls="kt_account_deactivate">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Non-aktifkan akun</h3>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_deactivate" class="collapse show">
            <!--begin::Form-->
            <form id="form_deactivated" method="POST" action="{{ route('account.deactivated') }}" class="form">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Notice-->
                    <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
                        <!--begin::Icon-->
                        <i class="ki-duotone ki-information fs-2tx text-warning me-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <!--end::Icon-->
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-grow-1">
                            <!--begin::Content-->
                            <div class="fw-semibold">
                                <h4 class="text-gray-900 fw-bold">Anda Menonaktifkan Akun Anda</h4>
                                <div class="fs-6 text-gray-700">Apakah Anda yakin ingin menonaktifkan akun Anda? Akun tersebut akan ditangguhkan dan tidak dapat dibuka kembali.</div>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Notice-->
                    <!--begin::Form input row-->
                    <div class="form-check form-check-solid fv-row">
                        <input name="deactivate" class="form-check-input" type="checkbox" value="" id="deactivate" />
                        <label class="form-check-label fw-semibold ps-2 fs-6" for="deactivate">Saya mengonfirmasi penonaktifan akun saya</label>
                    </div>
                    <!--end::Form input row-->
                </div>
                <!--end::Card body-->
                <!--begin::Card footer-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button id="button_deactivated" type="submit" class="btn btn-danger fw-semibold">Nonaktifkan Akun</button>
                </div>
                <!--end::Card footer-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Deactivate Account-->
</div>
<!--end::Container-->
@endsection