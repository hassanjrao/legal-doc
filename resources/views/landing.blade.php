@extends('layouts.front')

@section('page-title', 'Home')

@section('css')



@endsection

@section('content')
    <!-- Hero -->
    <!-- Start:: Section-1 -->
    <div class="landing-banner" id="home">
        <section class="section">
            <div class="container px-sm-0 main-banner-container pb-0">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 animation-zidex pos-relative my-auto">
                        <h1 class="fw-semibold">Free Legal Documents</h1>
                        <h5 class="text-start fw-bold mb-3 lh-base">Our goal is to simplify access to justice by providing
                            free and easy-to-use legal documents for all citizens of Kosovo.
                        </h5>
                        <ul class="pb-3 mb-3">
                            <li>300+ Free Legal Documents
                            </li>
                            <li>
                                Edit and Download the Documents You Need
                            </li>
                            <li>
                                Free Legal Information & Guides
                            </li>
                        </ul>


                    </div>
                    <div class="col-xl-6 col-lg-6 my-auto text-end">
                        <img src="{{ asset('assets/images/landing/dokumente ligjore homepage.svg') }}" alt="" class="w-100">
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- End:: Section-1 -->


    <!-- Start:: Section-2 -->
    <section class="section section-bf" id="howitworks">
        <div class="container text-center">
            <p class="fs-18 fw-medium mb-1"><span class="landing-section-heading">How it works?</span></p>
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


    <section class="section section-bg" id="documents">
        <div class="container text-center">
            <p class="fs-18 fw-medium mb-1"><span class="landing-section-heading">Documents</span></p>
            <span class="landing-title"></span>
            <h3 class="fw-semibold mb-5">Latest Documents</h3>
            <div class="row justify-content-center">

                @foreach ($documents as $document)
                    <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12">
                        <div class="card text-center team-card ">
                            <div class="card-body p-5">
                                <span class="avatar avatar-xxl avatar-rounded mb-3 team-avatar">
                                    <i class="fe fe-file-text fs-40 text-primary"></i>
                                </span>
                                <p class="fw-semibold fs-17 mb-0 text-default">
                                    {{ $document->title }}
                                </p>
                                <span class="text-muted fs-14 text-primary fw-semibold">
                                    {{ $document->documentCategory->name }}
                                </span>
                                <div class="mt-2">
                                    <a href="{{ route('documents.download', $document->id) }}"
                                        class="btn btn-light">Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-5">
                <a href="{{ route('documents.index') }}" class="btn btn-primary">View All</a>
            </div>
        </div>
    </section>


    <section class="section landing-Features" id="features">
        <div class="container text-center">
            <p class="fs-18 fw-medium mb-1 text-fixed-white"><span class="landing-section-heading">Donors</span></p>
            <span class="landing-title"></span>
            <h2 class="fw-semibold mb-3 text-fixed-white">Donors list</h2>
            <div class="feature-logos mt-sm-5 flex-wrap">
                <div class="swiper features-slide text-start">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="ms-sm-5 ms-2 text-center">
                                <img src="{{ asset('assets/images/landing/web/1.png') }}" alt="image"
                                    class="featur-icon">
                                <h5 class="mt-3 text-fixed-white ">Bootstrap5</h5>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="ms-sm-5 ms-2 text-center">
                                <img src="{{ asset('assets/images/landing/web/2.png') }}" alt="image"
                                    class="featur-icon">
                                <h5 class="mt-3 text-fixed-white ">HTML5</h5>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="ms-sm-5 ms-2 text-center">
                                <img src="{{ asset('assets/images/landing/web/3.png') }}" alt="image"
                                    class="featur-icon">
                                <h5 class="mt-3 text-fixed-white ">Sass</h5>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="ms-sm-5 ms-2 text-center">
                                <img src="{{ asset('assets/images/landing/web/4.png') }}" alt="image"
                                    class="featur-icon">
                                <h5 class="mt-3 text-fixed-white ">Gulp</h5>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="ms-sm-5 ms-2 text-center">
                                <img src="{{ asset('assets/images/landing/web/5.png') }}" alt="image"
                                    class="featur-icon">
                                <h5 class="mt-3 text-fixed-white ">NPM</h5>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="ms-sm-5 ms-2 text-center">
                                <img src="{{ asset('assets/images/landing/web/3.png') }}" alt="image"
                                    class="featur-icon">
                                <h5 class="mt-3 text-fixed-white ">Sass</h5>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="ms-sm-5 ms-2 text-center">
                                <img src="{{ asset('assets/images/landing/web/4.png') }}" alt="image"
                                    class="featur-icon">
                                <h5 class="mt-3 text-fixed-white ">Gulp</h5>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="ms-sm-5 ms-2 text-center">
                                <img src="{{ asset('assets/images/landing/web/5.png') }}" alt="image"
                                    class="featur-icon">
                                <h5 class="mt-3 text-fixed-white ">NPM</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-bg" id="blogs">
        <div class="container text-center">
            <p class="fs-18 fw-medium mb-1"><span class="landing-section-heading">Blogs</span></p>
            <span class="landing-title"></span>
            <h3 class="fw-semibold mb-5">Latest Blogs</h3>
            <div class="row justify-content-center">

                @foreach ($blogs as $blog)
                    <div class="col-sm-3 col-md-12 col-lg-3 col-xl-3">
                        <div class="card">
                            <a href="{{ route('blogs.show', $blog->id) }}">
                                <img class="card-img-top img-fluid" style="height: 200px" src="{{ $blog->image_url }}"
                                    alt="Well, I didn&#39;t vote for you.">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h4 class="fw-normal">
                                    <a href="{{ route('blogs.show', $blog->id) }}">
                                        {{ $blog->title }}
                                    </a>
                                </h4>
                                <div class="text-muted">{{ $blog->short_content }}</div>

                                <div class="mt-2">
                                    <a href="{{ route('blogs.show', $blog->id) }}" class="btn btn-light">Read More</a>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-5">
                <a href="{{ route('blogs.index') }}" class="btn btn-primary">View All</a>
            </div>
        </div>
    </section>



    <!-- Start:: Section-2 -->
    <section class="section " id="about">
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
                        {{-- <div class="col-lg-9">
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
                        </div> --}}
                        <div class="col-xl-9">
                            <form class="form-horizontal text-start" action="{{ route('home.contact-us') }}"
                                method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <div class="col-xs-12">
                                        <input class="form-control" type="text" required placeholder="Name*"
                                            name="name">
                                        @error('name')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="col-xs-12">
                                        <input class="form-control" type="email" required placeholder="Email*"
                                            name="email">
                                        @error('email')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="col-xs-12">
                                        <select name="type" class="form-select" required>
                                            <option value="" disabled>Complaint/Request*</option>
                                            <option value="complaint">Complaint</option>
                                            <option value="request">Request</option>
                                        </select>
                                        @error('type')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="form-group mb-3">
                                    <div class="col-xs-12">
                                        <textarea class="form-control" rows="5" required name="message">Your Message*</textarea>
                                        @error('message')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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


    <!-- End:: Section-11 -->

    <!-- END Hero -->
@endsection
@push('scripts')
@endpush
