@extends('layouts.admin.main')

@push('styles')
<style>
    :root {
        --primary-blue: #009ef7;
        --soft-blue: #f1faff;
        --border-blue: #e4e6ef;
    }

    .size-tag {
        background-color: var(--soft-blue);
        color: var(--primary-blue);
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 800;
        border: 1px solid #d0eaff;
        display: inline-block;
        min-width: 40px;
        text-align: center;
    }

    .cat-badge {
        background-color: #f5f8fa;
        color: #5e6278;
        padding: 4px 10px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 0.8rem;
    }
</style>
@endpush

@section('content')
<div class="container-xxl">
    <div class="card card-flush shadow-sm">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5 border-0">
            <div class="card-title">
                <h2 class="fw-bold"><i class="bi bi-rulers text-primary me-2"></i>Master Ukuran Produk</h2>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_size">
                    <i class="bi bi-plus-lg"></i> Tambah Ukuran
                </button>
            </div>
        </div>

        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="size_table">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="ps-4 w-50px">No</th>
                            <th class="min-w-150px">Label Ukuran</th>
                            <th class="min-w-150px">Kategori Ukuran</th>
                            <th>Status</th>
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

<div class="modal fade" id="modal_add_size" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Ukuran Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form_size">
                    <div class="mb-7">
                        <label class="required fw-bold mb-2">Label Ukuran</label>
                        <input type="text" id="size_label" class="form-control form-control-solid border-blue" placeholder="Contoh: XL, 42, 32W" required>
                    </div>
                    <div class="mb-5">
                        <label class="required fw-bold mb-2">Kategori Ukuran</label>
                        <select id="size_category" class="form-select form-select-solid border-blue" required>
                            <option value="Atasan">Atasan (Kaos, Kemeja, Hoodie)</option>
                            <option value="Bawahan">Bawahan (Celana, Rok)</option>
                            <option value="Aksesoris">Aksesoris / Sepatu</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="saveSize()">Simpan Ukuran</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Data Dummy Awal
    let initialSizes = [
        { id: 1, label: 'S', category: 'Atasan' },
        { id: 2, label: 'M', category: 'Atasan' },
        { id: 3, label: 'L', category: 'Atasan' },
        { id: 4, label: 'XL', category: 'Atasan' },
        { id: 5, label: '30', category: 'Bawahan' },
        { id: 6, label: '32', category: 'Bawahan' }
    ];

    if (!localStorage.getItem('master_sizes')) {
        localStorage.setItem('master_sizes', JSON.stringify(initialSizes));
    }

    renderSizeTable();
});

function renderSizeTable() {
    const tableBody = document.querySelector('#size_table tbody');
    const sizes = JSON.parse(localStorage.getItem('master_sizes')) || [];
    
    tableBody.innerHTML = '';

    sizes.forEach((s, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="ps-4">${index + 1}</td>
            <td>
                <span class="size-tag">${s.label}</span>
            </td>
            <td>
                <span class="cat-badge">${s.category}</span>
            </td>
            <td>
                <span class="badge badge-light-success fw-bold">Aktif</span>
            </td>
            <td class="text-end pe-4">
                <button class="btn btn-sm btn-icon btn-light-danger" onclick="deleteSize(${s.id})">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

function saveSize() {
    const label = document.getElementById('size_label').value;
    const cat = document.getElementById('size_category').value;

    if(!label || !cat) return alert('Lengkapi data ukuran!');

    let sizes = JSON.parse(localStorage.getItem('master_sizes')) || [];
    
    sizes.push({
        id: Date.now(),
        label: label,
        category: cat
    });

    localStorage.setItem('master_sizes', JSON.stringify(sizes));
    
    bootstrap.Modal.getInstance(document.getElementById('modal_add_size')).hide();
    document.getElementById('form_size').reset();
    renderSizeTable();
}

function deleteSize(id) {
    if(confirm('Hapus ukuran ini dari master?')) {
        let sizes = JSON.parse(localStorage.getItem('master_sizes')) || [];
        sizes = sizes.filter(s => s.id != id);
        localStorage.setItem('master_sizes', JSON.stringify(sizes));
        renderSizeTable();
    }
}
</script>
@endpush