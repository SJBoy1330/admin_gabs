@extends('layouts.admin.main')

@push('styles')
<style>
    :root { --flash-red: #d9534f; --blue-accent: #009ef7; }
    .table-flash thead { background-color: #f8f9fa; }
    .badge-stock { background-color: #e1f0ff; color: #007bff; border: 1px solid #b8daff; }
    .price-original { text-decoration: line-through; color: #a1a5b7; font-size: 0.85rem; }
</style>
@endpush

@section('content')
<div class="container-xxl">
    <div class="card card-flush shadow-sm">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <div class="card-title">
                <h2 class="fw-bold"><i class="bi bi-lightning-fill text-warning me-2"></i>Pengaturan Flash Sale</h2>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-primary" onclick="openFlashModal()">
                    <i class="bi bi-plus-lg"></i> Tambah Promo Flash Sale
                </button>
            </div>
        </div>

        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5 table-flash" id="table_flash_sale">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="ps-4">Produk</th>
                            <th>Harga Promo</th>
                            <th>Alokasi Stok</th>
                            <th>Durasi Promo</th>
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

<div class="modal fade" id="modal_flash_sale" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Setting Flash Sale Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form_flash">
                    <div class="mb-7">
                        <label class="required fw-bold mb-2">Pilih Produk dari Gudang</label>
                        <select id="select_product" class="form-select form-select-solid" onchange="syncStockHint()" required>
                            <option value="">-- Pilih Produk --</option>
                        </select>
                        <div id="stock_hint" class="fs-7 text-primary mt-2 fw-bold"></div>
                    </div>

                    <div class="row g-5 mb-7">
                        <div class="col-md-6">
                            <label class="required fw-bold mb-2">Harga Flash Sale (Rp)</label>
                            <input type="number" id="f_price" class="form-control form-control-solid" placeholder="Contoh: 50000" required>
                        </div>
                        <div class="col-md-6">
                            <label class="required fw-bold mb-2">Stok yang Diikutkan</label>
                            <input type="number" id="f_stock_qty" class="form-control form-control-solid" placeholder="Contoh: 10" required>
                        </div>
                    </div>

                    <div class="row g-5">
                        <div class="col-md-12">
                            <label class="required fw-bold mb-2">Durasi Promo (Jam)</label>
                            <div class="input-group input-group-solid">
                                <input type="number" id="f_duration" class="form-control" placeholder="Contoh: 2" min="1" required>
                                <span class="input-group-text">Jam</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="processSaveFlash()">Simpan & Aktifkan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    renderFlashTable();
});

// Fungsi buka modal & tarik data produk asli
function openFlashModal() {
    const products = JSON.parse(localStorage.getItem('my_products')) || [];
    const select = document.getElementById('select_product');
    
    select.innerHTML = '<option value="">-- Pilih Produk --</option>';
    products.forEach(p => {
        // Hitung stok asli (relate ke data gudang)
        let totalStock = 0;
        if (p.variations && p.variations.length > 0) {
            totalStock = p.variations.reduce((sum, v) => sum + parseInt(v.stock || 0), 0);
        } else {
            totalStock = p.stock || 0;
        }

        select.innerHTML += `<option value="${p.id}" data-stock="${totalStock}" data-price="${p.price}" data-img="${p.image || p.cover || ''}">${p.name} (Gudang: ${totalStock})</option>`;
    });

    const modal = new bootstrap.Modal(document.getElementById('modal_flash_sale'));
    modal.show();
}

// Menampilkan info stok gudang saat produk dipilih
function syncStockHint() {
    const select = document.getElementById('select_product');
    const option = select.options[select.selectedIndex];
    const stock = option.dataset.stock;
    const price = option.dataset.price;

    if(stock) {
        document.getElementById('stock_hint').innerHTML = `
            <i class="bi bi-info-circle-fill me-1"></i> 
            Stok Gudang: ${stock} pcs | Harga Normal: Rp ${new Intl.NumberFormat('id-ID').format(price)}`;
    } else {
        document.getElementById('stock_hint').innerText = '';
    }
}

function renderFlashTable() {
    const tableBody = document.querySelector('#table_flash_sale tbody');
    const flashSales = JSON.parse(localStorage.getItem('flash_sales_admin')) || [];
    
    tableBody.innerHTML = '';

    if (flashSales.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="6" class="text-center py-10 text-muted">Belum ada promo flash sale aktif.</td></tr>';
        return;
    }

    flashSales.forEach((fs, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="ps-4">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-40px me-3">
                        <img src="${fs.img || 'https://via.placeholder.com/40'}" class="rounded">
                    </div>
                    <div class="d-flex flex-column">
                        <span class="text-gray-800 fw-bold">${fs.name}</span>
                        <span class="text-muted fs-7">ID: ${fs.productId}</span>
                    </div>
                </div>
            </td>
            <td>
                <div class="d-flex flex-column">
                    <span class="text-danger fw-bold">Rp ${new Intl.NumberFormat('id-ID').format(fs.flashPrice)}</span>
                    <span class="price-original">Rp ${new Intl.NumberFormat('id-ID').format(fs.normalPrice)}</span>
                </div>
            </td>
            <td><span class="badge badge-stock fw-bold">${fs.flashStock} / ${fs.totalGudang} pcs</span></td>
            <td><span class="badge badge-light-dark fw-bold"><i class="bi bi-clock me-1"></i> ${fs.duration} Jam</span></td>
            <td><span class="badge badge-light-success">Berjalan</span></td>
            <td class="text-end pe-4">
                <button class="btn btn-sm btn-icon btn-light-danger" onclick="deleteFlash(${index})">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

function processSaveFlash() {
    const select = document.getElementById('select_product');
    const opt = select.options[select.selectedIndex];
    
    const fPrice = document.getElementById('f_price').value;
    const fStock = parseInt(document.getElementById('f_stock_qty').value);
    const fDuration = document.getElementById('f_duration').value;
    const gudangStock = parseInt(opt.dataset.stock);

    // Validasi
    if (!select.value || !fPrice || !fStock || !fDuration) return alert('Lengkapi semua data!');
    if (fStock > gudangStock) return alert(`Stok tidak cukup! Maksimal stok gudang adalah ${gudangStock}`);

    const flashSales = JSON.parse(localStorage.getItem('flash_sales_admin')) || [];
    
    flashSales.push({
        productId: select.value,
        name: opt.text.split(' (Gudang:')[0],
        normalPrice: opt.dataset.price,
        flashPrice: fPrice,
        flashStock: fStock,
        totalGudang: gudangStock,
        duration: fDuration,
        img: opt.dataset.img
    });

    localStorage.setItem('flash_sales_admin', JSON.stringify(flashSales));
    
    bootstrap.Modal.getInstance(document.getElementById('modal_flash_sale')).hide();
    document.getElementById('form_flash').reset();
    renderFlashTable();
}

function deleteFlash(index) {
    if(confirm('Batalkan promo ini?')) {
        let flashSales = JSON.parse(localStorage.getItem('flash_sales_admin')) || [];
        flashSales.splice(index, 1);
        localStorage.setItem('flash_sales_admin', JSON.stringify(flashSales));
        renderFlashTable();
    }
}
</script>
@endpush