@extends('layouts.front')

@section('page-title', 'Home')

@section('css')



@endsection

@section('content')
    <!-- Hero -->
    <!-- Start:: Section-1 -->
    <div class="landing-banner" id="home">
        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-8 animation-zidex pos-relative my-auto">
                        <h1 class="fw-semibold">Free Legal Documents</h1>
                        <h5 class="text-start fw-bold mb-3 lh-base w-75">Our goal is to simplify access to justice by
                            providing
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
                    <div class="col-xl-4 col-lg-4 my-auto text-end">
                        <img src="{{ asset('assets/images/landing/13338131_5217023.svg') }}" alt="" class="w-100">
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
            <h3 class="fw-semibold mb-5">Welcome to Dokumente Ligjore</h3>
            <div class="d-flex justify-content-center">
                <p class="w-75">At Dokumente Ligjore, our goal is to simplify your access to justice by providing
                    free, user-friendly legal document templates. Our process is designed to be straightforward and
                    accessible, ensuring you can find, customize, and use the legal documents you need with ease.
                    <b>Here’s how
                        it works:</b>
                </p>
            </div>

        </div>
        <div class="row justify-content-center align-items-center g-0">
            <div class="col-xxl-5 col-xl-5 col-lg-5 customize-image text-center">
                <div class="text-lg-end">
                    <img src="{{ asset('assets/images/landing/howitworks.png') }}" alt="" class="img-fluid">
                </div>
            </div>
            <div class="col-xxl-5 col-xl-5 col-lg-5 my-auto text-start pt-5 pb-0 px-lg-2 px-5">

                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="d-flex">
                            <span>
                                <i class="bx bxs-badge-check text-primary fs-18"></i>
                            </span>
                            <div class="ms-2">
                                <h6 class="fw-semibold mb-0">Browse Our Library</h6>
                                <p class=" text-muted">Explore our extensive collection of legal document templates. Our
                                    templates are categorized for easy navigation.
                                    Use our search bar or browse through the categories to find the specific template you
                                    need.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="d-flex">
                            <span>
                                <i class="bx bxs-badge-check text-primary fs-18"></i>
                            </span>
                            <div class="ms-2">
                                <h6 class="fw-semibold mb-0">Select and Download</h6>
                                <p class=" text-muted">Once you find the document template that suits your needs, simply
                                    click on it to view more details. You can then download the template in a format that is
                                    convenient for you, such as Word.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="d-flex">
                            <span>
                                <i class="bx bxs-badge-check text-primary fs-18"></i>
                            </span>
                            <div class="ms-2">
                                <h6 class="fw-semibold mb-0">Customize the Document</h6>
                                <p class=" text-muted">Open the downloaded template and fill in the necessary details. Our
                                    templates are designed to be easily customizable, with clear instructions and
                                    placeholders indicating where you need to insert your specific information. This ensures
                                    that you can tailor the document to fit your unique situation accurately.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="d-flex">
                            <span>
                                <i class="bx bxs-badge-check text-primary fs-18"></i>
                            </span>
                            <div class="ms-2">
                                <h6 class="fw-semibold mb-0">Use the Document</h6>
                                <p class=" text-muted">After customizing the template, carefully review the document to
                                    ensure all details are correct and complete. You can now download or save the finalized
                                    document for your legal needs.</p>
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





    <section class="section section-bg" id="blogs">
        <div class="container text-center">
            <p class="fs-18 fw-medium mb-1"><span class="landing-section-heading">Blogs</span></p>
            <span class="landing-title"></span>
            <h3 class="fw-semibold mb-5">Latest Blogs</h3>
            <div class="row justify-content-center">

                @foreach ($blogs as $blog)
                    <div class="col-sm-3 col-md-12 col-lg-3 col-xl-3">
                        <div class="card">
                            <a href="{{ route('blogs.show', $blog->id) }}" class="pt-5">

                                <span class="avatar avatar-xxl avatar-rounded mb-3 team-avatar">
                                    <img class="" style="height: 100px" src="{{ $blog->image_url }}"
                                        alt="Well, I didn&#39;t vote for you.">
                                </span>
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
        </div>

        <div class="row justify-content-center align-items-center g-0">

            <div class="col-xxl-5 col-xl-5 col-lg-5 customize-image text-center">
                <div class="text-lg-end">
                    <img src="{{ asset('assets/images/landing/about.png') }}" alt="" class="img-fluid">
                </div>
            </div>
            <div class="col-xxl-5 col-xl-5 col-lg-5 my-auto text-start pt-5 pb-0 px-lg-2 px-5">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="d-flex">
                            <span>
                                <i class="bx bxs-badge-check text-primary fs-18"></i>
                            </span>
                            <div class="ms-2">
                                <h6 class="fw-semibold mb-0">Who We Are</h6>
                                <p class=" text-muted">Dokumente Ligjore is a pioneering initiative dedicated to enhancing
                                    access to justice through the provision of free, user-friendly legal document templates.
                                    We are committed to simplifying legal processes and making legal resources accessible to
                                    everyone, especially those who cannot afford legal representation. Our mission is rooted
                                    in the belief that justice should be within reach for all.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="d-flex">
                            <span>
                                <i class="bx bxs-badge-check text-primary fs-18"></i>
                            </span>
                            <div class="ms-2">
                                <h6 class="fw-semibold mb-0">Our Mission</h6>
                                <p class=" text-muted">Our mission at Dokumente Ligjore is to democratize access to legal
                                    resources. We strive to break down barriers to justice by offering comprehensive,
                                    accessible, and understandable legal templates that cover a wide range of legal needs.
                                    We aim to empower individuals to navigate legal processes with confidence and ease.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="d-flex">
                            <span>
                                <i class="bx bxs-badge-check text-primary fs-18"></i>
                            </span>
                            <div class="ms-2">
                                <h6 class="fw-semibold mb-0">Our Vision</h6>
                                <p class=" text-muted">Our vision is a world where everyone has the tools and knowledge to
                                    access justice. We envision a society where legal processes are transparent,
                                    understandable, and accessible to all, regardless of their financial situation.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- End:: Section-2 -->





    <section class="section section-bg landing-testimonials" id="testimonials">
        <div class="container text-center">
            <p class="fs-18 fw-medium mb-1"><span class="landing-section-heading">Testinominals</span></p>
            <span class="landing-title"></span>
            {{-- <h3 class="fw-semibold mb-5">We never failed to reach expectations</h3> --}}
            <div class="swiper pagination-dynamic text-start">
                <div class="swiper-wrapper">

                    @foreach ($testimonials as $testimonial)
                        <div class="swiper-slide">
                            <div class="card  testimonial-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="avatar avatar-md avatar-rounded me-3">
                                            <img src="{{ $testimonial->image_url }}" alt="">
                                        </span>
                                        <div>
                                            <p class="mb-0 fw-semibold fs-14">
                                                {{ $testimonial->name }}
                                            </p>
                                            <p class="mb-0 fs-10 fw-semibold text-muted">
                                                {{ $testimonial->company_name }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <span class="text-muted">- {{ $testimonial->comment }} --</span>
                                    </div>
                                    {{-- <div class="d-flex align-items-center justify-content-end w-100">
                                        <div class="float-end fs-12 fw-semibold text-muted text-end">
                                            <span>
                                                {{ $testimonial->created_at->diffForHumans() }}
                                            </span>
                                            <span class="d-block fw-normal fs-12 text-success"><i>
                                                {{ $testimonial->name }}
                                                </i></span>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="swiper-pagination mt-4"></div>
            </div>
        </div>
    </section>




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


    <section class="section section-bg" id="feedback">
        <div class="container text-center">
            <div class="card mb-0">
                <div class="mt-5">
                    <p class="fs-18 fw-medium mb-1"><span class="landing-section-heading text-dark">Leave Feedback</span>
                    </p>
                    <span class="landing-title"></span>
                    @if (!Auth::check())
                        <h5 class="fw-semibold">Please Login To Leave a feedback</span></h3>
                    @endif
                </div>
                <div class="card-body text-dark">
                    <div class="row justify-content-center p-5 pt-0">

                        <div class="col-xl-9">
                            <form class="form-horizontal text-start" action="{{ route('home.feedback-submit') }}"
                                method="POST">
                                @csrf

                                @foreach ($feedbackQuestions as $feedbackQuestion)
                                    <div class="form-group mb-4">
                                        <h4>{{ $feedbackQuestion->question }}</h4>
                                        <div class="col-xs-12">
                                            @foreach ($feedbackQuestion->choices as $choice)
                                                <div class="form-check form-check-md form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="questions[{{ $feedbackQuestion->id }}]"
                                                        id="question_{{ $feedbackQuestion->id }}_{{ $choice->id }}"
                                                        value="{{ $choice->id }}" required>
                                                    <label class="form-check-label"
                                                        for="question_{{ $feedbackQuestion->id }}_{{ $choice->id }}">
                                                        {{ $choice->choice }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-xs-12 mt-2">
                                            <textarea class="form-control" name="comments[{{ $feedbackQuestion->id }}]" placeholder="Your Comment"></textarea>
                                        </div>
                                    </div>
                                @endforeach

                                @if (Auth::check())
                                    <button type="submit"
                                        class="btn btn-primary btn-rounded  waves-effect waves-light mt-3">Submit</button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
@push('scripts')
@endpush
