@extends('layouts.admin.main')

@push('styles')
<style>
    /* Custom Blue-White Theme */
    :root {
        --primary-blue: #009ef7;
        --soft-blue: #f1faff;
        --border-blue: #e4e6ef;
    }

    .card { border-radius: 12px; }
    .bg-light-blue { background-color: var(--soft-blue) !important; color: var(--primary-blue) !important; }
    
    /* Animation for New Orders */
    .pulse-blue {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
        background-color: var(--primary-blue);
        box-shadow: 0 0 0 rgba(0, 158, 247, 0.4);
        animation: pulse-blue 2s infinite;
    }
    @keyframes pulse-blue {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(0, 158, 247, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(0, 158, 247, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(0, 158, 247, 0); }
    }

    .table-fashion thead tr {
        background-color: #f5f8fa !important;
        color: #5e6278 !important;
    }
    
    .clothing-tag {
        background-color: #ffffff;
        border: 1px solid var(--border-blue);
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-action-blue {
        background-color: #ffffff;
        border: 1px solid var(--border-blue);
        color: var(--primary-blue);
    }
    .btn-action-blue:hover {
        background-color: var(--primary-blue);
        color: #ffffff;
    }
</style>
@endpush

@section('content')
<div class="container-xxl">
    <!-- Stats Row -->
    <div class="row g-5 mb-7">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-primary">
                <div class="card-body p-5">
                    <div class="text-white fw-bold fs-2" id="count_all">0</div>
                    <div class="text-white opacity-75 fw-semibold">Total Pesanan</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="background-color: #ffffff; border: 1px solid var(--border-blue) !important;">
                <div class="card-body p-5 text-center">
                    <div class="text-dark fw-bold fs-2" id="count_pending">0</div>
                    <div class="text-muted fw-semibold fs-7">Menunggu QC</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-light-blue">
                <div class="card-body p-5 text-center">
                    <div class="text-primary fw-bold fs-2" id="count_processing">0</div>
                    <div class="text-primary opacity-75 fw-semibold fs-7">Proses Packing</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="background-color: #e8fff3;">
                <div class="card-body p-5 text-center">
                    <div class="text-success fw-bold fs-2" id="count_completed">0</div>
                    <div class="text-success opacity-75 fw-semibold fs-7">Siap Kirim</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5 border-0">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="bi bi-search position-absolute ms-4 text-primary"></i>
                    <input type="text" id="search_queue" class="form-control form-control-solid w-300px ps-12 border-blue" placeholder="Cari Order ID atau Pelanggan...">
                </div>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-light-primary" onclick="location.reload()">
                    <i class="bi bi-arrow-repeat"></i> Refresh Antrian
                </button>
            </div>
        </div>

        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5 table-fashion" id="table_queue">
                    <thead>
                        <tr class="text-start text-uppercase fw-bold fs-7 gs-0">
                            <th class="ps-4">ORDER ID</th>
                            <th>CUSTOMER</th>
                            <th class="min-w-200px">ITEMS (CLOTHING)</th>
                            <th>STATUS</th>
                            <th class="text-end pe-4">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600" id="queue_body">
                        <!-- Data Rendering via JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data Dummy Produk Baju
    let orders = JSON.parse(localStorage.getItem('clothing_orders')) || [
        {
            id: '#ODR-7721',
            customer: 'Rian Perdana',
            items: [
                { name: 'Oversize Tee White', qty: 2, size: 'XL', color: 'White' },
                { name: 'Chino Pants Slim Fit', qty: 1, size: '32', color: 'Beige' }
            ],
            status: 'pending',
            time: '09:15'
        },
        {
            id: '#ODR-7722',
            customer: 'Clarissa Putri',
            items: [
                { name: 'Floral Summer Dress', qty: 1, size: 'M', color: 'Soft Pink' }
            ],
            status: 'processing',
            time: '10:05'
        },
        {
            id: '#ODR-7723',
            customer: 'Andika Pratama',
            items: [
                { name: 'Denim Jacket V2', qty: 1, size: 'L', color: 'Indigo Blue' }
            ],
            status: 'completed',
            time: '11:20'
        }
    ];

    const queueBody = document.getElementById('queue_body');

    function renderQueue(filter = "") {
        queueBody.innerHTML = '';
        let pending = 0, processing = 0, completed = 0;

        orders.forEach((ord, idx) => {
            if (filter && !ord.id.toLowerCase().includes(filter.toLowerCase()) && !ord.customer.toLowerCase().includes(filter.toLowerCase())) return;

            if(ord.status === 'pending') pending++;
            if(ord.status === 'processing') processing++;
            if(ord.status === 'completed') completed++;

            const row = document.createElement('tr');
            
            // Status Styling Logic
            let statusMarkup = '';
            if(ord.status === 'pending') {
                statusMarkup = `<span class="badge badge-light-dark text-dark fw-bold"><span class="pulse-blue"></span>Waiting QC</span>`;
            } else if(ord.status === 'processing') {
                statusMarkup = `<span class="badge badge-light-blue fw-bold">Packing</span>`;
            } else {
                statusMarkup = `<span class="badge badge-light-success fw-bold">Ready to Ship</span>`;
            }

            row.innerHTML = `
                <td class="ps-4">
                    <span class="text-primary fw-bold fs-6">${ord.id}</span>
                </td>
                <td>
                    <div class="d-flex flex-column">
                        <span class="text-gray-800 fw-bold">${ord.customer}</span>
                        <span class="text-muted fs-7">${ord.time} Today</span>
                    </div>
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-2">
                        ${ord.items.map(i => `
                            <div class="clothing-tag">
                                <span class="fw-bold text-dark">${i.qty}x</span>
                                <span class="text-gray-700">${i.name}</span>
                                <span class="badge badge-light-secondary fs-8">${i.size} / ${i.color}</span>
                            </div>
                        `).join('')}
                    </div>
                </td>
                <td>${statusMarkup}</td>
                <td class="text-end pe-4">
                    <div class="d-flex justify-content-end gap-2">
                        ${ord.status !== 'completed' ? `
                        <button class="btn btn-icon btn-sm btn-action-blue" onclick="nextStep(${idx})" title="Lanjut Tahapan">
                            <i class="bi bi-arrow-right-short fs-3"></i>
                        </button>` : ''}
                        <button class="btn btn-icon btn-sm btn-light-danger" onclick="deleteOrder(${idx})">
                            <i class="bi bi-trash3 fs-7"></i>
                        </button>
                    </div>
                </td>
            `;
            queueBody.appendChild(row);
        });

        // Update Stats
        document.getElementById('count_all').innerText = orders.length;
        document.getElementById('count_pending').innerText = pending;
        document.getElementById('count_processing').innerText = processing;
        document.getElementById('count_completed').innerText = completed;
    }

    window.nextStep = function(idx) {
        if(orders[idx].status === 'pending') orders[idx].status = 'processing';
        else if(orders[idx].status === 'processing') orders[idx].status = 'completed';
        save();
    };

    window.deleteOrder = function(idx) {
        if(confirm('Batalkan pesanan ini?')) {
            orders.splice(idx, 1);
            save();
        }
    };

    function save() {
        localStorage.setItem('clothing_orders', JSON.stringify(orders));
        renderQueue();
    }

    document.getElementById('search_queue').addEventListener('keyup', (e) => renderQueue(e.target.value));

    renderQueue();
});
</script>
@endpush