<!DOCTYPE html>
<html lang="en">

<head>
    <title>Attendance management</title>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="" />
    <link rel="canonical" href="" />
    <link rel="shortcut icon" href="/favicon/favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/dist/snackbar.css" />
    @livewireStyles()
</head>

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" class="app-default">
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
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <div id="kt_app_header" class="app-header" data-kt-sticky="true"
                data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize"
                data-kt-sticky-animation="false" data-kt-sticky-offset="{default: '0px', lg: '0px'}">
                <div class="app-container container-fluid d-flex align-items-stretch flex-stack mt-lg-8"
                    id="kt_app_header_container">
                    <div class="d-flex align-items-center d-block d-lg-none ms-n3" title="Show sidebar menu">
                        <div class="btn btn-icon btn-active-color-primary w-35px h-35px me-1"
                            id="kt_app_sidebar_mobile_toggle">
                            <i class="ki-outline ki-abstract-14 fs-2"></i>
                        </div>
                        <a href="index.html">
                            <img alt="Logo" src="/assets/media/logo.png" class="h-25px theme-light-show" />
                            <img alt="Logo" src="/assets/media/logo.png" class="h-25px theme-dark-show" />
                        </a>
                    </div>
                    <div class="app-navbar flex-lg-grow-1" id="kt_app_header_navbar">
                        <div class="app-navbar-item d-flex align-items-stretch flex-lg-grow-1 me-1 me-lg-0">
                            @if (auth()->user()->role == 1)
                            @if (now()->diffInDays(auth()->user()->expiry_date, false) < 3)
                                <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6"
                                    style="width: 100%">
                                    <!--begin::Icon-->
                                    <i class="ki-outline ki-bank fs-2tx text-primary me-4"></i>
                                    <!--end::Icon-->
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                        <!--begin::Content-->
                                        <div class="mb-3 mb-md-0 fw-semibold">
                                            <h4 class="text-gray-900 fw-bold">Your Plan will expire on
                                                {{ auth()->user()->expiry_date }}</h4>

                                        </div>
                                        <!--end::Content-->
                                        <!--begin::Action-->
                                        <a href="{{ route('packages') }}"
                                            class="btn btn-primary px-6 align-self-center text-nowrap">Upgrade Now</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                            @endif
                            @endif


                        </div>
                        <div class="app-navbar-item ms-1 ms-md-3">
                            <div class="btn btn-icon btn-custom btn-color-gray-500 btn-active-light btn-active-color-primary w-35px h-35px w-md-40px h-md-40px"
                                data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                                data-kt-menu-placement="bottom-end" id="kt_activities_toggle">
                                <i class="ki-outline ki-notification-on fs-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <div id="kt_app_sidebar" class="app-sidebar flex-column mt-lg-4 ps-2 pe-2 ps-lg-7 pe-lg-4"
                    data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
                    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                    data-kt-drawer-width="250px" data-kt-drawer-direction="start"
                    data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
                    <div class="app-sidebar-logo flex-shrink-0 d-none d-md-flex flex-center align-items-center"
                        id="kt_app_sidebar_logo">
                        <a href="/">
                            <img alt="Logo" src="/assets/media/logo.png"
                                class="h-90px d-none d-sm-inline app-sidebar-logo-default theme-light-show" />
                            <img alt="Logo" src="/assets/media/logo.png" class="h-90px theme-dark-show" />
                        </a>
                        <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
                            <div class="btn btn-icon btn-active-color-primary w-30px h-30px"
                                id="kt_aside_mobile_toggle">
                                <i class="ki-outline ki-abstract-14 fs-1"></i>
                            </div>
                        </div>
                    </div>
                    <div class="app-sidebar-menu flex-column-fluid">
                        <div id="kt_app_sidebar_menu_wrapper" class="hover-scroll-overlay-y my-5"
                            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                            data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px">
                            <div class="menu menu-column menu-rounded menu-sub-indention fw-bold px-6"
                                id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                                <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            <i class="ki-outline ki-category fs-2"></i>
                                        </span>
                                        <span class="menu-title">Dashboards</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion">
                                        <div class="menu-item">
                                            <a class="menu-link active" href="{{ route('dashboard') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Dashboard</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link active" href="{{ route('attendance') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Attendance</span>
                                            </a>
                                        </div>
                                        @if (auth()->user()->role == 1)
                                            <div class="menu-item">
                                                <a class="menu-link active" href="{{ route('settings') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Settings</span>
                                                </a>
                                            </div>
                                            <div class="menu-item">
                                                <a class="menu-link active" href="{{ route('employee') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Employee</span>
                                                </a>
                                            </div>
                                            <div class="menu-item">
                                                <a class="menu-link active" href="{{ route('packages') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Packages</span>
                                                </a>
                                            </div>
                                            <div class="menu-item">
                                                <a class="menu-link active" href="{{ route('referral') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Referral</span>
                                                </a>
                                            </div>
                                            <div class="menu-item">
                                                <a class="menu-link active" href="{{ route('wallet') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Wallet</span>
                                                </a>
                                            </div>
                                        @endif


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="app-sidebar-footer d-flex align-items-center px-8 pb-10" id="kt_app_sidebar_footer">
                        <div class="">
                            <div class="d-flex align-items-center"
                                data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-overflow="true"
                                data-kt-menu-placement="top-start">
                                <div class="d-flex flex-center cursor-pointer symbol symbol-circle symbol-40px">
                                    <img src="/assets/media/logo.png" alt="image" />
                                </div>
                                <div class="d-flex flex-column align-items-start justify-content-center ms-3">
                                    <span class="text-gray-500 fs-8 fw-semibold">Hello</span>
                                    <a href="#"
                                        class="text-gray-800 fs-7 fw-bold text-hover-primary">{{ auth()->user()->name ?? '' }}</a>
                                </div>
                            </div>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                                data-kt-menu="true">
                                <div class="menu-item px-3">
                                    <div class="menu-content d-flex align-items-center px-3">
                                        <div class="symbol symbol-50px me-5">
                                            <img alt="Logo" src="/assets/media/logo.png" />
                                        </div>
                                        <div class="d-flex flex-column">
                                            <div class="fw-bold d-flex align-items-center fs-5">
                                                {{ auth()->user()->name ?? '' }}
                                                <span
                                                    class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span>
                                            </div>
                                            <a href="#"
                                                class="fw-semibold text-muted text-hover-primary fs-7">{{ auth()->user()->mobile ?? '' }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-2"></div>
                                <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                    data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                                    <a href="#" class="menu-link px-5">
                                        <span class="menu-title position-relative">Mode <span
                                                class="ms-5 position-absolute translate-middle-y top-50 end-0">
                                                <i class="ki-outline ki-night-day theme-light-show fs-2"></i>
                                                <i class="ki-outline ki-moon theme-dark-show fs-2"></i>
                                            </span>
                                        </span>
                                    </a>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                                        data-kt-menu="true" data-kt-element="theme-mode-menu">
                                        <div class="menu-item px-3 my-0">
                                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                                data-kt-value="light">
                                                <span class="menu-icon" data-kt-element="icon">
                                                    <i class="ki-outline ki-night-day fs-2"></i>
                                                </span>
                                                <span class="menu-title">Light</span>
                                            </a>
                                        </div>
                                        <div class="menu-item px-3 my-0">
                                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                                data-kt-value="dark">
                                                <span class="menu-icon" data-kt-element="icon">
                                                    <i class="ki-outline ki-moon fs-2"></i>
                                                </span>
                                                <span class="menu-title">Dark</span>
                                            </a>
                                        </div>
                                        <div class="menu-item px-3 my-0">
                                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                                data-kt-value="system">
                                                <span class="menu-icon" data-kt-element="icon">
                                                    <i class="ki-outline ki-screen fs-2"></i>
                                                </span>
                                                <span class="menu-title">System</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="menu-item px-5 my-1">
                                    <a href="{{ route('settings') }}" class="menu-link px-5">Account Settings</a>
                                </div>
                                <div class="menu-item px-5">
                                    <a href="{{ route('logout') }}" class="menu-link px-5">Sign Out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <div class="d-flex flex-column flex-column-fluid">
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                    <div id="kt_app_footer" class="app-footer">
                        <div
                            class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                            <div class="text-gray-900 order-2 order-md-1">
                                <span class="text-muted fw-semibold me-1">2024&copy;</span>
                                <a href="/" target="_blank"
                                    class="text-gray-800 text-hover-primary">{{ config('app.name') }}</a>
                            </div>
                            <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
                                {{-- <li class="menu-item">
                                    <a href="/" target="_blank" class="menu-link px-2">About</a>
                                </li>
                                <li class="menu-item">
                                    <a href="/" target="_blank"
                                        class="menu-link px-2">Support</a>
                                </li>
                                <li class="menu-item">
                                    <a href="/" target="_blank"
                                        class="menu-link px-2">Purchase</a>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-outline ki-arrow-up"></i>
    </div>


    <script src="/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/assets/js/scripts.bundle.js"></script>
    <script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script type="text/javascript" src="/dist/webcam-easy.min.js"></script>
    <script type="text/javascript" src="/dist/snackbar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>

    @livewireScripts()
    <script>
        document.addEventListener('livewire:init', () => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        // User granted location access
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        Livewire.dispatch('set:latitude-longitude', {
                            latitude: lat,
                            longitude: lng
                        })
                    },
                    function(error) {
                        if (error.code === error.PERMISSION_DENIED) {
                            alert('Permission to access location was denied.');
                        } else {
                            alert('Error fetching location: ' + error.message);
                        }
                    }
                );
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        })

        function captureCamera() {
            // Ensure the video container is visible
            $("#canvasVideo").css({
                'display': 'block'
            });

            const webcamElement = document.getElementById('webcam');
            const canvasElement = document.getElementById('canvas');
            const snapSoundElement = document.getElementById('snapSound');
            const webcam = new Webcam(webcamElement, 'user', canvasElement, snapSoundElement);

            const videoConstraints = {
                width: {
                    ideal: 1920
                }, // Ideal width (HD or Full HD)
                height: {
                    ideal: 1080
                }, // Ideal height (HD or Full HD)
                facingMode: "user" // Front camera
            };
            // Start the webcam and handle initialization
            webcam.start(videoConstraints)
                .then(() => {
                    console.log("Webcam started");

                    // Wait for a short delay to ensure webcam feed is ready before snapping
                    setTimeout(() => {
                        // Capture the picture
                        const picture = webcam.snap();
                        console.log("Captured picture:", picture);
                        webcam.stop();
                        // Dispatch the image to Livewire
                        Livewire.dispatch('set:live-image', {
                            liveImage: picture
                        });

                        // Stop the webcam after capturing

                    }, 5000); // Adjust the delay as needed (2 seconds here)
                })
                .catch(err => {
                    console.error("Error starting webcam:", err);
                });
        }


        function captureCameraCheckout() {
            $("#canvasVideo").css({
                'display': 'block'
            });

            const webcamElement = document.getElementById('webcam');
            const canvasElement = document.getElementById('canvas');
            const webcam = new Webcam(webcamElement, 'user', canvasElement);

            const videoConstraints = {
                width: {
                    ideal: 1920
                }, // Ideal width (HD or Full HD)
                height: {
                    ideal: 1080
                }, // Ideal height (HD or Full HD)
                facingMode: "user" // Front camera
            };
            webcam.start(videoConstraints)
                .then(() => {
                    console.log("Webcam started");

                    // Add a slight delay to ensure the webcam feed is ready
                    setTimeout(() => {
                        let picture = webcam.snap();
                        console.log("Captured picture:", picture);
                        webcam.stop();
                        Livewire.dispatch('set:live-image-checkout', {
                            liveImage: picture
                        });


                    }, 5000); // Delay of 2 seconds
                })
                .catch(err => {
                    console.error("Webcam error:", err);
                });
        }
        Livewire.on('message', (event) => {
            Snackbar.show({
                text: event[0],
                pos: 'top-right'
            });
            $("#kt_modal_add_user").modal('hide')
        });
    </script>
    <script>
        // Initialize Clipboard.js
        const clipboard = new ClipboardJS('#kt_referral_program_link_copy_btn');

        // Success feedback
        clipboard.on('success', function(e) {
            alert('Copied to clipboard!');
            e.clearSelection();
        });

        // Error feedback
        clipboard.on('error', function(e) {
            alert('Failed to copy. Please try again.');
        });
    </script>

</body>

</html>
