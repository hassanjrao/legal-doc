@extends('layouts.front')

@section('page-title', 'Blogs')

@section('content')

    <div class="container mt-5">

        <section class="section " id="about">
            <div class="container text-center">
                <p class="fs-18 fw-medium mb-1"><span class="landing-section-heading">Blogs</span></p>
                <span class="landing-title"></span>

            </div>
            <div class="row mt-2">
                @foreach ($blogs as $blog)
                    <!-- COL-END -->
                    <div class="col-sm-3 col-md-12 col-lg-3 col-xl-3">
                        <div class="card">
                            <a href="{{ route('blogs.show',$blog->id) }}"><img class="card-img-top" src="../assets/images/media/photos/3.jpg"
                                    alt="Well, I didn&#39;t vote for you."></a>
                            <div class="card-body d-flex flex-column">
                                <h4 class="fw-normal"><a href="{{ route('blogs.show',$blog->id) }}"> {{ $blog->title }} </a></h4>
                                <div class="text-muted">{{ $blog->short_content }}</div>
                                <div class="d-flex align-items-center pt-4 mt-auto">
                                    <div class="avatar avatar-rounded avatar-md me-3 cover-image"
                                        data-bs-image-src="../assets/images/faces/16.jpg"></div>
                                    <div>
                                        <small class="d-block text-muted text-right">
                                            {{ $blog->created_at->diffForHumans() }}
                                        </small>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach

                <div class="col-lg-12 d-flex justify-content-center">
                    {{ $blogs->links() }}
                </div>
            </div>
        </section>



    </div>

@endsection
