@extends('layouts.front')

@section('page-title', 'Documents')

@section('content')

    <section class="section">

        <div class="container">

            <div class="row mt-2">
                <div class="col-lg-12 text-center w-100">
                    <p class="fs-18 fw-medium mb-1"><span class="landing-section-heading">Explore Our Legal Document
                            Templates</span></p>
                    <span class="landing-title">

                    </span>

                </div>
                <div class="col-lg-12 mt-5">
                    <p>At Dokumente Ligjore, we provide a comprehensive library of free, user-friendly legal document
                        templates designed to meet a wide range of needs. Whether you're dealing with personal, criminal,
                        administrative, or commercial legal matters, our templates offer a reliable starting point to help
                        you navigate the legal process with confidence and ease. Access, customize, and use our
                        professionally crafted documents to simplify your legal journey.</p>

                </div>


            </div>

            <div class="row mt-2 justify-content-between">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-body">
                            <form action="{{ route('documents.index') }}" method="GET">
                                <div class="row d-flex align-items-center  justify-content-between">
                                    <div class="col-lg-10 d-flex">

                                        <div class="d-flex justify-content-between w-75">
                                            <select name="type" class="form-select w-50 mr-2"
                                                onchange="this.form.submit()">
                                                <option value="">Select Type</option>
                                                @foreach ($documentCategories as $documentCategory)
                                                    <option value="{{ $documentCategory->id }}"
                                                        {{ request()->type == $documentCategory->id ? 'selected' : '' }}>
                                                        {{ $documentCategory->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <select name="law_area" class="form-select w-50 mr-2"
                                                onchange="this.form.submit()">
                                                <option value="">Law Area</option>
                                                @foreach ($lawAreas as $lawArea)
                                                    <option value="{{ $lawArea->id }}"
                                                        {{ request()->law_area == $lawArea->id ? 'selected' : '' }}>
                                                        {{ $lawArea->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <input class="form-control w-75" type="search" name="search"
                                                placeholder="Search" value="{{ request()->search }}" aria-label="Search">
                                        </div>
                                        <button class="btn btn-md btn-light mx-1 my-0" type="submit">Search</button>

                                    </div>



                                    <div class="col-lg-2 d-flex justify-content-end">

                                        <button class="btn btn-sm btn-light mx-1 my-0" type="button"
                                            onclick="clearFilters()">Clear Filters</button>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>


            <div class="row mt-5 justify-content-center">
                @foreach ($documents as $document)
                    <!-- COL-END -->
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

                <div class="col-lg-12 d-flex justify-content-center">
                    {{ $documents->links() }}
                </div>
            </div>
        </div>



    </section>

@endsection

@push('scripts')
    <script>
        function clearFilters() {
            window.location.href = "{{ route('documents.index') }}";
        }
    </script>
@endpush
