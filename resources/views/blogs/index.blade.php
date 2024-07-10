@extends('layouts.front')

@section('page-title', 'Blogs')

@section('content')

    <div class="container mt-5">

        <section class="section " id="about">
            <div class="container text-center">
                <h1 class=" mb-1"><span class="">Information Center</span></h1>
                <span class="landing-title"></span>


            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <h4>Stay Informed with Our Resources</h4>
                    <p>
                        At Dokumente Ligjore, we offer a wealth of information to help you understand and navigate legal processes. Our resources are designed to provide you with the knowledge and tools you need to make informed decisions.
                    </p>
                    <ul>
                        <li><b>Blogs:</b> Read our latest articles on legal topics and stay updated with current legal trends.</li>
                        <li><b>Fact Sheets:</b> Access concise and informative fact sheets that break down complex legal issues.</li>
                        <li><b>FAQs:</b> Find answers to common questions about using our templates and understanding legal procedures.</li>
                    </ul>
                    <p>Explore our information section to empower yourself with the knowledge you need for your legal matters.</p>
                </div>
            </div>

            <div class="row mt-4">
                @foreach ($blogs as $blog)
                    <!-- COL-END -->
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
                                    <a href="{{ route('blogs.show', $blog->id) }}"
                                        class="btn btn-light">Read More</a>
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
