@extends('layouts.admin.main')

@push('styles')
<style>
    :root {
        --primary-blue: #009ef7;
        --border-blue: #e4e6ef;
    }
    .brand-logo-container {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f5f8fa;
        border-radius: 8px;
        border: 1px solid var(--border-blue);
        overflow: hidden;
    }
    .brand-logo-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    #image_preview {
        width: 120px;
        height: 120px;
        border: 2px dashed var(--border-blue);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        margin-bottom: 10px;
        overflow: hidden;
    }
    #image_preview img {
        max-width: 100%;
        height: auto;
    }
</style>
@endpush

@section('content')
<div class="container-xxl">
    <div class="card card-flush shadow-sm">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5 border-0">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="bi bi-search position-absolute ms-4 text-primary"></i>
                    <input type="text" id="search_brand" class="form-control form-control-solid w-250px ps-12 border-blue" placeholder="Cari Brand...">
                </div>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_brand">
                    <i class="bi bi-plus-lg"></i> Tambah Brand
                </button>
            </div>
        </div>

        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="brand_table">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-50px ps-4">No</th>
                            <th class="min-w-250px">Nama Brand</th>
                            <th class="min-w-150px">Total Produk</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_add_brand" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Brand Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_add_brand">
                    <div class="mb-7 text-center d-flex flex-column align-items-center">
                        <label class="fw-semibold fs-6 mb-2">Logo Brand</label>
                        <div id="image_preview">
                            <span class="text-muted fs-7">No Preview</span>
                        </div>
                        <input type="file" id="brand_logo_input" class="form-control form-control-solid border-blue" accept="image/*">
                    </div>
                    <div class="mb-5">
                        <label class="required fw-semibold fs-6 mb-2">Nama Brand</label>
                        <input type="text" id="brand_name_input" class="form-control form-control-solid border-blue" placeholder="Contoh: Gabrielle Jeans" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="saveBrand()">Simpan Brand</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Data Dummy Awal
    let initialData = [
        { id: 1, name: 'Gabrielle Jeans', logo: 'https://via.placeholder.com/100?text=GJ' },
        { id: 2, name: 'Gabsjeans', logo: 'https://via.placeholder.com/100?text=GABS' }
    ];

    // Cek LocalStorage
    if (!localStorage.getItem('my_brands')) {
        localStorage.setItem('my_brands', JSON.stringify(initialData));
    }

    renderBrands();

    // 2. Preview Image Handler
    document.getElementById('brand_logo_input').addEventListener('change', function(e) {
        const preview = document.getElementById('image_preview');
        const file = e.target.files[0];
        const reader = new FileReader();

        reader.onload = function(event) {
            preview.innerHTML = `<img src="${event.target.result}" />`;
        }
        if(file) reader.readAsDataURL(file);
    });

    // 3. Search Handler
    document.getElementById('search_brand').addEventListener('keyup', function(e) {
        renderBrands(e.target.value);
    });
});

function renderBrands(filter = "") {
    const tableBody = document.querySelector('#brand_table tbody');
    const brands = JSON.parse(localStorage.getItem('my_brands')) || [];
    
    tableBody.innerHTML = '';

    const filteredBrands = brands.filter(b => b.name.toLowerCase().includes(filter.toLowerCase()));

    if (filteredBrands.length > 0) {
        filteredBrands.forEach((brand, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="ps-4">${index + 1}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="brand-logo-container me-3">
                            <img src="${brand.logo}" alt="${brand.name}">
                        </div>
                        <div class="d-flex flex-column">
                            <span class="text-gray-800 fs-6 fw-bold">${brand.name}</span>
                            <span class="text-muted fs-7">Brand Terverifikasi</span>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge badge-light-primary fw-bold">0 Produk</span>
                </td>
                <td class="text-end pe-4">
                    <button class="btn btn-sm btn-icon btn-light-danger" onclick="deleteBrand(${brand.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    } else {
        tableBody.innerHTML = '<tr><td colspan="4" class="text-center py-10 text-muted">Brand tidak ditemukan.</td></tr>';
    }
}

function saveBrand() {
    const name = document.getElementById('brand_name_input').value;
    const logoInput = document.getElementById('brand_logo_input');
    const previewImg = document.querySelector('#image_preview img');

    if (!name) {
        alert('Nama brand wajib diisi!');
        return;
    }

    let brands = JSON.parse(localStorage.getItem('my_brands')) || [];
    
    const newBrand = {
        id: Date.now(),
        name: name,
        logo: previewImg ? previewImg.src : 'https://via.placeholder.com/100?text=No+Logo'
    };

    brands.push(newBrand);
    localStorage.setItem('my_brands', JSON.stringify(brands));

    // Reset & Close
    document.getElementById('form_add_brand').reset();
    document.getElementById('image_preview').innerHTML = '<span class="text-muted fs-7">No Preview</span>';
    
    const modal = bootstrap.Modal.getInstance(document.getElementById('modal_add_brand'));
    modal.hide();

    renderBrands();
    alert('Brand berhasil ditambahkan!');
}

function deleteBrand(id) {
    if(confirm('Hapus brand ini?')) {
        let brands = JSON.parse(localStorage.getItem('my_brands')) || [];
        brands = brands.filter(b => b.id != id);
        localStorage.setItem('my_brands', JSON.stringify(brands));
        renderBrands();
    }
}
</script>
@endpush