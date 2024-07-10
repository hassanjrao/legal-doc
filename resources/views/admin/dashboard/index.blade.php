@extends('layouts.backend')

@section('page-name', 'Dashboard')

@section('css')


@endsection

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">

        <div class="container-fluid">

            @hasrole('admin')
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xxl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="mt-2">
                                        <h6 class="fw-normal">Total Documents</h6>
                                        <h2 class="mb-0 text-dark fw-semibold">{{ $totalDocuments }}</h2>
                                    </div>
                                    <div class="ms-auto">
                                        <div class=" mt-1">
                                            <i class="fe fe-file-text fs-40 text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xxl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="mt-2">
                                        <h6 class="fw-normal">Total Users</h6>
                                        <h2 class="mb-0 text-dark fw-semibold">{{ $totalUsers }}</h2>
                                    </div>
                                    <div class="ms-auto mt-2">
                                        {{-- users icons --}}
                                        <i class="fe fe-users fs-40 text-primary"></i>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xxl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="mt-2">
                                        <h6 class="fw-normal">Total Companies</h6>
                                        <h2 class="mb-0 text-dark fw-semibold">{{ $totalCompanies }}</h2>
                                    </div>
                                    <div class="ms-auto">
                                        <div class="mt-1">
                                            <i class="fe fe-briefcase fs-40 text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endhasrole

            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title fw-semibold">Document downloads</h4>
                        </div>
                        <div class="card-body">
                            <div class="browser-stats">

                                @foreach ($downloadedDocuments as $document)
                                    <div class="row mb-3">
                                        <div class="col-sm-4 col-lg-4 col-xl-4 col-xxl-4 mb-sm-0 mb-3">

                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-md">
                                                    <i class="fe fe-file-text fs-40 text-primary"></i>

                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-0">{{ $document->title }}</h6>

                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-8 col-lg-8 col-xl-8 col-xxl-8 ps-sm-0">
                                            <div class="d-flex align-items-end justify-content-between mb-1">
                                                <h6 class="mb-1">
                                                    <span class="text-dark">{{ $document->title }}</span>
                                                </h6>
                                                <h6 class="fw-semibold mb-1">
                                                    {{ $document->downloaded_by_count }}
                                                    <span class="text-success fs-11">(<i
                                                            class="fe fe-arrow-up"></i>{{ $document->downloaded_by_percentage }}%)</span>

                                                </h6>
                                            </div>
                                            <div class="progress progress-sm mb-3">
                                                <div class="progress-bar bg-primary"
                                                    style="width: {{ $document->downloaded_by_percentage }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- End::app-content -->
@endsection

@push('scripts')

    <!-- Chartjs Chart JS -->
    <script src="{{ asset('assets/libs/chart.js/chart.min.js') }}"></script>

    <!-- index -->
    <script src="{{ asset('assets/js/index.js') }}"></script>
@endpush
