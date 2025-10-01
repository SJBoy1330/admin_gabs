<!--begin::Form-->
<!--begin::Scroll-->
<div class="d-flex flex-column me-n7 pe-7" id="#">
    <!--begin::Input group-->
    <div class="fv-row mb-7 d-flex justify-content-center align-items-center flex-column">
        <!--begin::Label-->
        <label class="d-block fw-semibold fs-6 mb-5 required">Gambar</label>
        <!--end::Label-->
        <!--begin::Image input-->
        <div class="image-input background-partisi" data-kt-image-input="true" style="background-image: url('<?= image_check('notfound.jpg','default') ?>')">
            <!--begin::Image preview wrapper-->
            <div id="display_image" class="image-input-wrapper w-250px h-200px background-partisi" style="background-image: url('<?= (isset($result->image)) ? image_check($result->image,'gallery') : image_check('notfound.jpg','default') ?>')"></div>
            <!--end::Image preview wrapper-->

            <!--begin::Edit button-->
            <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Edit">
                <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>

                <!--begin::Inputs-->
                <input type="file" name="image" accept=".png, .jpg, .jpeg, .webp" />
                <input type="hidden" name="avatar_remove" />
                <input type="hidden" name="name_image" value="{{ (isset($result->image)) ? $result->image : 0 }}" />
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
    <input type="hidden" name="id_project_gallery" value="{{ (isset($result->id_project_gallery)) ? $result->id_project_gallery : 0 }}">


    @if($language->isNotEmpty())
    @foreach($language AS $row)
    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <!--begin::Label-->
        <label class="required fw-semibold fs-6 mb-2">Nama Galeri <span class="text-primary">({{ $row->name }})</span></label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" name="name_{{ $row->id_language }}" value="{{ optional($result?->details->firstWhere('id_language', $row->id_language))->name ?? '' }}" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Nama Galeri ({{ $row->name }})" autocomplete="off" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    @endforeach
    @endif
</div>
<!--end::Scroll-->
<!--begin::Actions-->
<div class="text-center pt-15">
    <button type="button" id="submit_project_gallery" data-loader="big" onclick="submit_form(this,'#form_gallery')" class="btn btn-primary">
        <span class="indicator-label">Simpan</span>
    </button>
</div>
<!--end::Actions-->

<script src="{{ asset('assets/public/plugins/global/plugins.bundle.js'); }}"></script>
<script src="{{ asset('assets/public/js/scripts.bundle.js'); }}"></script>