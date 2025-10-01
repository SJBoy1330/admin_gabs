@extends('layouts.admin.main')

@push('script')
<script src="{{ asset('assets/admin/js/modul/cms/gallery.js') }}"></script>
@endpush


@section('content')
<!--begin::Container-->
<div class="container-xxl" id="kt_content_container">
    <!--begin::gallerys-->
    <div class="card card-flush mb-10">
        <!--begin::Card body-->
        <div class="card-body pt-10 table-responsive">
            <!--begin::Table-->
            <table class="table align-middle table-bordered fs-6 gy-5">
                <tbody class="fw-semibold text-gray-600">
                    <tr>
                        <td rowspan="4" style="width : 200px">
                            <div class="rounded background-partisi" style="background-image : url('{{ image_check($result->image,'project') }}');width : 200px;height : 150px"></div>
                        </td>
                        <td style="width : 150px"><b>Nama</b></td>
                        <td>{{ ucwords($result->name) }}</td>
                    </tr>
                    <tr>
                         <td style="width : 150px"><b>Unit</b></td>
                        <td>{{ ucwords($result->unit->name) }}</td>
                    </tr>
                    <tr>
                         <td style="width : 150px"><b>Tipe</b></td>
                        <td>{{ ucwords($result->type->name) }}</td>
                    </tr>
                    <tr>
                         <td style="width : 150px"><b>Lokasi</b></td>
                        <td>{{ ucwords($result->location->name) }}</td>
                    </tr>
                </tbody>
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
        <div class="card-footer">
            <div class="w-100 d-flex justify-content-end align-items-center">
                 <!--begin::Add gallery-->
                <a role="button"  onclick="action_data()" data-bs-toggle="modal" data-bs-target="#kt_modal_gallery"  class="btn btn-primary">Tambah Galeri</a>
                <!--end::Add gallery-->
            </div>
        </div>
    </div>
    <!--end::gallerys-->
    <!--begin::gallerys-->
    <div class="card card-flush">
        <!--begin::Card body-->
        <div class="card-body pt-10">
           
            <div class="row w-100">
                @if($gallery->isNotEmpty())
                @foreach($gallery AS $row)
                <div class="col-md-4 col-lg-4 col-sm-12">
                    <div class="w-100 table-responsive">
                        <table class="table table-bordered w-100">
                            <tr>
                                <td colspan="2"><div class="rounded background-partisi mb-2" style="background-image : url('{{ image_check($row->image,'gallery') }}');width : 100%;height : 200px"></div></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="w-100 d-flex justify-content-center align-items-center">
                                        <button type="button" class="btn btn-icon btn-warning btn-sm me-1" title="Update" 
                                                onclick="action_data({{ $row->id_project_gallery }})"  
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_gallery">
                                            <i class="ki-outline ki-pencil fs-2"></i>
                                        </button>
                                        <button type="button" data-reload="big" onclick="hapus_data(this,event,{{ $row->id_project_gallery }},`project_galleries`,`id_project_gallery`)" class="btn btn-icon btn-danger btn-sm me-1" title="Delete">
                                            <i class="ki-outline ki-trash fs-2"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @if($language->isNotEmpty())
                            @foreach($language AS $key)
                            <tr>
                                <td>
                                    <span class="text-primary fs-5">{{ ucwords($key->name) }}</span>
                                </td>
                                <td>
                                    <span class="text-muted fs-5">{{ optional($row?->details->firstWhere('id_language', $key->id_language))->name ?? '' }}</span>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </table>
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-12">
                    <div class="w-100 d-flex justify-content-center align-items-center flex-column">
                        <div class="background-partisi-contain mb-3" style="width : 200px;height : 200px;background-image: url('{{ image_check('empty.svg','default') }}')"></div>
                        <h3 class="text-primary">Tidak Ada Asset</h3>
                        <p class="text-muted text-center" style="max-width : 400px">Belum ada gallery yang di tambahkan! Sialhkan tambahkan gallery baru atau hubungi admin jika terjadi kesalahan</p>
                    </div>
                </div>
                @endif
            </div>
           
        </div>
        <!--end::Card body-->
    </div>
    <!--end::gallerys-->
</div>
<!--end::Container-->


<!-- Modal Tambah gallery -->
<div class="modal fade" id="kt_modal_gallery" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title_modal" data-title="Edit Galeri|Tambah Galeri"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body mx-5 mx-xl-15 my-7">
                
                <form id="form_gallery" class="form" action="{{ route('insert.gallery') }}"  method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_project" value="{{ $id_project }}">
                    <div id="display_form_gallery"></div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection