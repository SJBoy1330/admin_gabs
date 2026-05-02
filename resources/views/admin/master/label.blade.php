@extends('layouts.admin.main')

@push('styles')
<style>
    :root { --primary-blue: #009ef7; --soft-bg: #f1faff; }
    .label-preview { padding: 4px 10px; border-radius: 4px; font-weight: bold; font-size: 0.75rem; text-transform: uppercase; }
    .bg-label-new { background-color: #e8fff3; color: #50cd89; border: 1px solid #ccf7e4; } /* Hijau */
    .bg-label-best { background-color: #fff8dd; color: #ffc700; border: 1px solid #fff1bc; } /* Kuning */
    .bg-label-hot { background-color: #fff5f8; color: #f1416c; border: 1px solid #ffdae4; } /* Merah */
    .bg-label-limited { background-color: #f1faff; color: #009ef7; border: 1px solid #d0eaff; } /* Biru */
</style>
@endpush

@section('content')
<div class="container-xxl">
    <div class="card card-flush shadow-sm">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5 border-0">
            <div class="card-title">
                <h2 class="fw-bold">Manajemen Label Produk</h2>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_label">
                    <i class="bi bi-bookmark-plus-fill me-2"></i>Pasang Label Baru
                </button>
            </div>
        </div>

        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="label_table">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="ps-4 w-10px">#</th>
                            <th class="min-w-250px">Produk</th>
                            <th class="min-w-150px">Label Terpasang</th>
                            <th class="min-w-100px text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_add_label" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Pasang Label ke Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-10">
                <form id="form_label">
                    <div class="mb-7">
                        <label class="required fw-bold mb-2">Pilih Produk</label>
                        <select id="select_product_label" class="form-select form-select-solid border-blue" required>
                            <option value="">-- Pilih Produk --</option>
                        </select>
                    </div>
                    <div class="mb-5">
                        <label class="required fw-bold mb-2">Jenis Label</label>
                        <select id="select_label_type" class="form-select form-select-solid border-blue" required>
                            <option value="new">NEW ARRIVAL (Hijau)</option>
                            <option value="best">BEST SELLER (Kuning)</option>
                            <option value="hot">HOT ITEM (Merah)</option>
                            <option value="limited">LIMITED EDITION (Biru)</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="saveLabel()">Pasang Label</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Inisialisasi Data Dummy Label
    let initialLabels = [
        { id: 1, productId: 'P-001', labelType: 'new', labelName: 'NEW ARRIVAL' },
        { id: 2, productId: 'P-002', labelType: 'hot', labelName: 'HOT ITEM' }
    ];

    if (!localStorage.getItem('product_labels')) {
        localStorage.setItem('product_labels', JSON.stringify(initialLabels));
    }

    // 2. Load Produk ke Dropdown
    const products = JSON.parse(localStorage.getItem('my_products')) || [];
    const select = document.getElementById('select_product_label');
    products.forEach(p => {
        select.innerHTML += `<option value="${p.id}" data-img="${p.image || p.cover || ''}">${p.name}</option>`;
    });

    renderLabelTable();
});

function renderLabelTable() {
    const tableBody = document.querySelector('#label_table tbody');
    const labels = JSON.parse(localStorage.getItem('product_labels')) || [];
    const products = JSON.parse(localStorage.getItem('my_products')) || [];
    
    tableBody.innerHTML = '';

    if (labels.length > 0) {
        labels.forEach((label, index) => {
            const product = products.find(p => p.id == label.productId);
            const row = document.createElement('tr');
            
            row.innerHTML = `
                <td class="ps-4">${index + 1}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-45px me-3">
                            <img src="${product ? (product.image || product.cover) : 'https://via.placeholder.com/45'}" class="rounded">
                        </div>
                        <div class="d-flex flex-column">
                            <span class="text-gray-800 fw-bold">${product ? product.name : 'Produk Tidak Ditemukan'}</span>
                            <span class="text-muted fs-7">ID: ${label.productId}</span>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="label-preview bg-label-${label.labelType}">${label.labelName}</span>
                </td>
                <td class="text-end pe-4">
                    <button class="btn btn-sm btn-icon btn-light-danger" onclick="deleteLabel(${label.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    } else {
        tableBody.innerHTML = '<tr><td colspan="4" class="text-center py-10 text-muted">Belum ada label terpasang.</td></tr>';
    }
}

function saveLabel() {
    const productId = document.getElementById('select_product_label').value;
    const type = document.getElementById('select_label_type').value;
    const typeName = document.getElementById('select_label_type').options[document.getElementById('select_label_type').selectedIndex].text.split(' (')[0];

    if (!productId || !type) return alert('Pilih produk dan jenis label!');

    let labels = JSON.parse(localStorage.getItem('product_labels')) || [];
    
    // Validasi agar satu produk tidak punya dua label (opsional, tergantung kebutuhanmu)
    const existing = labels.find(l => l.productId == productId);
    if(existing) {
        if(!confirm('Produk ini sudah punya label. Ganti dengan yang baru?')) return;
        labels = labels.filter(l => l.productId != productId);
    }

    labels.push({
        id: Date.now(),
        productId: productId,
        labelType: type,
        labelName: typeName
    });

    localStorage.setItem('product_labels', JSON.stringify(labels));
    
    const modal = bootstrap.Modal.getInstance(document.getElementById('modal_add_label'));
    modal.hide();
    document.getElementById('form_label').reset();
    renderLabelTable();
}

function deleteLabel(id) {
    if(confirm('Lepas label dari produk ini?')) {
        let labels = JSON.parse(localStorage.getItem('product_labels')) || [];
        labels = labels.filter(l => l.id != id);
        localStorage.setItem('product_labels', JSON.stringify(labels));
        renderLabelTable();
    }
}
</script>
@endpush