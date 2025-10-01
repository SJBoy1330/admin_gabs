@extends('layouts.admin.main')

@push('script')
<script src="{{ asset('assets/admin/js/modul/master/facility.js') }}"></script>
@endpush


@section('content')

<!--begin::Container-->
<div class="container-xxl" id="kt_content_container">
    <!--begin::facilitys-->
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
                <!--begin::Add facility-->
                <a role="button"  onclick="action_data()" data-bs-toggle="modal" data-bs-target="#kt_modal_facility"  class="btn btn-primary">Tambah Fasilitas</a>
                <!--end::Add facility-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 table-responsive">
            <!--begin::Table-->
            <table class="table align-middle table-bordered fs-6 gy-5" id="table_facility" data-url="{{ route('table.facility') }}">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th style="width : 80px;" data-orderable="false" data-searchable="false">Aksi</th>
                        <th style="width : 100px" data-orderable="false" data-searchable="false">Icon</th>
                        <th class="min-w-200px" data-orderable="false" data-searchable="false">Fasilitas</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                </tbody>
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::facilitys-->
</div>
<!--end::Container-->



<!-- Modal Tambah facility -->
<div class="modal fade" id="kt_modal_facility" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title_modal" data-title="Edit Fasilitas|Tambah Fasilitas"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body mx-5 mx-xl-15 my-7">
                
                <form id="form_facility" class="form" action="{{ route('insert.facility') }}"  method="POST" enctype="multipart/form-data">
                    <div id="display_form_facility"></div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection