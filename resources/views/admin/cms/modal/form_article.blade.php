<!--begin::Scroll-->
<div class="row me-n7 pe-7" id="#">
    <div class="col-md-5 col-lg-5 col-sm-12">
        <!--begin::Input group-->
        <div class="fv-row mb-7 d-flex justify-content-center align-items-center flex-column">
            <!--begin::Label-->
            <label class="d-block fw-semibold fs-6 mb-5 required">Gambar</label>
            <!--end::Label-->
            <!--begin::Image input-->
            <div class="image-input background-partisi" data-kt-image-input="true" style="background-image: url('<?= image_check('notfound.jpg','default') ?>')">
                <!--begin::Image preview wrapper-->
                <div id="display_image" class="image-input-wrapper w-200px h-150px background-partisi" style="background-image: url('<?= (isset($result->image)) ? image_check($result->image,'article') : image_check('notfound.jpg','default') ?>')"></div>
                <!--end::Image preview wrapper-->

                <!--begin::Edit button-->
                <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Edit">
                    <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>

                    <!--begin::Inputs-->
                    <input type="file" name="image" accept=".png, .jpg, .jpeg, .webp" />
                    <input type="hidden" name="avatar_remove" />
                    <input type="hidden" name="name_image" value="{{ (isset($result->image)) ? $result->image : 0 }}">
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
    </div>
    <div class="col-md-7 col-lg-7 col-sm-12">
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
        <div class="fv-row mb-7 content_lang cross_lang_<?= $row->id_language ?> {{ ($row->default == 'Y') ? '' : 'd-none' }}" id="req_description_<?= $row->id_language ?>">
            <!--begin::Label-->
            <label class="required fw-semibold fs-6 mb-2">Judul ({{ $row->name }})</label>
            <!--end::Label-->
            <input type="text" name="title_<?= $row->id_language ?>" id="name_<?= $row->id_language ?>" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Judul ({{ $row->name }})" value="{{ optional($result?->details->firstWhere('id_language', $row->id_language))->title ?? '' }}" required autocomplete="off">
        </div>
        <!--end::Input group-->
        @endforeach
        @endif
        
        @if($language->isNotEmpty())
        @foreach($language AS $row)
        <!--begin::Input group-->
        <div class="fv-row mb-7 content_lang cross_lang_<?= $row->id_language ?> {{ ($row->default == 'Y') ? '' : 'd-none' }}" id="req_short_description_<?= $row->id_language ?>">
            <!--begin::Label-->
            <label class="required fw-semibold fs-6 mb-2">Deskripsi Singkat ({{ $row->name }})</label>
            <!--end::Label-->
            <textarea name="short_description_<?= $row->id_language ?>" id="short_description_<?= $row->id_language ?>" cols="30" rows="3" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Deskripsi Pendek ({{ $row->name }})">{{ optional($result?->details->firstWhere('id_language', $row->id_language))->short_description ?? '' }}</textarea>
        </div>
        <!--end::Input group-->
        @endforeach
        @endif
    </div>
    
    <div class="col-md-12 col-lg-12 col-sm-12">
        
        @if($language->isNotEmpty())
        @foreach($language AS $row)
        <!--begin::Input group-->
        <div class="fv-row mb-7 content_lang cross_lang_<?= $row->id_language ?> {{ ($row->default == 'Y') ? '' : 'd-none' }}" id="req_description_<?= $row->id_language ?>">
            <!--begin::Label-->
            <label class="required fw-semibold fs-6 mb-2">Deskripsi ({{ $row->name }})</label>
            <!--end::Label-->
            <textarea name="description_<?= $row->id_language ?>" id="description_<?= $row->id_language ?>" cols="30" rows="10" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Deskripsi">{{ optional($result?->details->firstWhere('id_language', $row->id_language))->description ?? '' }}</textarea>
        </div>
        <!--end::Input group-->
        @endforeach
        @endif
    </div>
    
    <input type="hidden" name="id_article" value="{{ (isset($result->id_article)) ? $result->id_article : 0 }}">
    

</div>
<!--end::Scroll-->

<?php
    $arr_editor = [];
    if ($language->isNotEmpty()) {
        foreach ($language as $row) {
             $arr_editor[] = 'description_'.$row->id_language;
        }
       
    }
    $ae = implode(',',$arr_editor);
?>
<!--begin::Actions-->
<div class="text-center pt-15">
    <button type="button" id="submit_article" data-loader="big" data-editor_two="<?= $ae; ?>" onclick="submit_form(this,'#form_article')" class="btn btn-primary">
        <span class="indicator-label">Simpan</span>
    </button>
</div>
<!--end::Actions-->


<script src="{{ asset('assets/public/plugins/global/plugins.bundle.js'); }}"></script>
<script src="{{ asset('assets/public/js/scripts.bundle.js'); }}"></script>