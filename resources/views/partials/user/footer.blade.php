<!--begin::Footer Section-->
<div class="mb-0 mt-10">
    <!--begin::Wrapper-->
    <div class="landing-dark-bg pt-20">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Row-->
            <div class="row py-10 py-lg-20">
                @if($setting->meta_description)
                <div class="col-lg-4">
                    <!--begin::Subtitle-->
                        <h4 class="fw-bold text-primary mb-6">Deskripsi</h4>
                    <!--end::Logo image-->
                    <p class="text-white fs-6 mb-7">{{ $setting->meta_description }}</p>

                    
                </div>
                @endif

                <!--begin::Col-->
                <div class="col-lg-2">
                    <!--begin::Navs-->
                    <div class="d-flex justify-content-start align-items-center">
                        
                         <!--begin::Links-->
                        <div class="d-flex fw-semibold flex-column">
                            <!--begin::Subtitle-->
                            <h4 class="fw-bold text-primary mb-6">Menu</h4>
                            <!--end::Subtitle-->
                            <!--begin::Link-->
                            <a href="{{ route('home') }}" class="mb-6">
                                <span class="text-white fs-5 mb-6">Beranda</span>
                            </a>
                            <!--end::Link-->
                            <!--begin::Link-->
                            <a href="{{ route('about') }}" class="mb-6">
                                <span class="text-white fs-5 mb-6">About</span>
                            </a>
                            <!--end::Link-->
                            <!--begin::Link-->
                            <a href="{{ route('project') }}" class="mb-6">
                                <span class="text-white fs-5 mb-6">Projek</span>
                            </a>
                            <!--end::Link-->
                            <!--begin::Link-->
                            <a href="{{ route('article') }}" class="mb-6">
                                <span class="text-white fs-5 mb-6">Artikel</span>
                            </a>
                            <!--end::Link-->
                            <!--begin::Link-->
                            <a href="{{ route('contact') }}" class="mb-6">
                                <span class="text-white fs-5 mb-6">Kontak</span>
                            </a>
                            <!--end::Link-->
                        </div>
                        <!--end::Links-->
                        
                    </div>
                    <!--end::Navs-->
                </div>
                <!--end::Col-->

                

                @if($web_email->isNotEmpty() || $web_phone->isNotEmpty())
                <div class="col-lg-3">
                    
                    <!--begin::Links-->
                    <div class="d-flex fw-semibold flex-column">
                        <!--begin::Subtitle-->
                        <h4 class="fw-bold text-primary mb-6">Kontak Kami</h4>
                        <!--end::Subtitle-->
                        @if($web_email)
                            @foreach($web_email AS $row)
                            <!--begin::Link-->
                            <a role="button" class="mb-6">
                                <i class="fa-solid fa-envelope text-white fs-2 me-3"></i>
                                <span class="text-white fs-5 mb-6">{{ $row->email }}</span>
                            </a>
                            <!--end::Link-->
                            @endforeach
                        @endif
                        @if($web_phone)
                            @foreach($web_phone AS $row)
                            <!--begin::Link-->
                            <a role="button" class="mb-6">
                                <i class="fa-solid fa-phone text-white fs-2 me-3"></i>
                                <span class="text-white fs-5 mb-6">{{ ($row->name != '') ? $row->name.' | '.phone_format('0'.$row->phone) : phone_format('0'.$row->phone) }}</span>
                            </a>
                            <!--end::Link-->
                            @endforeach
                        @endif
                    </div>
                    <!--end::Links-->
                    
                </div>
                @endif

                
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
                <!--begin::Col-->
                <div class="col-lg-3">
                    <!--begin::Navs-->
                    <div class="d-flex justify-content-start align-items-center">
                        
                         <!--begin::Links-->
                        <div class="d-flex fw-semibold flex-column">
                            <!--begin::Subtitle-->
                            <h4 class="fw-bold text-primary mb-6">Sosial Media</h4>
                            <!--end::Subtitle-->
                            @foreach($sosmed AS $row)
                            @if($row->url != '')
                             <!--begin::Link-->
                            <a href="{{ $row->url }}" class="mb-6">
                                <i class="{{ $row->icon }} text-white fs-2 me-3"></i>
                                <span class="text-white fs-5 mb-6">{{ ($row->name_sosmed) ? $row->name_sosmed : $row->name }}</span>
                            </a>
                            <!--end::Link-->
                            @endif
                            @endforeach
                        </div>
                        <!--end::Links-->
                        
                    </div>
                    <!--end::Navs-->
                </div>
                <!--end::Col-->
                @endif
                
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
        <!--begin::Separator-->
        <div class="landing-dark-separator"></div>
        <!--end::Separator-->
        <!--begin::Container-->
        <div class="container">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-md-row flex-stack py-7 py-lg-10">
                <!--begin::Copyright-->
                <div class="d-flex align-items-center w-100 justify-content-between order-2 order-md-1">
                    <div class="d-flex">
                         <!--begin::Logo-->
                        @if(isset($setting->icon) && $setting->icon != '' && file_exists('./data/setting/'.$setting->icon))
                        <a href="{{ route('home') }}">
                            <img alt="Icon" src="{{ image_check($setting->icon,'setting') }}" class="h-15px h-md-20px" />
                        </a>
                        @endif
                        <!--end::Logo image-->
                        <!--begin::Logo image-->
                        <span class="mx-5 fs-6 fw-semibold text-white pt-1" href="{{ url('/') }}">&copy; 2025 {{ $setting->meta_title }}</span>
                        <!--end::Logo image-->
                    </div>

                    <p class="text-white fs-6 text-end" style="max-width : 300px">{{ $setting->meta_address }}</p>
                    
                   
                </div>
                <!--end::Copyright-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Footer Section-->
