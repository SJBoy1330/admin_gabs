@extends('layouts.admin.main')

@push('styles')
<style>
    /* UI Custom Styling Original */
    .preview-grid { display: flex; gap: .5rem; flex-wrap: wrap; }
    .preview-grid img { width: 72px; height: 72px; object-fit: cover; border-radius: .25rem; border: 1px solid #e9ecef; }
    .required-star::after { content: "*"; color: #f1416c; margin-left: .25rem; font-weight: 600; }
    .sidebar-reco li { margin-bottom: .6rem; transition: all 0.3s; }
    .tab-disabled { pointer-events: none; opacity: 0.5; }
    .muted-small { font-size: .85rem; color: #6c757d; }
    .table-sku input { min-width: 85px; font-size: 0.85rem; }
    .text-success { color: #28a745 !important; font-weight: bold; }
    .btn-remove-var { color: #f1416c; cursor: pointer; font-size: 0.8rem; font-weight: 600; }
    .btn-remove-var:hover { text-decoration: underline; }
    .sticky-preview { position: sticky; top: 20px; }

    /* Gallery Wrapper & Sortable Styling */
    .gallery-wrapper {
        border: 2px dashed #cbd5e0;
        border-radius: 12px;
        padding: 20px;
        background: #f8fafc;
        transition: all 0.3s ease;
    }
    .gallery-wrapper.dragover {
        border-color: #4facfe;
        background: #ebf8ff;
    }
    .gallery-dropzone-inner {
        text-align: center;
        cursor: pointer;
        padding: 10px;
        border-bottom: 1px solid transparent;
    }
    .gallery-preview-container {
        display: flex; gap: 12px; flex-wrap: wrap; margin-top: 15px;
    }
    .gallery-item {
        position: relative; width: 100px; height: 100px; cursor: grab;
    }
    .gallery-item img {
        width: 100%; height: 100%; object-fit: cover; border-radius: 8px; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .gallery-item .order-badge {
        position: absolute; bottom: 5px; left: 5px; background: rgba(0,0,0,0.5); color: white; font-size: 10px; padding: 2px 6px; border-radius: 4px; pointer-events: none;
    }
    .btn-remove-gallery {
        position: absolute; top: -8px; right: -8px; background: #f1416c; color: white; border-radius: 50%; width: 22px; height: 22px; font-size: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.2); z-index: 10;
    }
    .sortable-ghost { opacity: 0.4; border: 2px dashed #4facfe; border-radius: 8px; }
</style>
@endpush

@section('content')
<div class="container-xxl">
    <div class="row g-4">
        <div class="col-xl-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3 text-uppercase" style="font-size: 12px; letter-spacing: 1px;">Status Input</h6>
                    <ul class="sidebar-reco list-unstyled small">
                        <li class="mb-2"><span id="chk_image" class="me-2">◻</span> Foto Utama</li>
                        <li class="mb-2"><span id="chk_name" class="me-2">◻</span> Nama Produk (Min. 10)</li>
                        <li class="mb-2"><span id="chk_category" class="me-2">◻</span> Kategori</li>
                        <li class="mb-2"><span id="chk_price" class="me-2">◻</span> Harga</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 pt-3">
                    <ul class="nav nav-tabs nav-tabs-line" id="mainTabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#info" id="link-info">Informasi</a></li>
                        <li class="nav-item"><a class="nav-link tab-disabled" data-bs-toggle="tab" href="#sales" id="link-sales">Penjualan</a></li>
                        <li class="nav-item"><a class="nav-link tab-disabled" data-bs-toggle="tab" href="#shipping" id="link-shipping">Pengiriman</a></li>
                        <li class="nav-item"><a class="nav-link tab-disabled" data-bs-toggle="tab" href="#other" id="link-other">Konfirmasi</a></li>
                    </ul>
                </div>

                <form id="form_product">
                    <div class="card-body tab-content pt-4">
                        <div class="tab-pane fade show active" id="info">
                            <div class="mb-3">
                                <label class="form-label small fw-bold required-star">Foto Utama (Cover)</label>
                                <input type="file" id="product_images" class="form-control form-control-sm" accept="image/*">
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted">Gallery Produk (Optional)</label>
                                <div id="gallery_wrapper" class="gallery-wrapper">
                                    <div id="gallery_dropzone" class="gallery-dropzone-inner">
                                        <i class="bi bi-cloud-arrow-up fs-2 text-primary"></i>
                                        <p class="mb-2 small fw-bold">Tarik foto ke sini atau klik untuk upload</p>
                                        <input type="file" id="gallery_images" hidden multiple accept="image/*">
                                        <button type="button" class="btn btn-sm btn-primary px-3" onclick="document.getElementById('gallery_images').click()">Pilih File</button>
                                    </div>
                                    <div id="gallery_preview" class="gallery-preview-container"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold required-star">Nama Produk</label>
                                <input type="text" id="product_name" class="form-control" placeholder="Contoh: Sepatu Nike Air Jordan">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold required-star">Kategori</label>
                                    <select id="product_category" class="form-select">
                                        <option value="">Pilih...</option>
                                        <option value="Fashion">Fashion</option>
                                        <option value="Elektronik">Elektronik</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold required-star">Harga Dasar (Rp)</label>
                                    <input type="number" id="product_price" class="form-control" placeholder="0">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold">Deskripsi</label>
                                <textarea id="product_description" class="form-control" rows="4"></textarea>
                            </div>
                            <button type="button" class="btn btn-primary w-100" id="btn_to_sales">Lanjutkan</button>
                        </div>

                        <div class="tab-pane fade" id="sales">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="fw-bold small">Variasi Produk (Unlimited)</label>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="add_variation">+ Atribut Baru</button>
                            </div>
                            <div id="variation-container"></div>
                            <button type="button" class="btn btn-dark btn-sm w-100 mb-4" id="generate_sku">GENERATE TABEL SKU</button>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered align-middle" id="sku_table">
                                    <thead class="table-light small">
                                        <tr>
                                            <th>Varian</th><th>SKU</th><th>Stok</th><th>Harga</th><th>Berat</th><th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="small text-center">
                                        <tr><td colspan="6" class="py-3">Belum ada variasi.</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-check my-4">
                                <input class="form-check-input" type="checkbox" id="sales_ready">
                                <label class="form-check-label small" for="sales_ready">Konfirmasi variasi sudah benar.</label>
                            </div>
                            <button type="button" class="btn btn-primary w-100" id="btn_to_shipping">Lanjutkan</button>
                        </div>

                        <div class="tab-pane fade" id="shipping">
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="shipping_ready">
                                <label class="form-check-label small" for="shipping_ready">Konfirmasi pengiriman benar.</label>
                            </div>
                            <button type="button" class="btn btn-primary w-100" id="btn_to_other">Lanjutkan</button>
                        </div>

                        <div class="tab-pane fade" id="other">
                            <button type="submit" id="btn_publish" class="btn btn-danger btn-lg w-100 fw-bold">PUBLISH SEKARANG</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="sticky-preview text-center">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div id="preview_img_container" class="bg-light rounded mb-3 d-flex align-items-center justify-content-center" style="aspect-ratio:1/1; border: 1px dashed #ddd; overflow:hidden;">
                            <span class="text-muted small">No Image</span>
                        </div>
                        <h6 id="preview_title" class="fw-bold small mb-1 text-truncate">Nama Produk...</h6>
                        <div id="preview_price" class="text-danger fw-bold small">Rp 0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const productForm = document.getElementById('form_product');
    const nameInput = document.getElementById('product_name');
    const priceInput = document.getElementById('product_price');
    const categorySelect = document.getElementById('product_category');
    const imgInput = document.getElementById('product_images');
    const galleryInput = document.getElementById('gallery_images');
    const galleryPreview = document.getElementById('gallery_preview');
    const skuTableBody = document.querySelector('#sku_table tbody');
    const varContainer = document.getElementById('variation-container');
    const salesReady = document.getElementById('sales_ready');
    const shippingReady = document.getElementById('shipping_ready');

    let base64Cover = "";
    let galleryFiles = [];

    // --- SORTABLE ---
    new Sortable(galleryPreview, {
        animation: 150,
        onEnd: () => {
            const newOrder = [];
            galleryPreview.querySelectorAll('.gallery-item img').forEach(img => newOrder.push(img.src));
            galleryFiles = newOrder;
            renderGallery();
        }
    });

    // --- GALLERY LOGIC ---
    function renderGallery() {
        galleryPreview.innerHTML = '';
        galleryFiles.forEach((src, idx) => {
            const div = document.createElement('div');
            div.className = 'gallery-item';
            div.innerHTML = `<img src="${src}"><span class="order-badge">${idx+1}</span><div class="btn-remove-gallery" onclick="removeGalleryItem(${idx})">×</div>`;
            galleryPreview.appendChild(div);
        });
    }
    window.removeGalleryItem = (i) => { galleryFiles.splice(i, 1); renderGallery(); };
    galleryInput.onchange = (e) => {
        Array.from(e.target.files).forEach(file => {
            const r = new FileReader();
            r.onload = (ev) => { galleryFiles.push(ev.target.result); renderGallery(); };
            r.readAsDataURL(file);
        });
    };

    // --- SKU LOGIC ---
    const cartesian = (...a) => a.reduce((a, b) => a.flatMap(d => b.map(e => [d, e].flat())));

    document.getElementById('add_variation').onclick = () => {
        const div = document.createElement('div');
        div.className = "variation-group border rounded p-3 mb-3 bg-light";
        div.innerHTML = `
            <div class="d-flex justify-content-between mb-2">
                <input type="text" class="form-control form-control-sm var-name w-50 fw-bold" placeholder="Atribut: Warna">
                <span class="btn-remove-var" onclick="this.closest('.variation-group').remove();">Hapus</span>
            </div>
            <input type="text" class="form-control form-control-sm var-options" placeholder="Opsi: Merah, Hitam (Gunakan koma)">
        `;
        varContainer.appendChild(div);
    };

    document.getElementById('generate_sku').onclick = () => {
        let lists = [];
        document.querySelectorAll('.variation-group').forEach(g => {
            const opt = g.querySelector('.var-options').value.split(',').map(s => s.trim()).filter(s => s !== "");
            if(opt.length > 0) lists.push(opt);
        });
        if(lists.length === 0) return alert("Isi opsi dulu!");
        skuTableBody.innerHTML = '';
        const combos = (lists.length === 1) ? lists[0].map(i => [i]) : cartesian(...lists);
        combos.forEach((combo, idx) => {
            const label = combo.join(' - ');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="fw-bold small">${label}</td>
                <td><input type="text" class="form-control form-control-sm sku-code" value="SKU-${idx+1}"></td>
                <td><input type="number" class="form-control form-control-sm sku-stock" value="10"></td>
                <td><input type="number" class="form-control form-control-sm sku-price" value="${priceInput.value}"></td>
                <td><input type="number" class="form-control form-control-sm" value="250"></td>
                <td><button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">×</button></td>
            `;
            skuTableBody.appendChild(row);
        });
    };

    // --- VALIDASI & TAB ---
    function updateUI() {
        const v = { name: nameInput.value.trim().length >= 10, price: priceInput.value > 0, cat: categorySelect.value !== "", img: base64Cover !== "" };
        document.getElementById('chk_name').innerHTML = v.name ? '<span class="text-success">✔</span>' : '◻';
        document.getElementById('chk_price').innerHTML = v.price ? '<span class="text-success">✔</span>' : '◻';
        document.getElementById('chk_category').innerHTML = v.cat ? '<span class="text-success">✔</span>' : '◻';
        document.getElementById('chk_image').innerHTML = v.img ? '<span class="text-success">✔</span>' : '◻';
        const valid = v.name && v.price && v.cat && v.img;
        document.getElementById('link-sales').classList.toggle('tab-disabled', !valid);
        document.getElementById('link-shipping').classList.toggle('tab-disabled', !(valid && salesReady.checked));
        document.getElementById('link-other').classList.toggle('tab-disabled', !(valid && salesReady.checked && shippingReady.checked));
        document.getElementById('preview_title').innerText = nameInput.value || "Nama Produk...";
        document.getElementById('preview_price').innerText = "Rp " + (parseInt(priceInput.value) || 0).toLocaleString();
    }

    window.moveToTab = (id) => {
        const link = document.getElementById('link-' + id);
        if(!link.classList.contains('tab-disabled')) new bootstrap.Tab(link).show();
    };

    imgInput.onchange = function() {
        if(this.files[0]) {
            const r = new FileReader();
            r.onload = e => { base64Cover = e.target.result; document.getElementById('preview_img_container').innerHTML = `<img src="${base64Cover}" style="width:100%; height:100%; object-fit:cover;">`; updateUI(); };
            r.readAsDataURL(this.files[0]);
        }
    };

    [nameInput, priceInput, categorySelect, salesReady, shippingReady].forEach(el => el.addEventListener('input', updateUI));
    document.getElementById('btn_to_sales').onclick = () => moveToTab('sales');
    document.getElementById('btn_to_shipping').onclick = () => moveToTab('shipping');
    document.getElementById('btn_to_other').onclick = () => moveToTab('other');

    // --- FIX: LOGIKA SUBMIT (SIMPAN KE LOCAL STORAGE) ---
    productForm.onsubmit = function(e) {
        e.preventDefault();
        
        // 1. Ambil data variasi SKU dari tabel
        const variations = [];
        document.querySelectorAll('#sku_table tbody tr').forEach(row => {
            const code = row.querySelector('.sku-code');
            if(code) {
                variations.push({
                    variant: row.cells[0].innerText,
                    sku: code.value,
                    stock: row.querySelector('.sku-stock').value,
                    price: row.querySelector('.sku-price').value
                });
            }
        });

        // 2. Bungkus ke object Produk
        const productObj = {
            id: "ID-" + Date.now(),
            name: nameInput.value,
            category: categorySelect.value,
            price: priceInput.value,
            cover: base64Cover,
            variations: variations, // Array SKU ada di sini
            date: new Date().toLocaleDateString('id-ID')
        };

        // 3. Simpan ke localStorage (Key: my_products)
        let currentData = JSON.parse(localStorage.getItem('my_products')) || [];
        currentData.push(productObj);
        localStorage.setItem('my_products', JSON.stringify(currentData));

        const btn = document.getElementById('btn_publish');
        btn.disabled = true; btn.innerHTML = 'Berhasil Simpan!';

        setTimeout(() => {
            window.location.href = "{{ url('master/product') }}";
        }, 1000);
    };

    updateUI();
});
</script>
@endpush