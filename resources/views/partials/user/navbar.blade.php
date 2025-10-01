@php
    $segment1 = request()->segment(1);
    $segment2 = request()->segment(2);
@endphp
<!-- NAVBAR -->
<div class="container-fluid navbar-custom {{ (in_array($segment1,['project','article']) && $segment2 != '') ? 'navbar-fixed' : '' }}" id="mainNavbar">
    <div class="row align-items-center w-100 py-3">
        <!-- Left -->
        <div class="col-4 d-flex align-items-center gap-3">
            <div class="dropdown">
                <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    {{ session(config('session.prefix') . '_lang_code') }}
                </button>
                <ul class="dropdown-menu">
                    @if($language->isNotEmpty())
                    @foreach($language AS $row)
                    <li><button type="button" onclick="set_language({{ $row->id_language }})" class="dropdown-item">{{ $row->code }}</button></li>
                    @endforeach
                    @endif
                </ul>
            </div>

            <i class="fa-solid fa-magnifying-glass fs-2 search-icon"></i>
        </div>

        <!-- Center (Logo) -->
        <div class="col-4 text-center">
            @if($setting->logo  && file_exists(public_path('data/setting/' . $setting->logo )))
            <div class="background-partisi-contain logo-default h-80px" style="background-image: url({{ image_check($setting->logo,'setting') }})"></div>
            @endif
        </div>

        <!-- Right (Hamburger) -->
        <div class="col-4 d-flex justify-content-end ">
            
        </div>
    </div>

</div>


<div class="hamburger {{ ($segment1 == 'project' && $segment2 != '') ? 'position-fixed' : 'position-absolute' }}" id="hamburgerBtn">
    <span></span>
    <span></span>
    <span></span>
</div>

<div id="overlay-user-custom"></div>

<div id="sidebar-user-custom">
    <div class="menu-stand-user-custom pt-20">
        <div class="menu-links-user-custom pt-10 pe-15">
            <a class="{{ ($segment1 == 'home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
            <a class="{{ ($segment1 == 'about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
            <a class="{{ ($segment1 == 'project') ? 'active' : '' }}" href="{{ route('project') }}">Projects</a>
            <a class="{{ ($segment1 == 'article') ? 'active' : '' }}" href="{{ route('article') }}">Article</a>
            <a class="{{ ($segment1 == 'contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
        </div>
        <div class="sidebar-footer-user-custom row">
            <div class="col-8">
                <p>{{ $setting->meta_author }}</p>
                <p>{{ $setting->meta_address }}</p>
            </div>
            <div class="col-4 d-flex justify-content-center align-items-center">
                <span class="whatsapp-user-custom">
                    <i class="fa-brands fa-whatsapp"></i>
                </span>
            </div>
            
        </div>
    </div>
</div>






