<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="horizontal" data-nav-style="menu-click" data-menu-position="fixed"
    data-theme-mode="light">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> @yield('page-title')</title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/brand-logos/bluelogo.png') }}" style='height:45px'
        type="image/x-icon">

    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Style Css -->
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">

    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">

    <!-- Node Waves Css -->
    <link href="{{ asset('assets/libs/node-waves/waves.min.css') }}" rel="stylesheet">

    <!-- SwiperJS Css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/@simonwep/pickr/themes/nano.min.css') }}">

    <!-- Choices Css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/choices.js') }}">

    @yield('css')
    {{--
    <script>
        if (localStorage.sashlandingdarktheme) {
            document.querySelector("html").setAttribute("data-theme-mode", "dark")
        }
        if (localStorage.sashlandingrtl) {
            document.querySelector("html").setAttribute("dir", "rtl")
            document.querySelector("#style")?.setAttribute("href",
                "{{ asset('assets/libs/bootstrap/css/bootstrap.rtl.min.css') }}");
        }
    </script> --}}


</head>

<body class="landing-body">

    <!-- Start Switcher -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="switcher-canvas" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Switcher</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="">
                <p class="switcher-style-head">Theme Color Mode:</p>
                <div class="row switcher-style">
                    <div class="col-4">
                        <div class="form-check switch-select">
                            <label class="form-check-label" for="switcher-light-theme">
                                Light
                            </label>
                            <input class="form-check-input" type="radio" name="theme-style" id="switcher-light-theme"
                                checked>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-check switch-select">
                            <label class="form-check-label" for="switcher-dark-theme">
                                Dark
                            </label>
                            <input class="form-check-input" type="radio" name="theme-style" id="switcher-dark-theme">
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <p class="switcher-style-head">Directions:</p>
                <div class="row switcher-style">
                    <div class="col-4">
                        <div class="form-check switch-select">
                            <label class="form-check-label" for="switcher-ltr">
                                LTR
                            </label>
                            <input class="form-check-input" type="radio" name="direction" id="switcher-ltr" checked>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-check switch-select">
                            <label class="form-check-label" for="switcher-rtl">
                                RTL
                            </label>
                            <input class="form-check-input" type="radio" name="direction" id="switcher-rtl">
                        </div>
                    </div>
                </div>
            </div>
            <div class="theme-colors">
                <p class="switcher-style-head">Theme Primary:</p>
                <div class="d-flex align-items-center switcher-style">
                    <div class="form-check switch-select me-3">
                        <input class="form-check-input color-input color-primary-1" type="radio" name="theme-primary"
                            id="switcher-primary">
                    </div>
                    <div class="form-check switch-select me-3">
                        <input class="form-check-input color-input color-primary-2" type="radio" name="theme-primary"
                            id="switcher-primary1">
                    </div>
                    <div class="form-check switch-select me-3">
                        <input class="form-check-input color-input color-primary-3" type="radio"
                            name="theme-primary" id="switcher-primary2">
                    </div>
                    <div class="form-check switch-select me-3">
                        <input class="form-check-input color-input color-primary-4" type="radio"
                            name="theme-primary" id="switcher-primary3">
                    </div>
                    <div class="form-check switch-select me-3">
                        <input class="form-check-input color-input color-primary-5" type="radio"
                            name="theme-primary" id="switcher-primary4">
                    </div>
                    <div class="form-check switch-select me-3 ps-0 mt-1 color-primary-light">
                        <div class="theme-container-primary"></div>
                        <div class="pickr-container-primary"></div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center canvas-footer flex-wrap px-0 px-sm-5">
                <a href="javascript:void(0);" id="reset-all" class="btn btn-danger m-1">Reset</a>
            </div>
        </div>
    </div>
    <!-- End Switcher -->

    <div class="landing-page-wrapper">

        <!-- app-header -->
        <header class="app-header">

            <!-- Start::main-header-container -->
            <div class="main-header-container container-fluid">

                <!-- Start::header-content-left -->
                <div class="header-content-left">

                    <!-- Start::header-element -->
                    <div class="header-element">
                        <div class="horizontal-logo">
                            <a href="{{ route('home') }}" class="header-logo">
                                <img src="{{ asset('assets/images/brand-logos/bluelogo.png') }}" style='height:45px'
                                    alt="logo" class="toggle-logo">
                                <img src="{{ asset('assets/images/brand-logos/bluelogo.png') }}" style='height:45px'
                                    alt="logo" class="toggle-white">
                                <img src="{{ asset('assets/images/brand-logos/bluelogo.png') }}" style='height:45px'
                                    alt="logo" class="toggle-dark">
                            </a>
                        </div>
                    </div>
                    <!-- End::header-element -->

                    <!-- Start::header-element -->
                    <div class="header-element">
                        <!-- Start::header-link -->
                        <a aria-label="anchor" href="javascript:void(0);" class="sidemenu-toggle header-link"
                            data-bs-toggle="sidebar">
                            <span class="open-toggle">
                                <i class="ri-menu-3-line fs-20"></i>
                            </span>
                        </a>
                        <!-- End::header-link -->
                    </div>
                    <!-- End::header-element -->

                </div>
                <!-- End::header-content-left -->

                <!-- Start::header-content-right -->
                <div class="header-content-right">

                    <!-- Start::header-element -->
                    <div class="header-element align-items-center">
                        <!-- Start::header-link|switcher-icon -->
                        <div class="btn-list d-lg-none d-flex">
                            <a href="{{ route('register') }}" class="btn btn-sm-w-sm btn-wave btn-outline-primary">
                                New User
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-sm-w-sm btn-wave btn-primary">
                                Log In
                            </a>
                            {{-- <div class="switcher-icon nav-link icon" data-bs-toggle="offcanvas"
                                data-bs-target="#switcher-canvas">
                                <i class="fe fe-settings fa-spin  text_primary"></i>
                            </div> --}}
                        </div>
                        <!-- End::header-link|switcher-icon -->
                    </div>
                    <!-- End::header-element -->

                </div>
                <!-- End::header-content-right -->

            </div>
            <!-- End::main-header-container -->

        </header>
        <!-- /app-header -->

        <!-- Start::app-sidebar -->
        <aside class="app-sidebar sticky" id="sidebar">

            <div class="container-xl p-0">
                <!-- Start::main-sidebar -->
                <div class="main-sidebar">

                    <!-- Start::nav -->
                    <nav class="main-menu-container nav nav-pills sub-open">
                        <div class="landing-logo-container">
                            <div class="horizontal-logo">
                                <a href="{{ route('home') }}" class="header-logo">
                                    <img src="{{ asset('assets/images/brand-logos/bluelogo.png') }}" alt="logo"
                                        class="desktop-logo">
                                    <img src="{{ asset('assets/images/brand-logos/bluelogo.png') }}" alt="logo"
                                        class="desktop-white">
                                </a>
                            </div>
                        </div>
                        <div class="slide-left" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg"
                                fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                            </svg></div>
                        <ul class="main-menu">
                            <!-- Start::slide -->
                            <li class="slide">
                                <a class="side-menu__item" href="{{ route('home') }}">
                                    <span class="side-menu__label">Home</span>
                                </a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('documents.index') }}" class="side-menu__item">
                                    <span class="side-menu__label">Documents</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="{{ request()->is('/') ? '#about' : route('home') . '#about' }}"
                                    class="side-menu__item">
                                    <span class="side-menu__label">About</span>
                                </a>
                            </li>
                            <li class="slide">
                                <a href="{{ request()->is('/') ? '#contact' : route('home') . '#contact' }}"
                                    class="side-menu__item">
                                    <span class="side-menu__label">Contact Us</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="{{ route('blogs.index') }}" class="side-menu__item">
                                    <span class="side-menu__label">Information</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->

                            <!-- End::slide -->

                        </ul>
                        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg"
                                fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z">
                                </path>
                            </svg></div>
                        <div class="d-lg-flex d-none">
                            <div class="btn-list d-lg-flex d-none mt-lg-2 mt-xl-0 mt-0">
                                <a href="{{ route('register') }}" class="btn btn-w-sm btn-wave btn-outline-primary">
                                    New User
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-w-sm btn-wave btn-primary">
                                    Log In
                                </a>
                                {{-- <div class="switcher-icon nav-link icon" data-bs-toggle="offcanvas"
                                    data-bs-target="#switcher-canvas">
                                    <i class="fe fe-settings fa-spin  text_primary"></i>
                                </div> --}}
                            </div>
                        </div>
                    </nav>
                    <!-- End::nav -->

                </div>
                <!-- End::main-sidebar -->
            </div>

        </aside>

        <!-- Start::app-content -->
        <div class="main-content landing-main">

            @yield('content')
            <!-- Start:: Section-12 -->
            <section class="section landing-footer">
                <div class="container">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <a href="{{ route('home') }}">
                                <img loading="lazy" alt="" class="logo-2 mb-3 img-fluid"
                                    src="{{ asset('assets/images/brand-logos/pen_logo.png') }}"></a>


                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-4">

                            <a href="{{ route('home') }}"><img loading="lazy" alt=""
                                    class="logo-2 mb-3 img-fluid"
                                    src="{{ asset('assets/images/brand-logos/usaid_logo.png') }}"></a>


                        </div>

                        <div class="col-xl-2 col-lg-2 col-md-2 ">

                            <div>
                                <h6 class="fw-semibold">INFO</h6>
                                <ul class="list-unstyled op-6 fw-medium landing-footer-list mb-0">
                                    <li>
                                        <a href="{{ request()->is('/') ? '#contact' : route('home') . '#contact' }}"
                                            class="">Contact Us</a>
                                    </li>
                                    <li>
                                        <a href="{{ request()->is('/') ? '#about' : route('home') . '#about' }}"
                                            class="">About</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('documents.index') }}" class="">Documents</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blogs.index') }}" class="">Information</a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-xl-12">
                            <p>Implemented by PEN and Supported by USAID Justice Activity</p>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-12 -->

            <div class="text-center landing-main-footer py-3">
                <span class="text-muted fs-15"> Copyright ©
                    <span id="year"></span>
                    All rights reserved
                </span>
            </div>
        </div>
        <!-- End::app-content -->

    </div>

    <div class="scrollToTop">
        <span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
    </div>
    <div id="responsive-overlay"></div>

    <!-- Popper JS -->
    <script src="{{ asset('assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Color Picker JS -->
    <script src="{{ asset('assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>

    <!-- Choices JS -->
    <script src="{{ asset('assets/libs/choices.js') }}"></script>

    <!-- Swiper JS -->
    <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Defaultmenu JS -->
    <script src="{{ asset('assets/js/defaultmenu.min.js') }}"></script>

    <!-- Internal Landing JS -->
    <script src="{{ asset('assets/js/landing.js') }}"></script>

    <!-- Node Waves JS-->
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- Sticky JS -->
    <script src="{{ asset('assets/js/sticky.js') }}"></script>


    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('sweetalert::alert')

    @stack('scripts')

</body>

</html>
