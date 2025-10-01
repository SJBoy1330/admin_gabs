@extends('layouts.admin.main')

@push('styles')
@endpush

@push('script')
    <script src="{{ asset('assets/public/plugins/custom/fullcalendar/fullcalendar.bundle.js'); }}"></script>
    <script src="{{ asset('assets/admin/js/modul/dashboard/calendar.js'); }}"></script>
@endpush


@section('content')
<!--begin::Container-->
<div class="container-xxl" id="kt_content_container">
	<!--begin::Row-->

    <div class="row gx-5 gx-xl-10 mb-xl-10">
         <!--begin::Col-->
        <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-4">
        <!--begin::Card widget 16-->
        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-center border-0 h-md-100 mb-3 mb-xl-6 shadow-sm">
            <!--begin::Card body-->
            <div class="card-body d-flex justify-content-center py-7 flex-column">
                 <!--begin::Amount-->
                <div class="fs-1 fw-bold text-dark me-2 lh-1 ls-n2"><i class="fa-solid {{ (salamWaktu()->dark == true) ? 'fa-cloud-moon' : 'fa-cloud-sun' }}"></i> {{ salamWaktu()->message }} <span class="text-primary">{{ session(config('session.prefix') . '_name') }}</span></div>
                <!--end::Amount-->
                <span class="text-dark opacity-50 pt-1 mt-3 fw-semibold fs-6">Selamat datang di Website Manajemen Konten</span>
                <!--end::Subtitle-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card widget 16-->
        </div>
        <!--end::Col-->
    </div>
    
    <div class="row gx-5 gx-xl-10 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-5">
        <!--begin::Card widget 16-->
        <div class="card card-custom bgi-no-repeat gutter-b card-stretch border-0 h-md-100 mb-5 mb-xl-10 shadow-sm bgi-size-contain bgi-position-x-center" style="background-position: right top; background-size: 30% auto; background-image: url({{ asset('assets/admin/svg/abstract.svg') }});background-color: var(--bs-primary);">
            <!--begin::Card body-->
            <div class="card-body d-flex justify-content-center py-7 flex-column">
                 <!--begin::Amount-->
                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ (isset($cnt_report) && $cnt_report) ? number_format($cnt_report,0,',','.') : 0 }}</span>
                <!--end::Amount-->
                <span class="text-white opacity-50 pt-1 mt-3 fw-semibold fs-6">Total Project</span>
                <!--end::Subtitle-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card widget 16-->
        </div>
        <!--end::Col-->

        
        <!--begin::Col-->
        <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-5">
        <!--begin::Card widget 16-->
        <div class="card card-custom bgi-no-repeat gutter-b card-stretch border-0 h-md-100 mb-5 mb-xl-10 shadow-sm bgi-size-contain bgi-position-x-center" style="background-position: calc(100% + 20px) calc(0% + 10px);background-size: 30% auto; background-image: url({{ asset('assets/admin/svg/database.svg') }});">
            <!--begin::Card body-->
            <div class="card-body d-flex justify-content-center py-7 flex-column">
                  <!--begin::Amount-->
                <span class="fw-bold text-primary me-2 lh-1 ls-n2" style="font-size : 25px;">{{ (isset($cnt_admin) && $cnt_admin) ? number_format($cnt_admin,0,',','.') : 0 }}</span>
                <!--end::Amount-->
                <!--begin::Subtitle-->
                <span class="text-dark opacity-50 pt-1 mt-3 fw-semibold fs-6">Total Admin</span>
                <!--end::Subtitle-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card widget 16-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-5">
        <!--begin::Card widget 16-->
        <div class="card card-custom bgi-no-repeat gutter-b card-stretch border-0 h-md-100 mb-5 mb-xl-10 shadow-sm bgi-size-contain bgi-position-x-center" style="background-position: calc(100% + 20px) calc(0% + 10px);background-size: 30% auto; background-image: url({{ asset('assets/admin/svg/users.svg') }});">
            <!--begin::Card body-->
            <div class="card-body d-flex justify-content-center py-7 flex-column">
                  <!--begin::Amount-->
                <span class="fw-bold text-primary me-2 lh-1 ls-n2" style="font-size : 25px;">{{ (isset($cnt_member) && $cnt_member) ? number_format($cnt_member,0,',','.') : 0 }}</span>
                <!--end::Amount-->
                <!--begin::Subtitle-->
                <span class="text-dark opacity-50 pt-1 mt-3 fw-semibold fs-6">Admin Member</span>
                <!--end::Subtitle-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card widget 16-->
        </div>
        <!--end::Col-->

    </div>
    <!--end::Row-->
</div>
<!--end::Container-->
@endsection