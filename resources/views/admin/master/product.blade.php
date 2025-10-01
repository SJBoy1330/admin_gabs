@extends('layouts.admin.main')

@push('script')
<script src="{{ asset('assets/admin/js/modul/master/product.js') }}"></script>
@endpush

@section('content')

<!--begin::Container-->
<div class="container-xxl" id="kt_content_container">

    <!--begin::Card-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <!--begin::Card title-->
            <div class="card-title">
                <h2 class="fw-bold">Produk Saya</h2>
            </div>
            <!--end::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                <a href="{{ route('insert.product') }}" target="_BLANK" role="button" class="btn btn-primary">+ Tambah Produk Baru</a>
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-0">

            <!--begin::Nav Tabs-->
            <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tab_all">Semua (5)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab_hidden">Belum Ditampilkan (3)</a>
                </li>
            </ul>
            <!--end::Nav Tabs-->

            <!--begin::Tab Content-->
            <div class="tab-content" id="myTabContent">

                <!--begin::Tab Pane - Semua-->
                <div class="tab-pane fade show active" id="tab_all" role="tabpanel">

                    <!-- Filter bar -->
                    <div class="d-flex flex-wrap align-items-center mb-5 gap-3">
                        <input type="text" class="form-control form-control-solid w-250px"
                               placeholder="Cari Nama Produk / SKU" />
                        <select class="form-select form-select-solid w-200px">
                            <option>Semua Kategori</option>
                            <option>Kategori A</option>
                            <option>Kategori B</option>
                        </select>
                        <button class="btn btn-light">Atur Ulang</button>
                        <button class="btn btn-primary">Terapkan</button>
                    </div>

                    <!-- Table Produk -->
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="w-25px">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" />
                                        </div>
                                    </th>
                                    <th class="min-w-200px">Produk</th>
                                    <th class="min-w-100px">Harga</th>
                                    <th class="min-w-100px">Stok</th>
                                    <th class="min-w-100px">Performa</th>
                                    <th class="min-w-100px">Analisis</th>
                                    <th class="min-w-100px text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">

                                <!-- Dummy Produk -->
                                <tr>
                                    <td><div class="form-check form-check-sm form-check-custom form-check-solid"><input class="form-check-input" type="checkbox" /></div></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-50px me-3"><img src="{{ image_check('cek.jpg','default') }}" alt="" /></div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold">Test Produk 1</span>
                                                <span class="text-muted fs-7">ID: 2757679889</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp 100.000</td>
                                    <td>1k</td>
                                    <td><span class="text-gray-700">Penjualan 0</span><div class="text-muted fs-7">30 Hari terakhir: 0</div></td>
                                    <td><span class="badge badge-light-warning">Update Info Produk</span></td>
                                    <td class="text-end"><a href="#" class="btn btn-sm btn-light btn-active-light-primary">Ubah</a><a href="#" class="btn btn-sm btn-light btn-active-light-info">Hapus</a></td>
                                </tr>

                                <tr>
                                    <td><div class="form-check form-check-sm form-check-custom form-check-solid"><input class="form-check-input" type="checkbox" /></div></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-50px me-3"><img src="{{ image_check('cek.jpg','default') }}" alt="" /></div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold">Air Liur Cicak</span>
                                                <span class="text-muted fs-7">ID: 29884608114</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp 100</td>
                                    <td>360</td>
                                    <td><span class="text-gray-700">Penjualan 0</span><div class="text-muted fs-7">30 Hari terakhir: 0</div></td>
                                    <td><span class="badge badge-light-warning">Update Info Produk</span></td>
                                    <td class="text-end"><a href="#" class="btn btn-sm btn-light btn-active-light-primary">Ubah</a><a href="#" class="btn btn-sm btn-light btn-active-light-info">Hapus</a></td>
                                </tr>

                                <tr>
                                    <td><div class="form-check form-check-sm form-check-custom form-check-solid"><input class="form-check-input" type="checkbox" /></div></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-50px me-3"><img src="{{ image_check('cek.jpg','default') }}" alt="" /></div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold">Sepatu Sneakers Putih</span>
                                                <span class="text-muted fs-7">ID: 30011223344</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp 350.000</td>
                                    <td>50</td>
                                    <td><span class="text-gray-700">Penjualan 10</span><div class="text-muted fs-7">30 Hari terakhir: 3</div></td>
                                    <td><span class="badge badge-light-success">Info Produk Lengkap</span></td>
                                    <td class="text-end"><a href="#" class="btn btn-sm btn-light btn-active-light-primary">Ubah</a><a href="#" class="btn btn-sm btn-light btn-active-light-info">Hapus</a></td>
                                </tr>

                                <tr>
                                    <td><div class="form-check form-check-sm form-check-custom form-check-solid"><input class="form-check-input" type="checkbox" /></div></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-50px me-3"><img src="{{ image_check('cek.jpg','default') }}" alt="" /></div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold">Tas Ransel Kulit</span>
                                                <span class="text-muted fs-7">ID: 30099887766</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp 500.000</td>
                                    <td>12</td>
                                    <td><span class="text-gray-700">Penjualan 5</span><div class="text-muted fs-7">30 Hari terakhir: 1</div></td>
                                    <td><span class="badge badge-light-success">Info Produk Lengkap</span></td>
                                    <td class="text-end"><a href="#" class="btn btn-sm btn-light btn-active-light-primary">Ubah</a><a href="#" class="btn btn-sm btn-light btn-active-light-info">Hapus</a></td>
                                </tr>

                                <tr>
                                    <td><div class="form-check form-check-sm form-check-custom form-check-solid"><input class="form-check-input" type="checkbox" /></div></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-50px me-3"><img src="{{ image_check('cek.jpg','default') }}" alt="" /></div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold">Laptop Gaming XYZ</span>
                                                <span class="text-muted fs-7">ID: 30112233445</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp 15.000.000</td>
                                    <td>5</td>
                                    <td><span class="text-gray-700">Penjualan 20</span><div class="text-muted fs-7">30 Hari terakhir: 7</div></td>
                                    <td><span class="badge badge-light-success">Info Produk Lengkap</span></td>
                                    <td class="text-end"><a href="#" class="btn btn-sm btn-light btn-active-light-primary">Ubah</a><a href="#" class="btn btn-sm btn-light btn-active-light-info">Hapus</a></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- End Table -->

                </div>
                <!--end::Tab Pane - Semua-->

                <!--begin::Tab Pane - Belum Ditampilkan-->
                <div class="tab-pane fade" id="tab_hidden" role="tabpanel">

                    <!-- Table Produk Belum Ditampilkan -->
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="w-25px"><div class="form-check form-check-sm form-check-custom form-check-solid"><input class="form-check-input" type="checkbox" /></div></th>
                                    <th class="min-w-200px">Produk</th>
                                    <th class="min-w-100px">Harga</th>
                                    <th class="min-w-100px">Stok</th>
                                    <th class="min-w-100px">Performa</th>
                                    <th class="min-w-100px">Analisis</th>
                                    <th class="min-w-100px text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">

                                <tr>
                                    <td><div class="form-check form-check-sm form-check-custom form-check-solid"><input class="form-check-input" type="checkbox" /></div></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-50px me-3"><img src="{{ image_check('cek.jpg','default') }}" alt="" /></div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold">Kaos Oversize Hitam</span>
                                                <span class="text-muted fs-7">ID: 30098765432</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp 150.000</td>
                                    <td>20</td>
                                    <td><span class="text-gray-700">Penjualan 2</span><div class="text-muted fs-7">30 Hari terakhir: 1</div></td>
                                    <td><span class="badge badge-light-success">Info Produk Lengkap</span></td>
                                    <td class="text-end"><a href="#" class="btn btn-sm btn-light btn-active-light-primary">Ubah</a><a href="#" class="btn btn-sm btn-light btn-active-light-info">Hapus</a></td>
                                </tr>

                                <tr>
                                    <td><div class="form-check form-check-sm form-check-custom form-check-solid"><input class="form-check-input" type="checkbox" /></div></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-50px me-3"><img src="{{ image_check('cek.jpg','default') }}" alt="" /></div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold">Kemeja Flanel Merah</span>
                                                <span class="text-muted fs-7">ID: 30123456789</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp 250.000</td>
                                    <td>15</td>
                                    <td><span class="text-gray-700">Penjualan 0</span><div class="text-muted fs-7">30 Hari terakhir: 0</div></td>
                                    <td><span class="badge badge-light-warning">Update Info Produk</span></td>
                                    <td class="text-end"><a href="#" class="btn btn-sm btn-light btn-active-light-primary">Ubah</a><a href="#" class="btn btn-sm btn-light btn-active-light-info">Hapus</a></td>
                                </tr>

                                <tr>
                                    <td><div class="form-check form-check-sm form-check-custom form-check-solid"><input class="form-check-input" type="checkbox" /></div></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-50px me-3"><img src="{{ image_check('cek.jpg','default') }}" alt="" /></div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold">Jaket Hoodie Abu</span>
                                                <span class="text-muted fs-7">ID: 30199887766</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp 300.000</td>
                                    <td>10</td>
                                    <td><span class="text-gray-700">Penjualan 1</span><div class="text-muted fs-7">30 Hari terakhir: 0</div></td>
                                    <td><span class="badge badge-light-warning">Update Info Produk</span></td>
                                    <td class="text-end"><a href="#" class="btn btn-sm btn-light btn-active-light-primary">Ubah</a><a href="#" class="btn btn-sm btn-light btn-active-light-info">Hapus</a></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- End Table -->

                </div>
                <!--end::Tab Pane - Belum Ditampilkan-->

            </div>
            <!--end::Tab Content-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

</div>
<!--end::Container-->

@endsection
