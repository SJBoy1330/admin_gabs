@extends('layouts.admin.main')

@push('styles')
<style>
    .card-stat:hover { transform: translateY(-5px); transition: 0.3s; cursor: pointer; }
    .bg-light-primary-soft { background-color: #f1faff; }
</style>
@endpush

@push('script')
    <!-- Pakai Chart.js saja bro, lebih stabil buat alasan dummy -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="post" id="kt_post">
    <!-- Top Stats -->
    <div class="row mb-8">
        @php
            $stats = [
                ['label' => 'Produk', 'val' => '3', 'icon' => 'ki-basket-ok', 'color' => 'primary', 'link' => 'master/product'],
                ['label' => 'Pesanan', 'val' => '10', 'icon' => 'ki-basket', 'color' => 'success', 'link' => 'queue'],
                ['label' => 'Customer', 'val' => '21', 'icon' => 'ki-people', 'color' => 'info', 'link' => 'master/customer'],
                ['label' => 'Pengiriman', 'val' => '4', 'icon' => 'ki-delivery-time', 'color' => 'warning', 'link' => 'tracking']
            ];
        @endphp

        @foreach($stats as $s)
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat shadow-sm mb-5" style="height: 150px">
                <div class="card-body">
                    <i class="ki-duotone {{ $s['icon'] }} fs-3x text-{{ $s['color'] }}">
                        <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span>
                    </i>
                    <h1 class="text-dark fw-bolder mt-3">{{ $s['val'] }}</h1>
                    <p class="text-muted fs-7 mt-1">{{ $s['label'] }} -> <a href="{{ url($s['link']) }}" class="fw-bold text-{{ $s['color'] }}">Lihat Detail</a></p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Charts Row -->
    <div class="row mb-8">
        <div class="col-xl-8">
            <div class="card shadow-sm border-0">
                <div class="card-header pt-5 border-0">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">Tren Penjualan Mingguan</span>
                        <span class="text-muted mt-1 fw-semibold fs-7">Data statis 7 hari terakhir</span>
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Gunakan Canvas untuk Chart.js -->
                    <canvas id="chart_sales_new" style="min-height: 350px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card shadow-sm border-0">
                <div class="card-header pt-5 border-0">
                    <h3 class="card-title fw-bold">Proporsi Kategori</h3>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <canvas id="chart_cat_new" style="max-height: 350px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th>Status Inventori & Customer</th>
                                    <th class="text-end">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                <tr><td>Produk Hampir Habis</td><td class="text-end"><span class="badge badge-light-danger">100</span></td></tr>
                                <tr><td>Produk Habis</td><td class="text-end"><span class="badge badge-light-danger">59</span></td></tr>
                                <tr><td>Total Customer Reguler</td><td class="text-end"><span class="badge badge-light-primary">499</span></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Grafik 1: Line Chart Penjualan
    const ctxSales = document.getElementById('chart_sales_new').getContext('2d');
    new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Penjualan (Rp)',
                data: [4500000, 5900000, 4200000, 8100000, 5600000, 9500000, 12000000],
                borderColor: '#009ef7',
                backgroundColor: 'rgba(0, 158, 247, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { display: false } },
                x: { grid: { display: false } }
            }
        }
    });

    // Grafik 2: Pie Chart Kategori
    const ctxCat = document.getElementById('chart_cat_new').getContext('2d');
    new Chart(ctxCat, {
        type: 'doughnut',
        data: {
            labels: ['Atasan', 'Bawahan', 'Outerwear', 'Aksesoris'],
            datasets: [{
                data: [40, 25, 20, 15],
                backgroundColor: ['#009ef7', '#50cd89', '#ffc700', '#f1416c'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            },
            cutout: '70%'
        }
    });
});
</script>
@endsection