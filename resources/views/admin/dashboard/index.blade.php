@extends('layouts.admin.main')

@push('styles')
@endpush

@push('script')
    <script src="{{ asset('assets/public/plugins/custom/fullcalendar/fullcalendar.bundle.js'); }}"></script>
    <script src="{{ asset('assets/admin/js/modul/dashboard/calendar.js'); }}"></script>
@endpush


@section('content')
<!--begin::Post-->
<div class="post" id="kt_post">
<div class="row mb-8">
    <div class="col-xl-3">
    <!--begin::Tiles Widget 11-->
    <div class="card card-custom gutter-b" style="height: 150px">
        <div class="card-body">
        <i class="ki-duotone ki-basket-ok fs-3x">
            <span class="path1"></span>
            <span class="path2"></span>
            <span class="path3"></span>
            <span class="path4"></span>
        </i>
        <h1 class="text-dark font-weight-bolder mt-3">200</h1>
        <p class="text-muted font-size-lg mt-1">Produk -> <a href="" class="text-hover-primary font-weight-bold">Lihat Detail</a>
            </a>
        </div>
    </div>
    <!--end::Tiles Widget 11-->
    </div>
    <div class="col-xl-3">
    <!--begin::Tiles Widget 12-->
    <div class="card card-custom gutter-b" style="height: 150px">
        <div class="card-body">
        <i class="ki-duotone ki-basket fs-3x">
            <span class="path1"></span>
            <span class="path2"></span>
            <span class="path3"></span>
            <span class="path4"></span>
        </i>
        <h1 class="text-dark font-weight-bolder mt-3">0</h1>
        <p class="text-muted font-size-lg mt-1">Pesanan -> <a href="" class="text-hover-primary font-weight-bold">Lihat Detail</a>
            </a>
        </div>
    </div>
    <!--end::Tiles Widget 12-->
    </div>
    <div class="col-xl-3">
    <!--begin::Tiles Widget 11-->
    <div class="card card-custom gutter-b" style="height: 150px">
        <div class="card-body">
        <i class="ki-duotone ki-people fs-3x">
            <span class="path1"></span>
            <span class="path2"></span>
            <span class="path3"></span>
            <span class="path4"></span>
            <span class="path5"></span>
        </i>
        <h1 class="text-dark font-weight-bolder mt-3">500</h1>
        <p class="text-muted font-size-lg mt-1">Customer -> <a href="" class="text-hover-primary font-weight-bold">Lihat Detail</a>
            </a>
        </div>
    </div>
    <!--end::Tiles Widget 11-->
    </div>
    <div class="col-xl-3">
    <!--begin::Tiles Widget 12-->
    <div class="card card-custom gutter-b" style="height: 150px">
        <div class="card-body">
        <i class="ki-duotone ki-delivery-time fs-3x">
            <span class="path1"></span>
            <span class="path2"></span>
            <span class="path3"></span>
            <span class="path4"></span>
            <span class="path5"></span>
        </i>
        <h1 class="text-dark font-weight-bolder mt-3">0</h1>
        <p class="text-muted font-size-lg mt-1">Pengiriman -> <a href="" class="text-hover-primary font-weight-bold">Lihat Detail</a>
            </a>
        </div>
    </div>
    <!--end::Tiles Widget 12-->
    </div>
</div>
<div class="row mb-8">
    <div class="col-xl-8">
    <div class="card card-bordered">
        <div class="card-body">
        <div style="height: 350px;"></div>
        </div>
    </div>
    </div>
    <div class="col-xl-4">
    <div class="card card-bordered">
        <div class="card-body">
        <div style="height: 350px;"></div>
        </div>
    </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-8">
    <div class="table-responsive">
        <table class="table table-hover table-rounded table-striped border gy-7 gs-7">
        <tbody>
            <tr>
            <td class="text-start">Produk Hampir Habis</td>
            <td class="text-end">
                <span class="badge badge-light-danger">100</span>
            </td>
            </tr>
            <tr>
            <td class="text-start">Produk Habis</td>
            <td class="text-end">
                <span class="badge badge-light-danger">59</span>
            </td>
            </tr>
            <tr>
            <td class="text-start">Kategori</td>
            <td class="text-end">
                <span class="badge badge-light-success">10</span>
            </td>
            </tr>
            <tr>
            <td class="text-start">Produk</td>
            <td class="text-end">
                <span class="badge badge-light-success">198</span>
            </td>
            </tr>
            <tr>
            <td class="text-start">Total Customer</td>
            <td class="text-end">
                <span class="badge badge-light-success">588</span>
            </td>
            </tr>
            <tr>
            <td class="text-start">Total Customer Reguler</td>
            <td class="text-end">
                <span class="badge badge-light-primary">499</span>
            </td>
            </tr>
        </tbody>
        </table>
    </div>
    </div>
    <div class="col-xl-4">
    <div class="card card-bordered">
        <div class="card-body">
        <div style="height: 350px;"></div>
        </div>
    </div>
    </div>
</div>
</div>
<!--end::Post-->
@endsection