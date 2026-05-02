@extends('layouts.admin.main')

@push('styles')
<style>
    :root {
        --primary-blue: #009ef7;
        --soft-blue: #f1faff;
        --border-blue: #e4e6ef;
    }

    .category-icon-box {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--soft-blue);
        color: var(--primary-blue);
        border-radius: 8px;
        font-size: 1.2rem;
    }

    .table-category thead tr {
        background-color: #f5f8fa !important;
    }

    .badge-count {
        background-color: #ebf6fe;
        color: var(--primary-blue);
        border: 1px solid #d0eaff;
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
                    <input type="text" id="search_category" class="form-control form-control-solid w-250px ps-12 border-blue" placeholder="Cari Kategori Induk...">
                </div>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_category">
                    <i class="bi bi-grid-plus-fill"></i> Tambah Kategori Induk
                </button>
            </div>
        </div>

        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5 table-category" id="category_table">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-50px ps-4">No</th>
                            <th class="min-w-200px">Kategori Induk</th>
                            <th>Status</th>
                            <th>Total Sub</th>
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

<div class="modal fade" id="modal_add_category" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-3">Tambah Kategori Induk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-10">
                <form id="form_category">
                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2">Nama Kategori Induk</label>
                        <input type="text" id="cat_name" class="form-control form-control-solid border-blue" placeholder="Contoh: Atasan, Bawahan, Aksesoris" required>
                        <span class="text-muted fs-8 mt-2 d-block small">Pastikan nama kategori belum pernah digunakan sebelumnya.</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="saveCategory()">Simpan Kategori</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Dummy Data Kategori Induk
    let initialCategories = [
        { id: 101, name: 'Atasan', slug: 'atasan' },
        { id: 102, name: 'Bawahan', slug: 'bawahan' },
        { id: 103, name: 'Outerwear', slug: 'outerwear' }
    ];

    if (!localStorage.getItem('master_induk_categories')) {
        localStorage.setItem('master_induk_categories', JSON.stringify(initialCategories));
    }

    renderTable();

    // Live Search
    document.getElementById('search_category').addEventListener('keyup', function(e) {
        renderTable(e.target.value);
    });
});

function renderTable(filter = "") {
    const tableBody = document.querySelector('#category_table tbody');
    const categories = JSON.parse(localStorage.getItem('master_induk_categories')) || [];
    const subCategories = JSON.parse(localStorage.getItem('master_sub_categories')) || []; // Untuk hitung jumlah sub nanti
    
    tableBody.innerHTML = '';

    const filtered = categories.filter(c => c.name.toLowerCase().includes(filter.toLowerCase()));

    if (filtered.length > 0) {
        filtered.forEach((cat, index) => {
            // Hitung jumlah sub-kategori yang memiliki parent_id ini
            const countSub = subCategories.filter(sub => sub.parent_id == cat.id).length;

            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="ps-4">${index + 1}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="category-icon-box me-3">
                            <i class="bi bi-folder2-open"></i>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="text-gray-800 fs-6 fw-bold">${cat.name}</span>
                            <span class="text-muted fs-7">Slug: /category/${cat.slug}</span>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge badge-light-success text-success fw-bold">Active</span>
                </td>
                <td>
                    <span class="badge badge-count fw-bold px-3 py-2">${countSub} Sub-Kategori</span>
                </td>
                <td class="text-end pe-4">
                    <div class="d-flex justify-content-end gap-2">
                        <button class="btn btn-sm btn-icon btn-light-primary" onclick="alert('Fitur edit menyusul bro')">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-sm btn-icon btn-light-danger" onclick="deleteCategory(${cat.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });
    } else {
        tableBody.innerHTML = '<tr><td colspan="5" class="text-center py-10 text-muted">Kategori tidak ditemukan.</td></tr>';
    }
}

function saveCategory() {
    const name = document.getElementById('cat_name').value;
    if (!name) return alert('Nama kategori wajib diisi!');

    let categories = JSON.parse(localStorage.getItem('master_induk_categories')) || [];
    
    const newCat = {
        id: Date.now(), // Generate Unique ID untuk relasi ke sub-category
        name: name,
        slug: name.toLowerCase().replace(/ /g, '-')
    };

    categories.push(newCat);
    localStorage.setItem('master_induk_categories', JSON.stringify(categories));

    // Reset Form & Tutup Modal
    document.getElementById('form_category').reset();
    const modal = bootstrap.Modal.getInstance(document.getElementById('modal_add_category'));
    modal.hide();

    renderTable();
}

function deleteCategory(id) {
    if(confirm('Hapus kategori ini? Pastikan tidak ada sub-kategori di dalamnya.')) {
        let categories = JSON.parse(localStorage.getItem('master_induk_categories')) || [];
        categories = categories.filter(c => c.id != id);
        localStorage.setItem('master_induk_categories', JSON.stringify(categories));
        renderTable();
    }
}
</script>
@endpush