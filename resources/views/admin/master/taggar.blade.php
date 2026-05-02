@extends('layouts.admin.main')

@push('styles')
<style>
    :root { 
        --tag-blue: #009ef7; 
        --tag-bg: #f1faff; 
    }
    .tag-item {
        background-color: var(--tag-bg);
        color: var(--tag-blue);
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        border: 1px dashed var(--tag-blue);
        display: inline-flex;
        align-items: center;
    }
    .tag-item i { font-size: 0.7rem; margin-right: 5px; }
</style>
@endpush

@section('content')
<div class="container-xxl">
    <div class="card card-flush shadow-sm">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5 border-0">
            <div class="card-title">
                <h2 class="fw-bold"><i class="bi bi-hash text-primary me-2"></i>Master Taggar Produk</h2>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_tag">
                    <i class="bi bi-plus-lg"></i> Tambah Taggar
                </button>
            </div>
        </div>

        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="tag_table">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="ps-4 w-50px">No</th>
                            <th class="min-w-200px">Nama Taggar</th>
                            <th class="min-w-150px">Penggunaan</th>
                            <th class="min-w-100px">Status</th>
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

<div class="modal fade" id="modal_add_tag" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Taggar Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form_tag">
                    <div class="mb-5">
                        <label class="required fw-bold mb-2">Nama Taggar</label>
                        <div class="input-group input-group-solid border-blue">
                            <span class="input-group-text">#</span>
                            <input type="text" id="tag_name" class="form-control" placeholder="Contoh: vintage, kpopstyle, promo" required>
                        </div>
                        <div class="text-muted fs-7 mt-2">Gunakan huruf kecil dan tanpa spasi untuk hasil terbaik.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="saveTag()">Simpan Taggar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Data Dummy Awal
    let initialTags = [
        { id: 1, name: 'oversize', count: 12 },
        { id: 2, name: 'unisex', count: 45 },
        { id: 3, name: 'lokalbrand', count: 8 },
        { id: 4, name: 'premium', count: 21 },
        { id: 5, name: 'streetwear', count: 15 }
    ];

    if (!localStorage.getItem('master_tags')) {
        localStorage.setItem('master_tags', JSON.stringify(initialTags));
    }

    renderTagTable();
});

function renderTagTable() {
    const tableBody = document.querySelector('#tag_table tbody');
    const tags = JSON.parse(localStorage.getItem('master_tags')) || [];
    
    tableBody.innerHTML = '';

    if (tags.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="5" class="text-center py-10 text-muted">Belum ada taggar.</td></tr>';
        return;
    }

    tags.forEach((t, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="ps-4">${index + 1}</td>
            <td>
                <span class="tag-item"><i class="bi bi-hash"></i>${t.name}</span>
            </td>
            <td>
                <span class="fw-bold text-gray-700">${t.count} Produk</span>
            </td>
            <td>
                <span class="badge badge-light-primary text-primary fw-bold">Aktif</span>
            </td>
            <td class="text-end pe-4">
                <button class="btn btn-sm btn-icon btn-light-danger" onclick="deleteTag(${t.id})">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

function saveTag() {
    const nameInput = document.getElementById('tag_name').value.trim().toLowerCase().replace(/\s+/g, '');

    if(!nameInput) return alert('Nama taggar tidak boleh kosong!');

    let tags = JSON.parse(localStorage.getItem('master_tags')) || [];
    
    // Cek duplikasi
    if(tags.find(t => t.name === nameInput)) return alert('Taggar sudah ada!');

    tags.push({
        id: Date.now(),
        name: nameInput,
        count: 0
    });

    localStorage.setItem('master_tags', JSON.stringify(tags));
    
    bootstrap.Modal.getInstance(document.getElementById('modal_add_tag')).hide();
    document.getElementById('form_tag').reset();
    renderTagTable();
}

function deleteTag(id) {
    if(confirm('Hapus taggar ini? Taggar yang terhapus akan hilang dari semua produk.')) {
        let tags = JSON.parse(localStorage.getItem('master_tags')) || [];
        tags = tags.filter(t => t.id != id);
        localStorage.setItem('master_tags', JSON.stringify(tags));
        renderTagTable();
    }
}
</script>
@endpush