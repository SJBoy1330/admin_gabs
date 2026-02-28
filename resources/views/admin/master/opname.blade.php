@extends('layouts.admin.main')

@push('styles')
<style>
    .table-opname input { width: 100px; }
    .diff-positive { color: #28a745; font-weight: bold; }
    .diff-negative { color: #f1416c; font-weight: bold; }
    .product-header { background-color: #f8f9fa; font-weight: bold; }
    .sticky-submit { position: sticky; bottom: 20px; z-index: 100; }
</style>
@endpush

@section('content')
<div class="container-xxl">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-dark">Stock Opname</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Sesuaikan stok sistem dengan stok fisik gudang</span>
            </h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-light-primary btn-sm me-3" onclick="window.location.reload()">
                    <i class="bi bi-arrow-clockwise"></i> Refresh Data
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="mb-5">
                <input type="text" id="search_opname" class="form-control form-control-solid w-250px" placeholder="Cari Nama Produk...">
            </div>

            <div class="table-responsive">
                <table class="table table-row-bordered table-row-gray-300 align-middle gs-0 gy-4 table-opname" id="table_opname">
                    <thead>
                        <tr class="fw-bold text-muted bg-light">
                            <th class="ps-4 min-w-300px rounded-start">Produk & Variasi</th>
                            <th class="min-w-125px">Stok Sistem</th>
                            <th class="min-w-150px">Stok Fisik (Optimal)</th>
                            <th class="min-w-125px rounded-end">Selisih</th>
                        </tr>
                    </thead>
                    <tbody>
                        </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-5 sticky-submit">
                <button type="button" id="btn_save_opname" class="btn btn-danger btn-lg shadow">
                    <i class="bi bi-check-circle me-2"></i>SIMPAN PENYESUAIAN STOK
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('#table_opname tbody');
    const searchInput = document.getElementById('search_opname');
    
    // 1. Ambil data dari LocalStorage yang sama
    let products = JSON.parse(localStorage.getItem('my_products')) || [];

    function renderOpname(filter = "") {
        tableBody.innerHTML = '';
        
        if (products.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="4" class="text-center py-10">Belum ada data produk.</td></tr>';
            return;
        }

        products.forEach((product, pIdx) => {
            if (filter && !product.name.toLowerCase().includes(filter.toLowerCase())) return;

            // Baris Header Produk
            const headerRow = document.createElement('tr');
            headerRow.className = 'product-header';
            headerRow.innerHTML = `
                <td colspan="4" class="ps-4">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-30px me-3">
                            <img src="${product.cover || 'https://via.placeholder.com/30'}" alt="">
                        </div>
                        <span class="text-dark fw-bold">${product.name}</span>
                    </div>
                </td>
            `;
            tableBody.appendChild(headerRow);

            // Baris per Variasi
            if (product.variations && product.variations.length > 0) {
                product.variations.forEach((variant, vIdx) => {
                    const row = document.createElement('tr');
                    const sysStock = parseInt(variant.stock || 0);
                    
                    row.innerHTML = `
                        <td class="ps-10">
                            <span class="text-muted fw-semibold d-block fs-7">Varian:</span>
                            <span class="text-dark fw-bold">${variant.variant}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-light-dark fs-6">${sysStock}</span>
                        </td>
                        <td>
                            <input type="number" 
                                   class="form-control form-control-sm input-fisik" 
                                   data-pidx="${pIdx}" 
                                   data-vidx="${vIdx}" 
                                   data-system="${sysStock}" 
                                   value="${sysStock}">
                        </td>
                        <td class="text-center">
                            <span class="selisih-badge badge badge-light-secondary">0</span>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            } else {
                // Jika produk tidak punya variasi
                const row = document.createElement('tr');
                const sysStock = parseInt(product.stock || 0);
                row.innerHTML = `
                    <td class="ps-10 text-muted italic">Tanpa Variasi</td>
                    <td class="text-center"><span class="badge badge-light-dark fs-6">${sysStock}</span></td>
                    <td>
                        <input type="number" class="form-control form-control-sm input-fisik" 
                               data-pidx="${pIdx}" data-vidx="-1" data-system="${sysStock}" value="${sysStock}">
                    </td>
                    <td class="text-center"><span class="selisih-badge badge badge-light-secondary">0</span></td>
                `;
                tableBody.appendChild(row);
            }
        });

        initInputListeners();
    }

    // 2. Logika Hitung Selisih Otomatis
    function initInputListeners() {
        document.querySelectorAll('.input-fisik').forEach(input => {
            input.addEventListener('input', function() {
                const systemStock = parseInt(this.dataset.system);
                const fisikStock = parseInt(this.value) || 0;
                const selisih = fisikStock - systemStock;
                const badge = this.closest('tr').querySelector('.selisih-badge');

                badge.innerText = (selisih > 0 ? '+' : '') + selisih;
                
                // Ganti warna badge berdasarkan selisih
                badge.className = 'selisih-badge badge fw-bold ';
                if (selisih > 0) badge.classList.add('badge-light-success');
                else if (selisih < 0) badge.classList.add('badge-light-danger');
                else badge.classList.add('badge-light-secondary');
            });
        });
    }

    // 3. Simpan Penyesuaian ke LocalStorage
    document.getElementById('btn_save_opname').onclick = function() {
        const inputs = document.querySelectorAll('.input-fisik');
        
        if (!confirm('Simpan penyesuaian stok ini ke sistem?')) return;

        inputs.forEach(input => {
            const pIdx = input.dataset.pidx;
            const vIdx = input.dataset.vidx;
            const newVal = parseInt(input.value) || 0;

            if (vIdx === "-1") {
                // Update produk tanpa variasi
                products[pIdx].stock = newVal;
            } else {
                // Update variasi spesifik
                products[pIdx].variations[vIdx].stock = newVal;
            }
        });

        // Simpan balik ke LocalStorage yang sama
        localStorage.setItem('my_products', JSON.stringify(products));
        
        alert('Stock Opname Berhasil Disimpan!');
        window.location.href = "{{ url('master/product') }}";
    };

    // Search function
    searchInput.addEventListener('keyup', (e) => renderOpname(e.target.value));

    renderOpname();
});
</script>
@endpush