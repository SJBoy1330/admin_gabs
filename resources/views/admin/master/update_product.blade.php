@extends('layouts.admin.main')

@push('styles')
<style>
    /* UI Styling - Harus sama dengan Insert agar konsisten */
    .preview-grid { display: flex; gap: .5rem; flex-wrap: wrap; }
    .required-star::after { content: "*"; color: #f1416c; margin-left: .25rem; font-weight: 600; }
    .sidebar-reco li { margin-bottom: .6rem; transition: all 0.3s; }
    .tab-disabled { pointer-events: none; opacity: 0.5; }
    .table-sku input { min-width: 85px; font-size: 0.85rem; }
    .btn-remove-var { color: #f1416c; cursor: pointer; font-size: 0.8rem; font-weight: 600; }
    .sticky-preview { position: sticky; top: 20px; }

    /* Gallery Wrapper & Sortable */
    .gallery-wrapper { border: 2px dashed #cbd5e0; border-radius: 12px; padding: 20px; background: #f8fafc; transition: all 0.3s ease; }
    .gallery-preview-container { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 15px; }
    .gallery-item { position: relative; width: 100px; height: 100px; cursor: grab; }
    .gallery-item img { width: 100%; height: 100%; object-fit: cover; border-radius: 8px; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .gallery-item .order-badge { position: absolute; bottom: 5px; left: 5px; background: rgba(0,0,0,0.5); color: white; font-size: 10px; padding: 2px 6px; border-radius: 4px; pointer-events: none; }
    .btn-remove-gallery { position: absolute; top: -8px; right: -8px; background: #f1416c; color: white; border-radius: 50%; width: 22px; height: 22px; font-size: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 2px solid white; z-index: 10; }
    .sortable-ghost { opacity: 0.4; border: 2px dashed #4facfe; }
</style>
@endpush

@section('content')
<div class="container-xxl">
    <div class="row g-4">
        
        <div class="col-xl-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3 text-uppercase" style="font-size: 12px;">Update Status</h6>
                    <div class="alert alert-light-primary small py-2 mb-4">
                        Editing ID: <span id="display_id" class="fw-bold"></span>
                    </div>
                    <ul class="sidebar-reco list-unstyled small">
                        <li class="mb-2"><span id="chk_image" class="me-2">◻</span> Foto Utama</li>
                        <li class="mb-2"><span id="chk_name" class="me-2">◻</span> Nama Produk</li>
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
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#sales" id="link-sales">Penjualan (SKU)</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#other" id="link-other">Konfirmasi</a></li>
                    </ul>
                </div>

                <form id="form_product">
                    <div class="card-body tab-content pt-4">
                        
                        <div class="tab-pane fade show active" id="info">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Ganti Foto Utama</label>
                                <input type="file" id="product_images" class="form-control form-control-sm" accept="image/*">
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted">Edit Gallery</label>
                                <div id="gallery_wrapper" class="gallery-wrapper">
                                    <div class="gallery-dropzone-inner text-center">
                                        <input type="file" id="gallery_images" hidden multiple accept="image/*">
                                        <button type="button" class="btn btn-sm btn-primary px-3" onclick="document.getElementById('gallery_images').click()">+ Tambah Foto Gallery</button>
                                    </div>
                                    <div id="gallery_preview" class="gallery-preview-container"></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold required-star">Nama Produk</label>
                                <input type="text" id="product_name" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold required-star">Kategori</label>
                                    <select id="product_category" class="form-select">
                                        <option value="Fashion">Fashion</option>
                                        <option value="Elektronik">Elektronik</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold required-star">Harga Dasar (Rp)</label>
                                    <input type="number" id="product_price" class="form-control">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold">Deskripsi</label>
                                <textarea id="product_description" class="form-control" rows="4"></textarea>
                            </div>
                            <button type="button" class="btn btn-primary w-100" onclick="moveToTab('sales')">Lanjutkan ke Penjualan</button>
                        </div>

                        <div class="tab-pane fade" id="sales">
                            <h6 class="fw-bold mb-3 small">Daftar Variasi SKU</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered align-middle" id="sku_table">
                                    <thead class="table-light small">
                                        <tr>
                                            <th>Varian</th><th>SKU</th><th>Stok</th><th>Harga</th><th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="small text-center">
                                        </tbody>
                                </table>
                            </div>
                            <div class="alert alert-light-info small mt-4">
                                Anda dapat merubah Stok dan Harga pada setiap varian SKU di atas.
                            </div>
                            <div class="form-check my-4">
                                <input class="form-check-input" type="checkbox" id="sales_ready">
                                <label class="form-check-label small" for="sales_ready">Konfirmasi perubahan data variasi benar.</label>
                            </div>
                            <button type="button" class="btn btn-primary w-100" onclick="moveToTab('other')">Lanjutkan</button>
                        </div>

                        <div class="tab-pane fade" id="other">
                            <div class="alert alert-warning small">Menyimpan akan memperbarui data permanen di LocalStorage.</div>
                            <button type="submit" id="btn_publish" class="btn btn-success btn-lg w-100 fw-bold">UPDATE SEKARANG</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="sticky-preview">
                <div class="card shadow-sm border-0 text-center">
                    <div id="preview_img_container" class="bg-light rounded mb-3 d-flex align-items-center justify-content-center" style="aspect-ratio:1/1; border: 1px dashed #ddd; overflow:hidden;">
                        <span class="text-muted small">No Image</span>
                    </div>
                    <h6 id="preview_title" class="fw-bold small mb-1 px-2 text-truncate">Nama Produk...</h6>
                    <div id="preview_price" class="text-danger fw-bold small pb-3">Rp 0</div>
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
    const salesReady = document.getElementById('sales_ready');

    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');

    let base64Cover = "";
    let galleryFiles = [];

    // --- SORTABLE GALLERY ---
    new Sortable(galleryPreview, {
        animation: 150,
        onEnd: () => {
            const newOrder = [];
            galleryPreview.querySelectorAll('.gallery-item img').forEach(img => newOrder.push(img.src));
            galleryFiles = newOrder;
            renderGallery();
        }
    });

    // --- LOAD DATA LAMA ---
    function loadProduct() {
        if (!productId) return alert("ID Tidak Valid!");
        
        const products = JSON.parse(localStorage.getItem('my_products')) || [];
        const p = products.find(i => i.id == productId);

        if (p) {
            document.getElementById('display_id').innerText = p.id;
            nameInput.value = p.name;
            priceInput.value = p.price;
            categorySelect.value = p.category;
            document.getElementById('product_description').value = p.description || "";
            base64Cover = p.cover;
            galleryFiles = p.gallery || [];

            // Render Preview & UI
            if(base64Cover) document.getElementById('preview_img_container').innerHTML = `<img src="${base64Cover}" style="width:100%; height:100%; object-fit:cover;">`;
            renderGallery();
            
            // Render SKU Table
            if(p.variations && p.variations.length > 0) {
                skuTableBody.innerHTML = '';
                p.variations.forEach((v, idx) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="fw-bold small bg-light">${v.variant}</td>
                        <td><input type="text" class="form-control form-control-sm sku-code" value="${v.sku}"></td>
                        <td><input type="number" class="form-control form-control-sm sku-stock" value="${v.stock}"></td>
                        <td><input type="number" class="form-control form-control-sm sku-price" value="${v.price}"></td>
                        <td><button type="button" class="btn btn-sm btn-danger p-1" onclick="this.closest('tr').remove()">×</button></td>
                    `;
                    skuTableBody.appendChild(row);
                });
            }
            updateUI();
        }
    }

    // --- GALLERY RENDER ---
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

    // --- UI & NAVIGATION ---
    function updateUI() {
        document.getElementById('preview_title').innerText = nameInput.value || "...";
        document.getElementById('preview_price').innerText = "Rp " + (parseInt(priceInput.value) || 0).toLocaleString();
        document.getElementById('chk_name').innerHTML = nameInput.value.length >= 10 ? '✔' : '◻';
        document.getElementById('chk_price').innerHTML = priceInput.value > 0 ? '✔' : '◻';
    }

    imgInput.onchange = function() {
        const r = new FileReader();
        r.onload = e => { base64Cover = e.target.result; document.getElementById('preview_img_container').innerHTML = `<img src="${base64Cover}" style="width:100%; height:100%; object-fit:cover;">`; updateUI(); };
        r.readAsDataURL(this.files[0]);
    };

    window.moveToTab = (id) => { new bootstrap.Tab(document.getElementById('link-' + id)).show(); };
    [nameInput, priceInput, categorySelect].forEach(el => el.addEventListener('input', updateUI));

    // --- SUBMIT UPDATE ---
    productForm.onsubmit = function(e) {
        e.preventDefault();
        
        const finalVariations = [];
        document.querySelectorAll('#sku_table tbody tr').forEach(row => {
            const skuInput = row.querySelector('.sku-code');
            if(skuInput) {
                finalVariations.push({
                    variant: row.cells[0].innerText,
                    sku: skuInput.value,
                    stock: row.querySelector('.sku-stock').value,
                    price: row.querySelector('.sku-price').value
                });
            }
        });

        let products = JSON.parse(localStorage.getItem('my_products')) || [];
        const index = products.findIndex(i => i.id == productId);

        if(index !== -1) {
            products[index] = {
                ...products[index],
                name: nameInput.value,
                category: categorySelect.value,
                price: priceInput.value,
                cover: base64Cover,
                gallery: galleryFiles,
                variations: finalVariations,
                description: document.getElementById('product_description').value,
                last_updated: new Date().toLocaleString()
            };

            localStorage.setItem('my_products', JSON.stringify(products));
            alert("Perubahan Berhasil Disimpan!");
            window.location.href = "{{ url('master/product') }}";
        }
    };

    loadProduct();
});
</script>
@endpush