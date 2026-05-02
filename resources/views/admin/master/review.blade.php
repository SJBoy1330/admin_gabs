@extends('layouts.admin.main')

@push('styles')
<style>
    :root { --primary-blue: #009ef7; --star-color: #ffc700; }
    .star-rating { color: var(--star-color); font-size: 0.9rem; }
    .review-text { font-style: italic; color: #5e6278; border-left: 3px solid #e4e6ef; padding-left: 10px; }
    .user-avatar { background-color: #f1faff; color: #009ef7; font-weight: bold; }
</style>
@endpush

@section('content')
<div class="container-xxl">
    <div class="card card-flush shadow-sm">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5 border-0">
            <div class="card-title">
                <h2 class="fw-bold">Moderasi Review Produk</h2>
            </div>
            <div class="card-toolbar">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="bi bi-search position-absolute ms-4 text-primary"></i>
                    <input type="text" id="search_review" class="form-control form-control-solid w-250px ps-12" placeholder="Cari Produk / User...">
                </div>
            </div>
        </div>

        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="review_table">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="ps-4 w-10px">#</th>
                            <th class="min-w-200px">Produk</th>
                            <th class="min-w-150px">User / Pembeli</th>
                            <th class="min-w-100px">Rating</th>
                            <th class="min-w-250px">Komentar</th>
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
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Data Dummy Review (Nanti ini relate ke ID di my_products)
    let initialReviews = [
        { 
            id: 1, 
            productId: 'P-001', 
            productName: 'Gabrielle Oversize Tee', 
            userName: 'Santo Doni', 
            rating: 5, 
            comment: 'Bahannya adem banget bro, gokil! Pengiriman cepet.',
            date: '2026-04-28'
        },
        { 
            id: 2, 
            productId: 'P-002', 
            productName: 'Innova Reborn Hoodie', 
            userName: 'Saka_Devs', 
            rating: 4, 
            comment: 'Warna agak beda dikit sama foto, tapi overall oke lah.',
            date: '2026-04-29'
        },
        { 
            id: 3, 
            productId: 'P-001', 
            productName: 'Gabrielle Oversize Tee', 
            userName: 'Budi Santoso', 
            rating: 2, 
            comment: 'Ukuran XL-nya agak sempit buat saya.',
            date: '2026-04-30'
        }
    ];

    if (!localStorage.getItem('product_reviews')) {
        localStorage.setItem('product_reviews', JSON.stringify(initialReviews));
    }

    renderReviewTable();

    // Search Logic
    document.getElementById('search_review').addEventListener('keyup', function(e) {
        renderReviewTable(e.target.value);
    });
});

function renderReviewTable(filter = "") {
    const tableBody = document.querySelector('#review_table tbody');
    const reviews = JSON.parse(localStorage.getItem('product_reviews')) || [];
    
    tableBody.innerHTML = '';

    const filtered = reviews.filter(r => 
        r.productName.toLowerCase().includes(filter.toLowerCase()) || 
        r.userName.toLowerCase().includes(filter.toLowerCase())
    );

    if (filtered.length > 0) {
        filtered.forEach((rev, index) => {
            // Generate Stars
            let stars = '';
            for(let i=1; i<=5; i++) {
                stars += `<i class="bi bi-star${i <= rev.rating ? '-fill' : ''} star-rating"></i>`;
            }

            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="ps-4">${index + 1}</td>
                <td>
                    <div class="d-flex flex-column">
                        <span class="text-gray-800 fw-bold">${rev.productName}</span>
                        <span class="text-muted fs-7">ID: ${rev.productId}</span>
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-35px symbol-circle user-avatar me-3">
                            <span class="symbol-label">${rev.userName.charAt(0)}</span>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="text-gray-800 fw-bold">${rev.userName}</span>
                            <span class="text-muted fs-8">${rev.date}</span>
                        </div>
                    </div>
                </td>
                <td>${stars}</td>
                <td>
                    <div class="review-text fs-7">"${rev.comment}"</div>
                </td>
                <td class="text-end pe-4">
                    <button class="btn btn-sm btn-icon btn-light-danger" onclick="deleteReview(${rev.id})">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    } else {
        tableBody.innerHTML = '<tr><td colspan="6" class="text-center py-10 text-muted">Review tidak ditemukan.</td></tr>';
    }
}

function deleteReview(id) {
    if(confirm('Hapus review ini secara permanen? Tindakan ini tidak bisa dibatalkan.')) {
        let reviews = JSON.parse(localStorage.getItem('product_reviews')) || [];
        reviews = reviews.filter(r => r.id != id);
        localStorage.setItem('product_reviews', JSON.stringify(reviews));
        renderReviewTable();
    }
}
</script>
@endpush