@extends('layouts.admin.main')

@push('script')
<script src="{{ asset('assets/admin/js/modul/cms/article.js') }}"></script>
@endpush


@section('content')

<!--begin::Container-->
<div class="container-xxl" id="kt_content_container">
    <!--begin::articles-->
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
                <!--begin::Add article-->
                <a role="button"  onclick="action_data()" data-bs-toggle="modal" data-bs-target="#kt_modal_article"  class="btn btn-primary">Tambah Artikel</a>
                <!--end::Add article-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 table-responsive">
            <!--begin::Table-->
            <table class="table align-middle table-bordered fs-6 gy-5" id="table_article" data-url="{{ route('table.article') }}">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-10px pe-2" data-orderable="false" data-searchable="false">No</th>
                        <th style="width: 200px" data-orderable="false" data-searchable="false">Gambar</th>
                        <th class="min-w-200px" data-orderable="false" data-searchable="false">Judul</th>
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
    <!--end::articles-->
</div>
<!--end::Container-->



<!-- Modal Tambah article -->
<div class="modal fade" id="kt_modal_article" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered mw-800px">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title_modal" data-title="Edit Artikel|Tambah Artikel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="form_article" class="form" action="{{ route('insert.article') }}"  method="POST" enctype="multipart/form-data">
                    <div id="display_form_article"></div>
                    
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>

@endsection