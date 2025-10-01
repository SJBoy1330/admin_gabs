<!DOCTYPE html>
<html lang="en">
    @include('partials.admin.head')
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-enabled sidebar-enabled">
		<!--begin::Theme mode setup on page load-->
		<script>
		var defaultThemeMode = "light";
		var themeMode;
		if (document.documentElement) {
			if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
			themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
			} else {
			if (localStorage.getItem("data-bs-theme") !== null) {
				themeMode = localStorage.getItem("data-bs-theme");
			} else {
				themeMode = defaultThemeMode;
			}
			}
			if (themeMode === "system") {
			themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
			}
			document.documentElement.setAttribute("data-bs-theme", themeMode);
		}
		</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-column flex-column-fluid">
				@include('partials.admin.header')
				<!--begin::Wrapper-->
				<div id="kt_content_container" class="d-flex flex-column-fluid align-items-stretch container-xxl">
					@include('partials.admin.sidebar')
					<div class="wrapper d-flex flex-column flex-row-fluid mt-5 mt-lg-10" id="kt_wrapper">
						<!--begin::Content-->
						<div class="content flex-column-fluid px-3" id="kt_content">
							@if(isset($title))
							 <!--begin::Toolbar-->
							<div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
								<!--begin::Page title-->
								<div class="page-title d-flex flex-column py-1">
								<!--begin::Title-->
								<h1 class="d-flex align-items-center my-1">
									<span class="text-gray-900 fw-bold fs-1">{{ $title }}</span>
								</h1>
								<!--end::Title-->
								</div>
								<!--end::Page title-->
							</div>
							<!--end::Toolbar-->
							@endif
							@yield('content')
						</div>
						<!--end::Content-->
					</div>
				</div>
				<!--end::Wrapper-->
				@include('partials.admin.footer')
			</div>
			<!--end::Page-->
		</div>
		<!--end::Root-->
		<!--end::Main-->
		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<i class="ki-duotone ki-arrow-up">
				<span class="path1"></span>
				<span class="path2"></span>
			</i>
		</div>
		<!--end::Scrolltop-->
		<!--begin::Javascript-->
		@include('partials.admin.loading')
	    @include('partials.admin.script');
    </body>
    <!--end::Body-->

</html>
