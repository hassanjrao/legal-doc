@extends('layouts.backend')


@php
    $addEdit = isset($lawArea) ? 'Edit' : 'Add';
    $addUpdate = isset($lawArea) ? 'Update' : 'Add';
@endphp

@section('page-name', 'Add Law Area')

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">

        <div class="container-fluid">

            <div class="row">
                <div class="card custom-card">
                    <div class="card-header ">
                        <div class="card-title d-flex justify-content-between w-100">
                            <span>{{ $addEdit }} Law Area</span>

                            <a href="{{ route('admin.law-areas.index') }}" class="btn btn-primary">All</a>
                        </div>
                    </div>
                    <div class="card-body">

                        @if ($lawArea)
                            <form action="{{ route('admin.law-areas.update', $lawArea->id) }}" method="POST"
                                class="row g-3 mt-0" enctype="multipart/form-data">

                                @csrf
                                @method('PUT')
                            @else
                                <form action="{{ route('admin.law-areas.store') }}" method="POST"
                                    enctype="multipart/form-data" class="row g-3 mt-0">

                                    @csrf
                        @endif

                        <div class="col-md-6">
                            <?php
                            $value = old('name', $lawArea ? $lawArea->name : null);
                            ?>

                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $value }}">
                            @error('name')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        </form>

                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection
@push('scripts')

@endpush
