@extends('layouts.admin.main')

@push('script')
<script src="{{ asset('assets/admin/js/modul/master/user.js') }}"></script>
@endpush


@section('content')

<!--begin::Container-->
<div class="container-xxl" id="kt_content_container">
    <!--begin::users-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" class="form-control form-control-solid w-250px ps-12 search-datatable" placeholder="Search"  />
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                <div class="w-100 mw-150px">
                    
                    <!--begin::Select2-->
                    <select onchange="filter_status(this)" class="form-select form-select-solid table-filter" data-control="select2">
                        <option value="all">Semua</option>
                        <option value="Y">Aktif</option>
                        <option value="N">Non-Aktif</option>
                    </select>
                    <!--end::Select2-->
                </div>
                <!--begin::Add user-->
                <a role="button"  onclick="tambah_data()" data-bs-toggle="modal" data-bs-target="#kt_modal_user"  class="btn btn-primary">Tambah User</a>
                <!--end::Add user-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 table-responsive">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="table_user" data-url="{{ route('table.user') }}">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-10px pe-2" data-orderable="false" data-searchable="false">No</th>
                        <th class="min-w-200px">User</th>
                        <th class="min-w-200px">Kontak</th>
                        <th class="text-center min-w-100px" data-searchable="false">Status</th>
                        <th class="text-end min-w-70px" data-orderable="false" data-searchable="false">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                </tbody>
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::users-->
</div>
<!--end::Container-->



<!-- Modal Tambah user -->
<div class="modal fade" id="kt_modal_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title_modal" data-title="Edit User|Tambah User"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="form_user" class="form" action="{{ route('insert.user') }}"  method="POST" enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column me-n7 pe-7" id="#">

                        <!--begin::Input group-->
                        <div class="fv-row mb-7 d-flex justify-content-center align-items-center flex-column">
                            <!--begin::Label-->
                            <label class="d-block fw-semibold fs-6 mb-5">Foto</label>
                            <!--end::Label-->
                            <!--begin::Image input-->
                            <div class="image-input image-input-circle background-partisi" data-kt-image-input="true" style="background-image: url('<?= image_check('user.jpg','default') ?>')">
                                <!--begin::Image preview wrapper-->
                                <div id="display_image" class="image-input-wrapper w-125px h-125px background-partisi" style="background-image: url('<?= image_check('user.jpg','default') ?>')"></div>
                                <!--end::Image preview wrapper-->

                                <!--begin::Edit button-->
                                <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Edit">
                                    <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>

                                    <!--begin::Inputs-->
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg, .webp" />
                                    <input type="hidden" name="avatar_remove" />
                                    <input type="hidden" name="name_image" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Edit button-->

                                <!--begin::Cancel button-->
                                <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow hps_image" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Cancel">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <!--end::Cancel button-->

                                <!--begin::Remove button-->
                                <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow hps_image" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Delete">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <!--end::Remove button-->
                            </div>
                            <!--end::Image input-->
                            <!--begin::Hint-->
                            <div class="form-text">Tipe: png, jpg, jpeg.</div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Input group-->

                        <input type="hidden" name="id_user">
                        <input type="hidden" name="role" value="2">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_name">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Nama Lengkap</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Nama Lengkap" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_phone">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Nomor Telepon</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="phone" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Nomor Telepon" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_email">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Alamat Email</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Alamat Email" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_password">
                            <!--begin::Label-->
                            <label class="required password fw-semibold fs-6 mb-2">Kata Sandi</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="password" name="password" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Kata Sandi" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_repassword">
                            <!--begin::Label-->
                            <label class="required password fw-semibold fs-6 mb-2">Konfirmasi Kata Sandi</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="password" name="repassword" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Konfirmasi Kata Sandi" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="button" id="submit_user" onclick="submit_form(this,'#form_user')" class="btn btn-primary">
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

@endsection