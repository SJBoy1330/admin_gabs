@extends('layouts.admin.main')

@push('styles')
<style>
    :root { 
        --fit-blue: #009ef7; 
        --fit-bg: #f8f9fa; 
    }
    .fit-card {
        border-left: 4px solid var(--fit-blue);
        background-color: var(--fit-bg);
        padding: 8px 15px;
        border-radius: 0 8px 8px 0;
        display: inline-block;
    }
    .fit-title {
        font-weight: 800;
        color: #181c32;
        display: block;
        line-height: 1.2;
    }
    .fit-desc {
        font-size: 0.75rem;
        color: #a1a5b7;
    }
</style>
@endpush

@section('content')
<div class="container-xxl">
    <div class="card card-flush shadow-sm">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5 border-0">
            <div class="card-title">
                <h2 class="fw-bold"><i class="bi bi-person-bounding-box text-primary me-2"></i>Master Fit Label</h2>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_fit">
                    <i class="bi bi-plus-lg"></i> Tambah Fit Label
                </button>
            </div>
        </div>

        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="fit_table">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="ps-4 w-50px">No</th>
                            <th class="min-w-200px">Tipe Potongan (Fit)</th>
                            <th class="min-w-300px">Deskripsi Singkat</th>
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

<div class="modal fade" id="modal_add_fit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Fit Label Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-10">
                <form id="form_fit">
                    <div class="mb-7">
                        <label class="required fw-bold mb-2">Nama Fit</label>
                        <input type="text" id="fit_name" class="form-control form-control-solid border-blue" placeholder="Contoh: Slim Fit, Regular, Oversize" required>
                    </div>
                    <div class="mb-5">
                        <label class="fw-bold mb-2">Deskripsi (Opsional)</label>
                        <textarea id="fit_desc" class="form-control form-control-solid border-blue" rows="3" placeholder="Contoh: Potongan longgar yang nyaman digunakan sehari-hari"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="saveFit()">Simpan Label</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Data Dummy Awal
    let initialFits = [
        { id: 1, name: 'Slim Fit', desc: 'Potongan pas badan, memberikan kesan ramping.' },
        { id: 2, name: 'Regular Fit', desc: 'Potongan standar yang tidak terlalu ketat atau longgar.' },
        { id: 3, name: 'Oversize Fit', desc: 'Potongan jauh lebih besar dari ukuran standar.' },
        { id: 4, name: 'Skinny Fit', desc: 'Sangat ketat dari paha hingga pergelangan kaki.' }
    ];

    if (!localStorage.getItem('master_fits')) {
        localStorage.setItem('master_fits', JSON.stringify(initialFits));
    }

    renderFitTable();
});

function renderFitTable() {
    const tableBody = document.querySelector('#fit_table tbody');
    const fits = JSON.parse(localStorage.getItem('master_fits')) || [];
    
    tableBody.innerHTML = '';

    if (fits.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="4" class="text-center py-10 text-muted">Belum ada data fit label.</td></tr>';
        return;
    }

    fits.forEach((f, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="ps-4">${index + 1}</td>
            <td>
                <div class="fit-card">
                    <span class="fit-title">${f.name}</span>
                </div>
            </td>
            <td>
                <span class="text-gray-600 fs-7">${f.desc || '-'}</span>
            </td>
            <td class="text-end pe-4">
                <button class="btn btn-sm btn-icon btn-light-danger" onclick="deleteFit(${f.id})">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

function saveFit() {
    const name = document.getElementById('fit_name').value.trim();
    const desc = document.getElementById('fit_desc').value.trim();

    if(!name) return alert('Nama fit label tidak boleh kosong!');

    let fits = JSON.parse(localStorage.getItem('master_fits')) || [];
    
    fits.push({
        id: Date.now(),
        name: name,
        desc: desc
    });

    localStorage.setItem('master_fits', JSON.stringify(fits));
    
    bootstrap.Modal.getInstance(document.getElementById('modal_add_fit')).hide();
    document.getElementById('form_fit').reset();
    renderFitTable();
}

function deleteFit(id) {
    if(confirm('Hapus fit label ini? Produk yang menggunakan label ini perlu diupdate manual.')) {
        let fits = JSON.parse(localStorage.getItem('master_fits')) || [];
        fits = fits.filter(f => f.id != id);
        localStorage.setItem('master_fits', JSON.stringify(fits));
        renderFitTable();
    }
}
</script>
@endpush