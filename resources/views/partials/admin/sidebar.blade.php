@php
    $segment1 = request()->segment(1);
    $segment2 = request()->segment(2);
@endphp
<!--begin::Aside-->
<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '225px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle" data-kt-sticky="true" data-kt-sticky-name="aside-sticky" data-kt-sticky-offset="{default: false, lg: '1px'}" data-kt-sticky-width="{lg: '225px'}" data-kt-sticky-left="auto" data-kt-sticky-top="94px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
<!--begin::Aside nav-->
<div class="hover-scroll-overlay-y my-5 my-lg-5 w-100 ps-4 ps-lg-0 pe-4 me-1" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_header" data-kt-scroll-wrappers="#kt_aside" data-kt-scroll-offset="5px">
    <!--begin::Menu-->
    <div class="menu menu-column menu-active-bg menu-hover-bg menu-title-gray-700 fs-6 menu-rounded w-100" id="#kt_aside_menu" data-kt-menu="true">
    <!--begin::Menu item-->
    <div class="menu-item">
        <a href="{{ route('dashboard') }}" class="menu-link {{ (!$segment1 || $segment1 == 'dashboard') ? 'active' : ''}}">
        <span class="menu-title">Beranda</span>
        </a>
    </div>
    <!--end::Menu item-->
    <!--begin::Menu item-->
    <div class="menu-item">
        <a href="{{ route('antrian') }}" class="menu-link {{ ($segment1 == 'antrian') ? 'active' : ''}}">
        <span class="menu-title">Antrian Transaksi</span>
        </a>
    </div>
    <!--end::Menu item-->
    <!--begin::Menu item-->
    <!-- <div class="menu-item">
        <a href="transaksi.html" class="menu-link">
        <span class="menu-title">Transaksi</span>
        </a>
    </div> -->
    <!--end::Menu item-->
    <!--begin::Menu item-->
    <div class="menu-item">
        <a href="{{ route('tracking') }}" class="menu-link {{ ($segment1 == 'tracking') ? 'active' : ''}}">
        <span class="menu-title">Tracking</span>
        </a>
    </div>
    <!--end::Menu item-->
     <!--begin::Menu item-->
    <div class="menu-item">
        <a href="{{ route('stock.opname') }}" class="menu-link {{ ($segment1 == 'stock' && $segment2 == 'opname') ? 'active' : ''}}">
        <span class="menu-title">Stock Opname</span>
        </a>
    </div>
    <!--end::Menu item-->
    <!--begin::Heading-->
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ ($segment1 == 'master') ? 'hover show' : '' }}">
        <!--begin:Menu link-->
        <span class="menu-link py-2">
        <span class="menu-title">Produk</span>
        <span class="menu-arrow"></span>
        </span>
        <!--end:Menu link-->
        <!--begin:Menu sub-->
        <div class="menu-sub menu-sub-accordion {{ ($segment1 == 'master') ? 'show' : '' }}" kt-hidden-height="163" style="{{ ($segment1 == 'master') ? '' : 'display: none; overflow: hidden;' }}">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2 {{ ($segment1 == 'master' && $segment2 == 'brand') ? 'active' : '' }}" href="{{ route('master.brand') }}">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Brand</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2 {{ ($segment1 == 'master' && $segment2 == 'induk-category') ? 'active' : '' }}" href="{{ route('master.induk.category') }}">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Induk Kategori</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2 {{ ($segment1 == 'master' && $segment2 == 'sub-category') ? 'active' : '' }}" href="{{ route('master.sub.category') }}">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Sub Kategori</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2 {{ ($segment1 == 'master' && $segment2 == 'product') ? 'active' : '' }}" href="{{ route('master.product') }}">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Manajemen Produk</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2 {{ ($segment1 == 'master' && $segment2 == 'flash-sale') ? 'active' : '' }}" href="{{ route('master.flash.sale') }}">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Flash Sale</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2 {{ ($segment1 == 'master' && $segment2 == 'diskon') ? 'active' : '' }}" href="{{ route('master.diskon') }}">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Diskon</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2 {{ ($segment1 == 'master' && $segment2 == 'label') ? 'active' : '' }}" href="{{ route('master.label') }}">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Label Produk</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2 {{ ($segment1 == 'master' && $segment2 == 'review') ? 'active' : '' }}" href="{{ route('master.review') }}">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Review Produk</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2 {{ ($segment1 == 'master' && $segment2 == 'ukuran') ? 'active' : '' }}" href="{{ route('master.ukuran') }}">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Ukuran</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2 {{ ($segment1 == 'master' && $segment2 == 'taggar') ? 'active' : '' }}" href="{{ route('master.taggar') }}">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Tagar Produk</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2 {{ ($segment1 == 'master' && $segment2 == 'fit') ? 'active' : '' }}" href="{{ route('master.fit') }}">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Fit Label</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        </div>
        <!--end:Menu sub-->
    </div>
    <!--end::Heading-->
    <!--begin::Menu item-->
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
        <!--begin:Menu link-->
        <span class="menu-link py-2">
        <span class="menu-title">Customer</span>
        <span class="menu-arrow"></span>
        </span>
        <!--end:Menu link-->
        <!--begin:Menu sub-->
        <div class="menu-sub menu-sub-accordion" kt-hidden-height="163" style="display: none; overflow: hidden;">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2" onclick="showFeatureLocked('Manajemen Customer')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Manajemen Customer</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2" onclick="showFeatureLocked('Manajemen Broadcast')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Broadcast Newsletter</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2" onclick="showFeatureLocked('Manajemen Newsletter')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Newsletter</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2" onclick="showFeatureLocked('Manajemen Alamat')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Alamat Tersimpan</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2" onclick="showFeatureLocked('Manajemen Kontak')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Kontak</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        </div>
        <!--end:Menu sub-->
    </div>
    <!--end::Menu item-->
    <!--begin::Menu item-->
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
        <!--begin:Menu link-->
        <span class="menu-link py-2">
        <span class="menu-title">Halaman</span>
        <span class="menu-arrow"></span>
        </span>
        <!--end:Menu link-->
        <!--begin:Menu sub-->
        <div class="menu-sub menu-sub-accordion" kt-hidden-height="163" style="display: none; overflow: hidden;">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2" onclick="showFeatureLocked('Manajemen Halaman')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Kelola Halaman</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2" onclick="showFeatureLocked('Manajemen Kategori FAQ')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Kategori FAQ</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2" onclick="showFeatureLocked('Manajemen FAQ')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">FAQ</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        </div>
        <!--end:Menu sub-->
    </div>
    <!--end::Menu item-->
    <!--begin::Menu item-->
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
        <!--begin:Menu link-->
        <span class="menu-link py-2">
        <span class="menu-title">Users</span>
        <span class="menu-arrow"></span>
        </span>
        <!--end:Menu link-->
        <!--begin:Menu sub-->
        <div class="menu-sub menu-sub-accordion" kt-hidden-height="163" style="display: none; overflow: hidden;">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2" onclick="showFeatureLocked('Manajemen user')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Manajemen User</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2" onclick="showFeatureLocked('Manajemen Role')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Role</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        </div>
        <!--end:Menu sub-->
    </div>
    <!--end::Menu item-->
    <!--begin::Menu item-->
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
        <!--begin:Menu link-->
        <span class="menu-link py-2">
        <span class="menu-title">Pengaturan</span>
        <span class="menu-arrow"></span>
        </span>
        <!--end:Menu link-->
        <!--begin:Menu sub-->
        <div class="menu-sub menu-sub-accordion" kt-hidden-height="163" style="display: none; overflow: hidden;">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2" onclick="showFeatureLocked('Konfigurasi Umum')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Konfigurasi Umum</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2" onclick="showFeatureLocked('Manajemen Hak Akses')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Hak Akses</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2" onclick="showFeatureLocked('Manajemen Bank')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Bank</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2"onclick="showFeatureLocked('Manajemen Banner')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Banner Web</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2" onclick="showFeatureLocked('Manajemen Layanan')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Layanan</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2" onclick="showFeatureLocked('Manajemen Banner Menu')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Banner Menu</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2" onclick="showFeatureLocked('Manajemen Bannere Promo')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Banner Promo</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2" onclick="showFeatureLocked('Manajemen Cabang Toko')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Cabang Toko</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2" onclick="showFeatureLocked('Manajemen Kategori Video')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Kategori Video</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2" onclick="showFeatureLocked('Manajemen Backup')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Backup</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        </div>
        <!--end:Menu sub-->
    </div>
    <!--end::Menu item-->
    <!--begin::Menu item-->
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
        <!--begin:Menu link-->
        <span class="menu-link py-2">
        <span class="menu-title">Laporan</span>
        <span class="menu-arrow"></span>
        </span>
        <!--end:Menu link-->
        <!--begin:Menu sub-->
        <div class="menu-sub menu-sub-accordion" kt-hidden-height="163" style="display: none; overflow: hidden;">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2" onclick="showFeatureLocked('Laporan produk')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Produk</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2" onclick="showFeatureLocked('Laporan Keuangan')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Keuangan</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link py-2"onclick="showFeatureLocked('Laporan Pengiriman')">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">Pengiriman</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
        </div>
        <!--end:Menu sub-->
    </div>
    <!--end::Menu item-->
    </div>
    <!--end::Menu-->
</div>
<!--end::Aside nav-->
</div>
<!--end::Aside-->

<script>
    function showFeatureLocked(pageName = "Halaman ini") {
    Swal.fire({
        title: 'Mohon Maaf!',
        text: `${pageName} masih dalam tahap pengembangan dan belum bisa dibuka. Silahkan cek menu lainnya ya!`,
        icon: 'info',
        iconColor: '#009ef7', // Warna biru konsisten dengan dashboard
        showCancelButton: false,
        confirmButtonColor: '#009ef7',
        confirmButtonText: 'Oke, Saya Mengerti',
        buttonsStyling: true,
        customClass: {
            confirmButton: 'btn btn-primary px-10' // Pakai class bootstrap kamu
        },
        showClass: {
            popup: 'animate__animated animate__fadeInUp animate__faster'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutDown animate__faster'
        }
    });
}
</script>