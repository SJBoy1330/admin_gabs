@extends('layouts.admin.main')

@push('styles')
<style>
    :root {
        --primary-blue: #009ef7;
        --soft-blue: #f1faff;
        --border-blue: #e4e6ef;
        --success-green: #50cd89;
    }

    .tracking-card {
        border: 1px solid var(--border-blue);
        transition: all 0.3s ease;
    }
    .tracking-card:hover {
        border-color: var(--primary-blue);
        transform: translateY(-2px);
    }

    /* Stepper Mini Style */
    .stepper-mini {
        display: flex;
        align-items: center;
        gap: 0;
        margin-top: 10px;
    }
    .step-item {
        height: 4px;
        flex: 1;
        background: #eff2f5;
        position: relative;
        border-radius: 2px;
    }
    .step-item.active { background: var(--primary-blue); }
    .step-item.completed { background: var(--success-green); }
    
    .courier-badge {
        background-color: var(--soft-blue);
        color: var(--primary-blue);
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        border: 1px dashed var(--primary-blue);
    }

    .timeline-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #dee2e6;
        position: absolute;
        top: -3px;
    }
    .step-item.active .timeline-dot { 
        background: var(--primary-blue); 
        box-shadow: 0 0 0 3px rgba(0, 158, 247, 0.2);
    }
</style>
@endpush

@section('content')
<div class="container-xxl">
    <div class="d-flex flex-stack mb-7">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                Lacak Pengiriman
            </h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">Logistik</li>
                <li class="breadcrumb-item"><span class="bullet bg-gray-400 w-5px h-2px"></span></li>
                <li class="breadcrumb-item text-muted">Tracking Kurir</li>
            </ul>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="bi bi-truck position-absolute ms-4 text-primary fs-4"></i>
                    <input type="text" id="search_tracking" class="form-control form-control-solid w-350px ps-12 border-blue" placeholder="Cari Resi atau Nama Penerima...">
                </div>
            </div>
            <div class="card-toolbar">
                <select id="filter_courier" class="form-select form-select-solid w-150px me-3 border-blue">
                    <option value="">Semua Kurir</option>
                    <option value="JNE">JNE Express</option>
                    <option value="J&T">J&T Cargo</option>
                    <option value="Sicepat">Sicepat</option>
                </select>
            </div>
        </div>

        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="table_tracking">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="ps-4">No. Resi & Kurir</th>
                            <th>Penerima</th>
                            <th class="min-w-250px">Status Perjalanan</th>
                            <th>Update Terakhir</th>
                            <th class="text-end pe-4">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600" id="tracking_body">
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
    const trackingData = [
        { resi: 'JX-99210012', courier: 'JNE', receiver: 'Hendra Wijaya', location: 'Jakarta (Sortation Center)', update: '2 jam yang lalu', progress: 2, status: 'On Process' },
        { resi: 'JT-88200192', courier: 'J&T', receiver: 'Siska Amelia', location: 'Surabaya (Hub Timur)', update: '5 menit yang lalu', progress: 3, status: 'With Courier' },
        { resi: 'SC-11022938', courier: 'Sicepat', receiver: 'Bambang S.', location: 'Bandung (Delivered)', update: '1 hari yang lalu', progress: 4, status: 'Delivered' },
        { resi: 'JX-99210055', courier: 'JNE', receiver: 'Anita Joyo', location: 'Gudang Asal (Pickup)', update: '5 jam yang lalu', progress: 1, status: 'Picked Up' },
        { resi: 'JT-88200441', courier: 'J&T', receiver: 'Kevin Sanjaya', location: 'Semarang (Transit)', update: '1 jam yang lalu', progress: 2, status: 'On Process' },
        { resi: 'SC-11022000', courier: 'Sicepat', receiver: 'Rina Nose', location: 'Medan (Hub Sumatra)', update: '12 jam yang lalu', progress: 2, status: 'On Process' },
        { resi: 'JX-99210882', courier: 'JNE', receiver: 'Dedi Corbuzier', location: 'Jakarta (With Courier)', update: '10 menit yang lalu', progress: 3, status: 'With Courier' },
        { resi: 'JT-88200999', courier: 'J&T', receiver: 'Fuji An', location: 'Bali (Sortation)', update: '3 jam yang lalu', progress: 2, status: 'On Process' },
        { resi: 'SC-11022771', courier: 'Sicepat', receiver: 'Raffi Ahmad', location: 'Depok (Delivered)', update: '2 hari yang lalu', progress: 4, status: 'Delivered' },
        { resi: 'JX-99210111', courier: 'JNE', receiver: 'Atta H.', location: 'Tangerang (Transit)', update: '45 menit yang lalu', progress: 2, status: 'On Process' }
    ];

    const body = document.getElementById('tracking_body');

    function renderTracking(filterText = "", filterCourier = "") {
        body.innerHTML = '';
        
        const filtered = trackingData.filter(item => {
            const matchesText = item.resi.toLowerCase().includes(filterText.toLowerCase()) || 
                               item.receiver.toLowerCase().includes(filterText.toLowerCase());
            const matchesCourier = filterCourier === "" || item.courier === filterCourier;
            return matchesText && matchesCourier;
        });

        filtered.forEach(item => {
            const row = document.createElement('tr');
            row.className = 'tracking-card';

            // Progress Logic
            const steps = [
                { name: 'Pickup', p: 1 },
                { name: 'Transit', p: 2 },
                { name: 'Kurir', p: 3 },
                { name: 'Sampai', p: 4 }
            ];

            let stepperHtml = `<div class="stepper-mini">`;
            steps.forEach(s => {
                let state = '';
                if(item.progress > s.p) state = 'completed';
                else if(item.progress === s.p) state = 'active';
                
                stepperHtml += `
                    <div class="step-item ${state}">
                        <div class="timeline-dot"></div>
                    </div>`;
            });
            stepperHtml += `</div>`;

            row.innerHTML = `
                <td class="ps-4">
                    <div class="d-flex flex-column">
                        <span class="text-dark fw-bold fs-6">${item.resi}</span>
                        <div class="d-flex align-items-center mt-1">
                            <span class="courier-badge">${item.courier}</span>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="text-gray-800 fw-bold">${item.receiver}</span>
                </td>
                <td>
                    <div class="d-flex flex-column">
                        <span class="text-primary fw-bold fs-7">${item.status}: <span class="text-muted fw-normal">${item.location}</span></span>
                        ${stepperHtml}
                    </div>
                </td>
                <td>
                    <span class="badge badge-light-secondary text-muted">${item.update}</span>
                </td>
                <td class="text-end pe-4">
                    <button class="btn btn-sm btn-icon btn-action-blue">
                        <i class="bi bi-eye"></i>
                    </button>
                </td>
            `;
            body.appendChild(row);
        });
    }

    document.getElementById('search_tracking').addEventListener('keyup', (e) => {
        renderTracking(e.target.value, document.getElementById('filter_courier').value);
    });

    document.getElementById('filter_courier').addEventListener('change', (e) => {
        renderTracking(document.getElementById('search_tracking').value, e.target.value);
    });

    renderTracking();
});
</script>
@endpush