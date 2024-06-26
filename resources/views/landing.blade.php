@extends('layouts.front')

@section('page-title','Home')

@section('content')
    <!-- Hero -->
    <!-- Start:: Section-1 -->
    <div class="landing-banner" id="home">
        <section class="section">
            <div class="container px-sm-0 main-banner-container pb-0">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 animation-zidex pos-relative my-auto">
                        <h1 class="fw-semibold">Dokumente Ligjore Falas</h1>
                        <h5 class="text-start fw-bold mb-3 lh-base">Qëllimi ynë është të thjeshtojmë qasjen në drejtësi duke
                            ofruar dokumente ligjore falas dhe lehtësisht të përdorshme për të gjithë qytetarët e Kosovës.
                        </h5>
                        <ul class="pb-3 mb-3">
                            <li>300+ Dokumente Ligjore Falas
                            </li>
                            <li>
                                 Modifikoni dhe Shkarkoni Dokumentet që ju Nevojiten
                            </li>
                            <li>
                                Udhëzues Ligjorë Falas"</li>
                        </ul>

                        <a href="https://themeforest.net/item/sash-bootstrap-5-admin-dashboard-template/35183671"
                            target="_blank" class="btn ripple btn-min w-lg me-2 btn-primary"><i class="fe fe-play me-2"></i>
                            Get Started
                        </a>
                    </div>
                    <div class="col-xl-6 col-lg-6 my-auto text-end">
                        <img src="{{ asset('assets/images/landing/2.png') }}" alt="" class="w-100">
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- End:: Section-1 -->

    <!-- Start:: Section-2 -->
    <section class="section section-bg" id="about">
        <div class="container text-center">
            <p class="fs-18 fw-medium mb-1"><span class="landing-section-heading">About</span></p>
            <span class="landing-title"></span>
            <h3 class="fw-semibold mb-5">Designed with precision and well documented</h3>
        </div>
        <div class="row justify-content-center align-items-center g-0">
            <div class="col-xxl-5 col-xl-5 col-lg-5 customize-image text-center">
                <div class="text-lg-end">
                    <img src="{{ asset('assets/images/landing/1.png') }}" alt="" class="img-fluid">
                </div>
            </div>
            <div class="col-xxl-5 col-xl-5 col-lg-5 my-auto text-start pt-5 pb-0 px-lg-2 px-5">
                <h5 class="text-lg-start fw-semibold mb-0">Present your awesome product</h5>
                <p class=" text-muted">lorem ipsum, dolor sit var ameto condesetrat aiatel varen or damsenlel verman code
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit</p>
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="d-flex">
                            <span>
                                <i class="bx bxs-badge-check text-primary fs-18"></i>
                            </span>
                            <div class="ms-2">
                                <h6 class="fw-semibold mb-0">Can Switch Easily From Vertical to HorizontalMenu.</h6>
                                <p class=" text-muted">lorem ipsum, dolor sit var ameto condesetrat aiatel varen or
                                    damsenlel verman code Lorem ipsum, dolor sit amet consectetur </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="d-flex">
                            <span>
                                <i class="bx bxs-badge-check text-primary fs-18"></i>
                            </span>
                            <div class="ms-2">
                                <h6 class="fw-semibold mb-0">Switch Easily From One Color to Another Color style</h6>
                                <p class=" text-muted">lorem ipsum, dolor sit var ameto condesetrat aiatel varen or
                                    damsenlel verman code Lorem ipsum, dolor sit amet consectetur </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="d-flex">
                            <span>
                                <i class="bx bxs-badge-check text-primary fs-18"></i>
                            </span>
                            <div class="ms-2">
                                <h6 class="fw-semibold mb-0">Switch Easily From Fixed to Scrollable Layout.</h6>
                                <p class=" text-muted">lorem ipsum, dolor sit var ameto condesetrat aiatel varen or
                                    damsenlel verman code Lorem ipsum, dolor sit amet consectetur </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End:: Section-2 -->




    <!-- Start:: Section-10 -->
    <section class="section pb-0" id="contact">
        <div class="container text-center">
            <div class="card mb-0">
                <div class="mt-5">
                    <p class="fs-18 fw-medium mb-1"><span class="landing-section-heading text-dark">Contact Us</span></p>
                    <span class="landing-title"></span>
                    <h3 class="fw-semibold">Get in Touch with <span class="text-primary">US.</span></h3>
                </div>
                <div class="card-body text-dark">
                    <div class="row justify-content-center p-5 pt-0">
                        <div class="col-lg-9">
                            <div class="row text-center services-statistics">
                                <div class="col-xl-3 col-md-6 col-lg-6">
                                    <div class="card bg-transparent border-0 shadow-none">
                                        <div class="card-body p-0">
                                            <div class="counter-icon icon-1">
                                                <i class="fe fe-map-pin text-primary fs-23"></i>
                                            </div>
                                            <h5 class="mb-2 fw-medium">Main Branch</h5>
                                            <p>San Francisco, CA </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 col-lg-6">
                                    <div class="card bg-transparent border-0 shadow-none">
                                        <div class="card-body p-0">
                                            <div class="counter-icon icon-2">
                                                <i class="fe fe-headphones text-secondary fs-23"></i>
                                            </div>
                                            <h5 class="mb-2 fw-medium">Phone &amp; Email</h5>
                                            <p class="mb-0">+125 254 3562 </p>
                                            <p>georgeme@abc.com</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 col-lg-6">
                                    <div class="card bg-transparent border-0 shadow-none">
                                        <div class="card-body p-0">
                                            <div class="counter-statuss">
                                                <div class="counter-icon icon-3">
                                                    <i class="fe fe-mail text-success fs-23"></i>
                                                </div>
                                                <h5 class="mb-2 fw-medium">Contact</h5>
                                                <p class="mb-0"> www.example.com</p>
                                                <p>example@dev.com</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 col-lg-6">
                                    <div class="card bg-transparent border-0 shadow-none">
                                        <div class="card-body p-0">
                                            <div class="counter-status">
                                                <div class="counter-icon icon-4">
                                                    <i class="fe fe-airplay text-danger fs-23"></i>
                                                </div>
                                                <h5 class="mb-2 fw-medium">Working Hours</h5>
                                                <p class="mb-0">Monday - Friday: 9am - 6pm</p>
                                                <p>Satday - Sunday: Holiday</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9">
                            <form class="form-horizontal text-start" action="index.html">
                                <div class="form-group mb-3">
                                    <div class="col-xs-12">
                                        <input class="form-control" type="text" required placeholder="Username*">
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="col-xs-12">
                                        <input class="form-control" type="email" required placeholder="Email*">
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="col-xs-12">
                                        <textarea class="form-control" rows="5">Your Comment*</textarea>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="btn btn-primary btn-rounded  waves-effect waves-light">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End:: Section-10 -->

    <!-- Start:: Section-11 -->
    <div class="container">
        <div class="buynow-landing reveal">
            <div class="card bg-transparent border-0 shadow-none mb-0">
                <div class="card-body p-5">
                    <div class="row">
                        <div class="col-lg-9 my-auto">
                            <h2 class="fw-semibold text-fixed-white">Start Your Project
                                with Sash.</h2>
                            <p class="text-fixed-white mb-0">Sed ut perspiciatis unde omnis
                                iste natus error sit voluptatem accusantium
                                doloremque laudantium, totam rem aperiam, eaque ipsa
                                quae ab illo inventore veritatis et quasi architecto
                                beatae vitae dicta sunt
                                explicabo.
                            </p>
                        </div>
                        <div class="col-lg-3 text-end my-auto">
                            <a href="https://themeforest.net/item/sash-bootstrap-5-admin-dashboard-template/35183671"
                                target="_blank" class="btn btn-pink w-lg pt-2 pb-2 d-inline-flex align-items-center"><i
                                    class="fe fe-shopping-cart me-2"></i>Buy Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End:: Section-11 -->

    <!-- END Hero -->
@endsection
