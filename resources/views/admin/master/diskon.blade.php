@extends('layouts.admin.main')

@push('styles')
<style>
    :root { --discount-blue: #009ef7; --soft-bg: #f8f9fa; }
    .card-discount { border: 1px solid #e4e6ef; transition: all 0.3s ease; }
    .card-discount:hover { border-color: var(--discount-blue); }
    .discount-badge { 
        position: absolute; top: 10px; right: 10px; 
        background: #f1faff; color: #009ef7; 
        padding: 5px 12px; border-radius: 20px; font-weight: bold; font-size: 0.8rem;
    }
    .price-old { text-decoration: line-through; color: #a1a5b7; font-size: 0.9rem; }
    .price-new { color: #181c32; font-weight: 800; font-size: 1.1rem; }
</style>
@endpush

@section('content')
<div class="container-xxl">
    <div class="card card-flush shadow-sm mb-10">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <div class="card-title">
                <h2 class="fw-bold"><i class="bi bi-tag-fill text-primary me-2"></i>Manajemen Diskon Produk</h2>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-primary" onclick="openDiscountModal()">
                    <i class="bi bi-percent"></i> Buat Promo Diskon
                </button>
            </div>
        </div>
    </div>

    <div class="row g-6" id="discount_list">
        </div>
</div>

<div class="modal fade" id="modal_discount" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Atur Diskon Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form_discount">
                    <div class="mb-7">
                        <label class="required fw-bold mb-2">Pilih Produk</label>
                        <select id="select_prod_disc" class="form-select form-select-solid" onchange="calculatePreview()" required>
                            <option value="">-- Pilih Produk --</option>
                        </select>
                    </div>

                    <div class="row g-5 mb-7">
                        <div class="col-md-6">
                            <label class="required fw-bold mb-2">Tipe Diskon</label>
                            <select id="disc_type" class="form-select form-select-solid" onchange="calculatePreview()">
                                <option value="percentage">Persentase (%)</option>
                                <option value="fixed">Potongan Harga (Rp)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="required fw-bold mb-2">Nilai</label>
                            <input type="number" id="disc_value" class="form-control form-control-solid" placeholder="0" oninput="calculatePreview()" required>
                        </div>
                    </div>

                    <div class="p-5 rounded bg-light-primary border border-dashed border-primary">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold">Harga Normal:</span>
                            <span id="prev_normal" class="text-gray-600">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold text-primary">Harga Setelah Diskon:</span>
                            <span id="prev_final" class="fw-bolder text-primary">Rp 0</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="saveDiscount()">Terapkan Diskon</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    renderDiscountCards();
});

function openDiscountModal() {
    const products = JSON.parse(localStorage.getItem('my_products')) || [];
    const select = document.getElementById('select_prod_disc');
    
    select.innerHTML = '<option value="">-- Pilih Produk --</option>';
    products.forEach(p => {
        select.innerHTML += `<option value="${p.id}" data-price="${p.price}" data-img="${p.image || p.cover || ''}">${p.name}</option>`;
    });

    new bootstrap.Modal(document.getElementById('modal_discount')).show();
}

function calculatePreview() {
    const select = document.getElementById('select_prod_disc');
    const type = document.getElementById('disc_type').value;
    const value = parseFloat(document.getElementById('disc_value').value) || 0;
    const price = parseFloat(select.options[select.selectedIndex]?.dataset.price) || 0;

    let finalPrice = price;
    if (type === 'percentage') {
        finalPrice = price - (price * (value / 100));
    } else {
        finalPrice = price - value;
    }

    document.getElementById('prev_normal').innerText = `Rp ${new Intl.NumberFormat('id-ID').format(price)}`;
    document.getElementById('prev_final').innerText = `Rp ${new Intl.NumberFormat('id-ID').format(finalPrice)}`;
}

function renderDiscountCards() {
    const container = document.getElementById('discount_list');
    const discounts = JSON.parse(localStorage.getItem('product_discounts')) || [];
    
    container.innerHTML = '';

    if (discounts.length === 0) {
        container.innerHTML = '<div class="col-12 text-center text-muted py-10">Belum ada produk dengan diskon aktif.</div>';
        return;
    }

    discounts.forEach((d, index) => {
        const card = document.createElement('div');
        card.className = 'col-md-3';
        card.innerHTML = `
            <div class="card card-discount shadow-sm position-relative">
                <div class="discount-badge">-${d.displayValue}</div>
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <img src="${d.img || 'https://via.placeholder.com/150'}" class="rounded w-100 h-150px" style="object-fit:cover">
                    </div>
                    <h5 class="fw-bold text-gray-800 mb-1 text-truncate">${d.name}</h5>
                    <div class="d-flex flex-column mb-4">
                        <span class="price-old">Rp ${new Intl.NumberFormat('id-ID').format(d.normalPrice)}</span>
                        <span class="price-new">Rp ${new Intl.NumberFormat('id-ID').format(d.finalPrice)}</span>
                    </div>
                    <button class="btn btn-sm btn-light-danger w-100" onclick="removeDiscount(${index})">
                        <i class="bi bi-trash me-1"></i> Hapus Promo
                    </button>
                </div>
            </div>
        `;
        container.appendChild(card);
    });
}

function saveDiscount() {
    const select = document.getElementById('select_prod_disc');
    const opt = select.options[select.selectedIndex];
    const type = document.getElementById('disc_type').value;
    const value = document.getElementById('disc_value').value;

    if (!select.value || !value) return alert('Lengkapi data!');

    const normalPrice = parseFloat(opt.dataset.price);
    let finalPrice = 0;
    let displayValue = "";

    if (type === 'percentage') {
        finalPrice = normalPrice - (normalPrice * (value / 100));
        displayValue = value + "%";
    } else {
        finalPrice = normalPrice - value;
        displayValue = "Rp " + new Intl.NumberFormat('id-ID').format(value);
    }

    const discounts = JSON.parse(localStorage.getItem('product_discounts')) || [];
    
    discounts.push({
        productId: select.value,
        name: opt.text,
        img: opt.dataset.img,
        normalPrice: normalPrice,
        finalPrice: finalPrice,
        displayValue: displayValue
    });

    localStorage.setItem('product_discounts', JSON.stringify(discounts));
    
    bootstrap.Modal.getInstance(document.getElementById('modal_discount')).hide();
    renderDiscountCards();
}

function removeDiscount(index) {
    if(confirm('Hapus promo diskon untuk produk ini?')) {
        let discounts = JSON.parse(localStorage.getItem('product_discounts')) || [];
        discounts.splice(index, 1);
        localStorage.setItem('product_discounts', JSON.stringify(discounts));
        renderDiscountCards();
    }
}
</script>
@endpush