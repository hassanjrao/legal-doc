@extends('layouts.backend')


@php
    $addEdit = isset($donor) ? 'Edit' : 'Add';
    $addUpdate = isset($donor) ? 'Update' : 'Add';
@endphp

@section('page-name', 'Add Donor')

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">

        <div class="container-fluid">

            <div class="row">
                <div class="card custom-card">
                    <div class="card-header ">
                        <div class="card-title d-flex justify-content-between w-100">
                            <span>{{ $addEdit }} Donor</span>

                            <a href="{{ route('admin.donors.index') }}" class="btn btn-primary">All</a>
                        </div>
                    </div>
                    <div class="card-body">

                        @if ($donor)
                            <form action="{{ route('admin.donors.update', $donor->id) }}" method="POST"
                                class="row g-3 mt-0" enctype="multipart/form-data">

                                @csrf
                                @method('PUT')
                            @else
                                <form action="{{ route('admin.donors.store') }}" method="POST"
                                    enctype="multipart/form-data" class="row g-3 mt-0">

                                    @csrf
                        @endif

                        <div class="col-md-6">
                            <?php
                            $value = old('name', $donor ? $donor->name : null);
                            ?>

                            <label class="form-label">Name</label>
                            <input type="text" required class="form-control" name="name" value="{{ $value }}">
                            @error('name')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <?php
                            $value = old('image', $donor ? $donor->image : null);
                            ?>

                            @if ($donor)
                                <img src="{{ $donor->image_url }}" alt="{{ $donor->name }}"
                                    class="img-fluid" style="max-height: 100px;">
                            @endif

                            <label class="form-label">Image</label>
                            <input type="file" class="form-control" name="image"
                            {{ $addEdit == 'Add' ? 'required' : '' }}
                             value="{{ $value }}">
                            @error('image')
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
