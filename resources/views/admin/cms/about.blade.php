@extends('layouts.admin.main')

@push('script')
<script src="{{ asset('assets/admin/js/modul/cms/about.js'); }}"></script>
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
                <h3 class="fw-bold m-0">Deskripsi About (Halaman Home)</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="pane_ubah_profile" class="collapse show">
            <!--begin::Form-->
            <form id="form_simpan_about_1" method="POST" action="{{ route('update.about_1') }}" class="form">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                            <!--begin::Image input-->
                            <div class="image-input image-input-outline" data-kt-image-input="true" style="background-position : center; background-size : cover;background-image: url('{{ image_check('notfound.jpg', 'default') }}')">
                                <!--begin::Preview existing image-->
                                <div class="image-input-wrapper w-300px h-150px" style="background-position : center; background-size : cover;background-image: url('{{ image_check($setting->image_about, 'setting') }}')"></div>
                                <!--end::Preview existing image-->
                                <!--begin::Label-->
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change image">
                                    <i class="ki-duotone ki-pencil fs-7">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <!--begin::Inputs-->
                                    <input type="file" name="image_about" accept=".png, .jpg, .jpeg, .webp" />
                                    <input type="hidden" name="image_remove" />
                                    <input type="hidden" name="name_image_about" value="{{ $setting->image_about }}">
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
                        </label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                             <div class="w-100 d-flex justify-content-start align-items-center mb-10">
                                @if($language->isNotEmpty())
                                @foreach($language AS $row)
                                <button type="button" onclick="setLangContent(this,{{ $row->id_language }})" class="lang_button badge {{ ($row->default == 'Y') ? 'badge-primary' : 'badge-secondary'  }}  py-2 px-7 me-3 mb-2" style="border : none;">{{ $row->name }}</button>
                                @endforeach
                                @endif
                            </div>

                            
                            @if($language->isNotEmpty())
                            @foreach($language AS $row)
                            <!--begin::Input group-->
                            <div class="fv-row mb-7 content_lang cross_lang_{{ $row->id_language }} {{ ($row->default == 'Y') ? '' : 'd-none' }}">
                                
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Deskripsi ({{ $row->name }})</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="about_1_{{ $row->id_language }}" id="about_1_{{ $row->id_language }}" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Deskripsi ({{ $row->name }})">{{ (isset($about[$row->id_language]['about_1'])) ? $about[$row->id_language]['about_1'] : '' }}</textarea>
                                <!--end::Input-->
                                
                                
                            </div>
                            <!--end::Input group-->
                            @endforeach
                            @endif
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Card body-->
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <?php
                        $arr_editor = [];
                        if ($language->isNotEmpty()) {
                            foreach ($language as $row) {
                                $arr_editor[] = 'about_1_'.$row->id_language;
                            }
                        
                        }
                        $ae = implode(',',$arr_editor);
                    ?>
                    <button type="button" class="btn btn-primary" data-loader="big" data-editor_two="<?= $ae ?>" id="button_simpan_about_1" onclick="submit_form(this,'#form_simpan_about_1')">Simpan</button>
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Basic info-->

    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button">
            <!--begin::Card title-->
            <div class="card-title m-0 d-flex justify-content-between align-items-center w-100">
                <h3 class="fw-bold m-0">Deskripsi About (Halaman About)</h3>
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <?php
                        $arr_editor_2 = [];
                        if ($language->isNotEmpty()) {
                            foreach ($language as $row) {
                                $arr_editor_2[] = 'about_2_'.$row->id_language;
                            }
                        
                        }
                        $ae2 = implode(',',$arr_editor_2);
                    ?>
                    <button type="submit" class="btn btn-primary" data-loader="big" data-editor_two="<?= $ae2 ?>" id="button_simpan_about_2" onclick="submit_form(this,'#form_simpan_about_2')">Simpan</button>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="pane_ubah_profile" class="collapse show">
            
            <!--begin::Form-->
            <form id="form_simpan_about_2" method="POST" action="{{ route('update.about_2') }}" class="form">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div class="w-100 d-flex justify-content-start align-items-center mb-10">
                        @if($language->isNotEmpty())
                        @foreach($language AS $row)
                        <button type="button" onclick="setLangContent2(this,{{ $row->id_language }})" class="lang_button_2 badge {{ ($row->default == 'Y') ? 'badge-primary' : 'badge-secondary'  }}  py-2 px-7 me-3 mb-2" style="border : none;">{{ $row->name }}</button>
                        @endforeach
                        @endif
                    </div>
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        @if($language->isNotEmpty())
                        @foreach($language AS $row)
                        <!--begin::Col-->
                        <div class="col-lg-12 content_lang_2 cross_lang_2_{{ $row->id_language }} {{ ($row->default == 'Y') ? '' : 'd-none' }}">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7" id="req_about_2_{{ $row->id_language }}">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Deskripsi ({{ $row->name }})</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="about_2_{{ $row->id_language }}" id="about_2_{{ $row->id_language }}" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Deskripsi ({{ $row->name }})">{{ (isset($about[$row->id_language]['about_2'])) ? $about[$row->id_language]['about_2'] : '' }}</textarea>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->
                        @endforeach
                        @endif
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Card body-->
                
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Basic info-->
</div>
<!--end::Container-->
@endsection