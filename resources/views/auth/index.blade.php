@extends('layouts.auth.main')

@section('content')
<div class="custom-auth-container">
    <!-- LOGIN FORM -->
    <div class="custom-auth-form-box login">
        <form method="POST" novalidate="novalidate" id="form_login" class="pt-7" action="{{ route('login.process') }}">
            @csrf
            <h1 class="text-primary">Masuk</h1>
            <span class="mb-5 text-center">Sistem Manajemen CMS Website</span>

            <div class="custom-auth-input-box fv-row">
                <div class="position-relative">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="text" name="email" id="email" placeholder="Masukkan Alamat Email" required autocomplete="off">
                </div>
                
            </div>

            <div class="custom-auth-input-box mb-7 fv-row" data-kt-password-meter="true">
                <div class="position-relative">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="login_password" name="password" placeholder="Masukkan Kata Sandi" onkeyup="hideye(this, '#hideye_login')" autocomplete="off" required/>
                    <span class="btn btn-sm btn-icon position-absolute translate-middle d-none" id="hideye_login" style="top: 50%;right : 0" data-kt-password-meter-control="visibility">
                        <i class="fa-solid fa-eye fs-3 end-0 text-muted"></i>
                        <i class="fa-solid fa-eye-slash fs-3 end-0 text-muted d-none"></i>
                    </span>
                </div>
            </div>

            <button type="submit" id="button_login" class="custom-auth-btn">Kirim</button>

            @php
                $status = false;
                if (isset($sosmed) && $sosmed->isNotEmpty()) {
                    foreach ($sosmed as $row) {
                        if ($row->url != '') {
                            $status = true;
                        }
                    }
                }
            @endphp


            @if($status == true)
            <p>Kunjungi Sosial Media Kami</p>
            <div class="custom-auth-social-icons">
            @foreach($sosmed AS $row)
                @if($row->url != '')
                <a href="{{ $row->url }}" target="_BLANK" title="{{ ($row->name_sosmed) ? $row->name_sosmed : $row->name }}"><i class="{{ $row->icon }}"></i></a>
                @endif
            @endforeach
            </div>
            @endif
        </form>
    </div>

    <!-- REGISTER FORM -->
    <div class="custom-auth-form-box register">
        <div class="w-100 d-flex justify-content-center align-items-center flex-column">
            <div class="background-partisi-contain mb-3" style="background-image : url({{ image_check('soon.svg','default') }});width : 100%;height : 250px;"></div>
            <h3 class="text-center text-primary" style="max-width : 200px">Segera Hadir</h3>
            <p class="text-center text-muted" style="max-width : 300px">Pendaftaran member gadai belum dibuka! Kami akan segera menghubungi anda jika pendaftaran telah dibuka</p>
        </div>
    </div>

    <!-- TOGGLE BOX -->
    <div class="custom-auth-toggle-box">
        <div class="custom-auth-toggle-panel toggle-left">
            @if($setting->logo_white  && file_exists(public_path('data/setting/' . $setting->logo_white )))
                <div class="background-partisi-contain logo-auth" style="width : 150px;height : 150px;background-image : url('{{ image_check($setting->logo_white,'setting') }}');"></div>
            @endif
            <h3>Selamat Datang!</h3>
            <p class="text-center">Silahkan masukkan informasi login anda jika anda sudah memiliki akun terdaftar</p>
        </div>
        <div class="custom-auth-toggle-panel toggle-right">
            @if($setting->logo_white  && file_exists(public_path('data/setting/' . $setting->logo_white )))
                <div class="background-partisi-contain logo-auth" style="width : 150px;height : 150px;background-image : url('{{ image_check($setting->logo_white,'setting') }}');"></div>
            @endif
            <h3>Masuk Sistem!</h3>
            <p class="text-center">Silahkan masukkan informasi login anda jika anda sudah memiliki akun terdaftar</p>
            <button class="custom-auth-btn login-btn">Masuk</button>
        </div>
    </div>
</div>
@endsection
