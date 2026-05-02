@extends('layouts.admin.main')

@push('styles')
<style>
    :root {
        --primary-blue: #009ef7;
        --soft-blue: #f1faff;
        --border-blue: #e4e6ef;
    }

    .sub-icon-box {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #ffffff;
        color: var(--primary-blue);
        border: 1px solid var(--border-blue);
        border-radius: 6px;
    }

    .induk-tag {
        background-color: var(--soft-blue);
        color: var(--primary-blue);
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 700;
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
                    <input type="text" id="search_sub" class="form-control form-control-solid w-250px ps-12 border-blue" placeholder="Cari Sub Kategori...">
                </div>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-primary" onclick="openModalAdd()">
                    <i class="bi bi-node-plus-fill"></i> Tambah Sub Kategori
                </button>
            </div>
        </div>

        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="sub_table">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-50px ps-4">No</th>
                            <th class="min-w-200px">Sub Kategori</th>
                            <th>Induk Kategori</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        <!-- JS Rendering -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Sub Category -->
<div class="modal fade" id="modal_add_sub" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Sub Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_sub">
                    <div class="mb-7">
                        <label class="required fw-semibold fs-6 mb-2">Pilih Induk Kategori</label>
                        <select id="parent_id_select" class="form-select form-select-solid border-blue" required>
                            <option value="">-- Pilih Induk --</option>
                            <!-- Opsi diisi otomatis via JS -->
                        </select>
                    </div>
                    <div class="mb-5">
                        <label class="required fw-semibold fs-6 mb-2">Nama Sub Kategori</label>
                        <input type="text" id="sub_name" class="form-control form-control-solid border-blue" placeholder="Contoh: Kaos Oversize, Celana Cargo" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="saveSub()">Simpan Sub</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Dummy Data Sub Kategori Awal
    let initialSub = [
        { id: 201, parent_id: 101, name: 'Kaos Oversize' }, // 101 = Atasan
        { id: 202, parent_id: 101, name: 'Kemeja Flanel' },
        { id: 203, parent_id: 102, name: 'Celana Chino' }  // 102 = Bawahan
    ];

    if (!localStorage.getItem('master_sub_categories')) {
        localStorage.setItem('master_sub_categories', JSON.stringify(initialSub));
    }

    renderSubTable();

    // Search function
    document.getElementById('search_sub').addEventListener('keyup', (e) => renderSubTable(e.target.value));
});

function openModalAdd() {
    const parentSelect = document.getElementById('parent_id_select');
    const parents = JSON.parse(localStorage.getItem('master_induk_categories')) || [];
    
    // Reset dropdown & isi dengan data terbaru dari master induk
    parentSelect.innerHTML = '<option value="">-- Pilih Induk --</option>';
    parents.forEach(p => {
        parentSelect.innerHTML += `<option value="${p.id}">${p.name}</option>`;
    });

    const modal = new bootstrap.Modal(document.getElementById('modal_add_sub'));
    modal.show();
}

function renderSubTable(filter = "") {
    const tableBody = document.querySelector('#sub_table tbody');
    const subs = JSON.parse(localStorage.getItem('master_sub_categories')) || [];
    const parents = JSON.parse(localStorage.getItem('master_induk_categories')) || [];
    
    tableBody.innerHTML = '';

    const filtered = subs.filter(s => s.name.toLowerCase().includes(filter.toLowerCase()));

    if (filtered.length > 0) {
        filtered.forEach((sub, index) => {
            // Cari nama induk berdasarkan parent_id
            const parent = parents.find(p => p.id == sub.parent_id);
            const parentName = parent ? parent.name : '<span class="text-danger">Induk Dihapus</span>';

            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="ps-4">${index + 1}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="sub-icon-box me-3">
                            <i class="bi bi-arrow-return-right"></i>
                        </div>
                        <span class="text-gray-800 fw-bold">${sub.name}</span>
                    </div>
                </td>
                <td>
                    <span class="induk-tag">${parentName}</span>
                </td>
                <td><span class="badge badge-light-primary small">Active</span></td>
                <td class="text-end pe-4">
                    <button class="btn btn-sm btn-icon btn-light-danger" onclick="deleteSub(${sub.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    } else {
        tableBody.innerHTML = '<tr><td colspan="5" class="text-center py-10 text-muted">Sub kategori belum ada.</td></tr>';
    }
}

function saveSub() {
    const parentId = document.getElementById('parent_id_select').value;
    const name = document.getElementById('sub_name').value;

    if (!parentId || !name) return alert('Semua field wajib diisi!');

    let subs = JSON.parse(localStorage.getItem('master_sub_categories')) || [];
    
    subs.push({
        id: Date.now(),
        parent_id: parseInt(parentId),
        name: name
    });

    localStorage.setItem('master_sub_categories', JSON.stringify(subs));
    
    // Close modal (Bootstrap 5 way)
    const modalEl = document.getElementById('modal_add_sub');
    const modal = bootstrap.Modal.getInstance(modalEl);
    modal.hide();

    renderSubTable();
    document.getElementById('form_sub').reset();
}

function deleteSub(id) {
    if(confirm('Hapus sub kategori ini?')) {
        let subs = JSON.parse(localStorage.getItem('master_sub_categories')) || [];
        subs = subs.filter(s => s.id != id);
        localStorage.setItem('master_sub_categories', JSON.stringify(subs));
        renderSubTable();
    }
}
</script>
@endpush