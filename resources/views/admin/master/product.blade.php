@extends('layouts.admin.main')

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('#kt_ecommerce_products_table tbody');
    
    // 1. Ambil data (Gunakan Nama Key yang SAMA dengan Form Insert)
    const rawData = localStorage.getItem('my_products');
    console.log("Raw Data dari LocalStorage:", rawData); // Cek di F12 -> Console

    const products = JSON.parse(rawData) || [];
    console.log("Parsed Products:", products);

    tableBody.innerHTML = ''; 

    if (products.length > 0) {
        [...products].reverse().forEach((product) => {
            const newRow = document.createElement('tr');
            
            // MAPPING FIELD (Sesuaikan dengan object yang di-push saat insert)
            const productImage = product.cover || product.image || 'https://via.placeholder.com/50?text=No+Img';
            const productPrice = product.price || product.base_price || 0;
            const productName = product.name || 'Tanpa Nama';
            const productCat = product.category || 'Umum';
            const productId = product.id || 'N/A';
            const productDate = product.date || product.created_at || '-';

            // HITUNG STOK (Jika pakai sistem SKU Shopee, stok ada di dalam array variations)
            let totalStock = 0;
            if (product.variations && product.variations.length > 0) {
                totalStock = product.variations.reduce((sum, item) => sum + parseInt(item.stock || 0), 0);
            } else {
                totalStock = product.stock || 0;
            }

            newRow.innerHTML = `
                <td>
                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" value="${productId}" />
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-50px rounded me-3 overflow-hidden bg-light border">
                            <img src="${productImage}" alt="img" style="object-fit: cover; width: 50px; height: 50px;" />
                        </div>
                        <div class="d-flex flex-column">
                            <a href="#" class="text-gray-800 text-hover-primary fs-6 fw-bold">${productName}</a>
                            <span class="text-muted fs-7">Kategori: ${productCat} | ID: ${productId}</span>
                        </div>
                    </div>
                </td>
                <td><span class="fw-bold text-dark">Rp ${new Intl.NumberFormat('id-ID').format(productPrice)}</span></td>
                <td><span class="badge badge-light-success fw-bold">${totalStock} pcs</span></td>
                <td>
                    <div class="d-flex flex-column">
                        <span class="text-gray-800">Penjualan: 0</span>
                        <span class="text-muted fs-7">Tgl: ${productDate}</span>
                    </div>
                </td>
                <td><span class="badge badge-light-primary text-primary fw-bold small">Aktif</span></td>
                <td class="text-end">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ url('update/product') }}?id=${productId}" class="btn btn-sm btn-light-primary">Ubah</a>
                        <button type="button" class="btn btn-sm btn-light-danger" onclick="deleteProduct('${productId}')">Hapus</button>
                    </div>
                </td>
            `;
            tableBody.appendChild(newRow);
        });
    } else {
        tableBody.innerHTML = '<tr><td colspan="7" class="text-center py-10 text-muted">Belum ada produk. Coba insert produk baru dulu.</td></tr>';
    }
});

function deleteProduct(id) {
    if(confirm('Hapus produk ini?')) {
        let products = JSON.parse(localStorage.getItem('my_products')) || [];
        products = products.filter(p => p.id != id);
        localStorage.setItem('my_products', JSON.stringify(products));
        window.location.reload();
    }
}
</script>
@endpush

@section('content')
<div class="container-xxl" id="kt_content_container">
    <div class="card card-flush shadow-sm">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <div class="card-title">
                <h2 class="fw-bold">Produk Saya</h2>
            </div>
            <div class="card-toolbar">
                <a href="{{ url('insert/product') }}" class="btn btn-primary">+ Tambah Produk Baru</a>
            </div>
        </div>

        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">#</th>
                            <th class="min-w-200px">Produk</th>
                            <th class="min-w-100px">Harga</th>
                            <th class="min-w-100px">Total Stok</th>
                            <th class="min-w-150px">Performa</th>
                            <th class="min-w-100px">Status</th>
                            <th class="text-end min-w-70px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection