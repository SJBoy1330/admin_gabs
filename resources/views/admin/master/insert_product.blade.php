@extends('layouts.admin.main')

@push('styles')
<style>
    /* preview image grid */
    .preview-grid { display: flex; gap: .5rem; flex-wrap: wrap; }
    .preview-grid img { width: 72px; height: 72px; object-fit: cover; border-radius: .25rem; border: 1px solid #e9ecef; }
    .required-star::after { content: "*"; color: #f1416c; margin-left: .25rem; font-weight: 600; }
    .sidebar-reco li { margin-bottom: .6rem; }
    .tab-disabled { pointer-events: none; opacity: 0.6; }
    .muted-small { font-size: .85rem; color: #6c757d; }
    .badge-status { font-size: .75rem; padding: .35rem .5rem; }
    .table-sku input { min-width: 90px; }
</style>
@endpush

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ambil elemen
    const imgInput = document.getElementById('product_images');
    const imgPreview = document.getElementById('image_preview');
    const imgCount = document.getElementById('image_count');
    const nameInput = document.getElementById('product_name');
    const categorySelect = document.getElementById('product_category');
    const priceInput = document.getElementById('product_price');
    const descInput = document.getElementById('product_description');

    // nav tab link
    const salesTabLink = document.querySelector('[href="#sales"]');
    const shippingTabLink = document.querySelector('[href="#shipping"]');
    const otherTabLink = document.querySelector('[href="#other"]');

    // tombol
    const savePublishBtn = document.getElementById('btn_publish');
    const nextSalesBtn = document.getElementById('btn_next_to_sales');
    const nextShippingBtn = document.getElementById('btn_next_to_shipping');
    const nextOtherBtn = document.getElementById('btn_next_to_other');

    // checkbox ready
    const salesReady = document.getElementById('sales_ready');
    const shippingReady = document.getElementById('shipping_ready');
    const otherReady = document.getElementById('other_ready');

    // SKU
    const skuTable = document.querySelector('#sku_table tbody');
    const addVariationBtn = document.getElementById('add_variation');
    const generateSkuBtn = document.getElementById('generate_sku');
    const variationContainer = document.getElementById('variation-container');

    // cek progress step1
    function validateStep1() {
        const hasImage = imgInput.files.length >= 1;
        const nameOk = nameInput.value.trim().length >= 10;
        const catOk = categorySelect.value !== "";
        const priceOk = Number(priceInput.value) > 0;
        return { hasImage, nameOk, catOk, priceOk };
    }

    function updateProgressUI() {
        const v = validateStep1();
        document.getElementById('chk_image').classList.toggle('text-success', v.hasImage);
        document.getElementById('chk_name').classList.toggle('text-success', v.nameOk);
        document.getElementById('chk_category').classList.toggle('text-success', v.catOk);
        document.getElementById('chk_price').classList.toggle('text-success', v.priceOk);

        const step1ok = v.hasImage && v.nameOk && v.catOk && v.priceOk;
        toggleTab(salesTabLink, step1ok);

        const salesCompleted = salesReady.checked;
        toggleTab(shippingTabLink, step1ok && salesCompleted);

        const shippingCompleted = shippingReady.checked;
        toggleTab(otherTabLink, step1ok && salesCompleted && shippingCompleted);

    }

    function toggleTab(tabLink, enable) {
        if (!tabLink) return;
        if (enable) {
            tabLink.classList.remove('tab-disabled');
        } else {
            tabLink.classList.add('tab-disabled');
        }
    }

    // image preview
    imgInput.addEventListener('change', function (e) {
        imgPreview.innerHTML = '';
        const files = Array.from(e.target.files).slice(0, 9);
        files.forEach(file => {
            const reader = new FileReader();
            reader.onload = function (ev) {
                const img = document.createElement('img');
                img.src = ev.target.result;
                imgPreview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
        imgCount.textContent = `${files.length} / 9`;
        updateProgressUI();
    });

    // input listener
    [nameInput, categorySelect, priceInput, descInput, salesReady, shippingReady, otherReady].forEach(el => {
        el.addEventListener('input', updateProgressUI);
        el.addEventListener('change', updateProgressUI);
    });

    // tombol next antar tab
    nextSalesBtn.addEventListener('click', function(){
        new bootstrap.Tab(salesTabLink).show();
    });
    nextShippingBtn.addEventListener('click', function(){
        new bootstrap.Tab(shippingTabLink).show();
    });
    nextOtherBtn.addEventListener('click', function(){
        new bootstrap.Tab(otherTabLink).show();
    });

    // variasi
    addVariationBtn.addEventListener('click', function () {
        const group = document.createElement('div');
        group.className = "variation-group border rounded p-3 mb-3";
        group.innerHTML = `
            <div class="row g-2 mb-2">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Nama Variasi">
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" placeholder="Opsi Variasi (pisahkan dengan koma)">
                </div>
            </div>
        `;
        variationContainer.appendChild(group);
    });

    generateSkuBtn.addEventListener('click', function () {
        skuTable.innerHTML = '';
        let variations = ["Hitam", "Putih"];
        variations.forEach((v, i) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${v}</td>
                <td><input type="text" class="form-control form-control-sm" value="SKU${i+1}"></td>
                <td><input type="number" class="form-control form-control-sm" value="10"></td>
                <td><input type="number" class="form-control form-control-sm" value="10000"></td>
                <td><input type="number" class="form-control form-control-sm" value="200"></td>
                <td>
                    <div class="d-flex gap-1">
                        <input type="number" class="form-control form-control-sm" placeholder="L">
                        <input type="number" class="form-control form-control-sm" placeholder="P">
                        <input type="number" class="form-control form-control-sm" placeholder="T">
                    </div>
                </td>
            `;
            skuTable.appendChild(row);
        });
    });

    // init
    updateProgressUI();
});
</script>
@endpush


@section('content')
<div class="container-xxl">
    <div class="row g-4">
        <!-- left: rekomendasi -->
        <div class="col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Rekomendasi</h5>
                    <ul class="sidebar-reco list-unstyled">
                        <li><span id="chk_image" class="me-2 text-muted">◻</span> Tambah min 3 foto produk</li>
                        <li><span id="chk_name" class="me-2 text-muted">◻</span> Nama produk 25-100 karakter</li>
                        <li><span id="chk_category" class="me-2 text-muted">◻</span> Pilih kategori</li>
                        <li><span id="chk_price" class="me-2 text-muted">◻</span> Isi harga produk</li>
                        <li><span id="chk_desc" class="me-2 text-muted">◻</span> Deskripsi minimal 100 karakter</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- main form -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <ul class="nav nav-tabs nav-tabs-line" role="tablist" style="width:100%;">
                        <li class="nav-item"><a class="nav-link active" id="info-tab-link" data-bs-toggle="tab" href="#info" role="tab">Informasi Produk</a></li>
                        <li class="nav-item"><a class="nav-link" id="sales-tab-link" data-bs-toggle="tab" href="#sales" role="tab">Informasi Penjualan</a></li>
                        <li class="nav-item"><a class="nav-link" id="shipping-tab-link" data-bs-toggle="tab" href="#shipping" role="tab">Pengiriman</a></li>
                        <li class="nav-item"><a class="nav-link" id="other-tab-link" data-bs-toggle="tab" href="#other" role="tab">Lainnya</a></li>
                    </ul>
                </div>

                <form id="form_product">
                <div class="card-body tab-content pt-4">
                    <!-- Info Produk -->
                    <div class="tab-pane fade show active" id="info" role="tabpanel">
                        <div class="mb-4">
                            <label class="form-label required-star">Foto Produk</label>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <input id="product_images" type="file" accept="image/*" multiple class="form-control" />
                                <div class="muted-small">Max 9 foto</div>
                            </div>
                            <div class="preview-grid" id="image_preview"></div>
                            <div class="muted-small mt-2">Uploaded: <span id="image_count">0 / 9</span></div>
                        </div>

                        <div class="row gx-3">
                            <div class="col-md-8 mb-3">
                                <label class="form-label required-star">Nama Produk</label>
                                <input id="product_name" type="text" class="form-control" placeholder="Nama Merek + Tipe Produk + Fitur (min 10 karakter)">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required-star">Harga (Rp)</label>
                                <input id="product_price" type="number" class="form-control" min="0" placeholder="0">
                            </div>
                        </div>

                        <div class="row gx-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required-star">Kategori</label>
                                <select id="product_category" class="form-select">
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="fashion/tops">Fashion / Atasan</option>
                                    <option value="fashion/bottoms">Fashion / Bawahan</option>
                                    <option value="accessories">Aksesoris</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Stok</label>
                                <input id="product_stock" type="number" class="form-control" value="10" min="0">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Produk</label>
                            <textarea id="product_description" class="form-control" rows="5" maxlength="3000" placeholder="Deskripsi produk..."></textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" id="btn_next_to_sales">Lanjutkan ke Penjualan</button>
                        </div>
                    </div>

                    <!-- Sales -->
                    <div class="tab-pane fade" id="sales" role="tabpanel">
                        <div class="mb-3">
                            <div id="sales_note" class="alert alert-info d-none">Pengaturan penjualan muncul setelah memilih kategori. (Simulasi)</div>
                            <label class="form-label">Variasi Produk</label>
                            <div id="variation-container">
                                <div class="variation-group border rounded p-3 mb-3">
                                    <div class="row g-2 mb-2">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Nama Variasi (misal: Warna)">
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" placeholder="Opsi Variasi (pisahkan dengan koma)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-light btn-sm" id="add_variation">+ Tambah Variasi</button>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="generate_sku">Generate SKU</button>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Daftar SKU & Stok</label>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sku align-middle" id="sku_table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Variasi</th>
                                            <th>SKU</th>
                                            <th>Stok</th>
                                            <th>Harga (Rp)</th>
                                            <th>Berat (gr)</th>
                                            <th>Ukuran Paket (L x P x T cm)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span class="text-muted">Belum ada variasi</span></td>
                                            <td><input type="text" class="form-control form-control-sm" placeholder="SKU001"></td>
                                            <td><input type="number" class="form-control form-control-sm" value="10"></td>
                                            <td><input type="number" class="form-control form-control-sm" value="10000"></td>
                                            <td><input type="number" class="form-control form-control-sm" value="200"></td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <input type="number" class="form-control form-control-sm" placeholder="L">
                                                    <input type="number" class="form-control form-control-sm" placeholder="P">
                                                    <input type="number" class="form-control form-control-sm" placeholder="T">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input simulate-complete" type="checkbox" value="" id="sales_ready">
                            <label class="form-check-label" for="sales_ready">Saya sudah mengisi informasi penjualan</label>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" id="btn_next_to_shipping">Lanjutkan ke Pengiriman</button>
                        </div>
                    </div>

                    <!-- Shipping -->
                    <div class="tab-pane fade" id="shipping" role="tabpanel">
                        <div class="mb-3">
                            <label class="form-label">Pilih Kurir (simulasi)</label>
                            <select class="form-select">
                                <option>JNE</option>
                                <option>TIKI</option>
                                <option>J&T</option>
                            </select>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input simulate-complete" type="checkbox" value="" id="shipping_ready">
                            <label class="form-check-label" for="shipping_ready">Saya sudah mengisi informasi pengiriman</label>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" id="btn_next_to_other">Lanjutkan ke Lainnya</button>
                        </div>
                    </div>

                    <!-- Other -->
                    <div class="tab-pane fade" id="other" role="tabpanel">
                        <div class="mb-3">
                            <label class="form-label">Merek (opsional)</label>
                            <input type="text" class="form-control" placeholder="Brand name">
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input simulate-complete" type="checkbox" value="" id="other_ready">
                            <label class="form-check-label" for="other_ready">Semua informasi tambahan selesai</label>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-danger" id="btn_publish">Simpan & Tampilkan</button>
                        </div>
                    </div>
                </div>
                </form>

            </div>
        </div>

        <!-- right: preview -->
        <div class="col-xl-3">
            <div class="card">
                <div class="card-body">
                    <small class="text-muted">Preview</small>
                    <div class="mt-3">
                        <div style="width:100%; height:160px; background:#f5f5f7; border-radius:6px; display:flex; align-items:center; justify-content:center;">
                            <span class="muted-small">Gambar Produk</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
