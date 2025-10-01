@php
    $segment1 = request()->segment(1);
    $segment2 = request()->segment(2);
@endphp
<!--begin::Javascript-->
<script>

    var BASE_URL = BASEURL = '{{ url('/') }}';
    var hostUrl = "{{ asset('assets/user/') }}";
    var css_btn_confirm = 'btn btn-primary mx-1';
    var css_btn_cancel = 'btn btn-danger mx-1';
    var csrf_token = "{{ csrf_token() }}";
    var base_foto = '{{ image_check('notfound.jpg','default') }}';
    var user_base_foto = '{{ image_check('user.jpg','default') }}';
    var office_address = '{{ $setting->meta_address }}';
    var lat_value = '{{ $setting->lat }}';
    var lng_value = '{{ $setting->lng }}';
    addEventListener('keypress', function(e) {
        if (e.keyCode === 13 || e.which === 13) {
            e.preventDefault();
            return false;
        }
    });
    var div_loading = '<div class="logo-spinner-parent">\
                        <div class="logo-spinner">\
                            <img src="{{ image_check($setting->icon,"setting","blank") }}" alt="">\
                            <div class="logo-spinner-loader-big"></div>\
                        </div>\
                        <p id="text_loading">Tunggu sebentar...</p>\
                    </div>';
                
</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ asset('assets/user/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/user/js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{ asset('assets/public/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>
<script src="{{ asset('assets/public/plugins/custom/datatables/datatables_id.bundle.js') }}"></script>
<!--end::Vendors Javascript-->
<script src="{{ asset('assets/public/js/mekanik.js') }}"></script>
<script src="{{ asset('assets/public/js/function.js') }}"></script>
<script src="{{ asset('assets/public/js/global.js') }}"></script>
<script src="{{ asset('assets/public/js/custom-datatable.js') }}"></script>
<!--end::Custom Javascript-->
<!--end::Javascript-->

<script>
    /* Hamburger click */
    const sidebar = document.getElementById('sidebar-user-custom');
    const overlay = document.getElementById('overlay-user-custom');
    document.getElementById("hamburgerBtn").addEventListener("click", function () {
        this.classList.toggle("active");
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    });

    /* Scroll change to fixed */
    window.addEventListener("scroll", function () {
        let navbar = document.getElementById("mainNavbar");
        let hamburg = document.getElementById("hamburgerBtn");
        if (window.scrollY > 200) {
            navbar.classList.add("navbar-fixed");
            setTimeout(function() {
                hamburg.classList.remove("position-absolute");
                hamburg.classList.add("position-fixed");
            }, 200); // 1000 ms = 1 detik
        } else {
            <?php if(in_array($segment1,['project','article']) && $segment2 != '') : ?>
            <?php else : ?>
            navbar.classList.remove("navbar-fixed");
            setTimeout(function() {
                hamburg.classList.remove("position-fixed");
                hamburg.classList.add("position-absolute");
            }, 200); // 1000 ms = 1 detik
            <?php endif;?>
             
        }
    });
</script>
<script>
    function set_language(id) {
        $.ajax({
            url: BASE_URL + '/change_language',
            method: 'POST',
            data: {
                 _token: csrf_token, 
                 id: id 
            },
            dataType : 'json',
            beforeSend: function () {
                showLoading('Tunggu sebentar...');
            },
            success: function (data) {
                sessionStorage.setItem('isReload', 'true');
                sessionStorage.setItem('alert_icon', 'success');
                sessionStorage.setItem('alert_message', 'Bahasa berhasil di rubah');
            
                custom_reload();
            }
        });
    }
</script>

<script src="{{ asset('assets/user/js/aos.js') }}"></script>
<script>
    AOS.init({
        duration: 1000, // durasi animasi dalam ms
        once: true      // animasi cuma jalan sekali
    });
</script>
@stack('script')