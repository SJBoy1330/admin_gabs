
<div class="row w-100">
    <div class="col-md-4 col-lg-4 col-sm-12">
        <!--begin::Input group-->
        <div class="fv-row mb-7 d-flex justify-content-center align-items-center flex-column">
            <!--begin::Label-->
            <label class="d-block fw-semibold fs-6 mb-5 required">Gambar</label>
            <!--end::Label-->
            <!--begin::Image input-->
            <div class="image-input background-partisi" data-kt-image-input="true" style="background-image: url('<?= image_check('notfound.jpg','default') ?>')">
                <!--begin::Image preview wrapper-->
                <div id="display_image" class="image-input-wrapper w-200px h-150px background-partisi" style="background-image: url('<?= (isset($result->image)) ? image_check($result->image,'project') : image_check('notfound.jpg','default') ?>')"></div>
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
    <div class="col-md-8 col-lg-8 col-sm-12 mb-3">
        
        <div class="row w-100">
            <div class="col-md-12 col-lg-12 col-sm-12 mb-3">
                <!--begin::Input group-->
                <div class="fv-row mb-7" id="req_name">
                    <!--begin::Label-->
                    <label class="required fw-semibold fs-6 mb-2">Nama Proyek</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" name="name" class="form-control mb-3 mb-lg-0" placeholder="Masukkan Nama Proyek" value="{{ (isset($result->name)) ? $result->name : '' }}" autocomplete="off" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
            </div>
            <div class="col-md-4 col-lg-4 col-sm-12 mb-3">
                <!--begin::Input group-->
                <div class="fv-row mb-7" id="req_id_unit">
                    <!--begin::Label-->
                    <label id="label_id_unit" class="id_unit required fw-semibold fs-6 mb-2">Unit</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select id="select_id_unit" name="id_unit" class="form-select" data-control="select2" data-placeholder="Pilih Unit">
                        <option value=""></option>
                        @if($unit->isNotEmpty())
                        @foreach($unit AS $key)
                            <option value="{{ $key->id_unit }}" <?= (isset($result->id_unit) && $result->id_unit == $key->id_unit) ? 'selected' : '' ?>>{{ $key->name }}</option>
                        @endforeach
                        @endif
                    </select>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
            </div>
            <input type="hidden" name="id_project" value="{{ (isset($result->id_project)) ? $result->id_project : 0 }}">
            <div class="col-md-4 col-lg-4 col-sm-12 mb-3">
                <!--begin::Input group-->
                <div class="fv-row mb-7" id="req_id_type">
                    <!--begin::Label-->
                    <label id="label_id_type" class="id_type required fw-semibold fs-6 mb-2">Tipe</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select id="select_id_type" name="id_type" class="form-select" data-control="select2" data-placeholder="Pilih Tipe">
                        <option value=""></option>
                        @if($type->isNotEmpty())
                        @foreach($type AS $key)
                            <option value="{{ $key->id_type }}"  <?= (isset($result->id_type) && $result->id_type == $key->id_type) ? 'selected' : '' ?>>{{ $key->name }}</option>
                        @endforeach
                        @endif
                    </select>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
            </div>
            <div class="col-md-4 col-lg-4 col-sm-12 mb-3">
                <!--begin::Input group-->
                <div class="fv-row mb-7" id="req_id_location">
                    <!--begin::Label-->
                    <label id="label_id_location" class="id_location required fw-semibold fs-6 mb-2">Lokasi</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select id="select_id_location" name="id_location" class="form-select" data-control="select2" data-placeholder="Pilih Lokasi">
                        <option value=""></option>
                        @if($location->isNotEmpty())
                        @foreach($location AS $key)
                            <option value="{{ $key->id_location }}"  <?= (isset($result->id_location) && $result->id_location == $key->id_location) ? 'selected' : '' ?>>{{ $key->name }}</option>
                        @endforeach
                        @endif
                    </select>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                <!--begin::Input group-->
                <div class="fv-row mb-7" id="req_price">
                    <!--begin::Label-->
                    <label id="label_price" class="price required fw-semibold fs-6 mb-2">Harga Proyek</label>
                    <!--end::Label-->
                     <div class="input-group">
                        <span class="input-group-text" id="proyek-price">Rp. </span>
                        <input type="text" id="fake_price" onkeyup="matauang(this,'#real_price')" value="{{ (isset($result->price)) ? number_format($result->price,0,',','.') : '' }}" class="form-control mb-3 mb-lg-0" placeholder="Masukkan Harga" autocomplete="off" aria-describedby="proyek-price"/>
                    </div>
                    <input type="hidden" name="price" id="real_price" required autocomplete="off" value="{{ (isset($result->price)) ? $result->price : '' }}"/>
                    
                </div>
                <!--end::Input group-->
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                <!--begin::Input group-->
                <div class="fv-row mb-7" id="req_stock">
                    <!--begin::Label-->
                    <label id="label_stock" class="stock required fw-semibold fs-6 mb-2">Jumlah Unit</label>
                    <!--end::Label-->
                     <div class="input-group">
                        <input type="number" name="stock" value="{{ (isset($result->stock)) ? number_format($result->stock,0,',','.') : '' }}" class="form-control mb-3 mb-lg-0" placeholder="Masukkan Jumlah Unit" autocomplete="off" aria-describedby="proyek-stock"/>
                        <span class="input-group-text" id="proyek-stock">Unit</span>
                    </div>
                    
                </div>
                <!--end::Input group-->
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
        <!--begin::Input group-->
        <div class="fv-row mb-7" id="req_address">
            <!--begin::Label-->
            <label class="required fw-semibold fs-6 mb-2">Alamat</label>
            <!--end::Label-->
            <!--begin::Input-->
            <textarea name="address" id="address" cols="30" style="height : 200px" class="form-control mb-3 mb-lg-0" placeholder="Masukkan alamat">{{ (isset($result->address)) ? $result->address : '' }}</textarea>
            <!--end::Input-->
        </div>
        <!--end::Input group-->
    </div>
    <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <div id="req_location">
                <label class="required fw-semibold fs-6 mb-2">Pindah pion atau cari lokasi</label>
            </div>
            
            <!--end::Label-->
                <div id="map" style="height: 200px;"></div>

            <input type="hidden" id="lat" name="lat" placeholder="Latitude" value="{{ (isset($result->lat)) ? $result->lat : '' }}" class="form-control my-2" readonly>
            <input type="hidden" id="lng" name="lng" placeholder="Longitude" value="{{ (isset($result->lng)) ? $result->lng : '' }}" class="form-control" readonly>
        </div>
        <!--end::Input group-->
    </div>
    <div class="col-md-12 col-lg-12 col-sm-12 mb-3">
        <div class="w-100 d-flex justify-content-start align-items-center mb-10">
            @if($language->isNotEmpty())
            @foreach($language AS $row)
            <button type="button" onclick="setLangContent(this,{{ $row->id_language }},'{{ ucwords($row->name) }}')" class="lang_button badge {{ ($row->default == 'Y') ? 'badge-primary' : 'badge-secondary'  }}  py-2 px-7 me-3 mb-2" style="border : none;">{{ $row->name }}</button>
            @endforeach
            @endif
        </div>
        @if($language->isNotEmpty())
        @foreach($language AS $row)
        <!--begin::Input group-->
        <div class="fv-row mb-7 content_lang cross_lang_<?= $row->id_language ?> {{ ($row->default == 'Y') ? '' : 'd-none' }}" id="req_specification_<?= $row->id_language ?>">
            <!--begin::Label-->
            <label class="required fw-semibold fs-6 mb-2">Spesifikasi ({{ $row->name }})</label>
            <!--end::Label-->
            <textarea name="specification_<?= $row->id_language ?>" id="specification_<?= $row->id_language ?>" cols="30" rows="10" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Spesifikasi">{{ optional($result?->details->firstWhere('id_language', $row->id_language))->specification ?? '' }}</textarea>
        </div>
        <!--end::Input group-->
        @endforeach
        @endif
    </div>
    <div class="col-md-12 col-lg-12 col-sm-12 mb-3">
        <div class="w-100 table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width : 80px">Akses</th>
                        <th style="width : 150px">Fasilitas</th>
                        <th>Keterangan (<span id="title_lang">{{ $default_lang }}</span>)</th>
                    </tr>
                </thead>
                <tbody>
                    @if($facility)
                    @foreach($facility AS $row)
                    <tr>
                        <td>
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input cursor-pointer focus-info" {{ (isset($profas[$row->id_facility])) ? 'checked' : '' }} type="checkbox" name="id_facility[]" value="{{ $row->id_facility }}" role="switch" onchange="setFacility(this,{{ $row->id_facility }})">
                                </div>
                            </div>
                        </td>
                        <td>
                            {{ $row->name }}
                        </td>
                        <td>
                            <div class="{{ (isset($profas[$row->id_facility])) ? 'd-none' : '' }}" id="pane_unaccess_{{ $row->id_facility }}">
                                <span class="text-danger">Unaccess</span>
                            </div>
                            <div id="pane_access_{{ $row->id_facility }}" class="{{ (!isset($profas[$row->id_facility])) ? 'd-none' : '' }}">
                                @if($language->isNotEmpty())
                                @foreach($language AS $key)
                                <!--begin::Input group-->
                                <div class="fv-row content_lang cross_lang_<?= $key->id_language ?> {{ ($key->default == 'Y') ? '' : 'd-none' }}" id="req_description_{{ $row->id_facility }}_{{ $key->id_language }}">
                                    <!--begin::Input-->
                                    <input type="text" name="description_{{ $row->id_facility }}_{{ $key->id_language }}" class="form-control mb-3 mb-lg-0" value="{{ (isset($profas[$row->id_facility][$key->id_language])) ? $profas[$row->id_facility][$key->id_language] : '' }}" placeholder="Masukkan Keterangan ({{ $key->name }})" autocomplete="off" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                @endforeach
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="3"><center>Tidak Ada Fasilitas</center></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <?php
        $arr_editor = [];
        if ($language->isNotEmpty()) {
            foreach ($language as $row) {
                $arr_editor[] = 'specification_'.$row->id_language;
            }
        
        }
        $ae = implode(',',$arr_editor);
    ?>
    <!--begin::Actions-->
    <div class="text-center pt-15">
        <button type="button" id="submit_project" data-loader="big" data-editor_two="<?= $ae; ?>" onclick="submit_form(this,'#form_project')" class="btn btn-primary">
            <span class="indicator-label">Simpan</span>
        </button>
    </div>
    <!--end::Actions-->
</div>


<script src="{{ asset('assets/public/plugins/global/plugins.bundle.js'); }}"></script>
<script src="{{ asset('assets/public/js/scripts.bundle.js'); }}"></script>